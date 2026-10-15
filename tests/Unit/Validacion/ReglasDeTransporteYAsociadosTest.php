<?php

namespace IonysDev\Pkuatia\Tests\Unit\Validacion;

use DateTime;
use DateTimeZone;
use IonysDev\Pkuatia\Core\Constants;
use IonysDev\Pkuatia\Core\Constants\GTranspModTrans;
use IonysDev\Pkuatia\Core\Constants\MotEmiNR;
use IonysDev\Pkuatia\Core\Constants\OpeComTipTrans;
use IonysDev\Pkuatia\Core\Constants\TipDocAso;
use IonysDev\Pkuatia\Core\Constants\TipoDocImpresoAso;
use IonysDev\Pkuatia\Core\Fields\DE\A\DE;
use IonysDev\Pkuatia\Core\Fields\DE\H\GCamDEAsoc;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory as F;
use IonysDev\Pkuatia\Validacion\OrigenError;
use IonysDev\Pkuatia\Validacion\ValidadorDE;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Paso C11 de la Fase C: reglas del transporte (E900-E999), de los documentos asociados (H001-H018), de las compras
 * públicas (E020-E025), de la nota de remisión (E500-E506) y de los ciclos de gGrupAdi (E820-E824), según
 * errores-validacion.md (MT §12.4). Cada caso introduce una sola alteración en un documento válido de la fábrica.
 */
final class ReglasDeTransporteYAsociadosTest extends TestCase
{
  private static function ahora(): DateTime
  {
    return (clone F::fechaEmision())->setTimezone(new DateTimeZone(Constants::SIFEN_TIMEZONE))->modify('+2 hours');
  }

  private static function de(callable $crear): DE
  {
    return F::rde($crear())->getDE();
  }

  private static function fe(): DE
  {
    return self::de(fn () => F::facturaContado());
  }

  /** NR completa: vehículo por número de identificación, transportista no contribuyente con cédula, asociado electrónico. */
  private static function nr(): DE
  {
    return self::de(fn () => F::notaDeRemision());
  }

  private static function nrMatricula(): DE
  {
    return self::de(fn () => F::notaDeRemision(21, true, true));
  }

  /** NC con un documento asociado electrónico. */
  private static function nc(): DE
  {
    return self::de(fn () => F::notaDeCredito());
  }

  /** NC con un documento asociado impreso completo (H005-H011). */
  private static function ncImpreso(): DE
  {
    $d = self::nc();
    $d->gCamDEAsoc = [self::impreso()];
    return $d;
  }

  /** AF con constancia electrónica de no ser contribuyente (H014 = 1, H016, H017). */
  private static function af(): DE
  {
    return self::de(fn () => F::autofactura());
  }

  /** FE con gGrupAdi: ciclo 202601 del 01/01 al 31/01/2026, vencimiento 15/02/2026. */
  private static function feCiclo(): DE
  {
    return self::de(fn () => F::facturaSectorial('datos adicionales'));
  }

  /** FE B2G con compras públicas (E020, fecha del código 02/01/2026) y códigos DNCP en el ítem. */
  private static function feCompras(): DE
  {
    return self::de(fn () => F::facturaConTodosLosOpcionales());
  }

  private static function electronico(string $cdc = F::CDC_ASOCIADO): GCamDEAsoc
  {
    $a = new GCamDEAsoc();
    $a->setITipDocAso(TipDocAso::Electronico);
    $a->setDCdCDERef($cdc);
    return $a;
  }

  private static function impreso(int|TipoDocImpresoAso $tipo = TipoDocImpresoAso::Factura, ?string $retencion = null): GCamDEAsoc
  {
    $a = new GCamDEAsoc();
    $a->setITipDocAso(TipDocAso::Impreso);
    $a->setDNTimDI(12345678);
    $a->setDEstDocAso(1);
    $a->setDPExpDocAso(1);
    $a->setDNumDocAso(1234567);
    $a->setITipoDocAso($tipo);
    $a->setDFecEmiDI(new DateTime('2026-01-10'));
    if ($retencion !== null)
      $a->setDNumComRet($retencion);
    return $a;
  }

  private static function constancia(int $tipo = 1): GCamDEAsoc
  {
    $a = new GCamDEAsoc();
    $a->setITipDocAso(TipDocAso::ConstanciaElectronica);
    $a->setITipCons($tipo);
    $a->setDNumCons(12345678901);
    $a->setDNumControl('A1B2C3D4');
    return $a;
  }

  /** @return iterable<string, array{callable(): DE, string}> */
  public static function transporte(): iterable
  {
    yield '2102 NR sin tipo de transporte' => [function () { $d = self::nr(); $t = $d->gDtipDe->gTransp; unset($t->iTipTrans, $t->dDesTipTrans); return $d; }, '2102'];
    yield '2107 NR sin inicio de traslado' => [function () { $d = self::nr(); unset($d->gDtipDe->gTransp->dIniTras); return $d; }, '2107'];
    yield '2108 inicio de traslado anterior al SIFEN' => [function () { $d = self::nr(); $d->gDtipDe->gTransp->dIniTras = new DateTime('2018-01-01'); return $d; }, '2108'];
    yield '2109 NR sin fin de traslado' => [function () { $d = self::nr(); unset($d->gDtipDe->gTransp->dFinTras); return $d; }, '2109'];
    yield '2110 fin de traslado anterior al inicio' => [function () { $d = self::nr(); $d->gDtipDe->gTransp->dFinTras = new DateTime('2026-01-15'); return $d; }, '2110'];
    yield '2252 aéreo sin número de vuelo' => [function () { $d = self::nr(); $d->gDtipDe->gTransp->setIModTrans(GTranspModTrans::Aereo); return $d; }, '2252'];
    yield '2253 número de vuelo fuera del aéreo' => [function () { $d = self::nr(); $d->gDtipDe->gTransp->gVehTras[0]->dNroVuelo = 'AB1234'; return $d; }, '2253'];
    yield '2254 matrícula no informada' => [function () { $d = self::nr(); $d->gDtipDe->gTransp->gVehTras[0]->dTipIdenVeh = 2; return $d; }, '2254'];
    yield '2255 identificación no informada' => [function () { $d = self::nrMatricula(); $d->gDtipDe->gTransp->gVehTras[0]->dTipIdenVeh = 1; return $d; }, '2255'];
    yield '2302 transportista contribuyente sin RUC' => [function () { $d = self::nr(); $d->gDtipDe->gTransp->gCamTrans->iNatTrans = 1; return $d; }, '2302'];
    yield '2305 RUC del transportista no contribuyente' => [function () { $d = self::nr(); $d->gDtipDe->gTransp->gCamTrans->dRucTrans = '80012345'; return $d; }, '2305'];
    yield '2306 DV del RUC del transportista' => [function () { $d = self::nr(); $t = $d->gDtipDe->gTransp->gCamTrans; $t->iNatTrans = 1; $t->dRucTrans = '80012345'; $t->dDVTrans = 9; unset($t->iTipIDTrans, $t->dNumIDTrans); return $d; }, '2306'];
    yield '2307 no contribuyente sin tipo de documento' => [function () { $d = self::nr(); unset($d->gDtipDe->gTransp->gCamTrans->iTipIDTrans); return $d; }, '2307'];
    yield '2308 contribuyente con tipo de documento' => [function () { $d = self::nr(); $t = $d->gDtipDe->gTransp->gCamTrans; $t->iNatTrans = 1; $t->dRucTrans = '80012345'; $t->dDVTrans = 0; return $d; }, '2308'];
    yield '2311 tipo de documento sin número' => [function () { $d = self::nr(); unset($d->gDtipDe->gTransp->gCamTrans->dNumIDTrans); return $d; }, '2311'];
  }

  #[DataProvider('transporte')]
  public function testReglasDeTransporte(callable $crear, string $codigo): void
  {
    $this->assertCodigo($crear(), $codigo);
  }

  /** @return iterable<string, array{callable(): DE, string}> */
  public static function ciclos(): iterable
  {
    yield '2050 ciclo sin fecha de inicio' => [function () { $d = self::feCiclo(); $d->gDtipDe->gCamEsp->gGrupAdi->dFecIniC = null; return $d; }, '2050'];
    yield '2051 fecha de inicio sin ciclo' => [function () { $d = self::feCiclo(); $d->gDtipDe->gCamEsp->gGrupAdi->dCiclo = null; return $d; }, '2051'];
    yield '2052 inicio sin fin de ciclo' => [function () { $d = self::feCiclo(); $d->gDtipDe->gCamEsp->gGrupAdi->dFecFinC = null; return $d; }, '2052'];
    yield '2053 fin de ciclo sin inicio' => [function () { $d = self::feCiclo(); $g = $d->gDtipDe->gCamEsp->gGrupAdi; $g->dCiclo = null; $g->dFecIniC = null; return $d; }, '2053'];
    yield '2054 fin de ciclo anterior al inicio' => [function () { $d = self::feCiclo(); $d->gDtipDe->gCamEsp->gGrupAdi->dFecFinC = new DateTime('2025-12-31'); return $d; }, '2054'];
    yield '2055 vencimiento anterior a la emisión' => [function () { $d = self::feCiclo(); $d->gDtipDe->gCamEsp->gGrupAdi->dVencPag = new DateTime('2026-01-14'); return $d; }, '2055'];
  }

  #[DataProvider('ciclos')]
  public function testReglasDeCiclos(callable $crear, string $codigo): void
  {
    $this->assertCodigo($crear(), $codigo);
  }

  /** @return iterable<string, array{callable(): DE, string}> */
  public static function asociados(): iterable
  {
    yield '2415 NC con dos asociados' => [function () { $d = self::nc(); $d->gCamDEAsoc[] = self::electronico(); return $d; }, '2415'];
    yield '2416 AF con asociado electrónico' => [function () { $d = self::af(); $d->gCamDEAsoc = [self::electronico()]; return $d; }, '2416'];
    yield '2434 FE con constancia' => [function () { $d = self::fe(); $d->gCamDEAsoc = [self::constancia()]; return $d; }, '2434'];
    yield '2402 electrónico sin CDC' => [function () { $d = self::nc(); unset($d->gCamDEAsoc[0]->dCdCDERef); return $d; }, '2402'];
    yield '2418 constancia con CDC' => [function () { $d = self::af(); $d->gCamDEAsoc[0]->dCdCDERef = F::CDC_ASOCIADO; return $d; }, '2418'];
    yield '2405 impreso sin timbrado' => [function () { $d = self::ncImpreso(); unset($d->gCamDEAsoc[0]->dNTimDI); return $d; }, '2405'];
    yield '2406 impreso sin establecimiento' => [function () { $d = self::ncImpreso(); unset($d->gCamDEAsoc[0]->dEstDocAso); return $d; }, '2406'];
    yield '2407 impreso sin punto de expedición' => [function () { $d = self::ncImpreso(); unset($d->gCamDEAsoc[0]->dPExpDocAso); return $d; }, '2407'];
    yield '2408 impreso sin número' => [function () { $d = self::ncImpreso(); unset($d->gCamDEAsoc[0]->dNumDocAso); return $d; }, '2408'];
    yield '2409 impreso sin tipo' => [function () { $d = self::ncImpreso(); unset($d->gCamDEAsoc[0]->iTipoDocAso); return $d; }, '2409'];
    yield '2419 electrónico con timbrado' => [function () { $d = self::nc(); $d->gCamDEAsoc[0]->setDNTimDI(12345678); return $d; }, '2419'];
    yield '2420 electrónico con establecimiento' => [function () { $d = self::nc(); $d->gCamDEAsoc[0]->setDEstDocAso(1); return $d; }, '2420'];
    yield '2421 electrónico con punto de expedición' => [function () { $d = self::nc(); $d->gCamDEAsoc[0]->setDPExpDocAso(1); return $d; }, '2421'];
    yield '2422 electrónico con número' => [function () { $d = self::nc(); $d->gCamDEAsoc[0]->setDNumDocAso(1234567); return $d; }, '2422'];
    yield '2423 electrónico con tipo de impreso' => [function () { $d = self::nc(); $d->gCamDEAsoc[0]->setITipoDocAso(TipoDocImpresoAso::Factura); return $d; }, '2423'];
    yield '2424 tipo de impreso sin descripción' => [function () { $d = self::ncImpreso(); $d->gCamDEAsoc[0]->dDTipoDocAso = null; return $d; }, '2424'];
    yield '2435 descripción de impreso sin tipo' => [function () { $d = self::nc(); $d->gCamDEAsoc[0]->dDTipoDocAso = 'Factura'; return $d; }, '2435'];
    yield '2411 impreso sin fecha' => [function () { $d = self::ncImpreso(); unset($d->gCamDEAsoc[0]->dFecEmiDI); return $d; }, '2411'];
    yield '2425 electrónico con fecha de impreso' => [function () { $d = self::nc(); $d->gCamDEAsoc[0]->setDFecEmiDI(new DateTime('2026-01-10')); return $d; }, '2425'];
    yield '2413 venta de crédito fiscal sin resolución' => [function () { $d = self::fe(); $d->gDatGralOpe->gOpeCom->setITipTra(OpeComTipTrans::VentaCreditoFiscal); return $d; }, '2413'];
    yield '2426 constancia sin tipo' => [function () { $d = self::af(); $a = $d->gCamDEAsoc[0]; unset($a->iTipCons); $a->dDesTipCons = null; return $d; }, '2426'];
    yield '2427 electrónico con tipo de constancia' => [function () { $d = self::nc(); $d->gCamDEAsoc[0]->setITipCons(1); return $d; }, '2427'];
    yield '2430 microproductor sin número de constancia' => [function () { $d = self::af(); $a = $d->gCamDEAsoc[0]; $a->setITipCons(2); unset($a->dNumCons); return $d; }, '2430'];
    yield '2431 electrónico con número de constancia' => [function () { $d = self::nc(); $d->gCamDEAsoc[0]->setDNumCons(12345678901); return $d; }, '2431'];
    yield '2432 microproductor sin número de control' => [function () { $d = self::af(); $a = $d->gCamDEAsoc[0]; $a->setITipCons(2); unset($a->dNumControl); return $d; }, '2432'];
    yield '2433 electrónico con número de control' => [function () { $d = self::nc(); $d->gCamDEAsoc[0]->setDNumControl('A1B2C3D4'); return $d; }, '2433'];
    yield '2436 retención sin pago por retención' => [function () { $d = self::fe(); $d->gCamDEAsoc = [self::impreso(TipoDocImpresoAso::ComprobanteRetencion, '123456789012345')]; return $d; }, '2436'];
  }

  #[DataProvider('asociados')]
  public function testReglasDeDocumentosAsociados(callable $crear, string $codigo): void
  {
    $this->assertCodigo($crear(), $codigo);
  }

  /** @return iterable<string, array{callable(): DE, string}> */
  public static function especificas(): iterable
  {
    yield '2604 fecha futura de la factura en otro mes' => [function () { $d = self::nr(); $d->gDtipDe->gCamNRE->dFecEm = new DateTime('2026-02-01'); return $d; }, '2604'];
    yield '2605 traslado por venta sin asociado ni fecha futura' => [function () { $d = self::nr(); $d->gCamDEAsoc = []; return $d; }, '2605'];
    yield '2606 traslado entre locales con otro receptor' => [function () { $d = self::nr(); $d->gDtipDe->gCamNRE->setIMotEmiNR(MotEmiNR::TrasladoEntreLocales); return $d; }, '2606'];
    yield '1400 B2G sin compras públicas' => [function () { $d = self::fe(); $d->gDatGralOpe->gDatRec->iTiOpe = 3; return $d; }, '1400'];
    yield '1401 compras públicas fuera de B2G' => [function () { $d = self::feCompras(); $d->gDatGralOpe->gDatRec->iTiOpe = 1; return $d; }, '1401'];
    yield '1402 código de contratación posterior a la emisión' => [function () { $d = self::feCompras(); $d->gDtipDe->gCamFE->gCompPub->dFeCodCont = new DateTime('2026-02-01'); return $d; }, '1402'];
  }

  #[DataProvider('especificas')]
  public function testReglasEspecificas(callable $crear, string $codigo): void
  {
    $this->assertCodigo($crear(), $codigo);
  }

  /** Los documentos válidos de la fábrica no disparan estas reglas (incluida la NR con matrícula y la NC con impreso). */
  public function testLosDocumentosValidosSiguenSinErrores(): void
  {
    $documentos = ['FE' => self::fe(), 'NR' => self::nr(), 'NR matrícula' => self::nrMatricula(), 'NC' => self::nc(), 'NC impreso' => self::ncImpreso(),
      'ND' => self::de(fn () => F::notaDeDebito()), 'AF' => self::af(), 'FE ciclo' => self::feCiclo(), 'FE compras públicas' => self::feCompras(),
      'FE sectores' => self::de(fn () => F::facturaConTodosLosSectores())];
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
    $this->assertLessThanOrEqual(3, count($r), "una sola alteración no debe disparar una cascada: $r");
  }
}
