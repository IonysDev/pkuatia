<?php

namespace IonysDev\Pkuatia\Tests\Unit\Core;

use DateTime;
use DOMDocument;
use InvalidArgumentException;
use IonysDev\Pkuatia\Core\Constants\CamCondOpe;
use IonysDev\Pkuatia\Core\Constants\CamFEIndPres;
use IonysDev\Pkuatia\Core\Constants\CamIVAAfecIVA;
use IonysDev\Pkuatia\Core\Constants\CamIVATasaIVA;
use IonysDev\Pkuatia\Core\Constants\EmisRecTipCont;
use IonysDev\Pkuatia\Core\Constants\OpeComTipTrans;
use IonysDev\Pkuatia\Core\Constants\RecTiOpe;
use IonysDev\Pkuatia\Core\Constants\TipIDRec;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\Factura;
use PHPUnit\Framework\TestCase;

/**
 * Redondeo explícito en ItemValorado::calcTotSub (F013 informado por el consumidor):
 * con precisión 8 en ítems y totales, F014 = F008 - F013, no se informan F036/F037 y el
 * F010 derivado es consistente con cada EA004 (validación 1862 del SIFEN).
 */
final class ItemValoradoCalcTotSubRedondeoTest extends TestCase
{
  private function nuevaFacturaContado(): Factura
  {
    $factura = new Factura(CamCondOpe::Contado);
    $factura->setTimbrado(12345678, new DateTime('2024-01-01'), 1, 1, 1);
    $factura->setFechaEmision(new DateTime('2026-01-15T10:00:00'));
    $factura->setEmisor(
      '80000000',
      5,
      EmisRecTipCont::PersonaJuridica,
      null,
      'Empresa de Prueba SA',
      null,
      'Av. Principal',
      '100',
      null,
      null,
      1,
      null,
      1,
      '021000000',
      'test@example.com',
      null
    );
    $factura->addEmisorActividadEconomica(47190, 'Comercio al por menor');
    $factura->setReceptor(
      'Cliente Prueba',
      false,
      RecTiOpe::B2C,
      'PRY',
      null,
      null,
      null,
      TipIDRec::CedulaParaguaya,
      '1234567',
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null
    );
    $factura->setTipoDeTransaccion(OpeComTipTrans::VentaMercaderia);
    $factura->setIndicadorPresencia(CamFEIndPres::Presencial);
    return $factura;
  }

  private function agregarItem(Factura $factura, string $codigo, string $cantidad, string $precioUnit, string $descuentoUnitarioGlobal): void
  {
    $factura->addItem(
      codigo: $codigo,
      descripcion: "Ítem $codigo",
      codUnidadMedida: 77,
      cantidad: $cantidad,
      precisionMoneda: 8,
      precioUnit: $precioUnit,
      totalBruto: null,
      afectIVA: CamIVAAfecIVA::Gravado,
      proporcionGravadaIVA: '100',
      tasaDeIVA: CamIVATasaIVA::IVA10,
      descuentoUnitarioGlobal: $descuentoUnitarioGlobal
    );
  }

  /**
   * Conforma el RDE (sin firmar) y devuelve su XML.
   */
  private function toXml(Factura $factura): DOMDocument
  {
    $rde = $factura->facturaToRDE();
    $rde->DE->setDFecFirma(new DateTime('2026-01-15T10:00:00'));
    $doc = new DOMDocument('1.0', 'UTF-8');
    $doc->appendChild($rde->toDOMElement($doc));
    return $doc;
  }

  private function valor(DOMDocument $doc, string $tag): string
  {
    $nodos = $doc->getElementsByTagName($tag);
    $this->assertSame(1, $nodos->length, "Se esperaba un único <$tag> en el XML");
    return $nodos->item(0)->nodeValue;
  }

  private function assertMismoNumero(string $esperado, string $actual, string $campo): void
  {
    $this->assertSame(0, bccomp($esperado, $actual, 8), "$campo: se esperaba $esperado, se obtuvo $actual");
  }

  private function assertSinLiquidacionIVARedondeo(DOMDocument $doc): void
  {
    $xml = $doc->saveXML();
    $this->assertStringNotContainsString('dLiqTotIVA5', $xml);
    $this->assertStringNotContainsString('dLiqTotIVA10', $xml);
  }

  /**
   * Validación 1862 (NT-001): |EA004 - F010 × E721 / 100| <= 0,8 por ítem, con los valores del XML.
   *
   * @return string La mayor diferencia encontrada.
   */
  private function assertValidacion1862(DOMDocument $doc): string
  {
    $f010 = $this->valor($doc, 'dPorcDescTotal');
    $items = $doc->getElementsByTagName('gCamItem');
    $this->assertGreaterThan(0, $items->length);
    $maxima = '0';
    foreach ($items as $i => $item) {
      $e721 = $item->getElementsByTagName('dPUniProSer')->item(0)->nodeValue;
      $ea004 = $item->getElementsByTagName('dDescGloItem')->item(0)->nodeValue;
      $diferencia = ltrim(bcsub($ea004, bcdiv(bcmul($f010, $e721, 16), '100', 16), 16), '-');
      $this->assertLessThanOrEqual(0, bccomp($diferencia, '0.8', 16), 'Ítem ' . ($i + 1) . ": |EA004 - F010 × E721 / 100| = $diferencia");
      if (bccomp($diferencia, $maxima, 16) > 0) {
        $maxima = $diferencia;
      }
    }
    return $maxima;
  }

  public function testCasoAUnItemConDescuentoGlobalDelDiezPorCientoYRedondeoExplicito(): void
  {
    $factura = $this->nuevaFacturaContado();
    $this->agregarItem($factura, 'A1', '1', '12345', '1234.5');
    $factura->calcTotSub(8, false, null, '0.5');
    $doc = $this->toXml($factura);

    $this->assertSame('11110.5', $this->valor($doc, 'dTotOpeItem'));
    // La librería acumula los subtotales a escala 8 (11110.50000000)
    $this->assertMismoNumero('11110.5', $this->valor($doc, 'dSub10'), 'dSub10');
    // 1010,04545454 ± la escala de la librería (redondeo a 8 decimales de base e IVA por ítem)
    $iva10 = $this->valor($doc, 'dIVA10');
    $this->assertLessThanOrEqual(0, bccomp(ltrim(bcsub($iva10, '1010.04545454', 8), '-'), '0.00000001', 8), "dIVA10 = $iva10");
    $this->assertSame('0.5', $this->valor($doc, 'dRedon'));
    $this->assertSame('11110', $this->valor($doc, 'dTotGralOpe'));
    $this->assertSame('10.00000000', $this->valor($doc, 'dPorcDescTotal'));
    $this->assertSame($iva10, $this->valor($doc, 'dTotIVA'));
    $this->assertSinLiquidacionIVARedondeo($doc);
    $this->assertMismoNumero('0', $this->assertValidacion1862($doc), 'diferencia 1862 máxima');
  }

  public function testCasoB2SeisItemsConDescuentoGlobalPorMontoYRedondeoExplicito(): void
  {
    $factura = $this->nuevaFacturaContado();
    // Bruto 312.000, descuento global 2.200: EA004 = E721 × F010 / 100 al más cercano con 4 decimales
    $this->agregarItem($factura, 'B1', '1', '20000', '141.0256');
    $this->agregarItem($factura, 'B2', '1', '110000', '775.6408');
    $this->agregarItem($factura, 'B3', '2', '28000', '197.4358');
    $this->agregarItem($factura, 'B4', '6', '8000', '56.4102');
    $this->agregarItem($factura, 'B5', '6', '8000', '56.4102');
    $this->agregarItem($factura, 'B6', '3', '10000', '70.5128');
    $factura->calcTotSub(8, false, null, '0.0012');
    $doc = $this->toXml($factura);

    $this->assertSame('0.70512782', $this->valor($doc, 'dPorcDescTotal'));
    $this->assertMismoNumero('0.000198', $this->assertValidacion1862($doc), 'diferencia 1862 máxima');
    $this->assertMismoNumero('2199.9988', $this->valor($doc, 'dTotDescGlotem'), 'dTotDescGlotem');
    $this->assertMismoNumero('309800.0012', $this->valor($doc, 'dTotOpe'), 'dTotOpe');
    $this->assertSame('0.0012', $this->valor($doc, 'dRedon'));
    $this->assertSame('309800', $this->valor($doc, 'dTotGralOpe'));
    $this->assertSinLiquidacionIVARedondeo($doc);
  }

  public function testRedondeoExplicitoYRedondeoSedecoJuntosLanzaExcepcion(): void
  {
    $factura = $this->nuevaFacturaContado();
    $this->agregarItem($factura, 'A1', '1', '12345', '1234.5');

    $this->expectException(InvalidArgumentException::class);
    $factura->calcTotSub(8, true, null, '0.5');
  }

  public function testSinRedondeoExplicitoSeConservaElComportamientoAnterior(): void
  {
    $factura = $this->nuevaFacturaContado();
    $this->agregarItem($factura, 'A1', '1', '12345', '1234.5');
    $factura->calcTotSub(8, false);
    $doc = $this->toXml($factura);

    $this->assertSame('0', $this->valor($doc, 'dRedon'));
    $this->assertSame('11110.5', $this->valor($doc, 'dTotGralOpe'));
    $this->assertSinLiquidacionIVARedondeo($doc);
  }
}
