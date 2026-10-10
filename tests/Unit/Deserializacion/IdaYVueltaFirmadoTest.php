<?php

namespace IonysDev\Pkuatia\Tests\Unit\Deserializacion;

use DateTime;
use DateTimeZone;
use DOMDocument;
use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;
use IonysDev\Pkuatia\Core\Fields\DE\J\GCamFuFD;
use IonysDev\Pkuatia\Sifen;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory as F;
use IonysDev\Pkuatia\Tests\Support\RespuestasSifenFactory as R;
use IonysDev\Pkuatia\Tests\Support\RoundTrip;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Tests\Support\SignatureAssertions;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Fase B/B7 (PK-32): RDE::toDOMElement serializaba solo dVerFor y DE, así que un rDE firmado y leído perdía
 * Signature y gCamFuFD al volver a serializarse (orden de rDE: dVerFor, DE, Signature, gCamFuFD;
 * DE_v150.xsd:1939-1960). Un rDE leído de un XML firmado reemite ahora su firma tal como vino, y sigue
 * verificando; un rDE armado a mano se serializa como hasta 0.2.0.
 */
final class IdaYVueltaFirmadoTest extends TestCase
{
  /** @var callable */
  private $cleanup;

  protected function setUp(): void
  {
    $this->cleanup = SifenTestEnvironment::init()['cleanup'];
  }

  protected function tearDown(): void
  {
    ($this->cleanup)();
  }

  /** @return array<string, array{0: callable(): RDE, 1: string}> */
  public static function documentosPorVia(): array
  {
    $docs = [
      'FE contado' => fn (): RDE => F::rde(F::facturaContado()),
      'Nota de remisión' => fn (): RDE => F::rde(F::notaDeRemision()),
      'Autofactura' => fn (): RDE => F::rde(F::autofactura()),
    ];
    $res = [];
    foreach ($docs as $nombre => $crear) {
      foreach (['DOM' => RoundTrip::VIA_DOM, 'SimpleXML' => RoundTrip::VIA_SIMPLEXML] as $nombreVia => $via) {
        $res["$nombre por $nombreVia"] = [$crear, $via];
      }
    }
    return $res;
  }

  #[DataProvider('documentosPorVia')]
  public function testElDocumentoFirmadoHaceIdaYVueltaYSigueVerificando(callable $crear, string $via): void
  {
    $firmado = F::firmar($crear());
    SignatureAssertions::assertFirmaVerifica($firmado, 'original');
    $vuelta = RoundTrip::serializar(RoundTrip::leer($firmado, RDE::class, $via));
    $this->assertSame($firmado, $vuelta);
    SignatureAssertions::assertFirmaVerifica($vuelta, 'vuelta');
  }

  /** La FE de la captura real del 09/10/2026 (anonimizada: su firma ya no verifica, pero su estructura es la real). */
  #[DataProvider('vias')]
  public function testLaFeRealHaceIdaYVuelta(string $via): void
  {
    $rde = preg_replace('/^<\?xml[^>]*\?>\s*/', '', rtrim(R::crudo(R::FE_FIRMADA_0260)));
    $this->assertSame($rde, RoundTrip::serializar(RoundTrip::leer($rde, RDE::class, $via)));
  }

  /** @return array<string, array{0: string}> */
  public static function vias(): array
  {
    return ['DOM' => [RoundTrip::VIA_DOM], 'SimpleXML' => [RoundTrip::VIA_SIMPLEXML]];
  }

  /** Volver a firmar un rDE leído deja una sola firma y un solo gCamFuFD. */
  public function testVolverAFirmarUnDocumentoLeido(): void
  {
    $leido = RDE::FromSimpleXMLElement(simplexml_load_string(F::firmar(F::rde(F::facturaContado()))));
    $refirmado = Sifen::FirmarDE($leido, new DateTime('2026-01-15T11:00:00', new DateTimeZone('America/Asuncion')));
    $this->assertSame(1, substr_count($refirmado, '<Signature '));
    $this->assertSame(1, substr_count($refirmado, '<gCamFuFD>'));
    $this->assertStringContainsString('<dFecFirma>2026-01-15T11:00:00</dFecFirma>', $refirmado);
    SignatureAssertions::assertFirmaVerifica($refirmado, 'refirmado');
  }

  /** Un rDE armado a mano no cambia: sin Signature ni gCamFuFD, aunque tenga un gCamFuFD a medias. */
  public function testUnRdeArmadoAManoSeSerializaComoAntes(): void
  {
    $rde = F::rde(F::facturaContado());
    $rde->setGCamFuFD((new GCamFuFD())->setDInfAdic('Dato del emisor'));
    $doc = new DOMDocument();
    $doc->loadXML($rde->toXMLString());
    $this->assertSame(0, $doc->getElementsByTagName('gCamFuFD')->length);
    $this->assertSame(0, $doc->getElementsByTagName('Signature')->length);
    $firmado = F::firmar($rde);
    $this->assertStringContainsString('<dInfAdic>Dato del emisor</dInfAdic>', $firmado);
    SignatureAssertions::assertFirmaVerifica($firmado);
  }
}
