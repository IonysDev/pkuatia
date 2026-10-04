<?php

namespace IonysDev\Pkuatia\Tests\Unit\Conformidad;

use DateTime;
use IonysDev\Pkuatia\Core\Constants\CamIVAAfecIVA;
use IonysDev\Pkuatia\Core\Constants\CamIVATasaIVA;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Tests\Support\XsdAssertions;
use PHPUnit\Framework\TestCase;

/**
 * PK-06 (orden y typo en GCamEsp: secuencia gGrupEner, gGrupSeg, gGrupSup, gGrupAdi de tgCamEsp),
 * PK-07 (GGrupAdi: fechas 'yyyy-mm-dd' y opcionales sin isset), PK-08 (GRasMerc/GGrupSup/GCamCarg
 * emitían opcionales sin isset) y PK-19 (GGrupEner::getDConKwh devolvía siempre 0).
 */
final class GruposSectorialesTest extends TestCase
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

  public function testSectorEnergiaInformaElConsumoYValida(): void
  {
    $fe = DocumentoFactory::facturaContado(50);
    $fe->setDatosComplementariosSectorEnergia('MED-001', 1, 'R', '100.00', '250.00', '150.00');
    $xml = DocumentoFactory::firmar($fe->facturaToRDE());
    $this->assertStringContainsString('<dConKwh>150.00</dConKwh>', $xml);
    XsdAssertions::assertRdeValido($xml, 'FE sector energía');
  }

  public function testSectorSegurosValida(): void
  {
    $fe = DocumentoFactory::facturaContado(51);
    $fe->addDatosComplementariosSectorSegurosPoliza('SEG01', 'POL-2026-001', 'Meses', '12', '0001234567', new DateTime('2026-01-01'), new DateTime('2026-12-31'), 'PROD001');
    $xml = DocumentoFactory::firmar($fe->facturaToRDE());
    $this->assertStringContainsString('<gGrupSeg>', $xml);
    $this->assertStringNotContainsString('<gGrupSup>', $xml);
    XsdAssertions::assertRdeValido($xml, 'FE sector seguros');
  }

  public function testSectorSupermercadosConSoloAlgunosCamposValida(): void
  {
    $fe = DocumentoFactory::facturaContado(52);
    $fe->setDatosComplementariosSectorSupermercados('Cajero 1', '100000', '0', null, null);
    $xml = DocumentoFactory::firmar($fe->facturaToRDE());
    $this->assertStringContainsString('<dNomCaj>Cajero 1</dNomCaj>', $xml);
    $this->assertStringNotContainsString('<dMonDon', $xml);
    XsdAssertions::assertRdeValido($xml, 'FE sector supermercados');
  }

  public function testDatosAdicionalesDeUsoComercialConFechasValida(): void
  {
    $fe = DocumentoFactory::facturaContado(53);
    $fe->setDatosAdicionalesDeUsoComercial('202601', new DateTime('2026-01-01'), new DateTime('2026-01-31'), new DateTime('2026-02-15'), 'CONTR-0001', '0');
    $xml = DocumentoFactory::firmar($fe->facturaToRDE());
    $this->assertStringContainsString('<dFecIniC>2026-01-01</dFecIniC>', $xml);
    $this->assertStringContainsString('<dVencPag>2026-02-15</dVencPag>', $xml);
    XsdAssertions::assertRdeValido($xml, 'FE con gGrupAdi');
  }

  public function testItemConLoteSerieYPedidoValida(): void
  {
    $fe = DocumentoFactory::facturaContado(54);
    $fe->addItem('MED001', 'Medicamento', 77, '1', 0, '5000', null, CamIVAAfecIVA::Gravado, '100', CamIVATasaIVA::IVA10,
      null, null, null, null, null, null, 'LOTE-2026-A', new DateTime('2027-06-30'), 'SERIE-001', 'PED-77');
    $fe->calcTotSub(0);
    $xml = DocumentoFactory::firmar($fe->facturaToRDE());
    $this->assertStringContainsString('<dNumLote>LOTE-2026-A</dNumLote>', $xml);
    $this->assertStringContainsString('<dVencMerc>2027-06-30</dVencMerc>', $xml);
    XsdAssertions::assertRdeValido($xml, 'FE con trazabilidad de mercaderías');
  }
}
