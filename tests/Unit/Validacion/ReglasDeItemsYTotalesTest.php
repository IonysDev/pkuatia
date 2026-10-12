<?php

namespace IonysDev\Pkuatia\Tests\Unit\Validacion;

use DateTime;
use DateTimeZone;
use IonysDev\Pkuatia\Core\Constants;
use IonysDev\Pkuatia\Core\Fields\DE\A\DE;
use IonysDev\Pkuatia\Core\Fields\DE\J\GCamFuFD;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory as F;
use IonysDev\Pkuatia\Validacion\OrigenError;
use IonysDev\Pkuatia\Validacion\ValidadorDE;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Paso C10b de la Fase C: reglas de los ítems (E700-E739), del IVA por ítem (NT-013) y de los totales (F001-F037)
 * según errores-validacion.md (MT §12.4), campos-obligatorios.md y las fórmulas que addItem() y calcTotSub() aplican,
 * aprobadas por sifen-test. Cada caso introduce una sola alteración en un documento válido de la fábrica; alterar un
 * importe arrastra a los totales que dependen de él (como haría el SIFEN), por eso se admite un puñado de códigos.
 */
final class ReglasDeItemsYTotalesTest extends TestCase
{
  private static function ahora(): DateTime
  {
    return (clone F::fechaEmision())->setTimezone(new DateTimeZone(Constants::SIFEN_TIMEZONE))->modify('+2 hours');
  }

  private static function de(callable $crear): DE
  {
    return F::rde($crear())->getDE();
  }

  /** Un ítem gravado 10 % de 100 000. */
  private static function fe(): DE
  {
    return self::de(fn () => F::facturaContado());
  }

  /** Ítem 0 exento (100 000) e ítem 1 gravado 5 % (3 × 21 000). */
  private static function feCuotas(): DE
  {
    return self::de(fn () => F::facturaCreditoCuotas());
  }

  /** USD con tipo de cambio global 7300, un ítem de 2 × 150,50 gravado 10 %. */
  private static function feUsd(): DE
  {
    return self::de(fn () => F::facturaUsd());
  }

  /** La misma FE en USD, pasada a tipo de cambio por ítem (D017 = 2, E725 y EA009 informados, F023 = suma de EA009). */
  private static function feUsdPorItem(): DE
  {
    $d = self::feUsd();
    $opeCom = $d->gDatGralOpe->gOpeCom;
    $opeCom->dCondTiCam = 2;
    unset($opeCom->dTiCam);
    $valor = $d->gDtipDe->gCamItem[0]->gValorItem;
    $valor->dTiCamIt = '7300';
    $valor->gValorRestaItem->dTotOpeGs = bcmul($valor->gValorRestaItem->dTotOpeItem, '7300', 8);
    $d->gTotSub->dTotalGs = $valor->gValorRestaItem->dTotOpeGs;
    return $d;
  }

  private static function nr(): DE
  {
    return self::de(fn () => F::notaDeRemision());
  }

  /** Dos ítems sin IVA (5 × 20 000 y 30 000). */
  private static function af(): DE
  {
    return self::de(fn () => F::autofactura());
  }

  /** @return iterable<string, array{callable(): DE, string}> */
  public static function items(): iterable
  {
    yield '1800 B2G sin DNCP general' => [function () { $d = self::de(fn () => F::facturaConTodosLosOpcionales()); $d->gDatGralOpe->gDatRec->iTiOpe = 3; return $d; }, '1800'];
    yield '1801 DNCP general sin específico' => [function () { $d = self::fe(); $d->gDtipDe->gCamItem[0]->dDncpG = '12345678'; return $d; }, '1801'];
    yield '1807 relevancia fuera de la NR' => [function () { $d = self::fe(); $d->gDtipDe->gCamItem[0]->cRelMerc = 1; $d->gDtipDe->gCamItem[0]->dDesRelMerc = 'Tolerancia de quiebra'; return $d; }, '1807'];
    yield '1808 relevancia sin cantidad ni porcentaje' => [function () { $d = self::nr(); $d->gDtipDe->gCamItem[0]->cRelMerc = 1; $d->gDtipDe->gCamItem[0]->dDesRelMerc = 'Tolerancia de quiebra'; return $d; }, '1808'];
    yield '1859 total bruto del ítem' => [function () { $d = self::fe(); $d->gDtipDe->gCamItem[0]->gValorItem->dTotBruOpeItem = '999'; return $d; }, '1859'];
    yield '1853 total del ítem' => [function () { $d = self::fe(); $d->gDtipDe->gCamItem[0]->gValorItem->gValorRestaItem->dTotOpeItem = '999'; return $d; }, '1853'];
    yield '1853 total del ítem de la AF' => [function () { $d = self::af(); $d->gDtipDe->gCamItem[0]->gValorItem->gValorRestaItem->dTotOpeItem = '999'; return $d; }, '1853'];
    yield '1852 descuento sin porcentaje' => [function () { $d = self::fe(); $d->gDtipDe->gCamItem[0]->gValorItem->gValorRestaItem->dDescItem = '10'; return $d; }, '1852'];
    yield '1861 porcentaje de descuento' => [function () { $d = self::fe(); $v = $d->gDtipDe->gCamItem[0]->gValorItem->gValorRestaItem; $v->dDescItem = '10'; $v->dPorcDesIt = '50'; return $d; }, '1861'];
    yield '1854 tipo de cambio por ítem no informado' => [function () { $d = self::feUsdPorItem(); unset($d->gDtipDe->gCamItem[0]->gValorItem->dTiCamIt); return $d; }, '1854'];
    yield '1855 tipo de cambio por ítem con condición global' => [function () { $d = self::feUsd(); $d->gDtipDe->gCamItem[0]->gValorItem->dTiCamIt = '7300'; return $d; }, '1855'];
    yield '1856 tipo de cambio por ítem en PYG' => [function () { $d = self::fe(); $d->gDtipDe->gCamItem[0]->gValorItem->dTiCamIt = '7300'; return $d; }, '1856'];
    yield '1857 tipo de cambio por ítem sin total en guaraníes' => [function () { $d = self::feUsdPorItem(); unset($d->gDtipDe->gCamItem[0]->gValorItem->gValorRestaItem->dTotOpeGs); return $d; }, '1857'];
    yield '1858 total en guaraníes del ítem' => [function () { $d = self::feUsdPorItem(); $d->gDtipDe->gCamItem[0]->gValorItem->gValorRestaItem->dTotOpeGs = '1'; return $d; }, '1858'];
    yield '1904 gravado con proporción distinta de 100' => [function () { $d = self::fe(); $d->gDtipDe->gCamItem[0]->gCamIVA->dPropIVA = '50'; return $d; }, '1904'];
    yield '1905 exento con proporción distinta de 0' => [function () { $d = self::feCuotas(); $d->gDtipDe->gCamItem[0]->gCamIVA->dPropIVA = '100'; return $d; }, '1905'];
    yield '1906 gravado parcial con proporción 100' => [function () { $d = self::fe(); $i = $d->gDtipDe->gCamItem[0]->gCamIVA; $i->iAfecIVA = 4; $i->dDesAfecIVA = 'Gravado parcial (Grav- Exento)'; return $d; }, '1906'];
    yield '1907 exento con tasa' => [function () { $d = self::feCuotas(); $d->gDtipDe->gCamItem[0]->gCamIVA->dTasaIVA = 10; return $d; }, '1907'];
    yield '1908 gravado con tasa 0' => [function () { $d = self::fe(); $d->gDtipDe->gCamItem[0]->gCamIVA->dTasaIVA = 0; return $d; }, '1908'];
    yield '1909 exento con base gravada' => [function () { $d = self::feCuotas(); $d->gDtipDe->gCamItem[0]->gCamIVA->dBasGravIVA = '100'; return $d; }, '1909'];
    yield '1910 base gravada al 5 %' => [function () { $d = self::feCuotas(); $d->gDtipDe->gCamItem[1]->gCamIVA->dBasGravIVA = '1'; return $d; }, '1910'];
    yield '1911 base gravada al 10 %' => [function () { $d = self::fe(); $d->gDtipDe->gCamItem[0]->gCamIVA->dBasGravIVA = '1'; return $d; }, '1911'];
    yield '1912 exento con liquidación' => [function () { $d = self::feCuotas(); $d->gDtipDe->gCamItem[0]->gCamIVA->dLiqIVAItem = '5'; return $d; }, '1912'];
    yield '1913 liquidación del IVA' => [function () { $d = self::fe(); $d->gDtipDe->gCamItem[0]->gCamIVA->dLiqIVAItem = '1'; return $d; }, '1913'];
  }

  #[DataProvider('items')]
  public function testReglasDeItems(callable $crear, string $codigo): void
  {
    $this->assertCodigo($crear(), $codigo);
  }

  /**
   * NT-013 §2.1: la base exenta del gravado parcial (E737) tiene el código 1921, que errores-validacion.md todavía no
   * lista (devolución a ekuat-ia); el validador lo informa con el mensaje de la NT.
   */
  public function testBaseExentaDelGravadoParcial1921(): void
  {
    $d = self::fe();
    $i = $d->gDtipDe->gCamItem[0]->gCamIVA;
    $i->iAfecIVA = 4;
    $i->dDesAfecIVA = 'Gravado parcial (Grav- Exento)';
    $i->dPropIVA = '50';
    $i->dBasGravIVA = bcdiv(bcmul('100', bcmul('100000', '50', 8), 8), bcadd('10000', bcmul('10', '50', 8), 8), 8);
    $i->dLiqIVAItem = bcmul($i->dBasGravIVA, '0.1', 8);
    $i->dBasExe = '1';
    $r = ValidadorDE::validar($d, self::ahora());
    $e = $r->porCodigo('1921');
    $this->assertCount(1, $e, (string) $r);
    $this->assertSame('E737', $e[0]->campoMT);
    $this->assertSame('dBasExe', $e[0]->elemento);
    $this->assertFalse($e[0]->esAdvertencia);
    $this->assertStringContainsString('base exenta', $e[0]->mensaje);
    $this->assertStringContainsString('NT-013', (string) $e[0]->sugerencia);

    // Con la base exenta correcta no hay 1921
    $i->dBasExe = bcdiv(bcmul('100', bcmul('100000', '50', 8), 8), bcadd('10000', bcmul('10', '50', 8), 8), 8);
    $this->assertCount(0, ValidadorDE::validar($d, self::ahora())->porCodigo('1921'));
    // Un ítem exento con base exenta distinta de 0 también es 1921
    $c = self::feCuotas();
    $c->gDtipDe->gCamItem[0]->gCamIVA->dBasExe = '5';
    $this->assertCount(1, ValidadorDE::validar($c, self::ahora())->porCodigo('1921'));
  }

  /** @return iterable<string, array{callable(): DE, string}> */
  public static function totales(): iterable
  {
    yield '2352 exento sin subtotal exento' => [function () { $d = self::feCuotas(); unset($d->gTotSub->dSubExe); return $d; }, '2352'];
    yield '2353 subtotal exento' => [function () { $d = self::feCuotas(); $d->gTotSub->dSubExe = '1'; return $d; }, '2353'];
    yield '2354 exonerado sin subtotal exonerado' => [function () { $d = self::feCuotas(); $i = $d->gDtipDe->gCamItem[0]->gCamIVA; $i->iAfecIVA = 2; $i->dDesAfecIVA = 'Exonerado (Art. 100 - Ley 6380/2019)'; unset($d->gTotSub->dSubExo); return $d; }, '2354'];
    yield '2355 subtotal exonerado' => [function () { $d = self::feCuotas(); $i = $d->gDtipDe->gCamItem[0]->gCamIVA; $i->iAfecIVA = 2; $i->dDesAfecIVA = 'Exonerado (Art. 100 - Ley 6380/2019)'; $d->gTotSub->dSubExo = '1'; return $d; }, '2355'];
    yield '2356 tasa 5 sin subtotal al 5' => [function () { $d = self::feCuotas(); unset($d->gTotSub->dSub5); return $d; }, '2356'];
    yield '2357 subtotal al 5' => [function () { $d = self::feCuotas(); $d->gTotSub->dSub5 = '1'; return $d; }, '2357'];
    yield '2358 tasa 10 sin subtotal al 10' => [function () { $d = self::fe(); unset($d->gTotSub->dSub10); return $d; }, '2358'];
    yield '2359 subtotal al 10' => [function () { $d = self::fe(); $d->gTotSub->dSub10 = '1'; return $d; }, '2359'];
    yield '2362 total de la operación' => [function () { $d = self::fe(); $d->gTotSub->dTotOpe = '1'; return $d; }, '2362'];
    yield '2362 total de la operación de la AF' => [function () { $d = self::af(); $d->gTotSub->dTotOpe = '1'; return $d; }, '2362'];
    yield '2363 total de descuentos por ítem' => [function () { $d = self::fe(); $d->gTotSub->dTotDesc = '1'; return $d; }, '2363'];
    yield '2364 total de descuentos' => [function () { $d = self::fe(); $d->gTotSub->dDescTotal = '1'; return $d; }, '2364'];
    yield '2365 total general' => [function () { $d = self::fe(); $d->gTotSub->dTotGralOpe = '1'; return $d; }, '2365'];
    yield '2365 total general de la AF' => [function () { $d = self::af(); $d->gTotSub->dTotGralOpe = '1'; return $d; }, '2365'];
    yield '2366 tasa 5 sin liquidación al 5' => [function () { $d = self::feCuotas(); unset($d->gTotSub->dIVA5); return $d; }, '2366'];
    yield '2367 liquidación al 5' => [function () { $d = self::feCuotas(); $d->gTotSub->dIVA5 = '1'; return $d; }, '2367'];
    yield '2368 tasa 10 sin liquidación al 10' => [function () { $d = self::fe(); unset($d->gTotSub->dIVA10); return $d; }, '2368'];
    yield '2369 liquidación al 10' => [function () { $d = self::fe(); $d->gTotSub->dIVA10 = '1'; return $d; }, '2369'];
    yield '2370 sin liquidación total' => [function () { $d = self::fe(); unset($d->gTotSub->dTotIVA); return $d; }, '2370'];
    yield '2371 liquidación total' => [function () { $d = self::fe(); $d->gTotSub->dTotIVA = '1'; return $d; }, '2371'];
    yield '2372 tasa 5 sin base al 5' => [function () { $d = self::feCuotas(); unset($d->gTotSub->dBaseGrav5); return $d; }, '2372'];
    yield '2373 base al 5' => [function () { $d = self::feCuotas(); $d->gTotSub->dBaseGrav5 = '1'; return $d; }, '2373'];
    yield '2374 tasa 10 sin base al 10' => [function () { $d = self::fe(); unset($d->gTotSub->dBaseGrav10); return $d; }, '2374'];
    yield '2375 base al 10' => [function () { $d = self::fe(); $d->gTotSub->dBaseGrav10 = '1'; return $d; }, '2375'];
    yield '2376 sin base total' => [function () { $d = self::fe(); unset($d->gTotSub->dTBasGraIVA); return $d; }, '2376'];
    yield '2377 base total' => [function () { $d = self::fe(); $d->gTotSub->dTBasGraIVA = '1'; return $d; }, '2377'];
    yield '2382 moneda extranjera sin total en guaraníes' => [function () { $d = self::feUsd(); unset($d->gTotSub->dTotalGs); return $d; }, '2382'];
    yield '2385 total en guaraníes con tipo de cambio global' => [function () { $d = self::feUsd(); $d->gTotSub->dTotalGs = '1'; return $d; }, '2385'];
    yield '2386 total en guaraníes con tipo de cambio por ítem' => [function () { $d = self::feUsdPorItem(); $d->gTotSub->dTotalGs = '1'; return $d; }, '2386'];
  }

  #[DataProvider('totales')]
  public function testReglasDeTotales(callable $crear, string $codigo): void
  {
    $this->assertCodigo($crear(), $codigo);
  }

  /** El redondeo a la unidad de la moneda (calcTotSub con precisión 0) no dispara 1853: la tolerancia es el último decimal informado. */
  public function testElRedondeoALaPrecisionDeLaMonedaNoEsError(): void
  {
    $d = self::fe();
    $item = $d->gDtipDe->gCamItem[0];
    $item->dCantProSer = '3';
    $item->gValorItem->dPUniProSer = '33333.33';
    $item->gValorItem->dTotBruOpeItem = '99999.99';
    $item->gValorItem->gValorRestaItem->dTotOpeItem = '100000'; // 99 999,99 redondeado a la unidad (PYG)
    $r = ValidadorDE::validar($d, self::ahora());
    $this->assertCount(0, $r->porCodigo('1853'), (string) $r);
    $this->assertCount(0, $r->porCodigo('1859'), (string) $r);
    $item->gValorItem->gValorRestaItem->dTotOpeItem = '100001.5';
    $this->assertCount(1, ValidadorDE::validar($d, self::ahora())->porCodigo('1853'));
  }

  /** J003 dInfAdic va fuera de la firma y el MT (2503) dice que no debe enviarse: advertencia hasta probarlo en C14. */
  public function testInformacionAdicionalDelEmisorEsAdvertencia2503(): void
  {
    $rde = F::rde(F::facturaContado());
    $fuera = new GCamFuFD();
    $fuera->setDInfAdic('Texto adicional del emisor');
    $rde->setGCamFuFD($fuera);
    $r = ValidadorDE::validar($rde, self::ahora());
    $this->assertTrue($r->esValido(), (string) $r);
    $this->assertCount(1, $r->porCodigo('2503'));
    $this->assertTrue($r->porCodigo('2503')[0]->esAdvertencia);
    $this->assertSame('J003', $r->porCodigo('2503')[0]->campoMT);
    $this->assertSame('rDE.gCamFuFD', $r->porCodigo('2503')[0]->ruta);
    $this->assertCount(0, ValidadorDE::validar(F::facturaContado(), self::ahora())->porCodigo('2503'), 'el builder no lleva J003');
  }

  /** Los documentos válidos de la fábrica (con y sin IVA, en USD con las dos condiciones de cambio, AF, NR) no disparan estas reglas. */
  public function testLosDocumentosValidosSiguenSinErrores(): void
  {
    $documentos = ['FE' => self::fe(), 'FE cuotas' => self::feCuotas(), 'FE USD' => self::feUsd(), 'FE USD por ítem' => self::feUsdPorItem(),
      'AF' => self::af(), 'NR' => self::nr(), 'FE opcionales' => self::de(fn () => F::facturaConTodosLosOpcionales()),
      'FE cuotas con entrega' => self::de(fn () => F::facturaCreditoCuotas(5, '20000'))];
    foreach ($documentos as $nombre => $d) {
      $r = ValidadorDE::validar($d, self::ahora());
      $this->assertTrue($r->esValido(), "$nombre: $r");
    }
  }

  private function assertCodigo(DE $de, string $codigo): void
  {
    $r = ValidadorDE::validar($de, self::ahora());
    $encontrados = $r->porCodigo($codigo);
    $this->assertNotEmpty($encontrados, "se esperaba el código $codigo; resultado: $r");
    $e = $encontrados[0];
    $this->assertSame(OrigenError::Regla, $e->origen);
    $this->assertNotNull($e->campoMT, (string) $e);
    $this->assertSame($e->getInfoValidacion()?->mensaje, $e->mensaje, 'el mensaje es el del MT');
    $this->assertLessThanOrEqual(6, count($r), "una sola alteración no debe disparar una cascada: $r");
  }
}
