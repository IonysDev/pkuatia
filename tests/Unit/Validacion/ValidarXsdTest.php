<?php

namespace IonysDev\Pkuatia\Tests\Unit\Validacion;

use IonysDev\Pkuatia\Core\Config;
use IonysDev\Pkuatia\Core\Exceptions\DocumentoInvalidoException;
use IonysDev\Pkuatia\Sifen;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory as F;
use IonysDev\Pkuatia\Tests\Support\EventoFactory;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Tests\Support\StubSoapClient;
use IonysDev\Pkuatia\Validacion\CatalogoValidaciones;
use IonysDev\Pkuatia\Validacion\OrigenError;
use IonysDev\Pkuatia\Validacion\ValidadorXsd;
use PHPUnit\Framework\TestCase;

/**
 * Paso C7 de la Fase C (evaluación §6.3): Sifen::ValidarXSD() y ValidarEventoXSD() validan un XML contra los XSD de
 * producción incluidos en la librería, sin red y sin Init(); cada error de libxml se traduce a un ErrorValidacion con
 * origen XSD, código 0160 (AE01, lo que el SIFEN responde a un XML que no cumple el esquema), elemento, campo del MT y
 * línea. Config::$validarXsdAntesDeEnviar (opt-in) hace que EnviarDE, EnviarLoteDE y RegistrarEvento validen antes de
 * tocar la red y lancen DocumentoInvalidoException.
 */
final class ValidarXsdTest extends TestCase
{
  private const CAPTURAS = __DIR__ . '/../../Resources/sifen/respuestas-ws';

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

  private static function feFirmada(): string
  {
    return F::firmar(F::rde(F::facturaContado()));
  }

  private static function conSerieInvalida(string $xml): string
  {
    $con = str_replace('</dNumDoc>', '</dNumDoc><dSerieNum>0</dSerieNum>', $xml);
    assert($con !== $xml);
    return $con;
  }

  public function testUnaFacturaFirmadaValida(): void
  {
    $r = Sifen::ValidarXSD(self::feFirmada());
    $this->assertTrue($r->esValido(), (string) $r);
    $this->assertCount(0, $r);
  }

  public function testUnCampoInvalidoSeReportaConElementoCampoYLinea(): void
  {
    $r = Sifen::ValidarXSD(self::conSerieInvalida(self::feFirmada()));
    $this->assertFalse($r->esValido());
    $this->assertCount(1, $r, (string) $r);
    $e = $r->getErrores()[0];
    $this->assertSame(OrigenError::Xsd, $e->origen);
    $this->assertSame('0160', $e->codigoSifen);
    $this->assertSame('dSerieNum', $e->elemento);
    $this->assertSame('C010', $e->campoMT);
    $this->assertNotNull($e->linea);
    $this->assertStringContainsString("'0'", $e->mensaje);
    $this->assertStringNotContainsString('{http://', $e->mensaje, 'el espacio de nombres no ensucia el mensaje');
    $this->assertCount(1, $r->porOrigen(OrigenError::Xsd));
  }

  public function testUnElementoFaltanteIndicaQueFaltaYDonde(): void
  {
    $xml = preg_replace('#<dCodInt>[^<]*</dCodInt>#', '', self::feFirmada(), 1);
    $r = Sifen::ValidarXSD($xml);
    $this->assertFalse($r->esValido());
    $e = $r->getErrores()[0];
    // libxml señala el elemento que aparece donde esperaba dCodInt (o el padre, según la versión): lo que importa es
    // que el mensaje y la sugerencia digan qué falta.
    $this->assertContains($e->elemento, ['gCamItem', 'dDesProSer']);
    $this->assertSame('E700', CatalogoValidaciones::campoMT('gCamItem'));
    $this->assertStringContainsString('dCodInt', $e->mensaje);
    $this->assertStringContainsString('dCodInt', (string) $e->sugerencia);
    $this->assertNotNull($e->campoMT);
  }

  public function testLaFacturaB2GConComprasPublicasValidaGraciasALaCopiaLocal(): void
  {
    $xml = F::firmar(F::rde(F::facturaConTodosLosOpcionales()));
    $this->assertStringContainsString('<dEntCont>', $xml);
    $this->assertTrue(Sifen::ValidarXSD($xml)->esValido());
  }

  public function testLosDocumentosAprobadosPorElSifenValidan(): void
  {
    $archivos = array_merge(glob(self::CAPTURAS . '/2026-10-11/*-firmada-anonimizada.xml') ?: [], glob(self::CAPTURAS . '/2026-10-09/*-firmada-anonimizada.xml') ?: []);
    $this->assertGreaterThanOrEqual(9, count($archivos));
    foreach ($archivos as $archivo) {
      $r = Sifen::ValidarXSD((string) file_get_contents($archivo));
      $this->assertTrue($r->esValido(), basename($archivo) . ': ' . $r);
    }
  }

  public function testSobreDeEventosValidoEInvalido(): void
  {
    $xml = EventoFactory::firmar(EventoFactory::sobreDe(EventoFactory::cancelacion()));
    $this->assertTrue(Sifen::ValidarEventoXSD($xml)->esValido());
    $this->assertFalse(Sifen::ValidarXSD($xml)->esValido(), 'un sobre de eventos no es un rDE');
    $sinMotivo = preg_replace('#<mOtEve>[^<]*</mOtEve>#', '', $xml, 1);
    $this->assertNotSame($xml, $sinMotivo);
    $r = Sifen::ValidarEventoXSD($sinMotivo);
    $this->assertFalse($r->esValido());
    $this->assertSame('rGeVeCan', $r->getErrores()[0]->elemento);
    $this->assertStringContainsString('mOtEve', $r->getErrores()[0]->mensaje);
  }

  public function testXmlMalFormadoOVacioDaUnSoloErrorSinElemento(): void
  {
    foreach (['<rDE><DE>', '', 'esto no es xml'] as $xml) {
      $r = Sifen::ValidarXSD($xml);
      $this->assertCount(1, $r, var_export($xml, true));
      $this->assertNull($r->getErrores()[0]->elemento);
      $this->assertSame('0160', $r->getErrores()[0]->codigoSifen);
      $this->assertStringContainsString('mal formado', $r->getErrores()[0]->mensaje);
    }
  }

  public function testValidadorXsdAceptaUnEsquemaCualquiera(): void
  {
    $r = ValidadorXsd::validar(self::feFirmada(), ValidadorXsd::XSD_DIR . '/siRecepDE_v150.xsd');
    $this->assertTrue($r->esValido());
  }

  public function testLaOpcionSeConfiguraPorPropiedadSetterYJson(): void
  {
    $config = new Config();
    $this->assertFalse($config->validarXsdAntesDeEnviar, 'opt-in: por defecto EnviarDE no cambia');
    $this->assertSame($config, $config->setValidarXsdAntesDeEnviar(true));
    $this->assertTrue($config->validarXsdAntesDeEnviar);
    $this->assertTrue(Config::ParseObject((object) ['privateKeyFilePath' => 'x.pem', 'privateKeyPassphrase' => 'x', 'validarXsdAntesDeEnviar' => true])->validarXsdAntesDeEnviar);
  }

  public function testConLaOpcionActivaEnviarDENoTocaLaRedSiElXmlNoCumpleElXsd(): void
  {
    StubSoapClient::instalar(['rEnviDe' => static fn () => throw new \RuntimeException('cliente llamado')]);
    $invalido = self::conSerieInvalida(self::feFirmada());

    // Por defecto (false): el XML llega al cliente como hasta 0.2.1
    try {
      Sifen::EnviarDE($invalido);
      $this->fail('el stub debía ser llamado');
    } catch (\Throwable $e) {
      $this->assertStringContainsString('cliente llamado', $e->getMessage());
    }

    $this->entorno['config']->validarXsdAntesDeEnviar = true;
    Sifen::Init($this->entorno['config']);
    StubSoapClient::instalar(['rEnviDe' => static fn () => throw new \RuntimeException('cliente llamado')]);
    try {
      Sifen::EnviarDE($invalido);
      $this->fail('debe lanzar DocumentoInvalidoException');
    } catch (DocumentoInvalidoException $e) {
      $this->assertNull(StubSoapClient::ultimoRequest(), 'no se llamó al cliente');
      $this->assertStringContainsString('EnviarDE', $e->getMessage());
      $this->assertStringContainsString('XSD', $e->getMessage());
      $this->assertSame('dSerieNum', $e->getResultado()?->getErrores()[0]->elemento);
    }
    $this->expectException(DocumentoInvalidoException::class);
    Sifen::EnviarLoteDE([$invalido]);
  }

  public function testConLaOpcionActivaUnDocumentoValidoSigueLlegandoAlCliente(): void
  {
    $this->entorno['config']->validarXsdAntesDeEnviar = true;
    Sifen::Init($this->entorno['config']);
    StubSoapClient::instalar(['rEnviEventoDe' => static fn () => StubSoapClient::respuestaEventoAprobado()]);
    $respuesta = Sifen::RegistrarEvento(EventoFactory::sobreDe(EventoFactory::cancelacion()));
    $this->assertTrue($respuesta->esExitosa());
    $this->assertNotNull(StubSoapClient::ultimoRequest());
  }
}
