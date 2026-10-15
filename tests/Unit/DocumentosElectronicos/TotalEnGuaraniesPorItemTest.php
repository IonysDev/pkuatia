<?php

namespace IonysDev\Pkuatia\Tests\Unit\DocumentosElectronicos;

use IonysDev\Pkuatia\Core\Constants\CamCondOpe;
use IonysDev\Pkuatia\Core\Constants\CamFEIndPres;
use IonysDev\Pkuatia\Core\Constants\CamIVAAfecIVA;
use IonysDev\Pkuatia\Core\Constants\CamIVATasaIVA;
use IonysDev\Pkuatia\Core\Constants\OpeComCondTipCam;
use IonysDev\Pkuatia\Core\Constants\OpeComTipTrans;
use IonysDev\Pkuatia\Core\Constants\PaConEIniTiPago;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\Factura;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory as F;
use PHPUnit\Framework\TestCase;

/**
 * Decisión Q-C8 de la Fase C: el total del ítem en guaraníes (EA009 dTotOpeGs, tipo de cambio por ítem) se redondea
 * al guaraní entero. Hasta 0.2.1 addItem() lo calculaba con bcmul() sin escala, es decir truncado: con precios o
 * tipos de cambio con fracción cada ítem quedaba hasta 1 guaraní por debajo del valor exacto, y F023 (suma de EA009)
 * arrastraba la diferencia. EA008 = EA009 × E725 (validación 1858) y F023 = suma de EA009 (2386).
 */
final class TotalEnGuaraniesPorItemTest extends TestCase
{
  private static function facturaUsdPorItem(string $cantidad, string $precio, string $cambio): Factura
  {
    $fe = new Factura(CamCondOpe::Contado);
    F::configurarBase($fe, 90);
    F::receptorContribuyente($fe);
    $fe->setTipoDeTransaccion(OpeComTipTrans::VentaMercaderia);
    $fe->setIndicadorPresencia(CamFEIndPres::Electronica);
    $fe->setMoneda('USD');
    $fe->setCondicionTipoDeCambio(OpeComCondTipCam::PorItem);
    $fe->addItem('EXP001', 'Producto en moneda extranjera', 77, $cantidad, 2, $precio, null, CamIVAAfecIVA::Gravado, '100', CamIVATasaIVA::IVA10,
      esTipoCambioPorItem: true, tipoDeCambioItem: $cambio);
    $fe->calcTotSub(2);
    $fe->addPago(PaConEIniTiPago::Efectivo, $fe->gTotSub->getDTotGralOpe(), 'USD', $cambio);
    return $fe;
  }

  public function testElTotalEnGuaraniesSeRedondeaAlGuaraniEntero(): void
  {
    // 2 × 150,50 = 301,00 USD × 7300,5 = 2 197 450,5 Gs: redondeado 2 197 451 (hasta 0.2.1, truncado: 2 197 450)
    $fe = self::facturaUsdPorItem('2', '150.50', '7300.5');
    $item = $fe->items[0];
    $this->assertSame('301', $item->gValorItem->gValorRestaItem->dTotOpeItem); // BC::round quita los ceros finales
    $this->assertSame('2197451', $item->gValorItem->gValorRestaItem->dTotOpeGs);
    $this->assertSame('2197451', bcadd($fe->gTotSub->getDTotalGs(), '0', 0), 'F023 = suma de EA009');
    $this->assertStringContainsString('<dTotOpeGs>2197451</dTotOpeGs>', F::rde($fe)->toXMLString());
  }

  public function testSinFraccionNoCambiaNada(): void
  {
    $fe = self::facturaUsdPorItem('2', '150.50', '7300');
    $this->assertSame('2197300', $fe->items[0]->gValorItem->gValorRestaItem->dTotOpeGs);
  }

  public function testElValidadorNoObjetaElRedondeo(): void
  {
    $r = self::facturaUsdPorItem('3', '33.33', '7312.75')->validarReglas(F::fechaEmision()->modify('+2 hours'));
    $this->assertCount(0, $r->porCodigo('1858'), (string) $r);
    $this->assertCount(0, $r->porCodigo('2386'), (string) $r);
  }
}
