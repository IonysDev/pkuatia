<?php

namespace IonysDev\Pkuatia\Tests\Unit\Conformidad;

use IonysDev\Pkuatia\Core\Constants\CamCondOpe;
use IonysDev\Pkuatia\Core\Constants\CamFEIndPres;
use IonysDev\Pkuatia\Core\Constants\CamIVAAfecIVA;
use IonysDev\Pkuatia\Core\Constants\CamIVATasaIVA;
use IonysDev\Pkuatia\Core\Constants\OpeComTipTrans;
use IonysDev\Pkuatia\Core\Constants\PaConEIniTiPago;
use IonysDev\Pkuatia\Core\Constants\RecTiOpe;
use IonysDev\Pkuatia\Core\Constants\TipIDRec;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\Factura;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Tests\Support\XsdAssertions;
use PHPUnit\Framework\TestCase;

/**
 * PK-17 (setReceptor rechazaba el '0' que el MT exige como dNumIDRec del innominado, D208 = 5;
 * tipos-receptor.md), PK-20 (cantidad '0' producía DivisionByZeroError en F010; moneda extranjera sin
 * condición de tipo de cambio terminaba en un Error de propiedad tipada en vez de una validación con
 * mensaje, D017/D018, validaciones 1207 y 1209).
 */
final class BuildersTest extends TestCase
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

  public function testReceptorInnominadoConElBuilderValida(): void
  {
    $fe = new Factura(CamCondOpe::Contado);
    DocumentoFactory::configurarBase($fe, 70);
    $fe->setReceptor('Sin Nombre', false, RecTiOpe::B2C, 'PRY', null, null, null, TipIDRec::Innominado, '0',
      null, null, null, null, null, null, null, null, null, null);
    $fe->setTipoDeTransaccion(OpeComTipTrans::VentaMercaderia);
    $fe->setIndicadorPresencia(CamFEIndPres::Presencial);
    $fe->addItem('PROD001', 'Producto', 77, '1', 0, '50000', null, CamIVAAfecIVA::Gravado, '100', CamIVATasaIVA::IVA10);
    $fe->calcTotSub(0);
    $fe->addPago(PaConEIniTiPago::Efectivo, '50000', 'PYG');

    $xml = DocumentoFactory::firmar($fe->facturaToRDE());
    $this->assertStringContainsString('<iTipIDRec>5</iTipIDRec><dDTipIDRec>Innominado</dDTipIDRec><dNumIDRec>0</dNumIDRec>', $xml);
    XsdAssertions::assertRdeValido($xml, 'FE innominada');
  }

  public function testCantidadCeroNoDividePorCero(): void
  {
    $fe = DocumentoFactory::facturaContado(71);
    $fe->addItem('MUESTRA', 'Muestra sin cargo', 77, '0', 0, '0', null, CamIVAAfecIVA::Exento, '0', CamIVATasaIVA::ExentoExonerado);
    $tot = $fe->calcTotSub(0);
    $this->assertSame('0.00000000', $tot->getDPorcDescTotal(), 'F010 debe ser 0 cuando no hay descuento global');
  }

  public function testSoloItemsSinValorNoDividePorCero(): void
  {
    $fe = new Factura(CamCondOpe::Contado);
    DocumentoFactory::configurarBase($fe, 72);
    DocumentoFactory::receptorContribuyente($fe);
    $fe->setTipoDeTransaccion(OpeComTipTrans::Donacion);
    $fe->setIndicadorPresencia(CamFEIndPres::Presencial);
    $fe->addItem('DON', 'Donacion', 77, '1', 0, '0', null, CamIVAAfecIVA::Exento, '0', CamIVATasaIVA::ExentoExonerado);
    $tot = $fe->calcTotSub(0);
    $this->assertSame('0.00000000', $tot->getDPorcDescTotal());
  }

  public function testMonedaExtranjeraSinTipoDeCambioLanzaUnaExcepcionDeDominio(): void
  {
    $fe = new Factura(CamCondOpe::Contado);
    DocumentoFactory::configurarBase($fe, 73);
    DocumentoFactory::receptorContribuyente($fe);
    $fe->setTipoDeTransaccion(OpeComTipTrans::VentaMercaderia);
    $fe->setIndicadorPresencia(CamFEIndPres::Presencial);
    $fe->setMoneda('USD'); // sin setCondicionTipoDeCambio ni setTipoDeCambio
    $fe->addItem('EXP001', 'Producto', 77, '1', 2, '10.00', null, CamIVAAfecIVA::Gravado, '100', CamIVATasaIVA::IVA10);

    $this->expectException(\Exception::class);
    $this->expectExceptionMessageMatches('/D017|tipo de cambio/i');
    $fe->calcTotSub(2);
    DocumentoFactory::firmar($fe->facturaToRDE());
  }
}
