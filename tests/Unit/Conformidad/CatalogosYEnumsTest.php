<?php

namespace IonysDev\Pkuatia\Tests\Unit\Conformidad;

use IonysDev\Pkuatia\Core\Constants\CamIVAAfecIVA;
use IonysDev\Pkuatia\Core\Constants\CamIVATasaIVA;
use IonysDev\Pkuatia\Core\Constants\MotEmiNR;
use IonysDev\Pkuatia\Core\Constants\TimbTiDE;
use IonysDev\Pkuatia\Core\Fields\DE\C\GTimb;
use IonysDev\Pkuatia\DataMappings\MonedaMapping;
use IonysDev\Pkuatia\DataMappings\UnidadMedidaMapping;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Tests\Support\XsdAssertions;
use PHPUnit\Framework\TestCase;

/**
 * PK-05 (unidades 111-140 de la NT-023: el literal de E710 es la abreviatura, Unidades_Medida_v141.xsd),
 * PK-23 (descripción de moneda ≤ 20, tdDMoneTiPag DE_Types_v150.xsd:884-895) y PK-18 (literales de
 * tdDMotivTras 9 y 11, DE_Types_v150.xsd:1953/1955; tipos de DE 9 y 10, tiTiDE `1|[4-7]|9|10`).
 */
final class CatalogosYEnumsTest extends TestCase
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

  public function testLasUnidadesDeLaNt023LlevanLaAbreviaturaComoLiteral(): void
  {
    $this->assertSame('UNI', UnidadMedidaMapping::GetDesc(77));
    $this->assertSame('kg', UnidadMedidaMapping::GetDesc(83));
    $this->assertSame('4A', UnidadMedidaMapping::GetDesc(111));
    $this->assertSame('Ci', UnidadMedidaMapping::GetDesc(112));
    $this->assertSame('BW', UnidadMedidaMapping::GetDesc(140));
  }

  public function testElXsdDeUnidadesEmpaquetadoEsElDeProduccion(): void
  {
    $empaquetado = str_replace("\r\n", "\n", file_get_contents(__DIR__ . '/../../../src/DataMappings/Sources/Unidades_Medida_v141.xsd'));
    $produccion = str_replace("\r\n", "\n", file_get_contents(XsdAssertions::XSD_DIR . '/Unidades_Medida_v141.xsd'));
    $this->assertSame(md5($produccion), md5($empaquetado), 'src/DataMappings/Sources/Unidades_Medida_v141.xsd difiere del XSD de producción');
  }

  public function testUnItemConUnidadDeLaNt023ValidaContraElXsd(): void
  {
    $fe = DocumentoFactory::facturaContado(40);
    $fe->addItem('BOV001', 'Bovinas', 111, '1', 0, '1000', null, CamIVAAfecIVA::Gravado, '100', CamIVATasaIVA::IVA10);
    $fe->calcTotSub(0);
    $xml = DocumentoFactory::firmar($fe->facturaToRDE());
    $this->assertStringContainsString('<cUniMed>111</cUniMed><dDesUniMed>4A</dDesUniMed>', $xml);
    XsdAssertions::assertRdeValido($xml, 'FE con unidad 111');
  }

  public function testLasMonedasConNombreLargoSeRecortanA20Caracteres(): void
  {
    $this->assertLessThanOrEqual(20, mb_strlen(MonedaMapping::GetDescription('ANG')));
    $xml = DocumentoFactory::firmar(DocumentoFactory::facturaUsd(41, 'ANG')->facturaToRDE());
    XsdAssertions::assertRdeValido($xml, 'FE en ANG (CodeName de 29 caracteres en el XSD)');
  }

  public function testLiteralesDeMotivosDeTrasladoCoincidenConElXsd(): void
  {
    $this->assertSame('Traslado de bienes para reparación', MotEmiNR::from(9)->getDescription());
    $this->assertSame('Exhibición o Demostración', MotEmiNR::from(11)->getDescription());
  }

  public function testLasBoletasExistenComoTipoDeDocumento(): void
  {
    $this->assertSame('Boleta de venta electrónica', TimbTiDE::from(9)->getDescription());
    $this->assertSame('Boleta resimple electrónica', TimbTiDE::from(10)->getDescription());
    $timb = new GTimb();
    $timb->setITiDE(9);
    $this->assertSame(9, $timb->getITiDE());
    $this->assertSame('Boleta de venta electrónica', $timb->getDDesTiDE());
  }

  public function testLosTiposNoHabilitadosPorElXsdSiguenEnElEnumParaDeserializar(): void
  {
    $this->assertSame('Factura electrónica de exportación', TimbTiDE::from(2)->getDescription());
  }
}
