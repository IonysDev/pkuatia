<?php

namespace IonysDev\Pkuatia\Tests\Unit\Conformidad;

use DateTime;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\Factura;
use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamEsp;
use IonysDev\Pkuatia\Core\Fields\DE\E\GGrupAdi;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory;
use IonysDev\Pkuatia\Tests\Support\RoundTrip;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Tests\Support\XsdAssertions;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Q-B9 (decisión del 10/10/2026): gGrupEner admite hasta 9 ocurrencias (DE_v150.xsd:802; NT-023, un
 * grupo por medidor) y dVencPag hasta 3 (tgGrupAdi, DE_v150.xsd:829). Hasta 0.2.0 la librería guardaba
 * una sola de cada uno: no se podían emitir más y al leer un DE recibido se descartaban sin aviso.
 */
final class OcurrenciasMultiplesTest extends TestCase
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

  private static function facturaConTresMedidores(int $numDoc = 70): Factura
  {
    $fe = DocumentoFactory::facturaSectorial('energía', $numDoc);
    $fe->addDatosComplementariosSectorEnergia('MED-002', 1, 'R', '10.00', '30.00', '20.00');
    $fe->addDatosComplementariosSectorEnergia('MED-003', 1, 'R', '5.00', '9.00', '4.00');
    return $fe;
  }

  /** Tres medidores y tres vencimientos, junto con los otros grupos sectoriales. */
  private static function facturaCompleta(): Factura
  {
    $fe = self::facturaConTresMedidores(73);
    (DocumentoFactory::sectores()['datos adicionales'])($fe);
    $fe->addVencimientoDePagoDeUsoComercial(new DateTime('2026-03-15'));
    $fe->addVencimientoDePagoDeUsoComercial(new DateTime('2026-04-15'));
    return $fe;
  }

  public function testTresMedidoresSeEmitenEnOrdenYValidan(): void
  {
    $xml = DocumentoFactory::firmar(self::facturaConTresMedidores()->facturaToRDE());
    $this->assertSame(3, substr_count($xml, '<gGrupEner>'));
    $this->assertLessThan(strpos($xml, 'MED-002'), strpos($xml, 'MED-001'));
    $this->assertLessThan(strpos($xml, 'MED-003'), strpos($xml, 'MED-002'));
    XsdAssertions::assertRdeValido($xml, 'FE con tres medidores');
  }

  public function testElDecimoMedidorSeRechaza(): void
  {
    $fe = DocumentoFactory::facturaSectorial('energía', 71);
    for ($i = 2; $i <= 9; $i++) {
      $fe->addDatosComplementariosSectorEnergia("MED-00$i", 1, 'R', '1.00', '2.00', '1.00');
    }
    $this->expectException(\InvalidArgumentException::class);
    $this->expectExceptionMessage('9');
    $fe->addDatosComplementariosSectorEnergia('MED-010', 1, 'R', '1.00', '2.00', '1.00');
  }

  /** setDatosComplementariosSectorEnergia() sigue reemplazando: queda un solo medidor, como hasta 0.2.0. */
  public function testSetReemplazaTodosLosMedidores(): void
  {
    $fe = self::facturaConTresMedidores(72);
    $fe->setDatosComplementariosSectorEnergia('MED-UNICO', 1, 'R', '1.00', '2.00', '1.00');
    $xml = RoundTrip::serializar(DocumentoFactory::rde($fe));
    $this->assertSame(1, substr_count($xml, '<gGrupEner>'));
    $this->assertStringContainsString('<dNroMed>MED-UNICO</dNroMed>', $xml);
  }

  public function testTresVencimientosSeEmitenEnOrdenYValidanYElCuartoSeRechaza(): void
  {
    $fe = self::facturaCompleta();
    $xml = DocumentoFactory::firmar($fe->facturaToRDE());
    $this->assertStringContainsString('<dVencPag>2026-02-15</dVencPag><dVencPag>2026-03-15</dVencPag><dVencPag>2026-04-15</dVencPag>', $xml);
    XsdAssertions::assertRdeValido($xml, 'FE con tres medidores y tres vencimientos');

    $this->expectException(\InvalidArgumentException::class);
    $this->expectExceptionMessage('3');
    $fe->addVencimientoDePagoDeUsoComercial(new DateTime('2026-05-15'));
  }

  /** @return array<string, array{0: string}> */
  public static function vias(): array
  {
    return ['DOM' => [RoundTrip::VIA_DOM], 'SimpleXML' => [RoundTrip::VIA_SIMPLEXML]];
  }

  #[DataProvider('vias')]
  public function testIdaYVueltaDelDocumentoEsIdentica(string $via): void
  {
    RoundTrip::assertIdaYVueltaIdentica(DocumentoFactory::rde(self::facturaCompleta()), $via);
  }

  public function testIdaYVueltaPorObjetoSoap(): void
  {
    $gCamEsp = DocumentoFactory::rde(self::facturaCompleta())->getDE()->getGDtipDe()->getGCamEsp();
    RoundTrip::assertIdaYVueltaIdentica($gCamEsp, RoundTrip::VIA_SOAP, GCamEsp::class);
    RoundTrip::assertIdaYVueltaIdentica($gCamEsp->getGGrupAdi(), RoundTrip::VIA_SOAP, GGrupAdi::class);
  }

  /** La lectura conserva todas las ocurrencias; los getters de siempre devuelven la primera. */
  public function testLaLecturaConservaTodasLasOcurrencias(): void
  {
    $xml = RoundTrip::serializar(DocumentoFactory::rde(self::facturaCompleta()));
    /** @var RDE $leido */
    $leido = RoundTrip::leer($xml, RDE::class, RoundTrip::VIA_SIMPLEXML);
    $gCamEsp = $leido->getDE()->getGDtipDe()->getGCamEsp();
    $this->assertCount(3, $gCamEsp->getGGrupEners());
    $this->assertSame('MED-001', $gCamEsp->getgGrupEner()->getDNroMed());
    $this->assertSame('MED-003', $gCamEsp->getGGrupEners()[2]->getDNroMed());
    $this->assertCount(3, $gCamEsp->getGGrupAdi()->getDVencPags());
    $this->assertSame('2026-02-15', $gCamEsp->getGGrupAdi()->getDVencPag()->format('Y-m-d'));
  }
}
