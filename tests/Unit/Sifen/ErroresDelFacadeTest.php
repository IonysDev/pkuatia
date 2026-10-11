<?php

namespace IonysDev\Pkuatia\Tests\Unit\Sifen;

use IonysDev\Pkuatia\Core\Config;
use IonysDev\Pkuatia\Sifen;
use IonysDev\Pkuatia\Tests\Support\CapturaSoapClient;
use IonysDev\Pkuatia\Tests\Support\EventoFactory as E;
use IonysDev\Pkuatia\Tests\Support\RespuestasSifenFactory as R;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Tests\Support\StubSoapClient;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SoapClient;
use SoapFault;
use TypeError;

/**
 * Fase B/B6 (PK-31) con la decisión Q-B4: los cinco métodos que ya envolvían errores conservan la causa
 * (previous) y también envuelven los errores de programa (\Throwable); ConsultarRUC y ConsultarDE dejan pasar
 * el SoapFault como hasta 0.2.0 y solo envuelven los \Error del parseo. GetLastRequest()/GetLastResponse()
 * permiten guardar la respuesta cruda aunque el parseo falle. Config suma connection_timeout y user_agent.
 */
final class ErroresDelFacadeTest extends TestCase
{
  /** @var array{config: Config, cleanup: callable} */
  private array $entorno;

  protected function setUp(): void
  {
    $this->entorno = SifenTestEnvironment::init();
  }

  protected function tearDown(): void
  {
    ($this->entorno['cleanup'])();
  }

  /** @return array<string, array{0: callable(): mixed, 1: string}> */
  public static function operacionesEnvueltas(): array
  {
    return [
      'EnviarDE' => [fn () => Sifen::EnviarDE('<rDE/>'), 'rEnviDe'],
      // rDE mínimo con lo que EnviarLoteDE valida antes de la red desde B10 (CDC, tipo de documento y RUC emisor).
      'EnviarLoteDE' => [fn () => Sifen::EnviarLoteDE(['<rDE><DE Id="01800000000001001000000122026011510123456781"><gTimb><iTiDE>1</iTiDE></gTimb><gEmis><dRucEm>80000000</dRucEm></gEmis></DE></rDE>']), 'rEnvioLote'],
      'ConsultaLote' => [fn () => Sifen::ConsultaLote('123456789012345'), 'rEnviConsLoteDe'],
      'CancelarDE (RegistrarEvento)' => [fn () => Sifen::CancelarDE(E::CDC, 'Motivo de prueba'), 'rEnviEventoDe'],
      'ConsultarArchivoRUC' => [fn () => Sifen::ConsultarArchivoRUC('80000000'), 'rEnviConsArchivoRUC'],
    ];
  }

  /** Hasta 0.2.0 se perdía el SoapFault (faultcode, detalle, traza): solo quedaba su mensaje concatenado. */
  #[DataProvider('operacionesEnvueltas')]
  public function testElSoapFaultQuedaComoCausa(callable $llamar, string $operacion): void
  {
    StubSoapClient::instalar([$operacion => fn () => throw new SoapFault('Receiver', 'Servicio no disponible')]);
    try {
      $llamar();
      $this->fail('Se esperaba una excepción');
    } catch (\Exception $e) {
      $this->assertStringStartsWith('[Sifen]', $e->getMessage());
      $this->assertInstanceOf(SoapFault::class, $e->getPrevious());
      $this->assertSame('Receiver', $e->getPrevious()->faultcode);
    }
  }

  /** Q-B4, parte 1: un TypeError del parseo llega como la excepción del facade, con la causa. */
  public function testUnErrorDeProgramaLlegaEnvueltoEnElEnvio(): void
  {
    StubSoapClient::instalar(['rEnviDe' => fn () => (object) ['rProtDe' => (object) ['dEstRes' => ['no es texto']]]]);
    try {
      Sifen::EnviarDE('<rDE/>');
      $this->fail('Se esperaba una excepción');
    } catch (\Exception $e) {
      $this->assertStringStartsWith('[Sifen]', $e->getMessage());
      $this->assertInstanceOf(TypeError::class, $e->getPrevious());
    }
  }

  /** Q-B4, parte 2 (b): en las consultas el SoapFault sigue llegando tal cual, como hasta 0.2.0. */
  public function testLasConsultasDejanPasarElSoapFault(): void
  {
    StubSoapClient::instalar([
      'rEnviConsRUC' => fn () => throw new SoapFault('Receiver', 'RUC'),
      'REnviConsDe' => fn () => throw new SoapFault('Receiver', 'DE'),
    ]);
    foreach ([fn () => Sifen::ConsultarRUC('80000000'), fn () => Sifen::ConsultarDE(E::CDC)] as $llamar) {
      try {
        $llamar();
        $this->fail('Se esperaba un SoapFault');
      } catch (SoapFault $e) {
        $this->assertSame('Receiver', $e->faultcode);
      }
    }
  }

  /** Q-B4, parte 2 (b): en las consultas solo se envuelven los \Error del parseo. */
  public function testLasConsultasEnvuelvenLosErroresDeProgramaYConservanLaRespuestaCruda(): void
  {
    $crudo = '<?xml version="1.0" encoding="UTF-8"?><env:Envelope xmlns:env="http://www.w3.org/2003/05/soap-envelope"><env:Body>'
      . '<ns2:rResEnviConsRUC xmlns:ns2="http://ekuatia.set.gov.py/sifen/xsd"><ns2:dCodRes>abc</ns2:dCodRes><ns2:dMsgRes>x</ns2:dMsgRes>'
      . '</ns2:rResEnviConsRUC></env:Body></env:Envelope>';
    CapturaSoapClient::instalar($crudo);
    try {
      Sifen::ConsultarRUC('80000000');
      $this->fail('Se esperaba una excepción');
    } catch (\Exception $e) {
      $this->assertStringStartsWith('[Sifen]', $e->getMessage());
      $this->assertInstanceOf(TypeError::class, $e->getPrevious());
      $this->assertSame($crudo, Sifen::GetLastResponse());
    }

    StubSoapClient::instalar(['REnviConsDe' => fn () => (object) ['dFecProc' => '2026-10-09T17:04:35-03:00', 'dCodRes' => '0420', 'dMsgRes' => ['no es texto']]]);
    try {
      Sifen::ConsultarDE(E::CDC);
      $this->fail('Se esperaba una excepción');
    } catch (\Exception $e) {
      $this->assertInstanceOf(TypeError::class, $e->getPrevious());
    }
  }

  public function testUltimaPeticionYRespuesta(): void
  {
    $this->assertNull(Sifen::GetLastRequest(), 'Init() empieza sin cliente');
    $this->assertNull(Sifen::GetLastResponse());
    R::instalar(R::ENVIO_DE_0260);
    Sifen::EnviarDE('<rDE/>');
    $this->assertSame(R::crudo(R::ENVIO_DE_0260), Sifen::GetLastResponse());
    $this->assertStringContainsString('rEnviDe', Sifen::GetLastRequest());
  }

  /**
   * QA de la Fase B: si crear el cliente falla (por ejemplo, el WSDL no responde), GetLastRequest() y
   * GetLastResponse() no deben devolver la petición y la respuesta de la llamada anterior.
   */
  public function testSiFallaCrearElClienteNoQuedaLaRespuestaAnterior(): void
  {
    R::instalar(R::RUC_0502);
    Sifen::ConsultarRUC('80000000');
    $this->assertNotNull(Sifen::GetLastResponse());

    Sifen::SetSoapClientFactory(static fn (): SoapClient => throw new SoapFault('Receiver', 'WSDL no disponible'));
    try {
      Sifen::ConsultarDE('01800000000001001000000122026011510123456781');
      $this->fail('Se esperaba el SoapFault.');
    } catch (SoapFault $e) {
      $this->assertNull(Sifen::GetLastResponse());
      $this->assertNull(Sifen::GetLastRequest());
    }
  }

  /**
   * QA de la Fase B: la consulta masiva de RUC pasa por la lectura del rechazo genérico (B13b), así que su respuesta
   * tiene que leer rProtDe como las demás; si no, devolvía una respuesta vacía en lugar del 0160.
   */
  public function testConsultarArchivoRucLeeElRechazoGenerico(): void
  {
    R::instalar(R::RUC_0160);

    $respuesta = Sifen::ConsultarArchivoRUC('80000000');

    $this->assertSame(160, $respuesta->getDCodRes());
    $this->assertSame('XML Mal Formado.', $respuesta->getDMsgRes());
    $this->assertNull($respuesta->getArchivoZip());
  }

  public function testOpcionesDeConexionConfigurables(): void
  {
    $opciones = null;
    $fabrica = function (string $wsdl, array $options) use (&$opciones): SoapClient {
      $opciones = $options;
      return new CapturaSoapClient(R::crudo(R::RUC_0502));
    };

    $config = $this->entorno['config'];
    Sifen::Init($config);
    Sifen::SetSoapClientFactory($fabrica);
    Sifen::ConsultarRUC('80000000');
    $this->assertArrayNotHasKey('connection_timeout', $opciones, 'sin configurar, como hasta 0.2.0');
    $this->assertArrayNotHasKey('user_agent', $opciones);

    $config->setSoapConnectionTimeout(5)->setSoapUserAgent('PKuatia-Test');
    Sifen::Init($config);
    Sifen::SetSoapClientFactory($fabrica);
    Sifen::ConsultarRUC('80000000');
    $this->assertSame(5, $opciones['connection_timeout']);
    $this->assertSame('PKuatia-Test', $opciones['user_agent']);
  }

  public function testOpcionesDesdeJson(): void
  {
    $config = Config::ParseObject((object) ['privateKeyFilePath' => 'x.pem', 'privateKeyPassphrase' => 'x',
      'soapConnectionTimeout' => 7, 'soapUserAgent' => 'Agente']);
    $this->assertSame(7, $config->soapConnectionTimeout);
    $this->assertSame('Agente', $config->soapUserAgent);
  }
}
