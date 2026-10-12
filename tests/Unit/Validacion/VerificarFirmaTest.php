<?php

namespace IonysDev\Pkuatia\Tests\Unit\Validacion;

use DateTime;
use DateTimeZone;
use IonysDev\Pkuatia\Core\Config;
use IonysDev\Pkuatia\Core\Constants;
use IonysDev\Pkuatia\Helpers\SignHelper;
use IonysDev\Pkuatia\Sifen;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory;
use IonysDev\Pkuatia\Tests\Support\MinimalRdeFactory;
use IonysDev\Pkuatia\Tests\Support\RespuestasSifenFactory as R;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Tests\Support\TestCertFactory;
use IonysDev\Pkuatia\Validacion\CertificadoFirma;
use IonysDev\Pkuatia\Validacion\OrigenError;
use IonysDev\Pkuatia\Validacion\ResultadoFirma;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Paso C8 de la Fase C: Sifen::VerificarFirma() (evaluación §6.2, receta de xmlseclibs ya probada en
 * SignatureAssertions). Control positivo: documentos firmados en el test con un certificado autofirmado. Control
 * negativo: las capturas anonimizadas de sifen-test, cuya firma ya no verifica. Reglas: MT §12.2.4-12.2.5 (0120, 0121,
 * 0140, 0141), §12.4 I002 (2450), NT-016 (algoritmos; ekuat-ia reglas-de-validacion.md FIRMA-001..007).
 */
final class VerificarFirmaTest extends TestCase
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

  private static function ahora(): DateTime
  {
    return new DateTime('now', new DateTimeZone(Constants::SIFEN_TIMEZONE));
  }

  private function facturaFirmada(?DateTime $fecha = null): array
  {
    $rde = DocumentoFactory::facturaContado(1)->facturaToRDE();
    $fecha ??= self::ahora();
    return [Sifen::FirmarDE($rde, $fecha), $rde->getDE()->getId(), $fecha];
  }

  public function testUnaFacturaFirmadaConElCertificadoDePruebaEsValida(): void
  {
    [$xml, $cdc, $fecha] = $this->facturaFirmada();
    $r = Sifen::VerificarFirma($xml);
    $this->assertInstanceOf(ResultadoFirma::class, $r);
    $this->assertTrue($r->esValida(), (string) $r);
    $this->assertSame('rDE', $r->getTipoDocumento());
    $this->assertCount(1, $r);
    $this->assertSame([], $r->getErrores());

    $f = $r->getFirmas()[0];
    $this->assertSame('#' . $cdc, $f->referenciaUri);
    $this->assertTrue($f->digestValido);
    $this->assertTrue($f->firmaValida);
    $this->assertTrue($f->cumpleEstandar);
    $this->assertSame('http://www.w3.org/2001/04/xmldsig-more#rsa-sha256', $f->algoritmos['firma']);
    $this->assertSame('http://www.w3.org/2001/04/xmlenc#sha256', $f->algoritmos['digest']);
    $this->assertSame('http://www.w3.org/2001/10/xml-exc-c14n#', $f->algoritmos['canonicalizacion']);
    $this->assertContains('http://www.w3.org/2000/09/xmldsig#enveloped-signature', $f->algoritmos['transforms']);
    $this->assertStringContainsString('PKuatia Unit Test', $f->certificado->sujeto);
    $this->assertNull($f->certificado->ruc, 'el certificado de prueba no lleva RUC');
    $this->assertTrue($f->certificadoVigenteAlFirmar);
    $this->assertSame($fecha->format('Y-m-d\TH:i:s'), $f->fechaFirma->format('Y-m-d\TH:i:s'));
    $this->assertTrue($f->esValida());
  }

  public function testUnSobreConDosEventosTieneDosFirmasValidas(): void
  {
    $sobre = MinimalRdeFactory::createCancellationEventsEnvelope();
    foreach ($sobre->getRGesEve() as $rGesEve) {
      $rGesEve->getREve()->setDFecFirma(self::ahora()); // el certificado de prueba vale desde hoy
    }
    $doc = SignHelper::SingEvents($sobre, $this->entorno['config']);
    $xml = $doc->saveXML($doc->getElementsByTagName('gGroupGesEve')->item(0));
    $r = Sifen::VerificarFirma($xml);
    $this->assertTrue($r->esValida(), (string) $r);
    $this->assertSame('gGroupGesEve', $r->getTipoDocumento());
    $this->assertCount(2, $r);
    $this->assertSame(['#1', '#2'], array_map(fn ($f) => $f->referenciaUri, $r->getFirmas()));
    foreach ($r->getFirmas() as $f) {
      $this->assertTrue($f->digestValido && $f->firmaValida && $f->cumpleEstandar);
      $this->assertNotNull($f->fechaFirma, 'dFecFirma del rEve');
      $this->assertTrue($f->certificadoVigenteAlFirmar);
    }
  }

  public function testElContenidoAlteradoInvalidaElDigest(): void
  {
    [$xml] = $this->facturaFirmada();
    $alterado = preg_replace('/<dNomEmi>[^<]*<\/dNomEmi>/', '<dNomEmi>Emisor Alterado</dNomEmi>', $xml, 1, $n);
    $this->assertSame(1, $n);
    $r = Sifen::VerificarFirma($alterado);
    $this->assertFalse($r->esValida());
    $f = $r->getFirmas()[0];
    $this->assertFalse($f->digestValido);
    $this->assertTrue($f->firmaValida, 'SignedInfo no cambió: lo que falla es el digest del DE');
    $this->assertSame('0141', $r->getErrores()[0]->codigoSifen);
    $this->assertSame(OrigenError::Firma, $r->getErrores()[0]->origen);
    $this->assertStringContainsStringIgnoringCase('digest', $r->getErrores()[0]->mensaje);
  }

  public function testLaFirmaAlteradaNoVerifica(): void
  {
    [$xml] = $this->facturaFirmada();
    $alterado = preg_replace('/<SignatureValue>[A-Za-z0-9+\/]{8}/', '<SignatureValue>AAAAAAAA', $xml, 1, $n);
    $this->assertSame(1, $n);
    $r = Sifen::VerificarFirma($alterado);
    $this->assertFalse($r->esValida());
    $f = $r->getFirmas()[0];
    $this->assertTrue($f->digestValido);
    $this->assertFalse($f->firmaValida);
    $this->assertSame('0141', $r->getErrores()[0]->codigoSifen);
    $this->assertStringContainsString('SignatureValue', $r->getErrores()[0]->mensaje);
  }

  public function testElCertificadoDebeEstarVigenteAlFirmar(): void
  {
    [$xml] = $this->facturaFirmada(new DateTime('2020-01-01T10:00:00', new DateTimeZone(Constants::SIFEN_TIMEZONE)));
    $r = Sifen::VerificarFirma($xml);
    $this->assertFalse($r->esValida());
    $f = $r->getFirmas()[0];
    $this->assertTrue($f->digestValido && $f->firmaValida, 'la firma es correcta; lo que falla es la vigencia');
    $this->assertFalse($f->certificadoVigenteAlFirmar);
    $this->assertSame('2450', $r->getErrores()[0]->codigoSifen, 'I002: certificado no vigente al momento de la firma');
    $this->assertSame('I002', $r->getErrores()[0]->campoMT);
  }

  public function testExtraeElRucDelCertificado(): void
  {
    $cert = TestCertFactory::createSelfSignedPem('pass', ['serialNumber' => 'RUC80000000-5']);
    try {
      $c = CertificadoFirma::desdePem(file_get_contents($cert['pemPath']));
      $this->assertSame('RUC80000000-5', $c->serialNumber);
      $this->assertSame('80000000-5', $c->ruc);
      $this->assertStringContainsString('PKuatia Unit Test', $c->sujeto);
      $this->assertTrue($c->vigenteEn(new DateTime()));
      $this->assertFalse($c->vigenteEn(new DateTime('2020-01-01')));
      $this->assertInstanceOf(DateTime::class, $c->validoDesde);
      $this->assertInstanceOf(DateTime::class, $c->validoHasta);
      $this->assertStringContainsString('BEGIN CERTIFICATE', $c->pem);
    } finally {
      ($cert['cleanup'])();
    }
  }

  /** @return iterable<string, array{string}> los rDE anonimizados de las capturas (firma no verificable por diseño) */
  public static function capturasFirmadas(): iterable
  {
    foreach (glob(R::DIR . '/*/*-firmada-anonimizada.xml') as $ruta) {
      yield basename(dirname($ruta)) . '/' . basename($ruta) => [$ruta];
    }
  }

  #[DataProvider('capturasFirmadas')]
  public function testLasCapturasAnonimizadasNoVerifican(string $ruta): void
  {
    $r = Sifen::VerificarFirma(file_get_contents($ruta));
    $this->assertFalse($r->esValida());
    $this->assertCount(1, $r, 'la estructura de la firma se lee aunque no verifique');
    $this->assertStringStartsWith('#', $r->getFirmas()[0]->referenciaUri);
    $this->assertNotEmpty($r->getErrores());
    foreach ($r->getErrores() as $e) {
      $this->assertSame(OrigenError::Firma, $e->origen);
      $this->assertContains($e->codigoSifen, ['0120', '0141'], $e->mensaje);
    }
  }

  public function testSinFirmaYXmlMalFormado(): void
  {
    $r = Sifen::VerificarFirma('<rDE xmlns="http://ekuatia.set.gov.py/sifen/xsd"><DE Id="x"/></rDE>');
    $this->assertFalse($r->esValida());
    $this->assertCount(0, $r);
    $this->assertSame('rDE', $r->getTipoDocumento());
    $this->assertSame('0140', $r->getErrores()[0]->codigoSifen);

    $r = Sifen::VerificarFirma('<rDE>');
    $this->assertFalse($r->esValida());
    $this->assertStringContainsStringIgnoringCase('mal formado', $r->getErrores()[0]->mensaje);

    $r = Sifen::VerificarFirma('<otro/>');
    $this->assertFalse($r->esValida());
    $this->assertSame('desconocido', $r->getTipoDocumento());
    $this->assertStringContainsString('0140', (string) $r);
  }
}
