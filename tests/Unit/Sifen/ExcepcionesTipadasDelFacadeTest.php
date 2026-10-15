<?php

namespace IonysDev\Pkuatia\Tests\Unit\Sifen;

use IonysDev\Pkuatia\Core\Config;
use IonysDev\Pkuatia\Core\Constants\MotivoCertificado;
use IonysDev\Pkuatia\Core\Constants\TipoFallaTransporte;
use IonysDev\Pkuatia\Core\Exceptions\CampoInvalidoException;
use IonysDev\Pkuatia\Core\Exceptions\CertificadoException;
use IonysDev\Pkuatia\Core\Exceptions\ConfiguracionException;
use IonysDev\Pkuatia\Core\Exceptions\PkuatiaExceptionInterface;
use IonysDev\Pkuatia\Core\Exceptions\RespuestaException;
use IonysDev\Pkuatia\Core\Exceptions\SifenNoDisponibleException;
use IonysDev\Pkuatia\Core\Exceptions\TransporteException;
use IonysDev\Pkuatia\Core\Exceptions\ValidacionException;
use IonysDev\Pkuatia\Helpers\PemHelper;
use IonysDev\Pkuatia\Helpers\Pkcs12Helper;
use IonysDev\Pkuatia\Helpers\SignHelper;
use IonysDev\Pkuatia\Sifen;
use IonysDev\Pkuatia\Tests\Support\CapturaSoapClient;
use IonysDev\Pkuatia\Tests\Support\EventoFactory as E;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Tests\Support\StubSoapClient;
use IonysDev\Pkuatia\Tests\Support\TestCertFactory;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SoapClient;
use SoapFault;
use TypeError;

/**
 * Paso C2 de la Fase C: el facade, Config y los helpers de certificados lanzan las excepciones tipadas. Con Q-C3 = C
 * las siete operaciones envuelven la falla de comunicación en TransporteException (que extiende \SoapFault), así que
 * los catch (\SoapFault) de las consultas y los catch (\Exception) de las demás operaciones siguen funcionando
 * (ErroresDelFacadeTest conserva esas comprobaciones).
 */
final class ExcepcionesTipadasDelFacadeTest extends TestCase
{
  /** @var array{config: Config, cleanup: callable} */
  private array $entorno;
  private $cleanupCert = null;

  protected function setUp(): void
  {
    $this->entorno = SifenTestEnvironment::init();
  }

  protected function tearDown(): void
  {
    ($this->entorno['cleanup'])();
    if ($this->cleanupCert) {
      ($this->cleanupCert)();
    }
  }

  /** @return array<string, array{0: callable(): mixed, 1: string, 2: string}> */
  public static function operaciones(): array
  {
    return [
      'EnviarDE' => [fn () => Sifen::EnviarDE('<rDE/>'), 'rEnviDe', 'EnviarDE'],
      'EnviarLoteDE' => [fn () => Sifen::EnviarLoteDE(['<rDE><DE Id="01800000000001001000000122026011510123456781"><gTimb><iTiDE>1</iTiDE></gTimb><gEmis><dRucEm>80000000</dRucEm></gEmis></DE></rDE>']), 'rEnvioLote', 'EnviarLoteDE'],
      'ConsultaLote' => [fn () => Sifen::ConsultaLote('123456789012345'), 'rEnviConsLoteDe', 'ConsultaLote'],
      'CancelarDE (RegistrarEvento)' => [fn () => Sifen::CancelarDE(E::CDC, 'Motivo de prueba'), 'rEnviEventoDe', 'RegistrarEvento'],
      'ConsultarArchivoRUC' => [fn () => Sifen::ConsultarArchivoRUC('80000000'), 'rEnviConsArchivoRUC', 'ConsultarArchivoRUC'],
      'ConsultarRUC' => [fn () => Sifen::ConsultarRUC('80000000'), 'rEnviConsRUC', 'ConsultarRUC'],
      'ConsultarDE' => [fn () => Sifen::ConsultarDE(E::CDC), 'REnviConsDe', 'ConsultarDE'],
    ];
  }

  #[DataProvider('operaciones')]
  public function testLaFallaDeComunicacionLlegaComoTransporteException(callable $llamar, string $operacionSoap, string $operacion): void
  {
    StubSoapClient::instalar([$operacionSoap => fn () => throw new SoapFault('Receiver', 'Servicio no disponible')]);
    try {
      $llamar();
      $this->fail('Se esperaba TransporteException');
    } catch (TransporteException $e) {
      $this->assertSame($operacion, $e->getOperacion());
      $this->assertSame(TipoFallaTransporte::SoapFault, $e->getTipo());
      $this->assertSame('Receiver', $e->faultcode);
      $this->assertInstanceOf(SoapFault::class, $e->getPrevious());
      $this->assertStringStartsWith('[Sifen]', $e->getMessage());
      $this->assertStringEndsWith(': Servicio no disponible', $e->getMessage());
      $this->assertInstanceOf(PkuatiaExceptionInterface::class, $e);
    }
  }

  public function testElCuerpoVacioEsSifenNoDisponible(): void
  {
    StubSoapClient::instalar(['rEnviConsRUC' => fn () => throw new SoapFault('Client', 'looks like we got no XML document')]);
    try {
      Sifen::ConsultarRUC('80000000');
      $this->fail('Se esperaba SifenNoDisponibleException');
    } catch (SifenNoDisponibleException $e) {
      $this->assertSame(TipoFallaTransporte::RespuestaVaciaONoXml, $e->getTipo());
      $this->assertTrue($e->esPosibleSaturacion());
    }
  }

  public function testElWsdlQueNoCargaEsSifenNoDisponibleYNoDejaRespuestaAnterior(): void
  {
    Sifen::SetSoapClientFactory(static fn (): SoapClient => throw new SoapFault('WSDL', "SOAP-ERROR: Parsing WSDL: Couldn't load from 'https://sifen-test.set.gov.py/de/ws/consultas/consulta.wsdl' : failed to load external entity"));
    try {
      Sifen::ConsultarDE(E::CDC);
      $this->fail('Se esperaba SifenNoDisponibleException');
    } catch (SifenNoDisponibleException $e) {
      $this->assertSame(TipoFallaTransporte::Wsdl, $e->getTipo());
      $this->assertSame('ConsultarDE', $e->getOperacion());
      $this->assertNull(Sifen::GetLastResponse());
    }
  }

  public function testUnErrorDeProgramaLlegaComoRespuestaExceptionConLaRespuestaCruda(): void
  {
    $crudo = '<?xml version="1.0" encoding="UTF-8"?><env:Envelope xmlns:env="http://www.w3.org/2003/05/soap-envelope"><env:Body>'
      . '<ns2:rResEnviConsRUC xmlns:ns2="http://ekuatia.set.gov.py/sifen/xsd"><ns2:dCodRes>abc</ns2:dCodRes><ns2:dMsgRes>x</ns2:dMsgRes>'
      . '</ns2:rResEnviConsRUC></env:Body></env:Envelope>';
    CapturaSoapClient::instalar($crudo);
    try {
      Sifen::ConsultarRUC('80000000');
      $this->fail('Se esperaba RespuestaException');
    } catch (RespuestaException $e) {
      $this->assertSame('ConsultarRUC', $e->getOperacion());
      $this->assertSame($crudo, $e->getRespuestaCruda());
      $this->assertInstanceOf(TypeError::class, $e->getPrevious());
    }

    StubSoapClient::instalar(['rEnviDe' => fn () => (object) ['rProtDe' => (object) ['dEstRes' => ['no es texto']]]]);
    try {
      Sifen::EnviarDE('<rDE/>');
      $this->fail('Se esperaba RespuestaException');
    } catch (RespuestaException $e) {
      $this->assertSame('EnviarDE', $e->getOperacion());
      $this->assertInstanceOf(TypeError::class, $e->getPrevious());
    }
  }

  public function testLaFactoriaInvalidaEsConfiguracionException(): void
  {
    Sifen::SetSoapClientFactory(static fn () => new \stdClass());
    $this->expectException(ConfiguracionException::class);
    Sifen::ConsultarRUC('80000000');
  }

  public function testInitSinArchivoDeClaveEsCertificadoException(): void
  {
    $config = new Config();
    $config->setCertificateFormat('pem')->setPrivateKeyFilePath(sys_get_temp_dir() . '/pkuatia-no-existe.pem')->setPrivateKeyPassphrase('x');
    try {
      Sifen::Init($config);
      $this->fail('Se esperaba CertificadoException');
    } catch (CertificadoException $e) {
      $this->assertSame(MotivoCertificado::NoEncontrado, $e->getMotivo());
      $this->assertInstanceOf(\Exception::class, $e);
    }
  }

  public function testLasValidacionesPreviasDelFacadeSonValidacionException(): void
  {
    try {
      Sifen::CancelarDE('123', 'Motivo de prueba');
      $this->fail('Se esperaba CampoInvalidoException por el CDC');
    } catch (CampoInvalidoException $e) {
      $this->assertSame('Id', $e->getElemento());
      $this->assertSame('123', $e->getValorRecibido());
      $this->assertStringContainsString('Evento_Types_v150.xsd:71-80', $e->getReglaEsperada());
    }
    try {
      Sifen::CancelarDE(E::CDC, 'abc');
      $this->fail('Se esperaba CampoInvalidoException por el motivo');
    } catch (CampoInvalidoException $e) {
      $this->assertSame('mOtEve', $e->getElemento());
      $this->assertInstanceOf(\InvalidArgumentException::class, $e);
    }
    try {
      Sifen::EnviarLoteDE([]);
      $this->fail('Se esperaba ValidacionException');
    } catch (ValidacionException $e) {
      $this->assertStringContainsString('al menos un documento', $e->getMessage());
    }
  }

  public function testNt024EsCampoInvalidoConElCodigoDelSifen(): void
  {
    $de = new \IonysDev\Pkuatia\Core\Fields\DE\A\DE();
    $gdgo = new \IonysDev\Pkuatia\Core\Fields\DE\D\GDatGralOpe();
    $gdr = new \IonysDev\Pkuatia\Core\Fields\DE\D\GDatRec();
    $gdr->setINatRec(\IonysDev\Pkuatia\Core\Constants\RecNat::NoContribuyente);
    $gdr->setITipIDRec(\IonysDev\Pkuatia\Core\Constants\TipIDRec::Innominado);
    $gdgo->setGDatRec($gdr);
    $de->setGDatGralOpe($gdgo);
    $tot = new \IonysDev\Pkuatia\Core\Fields\DE\F\GTotSub();
    $tot->dTotGralOpe = '7000000';
    $de->gTotSub = $tot;

    $validador = new \ReflectionMethod(Sifen::class, 'ValidarUmbralInnominadoNT024');
    try {
      $validador->invoke(null, $de);
      $this->fail('NT-024: innominado con 7M debe lanzar');
    } catch (CampoInvalidoException $e) {
      $this->assertSame('1321', $e->getCodigoSifen());
      $this->assertSame('D208', $e->getCampoMT());
      $this->assertSame('iTipIDRec', $e->getElemento());
      $this->assertStringContainsString('NT-024', $e->getMessage());
    }
  }

  public function testConfigLanzaConfiguracionException(): void
  {
    $this->expectException(ConfiguracionException::class);
    Config::ParseObject((object) ['certificateFormat' => 'pem']);
  }

  public function testElFormatoDeCertificadoNoSoportadoEsCertificadoException(): void
  {
    try {
      Config::normalizeCertificateFormat('der');
      $this->fail('Se esperaba CertificadoException');
    } catch (CertificadoException $e) {
      $this->assertSame(MotivoCertificado::NoSoportado, $e->getMotivo());
    }
  }

  public function testLaContrasenaIncorrectaDelPkcs12EsCertificadoException(): void
  {
    $p12 = TestCertFactory::createModernPkcs12('correct-pass');
    $this->cleanupCert = $p12['cleanup'];
    try {
      Pkcs12Helper::read(file_get_contents($p12['p12Path']), 'wrong-pass');
      $this->fail('Se esperaba CertificadoException');
    } catch (CertificadoException $e) {
      $this->assertSame(MotivoCertificado::PassphraseIncorrecta, $e->getMotivo());
      $this->assertMatchesRegularExpression('/contraseña.*incorrecta/i', $e->getMessage());
    }
  }

  public function testUnPemSinCertificadoEsCertificadoException(): void
  {
    try {
      PemHelper::extractCertificatePem('sin certificado');
      $this->fail('Se esperaba CertificadoException');
    } catch (CertificadoException $e) {
      $this->assertSame(MotivoCertificado::PemInvalido, $e->getMotivo());
    }
  }

  public function testSignHelperSinArchivoDeClaveEsCertificadoException(): void
  {
    try {
      SignHelper::Init(sys_get_temp_dir() . '/pkuatia-no-existe.pem', 'x', Config::CERT_FORMAT_PEM);
      $this->fail('Se esperaba CertificadoException');
    } catch (CertificadoException $e) {
      $this->assertSame(MotivoCertificado::NoEncontrado, $e->getMotivo());
    }
  }
}
