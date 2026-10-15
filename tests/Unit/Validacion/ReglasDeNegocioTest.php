<?php

namespace IonysDev\Pkuatia\Tests\Unit\Validacion;

use DateTime;
use DateTimeZone;
use IonysDev\Pkuatia\Core\Constants;
use IonysDev\Pkuatia\Core\Fields\DE\A\DE;
use IonysDev\Pkuatia\Core\Fields\DE\E\GPagCheq;
use IonysDev\Pkuatia\Core\Fields\DE\E\GPagCred;
use IonysDev\Pkuatia\Core\Fields\DE\E\GPagTarCD;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory as F;
use IonysDev\Pkuatia\Utils\RucUtils;
use IonysDev\Pkuatia\Validacion\OrigenError;
use IonysDev\Pkuatia\Validacion\ValidadorDE;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Paso C10 de la Fase C: reglas de negocio con código del SIFEN sobre descripciones, datos generales, receptor y
 * pagos (ekuat-ia errores-validacion.md, MT §12.4; la observación de cada fila es la regla). Cada caso parte de un
 * documento válido de la fábrica y le introduce una sola violación; el validador debe predecir el código con el
 * que el SIFEN lo rechazaría (homologación de una muestra en C14).
 */
final class ReglasDeNegocioTest extends TestCase
{
  /** Momento de referencia coherente con la fecha de emisión y de firma de la fábrica (las reglas de fechas son relativas a él). */
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

  private static function feNoContribuyente(): DE
  {
    return self::de(fn () => F::facturaCreditoCuotas());
  }

  private static function feUsd(): DE
  {
    return self::de(fn () => F::facturaUsd());
  }

  private static function nr(): DE
  {
    return self::de(fn () => F::notaDeRemision());
  }

  private static function af(): DE
  {
    return self::de(fn () => F::autofactura());
  }

  private static function nc(): DE
  {
    return self::de(fn () => F::notaDeCredito());
  }

  private static function feConDireccion(): DE
  {
    $fe = F::facturaContado();
    F::receptorContribuyente($fe, 'Cliente Receptor SA', true);
    return F::rde($fe)->getDE();
  }

  /** @return iterable<string, array{callable(): DE, string}> descripción → código esperado */
  public static function descripciones(): iterable
  {
    yield '1051 tipo de emisión' => [function () { $d = self::fe(); $d->gOpeDe->dDesTipEmi = 'Contingencia'; return $d; }, '1051'];
    yield '1100 tipo de documento' => [function () { $d = self::fe(); $d->gTimb->dDesTiDE = 'Nota de crédito electrónica'; return $d; }, '1100'];
    yield '1203 tipo de transacción' => [function () { $d = self::fe(); $d->gDatGralOpe->gOpeCom->dDesTipTra = 'Donación'; return $d; }, '1203'];
    yield '1205 tipo de impuesto' => [function () { $d = self::fe(); $d->gDatGralOpe->gOpeCom->dDesTImp = 'ISC'; return $d; }, '1205'];
    yield '1206 moneda' => [function () { $d = self::fe(); $d->gDatGralOpe->gOpeCom->dDesMoneOpe = 'Dolar'; return $d; }, '1206'];
    yield '1211 condición del anticipo' => [function () { $d = self::fe(); $d->gDatGralOpe->gOpeCom->iCondAnt = 1; $d->gDatGralOpe->gOpeCom->dDesCondAnt = 'Anticipo por Ítem'; return $d; }, '1211'];
    yield '1254 departamento del emisor' => [function () { $d = self::fe(); $d->gDatGralOpe->gEmis->dDesDepEmi = 'OTRO'; return $d; }, '1254'];
    yield '1257 distrito del emisor' => [function () { $d = self::fe(); $d->gDatGralOpe->gEmis->cDisEmi = 1; $d->gDatGralOpe->gEmis->dDesDisEmi = 'OTRO'; return $d; }, '1257'];
    yield '1260 ciudad del emisor' => [function () { $d = self::fe(); $d->gDatGralOpe->gEmis->dDesCiuEmi = 'OTRA'; return $d; }, '1260'];
    yield '1301 país del receptor' => [function () { $d = self::fe(); $d->gDatGralOpe->gDatRec->dDesPaisRe = 'Brasil'; return $d; }, '1301'];
    yield '1313 tipo de documento del receptor' => [function () { $d = self::feNoContribuyente(); $d->gDatGralOpe->gDatRec->dDTipIDRec = 'Pasaporte'; return $d; }, '1313'];
    yield '1325 departamento del receptor' => [function () { $d = self::feConDireccion(); $d->gDatGralOpe->gDatRec->dDesDepRec = 'OTRO'; return $d; }, '1325'];
    yield '1326 distrito del receptor' => [function () { $d = self::feConDireccion(); $d->gDatGralOpe->gDatRec->dDesDisRec = 'OTRO'; return $d; }, '1326'];
    yield '1329 ciudad del receptor' => [function () { $d = self::feConDireccion(); $d->gDatGralOpe->gDatRec->dDesCiuRec = 'OTRA'; return $d; }, '1329'];
    yield '1352 indicador de presencia' => [function () { $d = self::fe(); $d->gDtipDe->gCamFE->dDesIndPres = 'Operación electrónica'; return $d; }, '1352'];
    yield '1452 motivo de la NC' => [function () { $d = self::nc(); $d->gDtipDe->gCamNCDE->dDesMotEmi = 'Otro motivo'; return $d; }, '1452'];
    yield '1502 condición de la operación' => [function () { $d = self::fe(); $d->gDtipDe->gCamCond->dDCondOpe = 'Crédito'; return $d; }, '1502'];
    yield '1554 tipo de pago' => [function () { $d = self::fe(); $d->gDtipDe->gCamCond->gPaConEIni[0]->dDesTiPag = 'Cheque'; return $d; }, '1554'];
    yield '1555 moneda del pago' => [function () { $d = self::fe(); $d->gDtipDe->gCamCond->gPaConEIni[0]->dDMoneTiPag = 'Dolar'; return $d; }, '1555'];
    yield '1602 denominación de la tarjeta' => [function () { $d = self::fe(); $p = $d->gDtipDe->gCamCond->gPaConEIni[0]; $p->iTiPago = 3; $p->dDesTiPag = 'Tarjeta de crédito'; $t = new GPagTarCD(); $t->iDenTarj = 1; $t->dDesDenTarj = 'Mastercard'; $t->iForProPa = 1; $p->gPagTarCD = $t; return $d; }, '1602'];
    yield '1702 condición del crédito' => [function () { $d = self::feNoContribuyente(); $d->gDtipDe->gCamCond->gPagCred->dDCondCred = 'Plazo'; return $d; }, '1702'];
    yield '1802 unidad de medida' => [function () { $d = self::fe(); $d->gDtipDe->gCamItem[0]->dDesUniMed = 'KG'; return $d; }, '1802'];
    yield '1804 país de origen' => [function () { $d = self::fe(); $d->gDtipDe->gCamItem[0]->cPaisOrig = 'PRY'; $d->gDtipDe->gCamItem[0]->dDesPaisOrig = 'Brasil'; return $d; }, '1804'];
    yield '1806 relevancia de mercaderías' => [function () { $d = self::nr(); $d->gDtipDe->gCamItem[0]->cRelMerc = 1; $d->gDtipDe->gCamItem[0]->dDesRelMerc = 'Tolerancia de merma'; return $d; }, '1806'];
    yield '1903 afectación del IVA' => [function () { $d = self::fe(); $d->gDtipDe->gCamItem[0]->gCamIVA->dDesAfecIVA = 'Exento'; return $d; }, '1903'];
    yield '2103 tipo de transporte' => [function () { $d = self::nr(); $d->gDtipDe->gTransp->dDesTipTrans = 'Tercero'; return $d; }, '2103'];
    yield '2104 modalidad de transporte' => [function () { $d = self::nr(); $d->gDtipDe->gTransp->dDesModTrans = 'Fluvial'; return $d; }, '2104'];
    yield '2401 tipo de documento asociado' => [function () { $d = self::nc(); $d->gCamDEAsoc[0]->dDesTipDocAso = 'Impreso'; return $d; }, '2401'];
    yield '2410 tipo de documento impreso' => [function () { $d = self::nc(); $d->gCamDEAsoc[0]->iTipoDocAso = 1; $d->gCamDEAsoc[0]->dDTipoDocAso = 'Nota de crédito'; return $d; }, '2410'];
    yield '2429 tipo de constancia' => [function () { $d = self::af(); $d->gCamDEAsoc[0]->dDesTipCons = 'Constancia de microproductores'; return $d; }, '2429'];
    yield '2552 departamento del vendedor' => [function () { $d = self::af(); $d->gDtipDe->gCamAE->dDesDepVen = 'OTRO'; return $d; }, '2552'];
    yield '2555 ciudad del vendedor' => [function () { $d = self::af(); $d->gDtipDe->gCamAE->dDesCiuVen = 'OTRA'; return $d; }, '2555'];
    yield '2556 departamento de la transacción' => [function () { $d = self::af(); $d->gDtipDe->gCamAE->dDesDepProv = 'OTRO'; return $d; }, '2556'];
    yield '2559 ciudad de la transacción' => [function () { $d = self::af(); $d->gDtipDe->gCamAE->dDesCiuProv = 'OTRA'; return $d; }, '2559'];
    yield '2561 distrito del vendedor' => [function () { $d = self::af(); $d->gDtipDe->gCamAE->cDisVen = 1; $d->gDtipDe->gCamAE->dDesDisVen = 'OTRO'; return $d; }, '2561'];
    yield '2558 distrito de la transacción' => [function () { $d = self::af(); $d->gDtipDe->gCamAE->cDisProv = 1; $d->gDtipDe->gCamAE->dDesDisProv = 'OTRO'; return $d; }, '2558'];
    yield '2602 motivo de la NR' => [function () { $d = self::nr(); $d->gDtipDe->gCamNRE->dDesMotEmiNR = 'Otro motivo'; return $d; }, '2602'];
    yield '2603 responsable de la NR' => [function () { $d = self::nr(); $d->gDtipDe->gCamNRE->dDesRespEmiNR = 'Otro responsable'; return $d; }, '2603'];
  }

  #[DataProvider('descripciones')]
  public function testDescripcionQueNoCorrespondeAlCodigo(callable $crear, string $codigo): void
  {
    $this->assertCodigo($crear(), $codigo);
  }

  public function testLasDescripcionesLibresNoSeComparan(): void
  {
    $d = self::feNoContribuyente();
    $d->gDatGralOpe->gDatRec->iTipIDRec = 9;
    $d->gDatGralOpe->gDatRec->dDTipIDRec = 'Licencia de conducir';
    $d->gDtipDe->gCamFE->iIndPres = 9;
    $d->gDtipDe->gCamFE->dDesIndPres = 'Venta en feria itinerante';
    $r = ValidadorDE::validar($d, self::ahora());
    $this->assertSame([], $r->porCodigo('1313'));
    $this->assertSame([], $r->porCodigo('1352'));
  }

  /** D-A3: las 15 monedas de nombre largo se emiten recortadas y el SIFEN las rechaza con 1206; el validador avisa. */
  public function testMonedaDeNombreLargoEsAdvertencia1206(): void
  {
    $r = ValidadorDE::validar(F::facturaUsd(3, 'ANG'), self::ahora());
    $this->assertTrue($r->esValido(), (string) $r);
    $this->assertCount(1, $r->porCodigo('1206'));
    $this->assertTrue($r->porCodigo('1206')[0]->esAdvertencia);
    $this->assertStringContainsString('20 caracteres', $r->porCodigo('1206')[0]->mensaje);
  }

  /** @return iterable<string, array{callable(): DE, string}> */
  public static function generales(): iterable
  {
    yield '1003 DV del CDC' => [function () { $d = self::fe(); $d->id = substr($d->id, 0, 43) . ((intval($d->id[43]) + 1) % 10); return $d; }, '1003'];
    yield '1000 CDC no coincide con el contenido' => [function () { $d = self::fe(); $d->gOpeDe->dCodSeg = '000000001'; return $d; }, '1000'];
    yield '1004 firma adelantada' => [function () { $d = self::fe(); $d->dFecFirma = (clone self::ahora())->modify('+1 day'); return $d; }, '1004'];
    yield '1103 timbrado vigente después de la emisión' => [function () { $d = self::fe(); $d->gTimb->dFeIniT = (clone $d->gDatGralOpe->dFeEmiDE)->modify('+1 day'); return $d; }, '1103'];
    yield '1110 serie inválida' => [function () { $d = self::fe(); $d->gTimb->dSerieNum = 'A1'; return $d; }, '1110'];
    yield '1150 emisión con más de 720 h de atraso' => [function () { $d = self::fe(); $d->gDatGralOpe->dFeEmiDE = (clone self::ahora())->modify('-31 days'); return $d; }, '1150'];
    yield '1151 emisión con más de 120 h de adelanto' => [function () { $d = self::fe(); $d->gDatGralOpe->dFeEmiDE = (clone self::ahora())->modify('+6 days'); return $d; }, '1151'];
    yield '1156 emisión anterior al lanzamiento' => [function () { $d = self::fe(); $d->gDatGralOpe->dFeEmiDE = new DateTime('2018-01-01T10:00:00', new DateTimeZone(Constants::SIFEN_TIMEZONE)); return $d; }, '1156'];
    yield '1202 FE sin tipo de transacción' => [function () { $d = self::fe(); unset($d->gDatGralOpe->gOpeCom->iTipTra); return $d; }, '1202'];
    yield '1207 moneda extranjera sin condición del tipo de cambio' => [function () { $d = self::feUsd(); unset($d->gDatGralOpe->gOpeCom->dCondTiCam); return $d; }, '1207'];
    yield '1208 PYG con condición del tipo de cambio' => [function () { $d = self::fe(); $d->gDatGralOpe->gOpeCom->dCondTiCam = 1; return $d; }, '1208'];
    yield '1209 tipo de cambio global sin valor' => [function () { $d = self::feUsd(); unset($d->gDatGralOpe->gOpeCom->dTiCam); return $d; }, '1209'];
    yield '1210 PYG con tipo de cambio' => [function () { $d = self::fe(); $d->gDatGralOpe->gOpeCom->dTiCam = '7300'; return $d; }, '1210'];
    yield '1253 DV del emisor' => [function () { $d = self::fe(); $d->gDatGralOpe->gEmis->dDVEmi = (RucUtils::CalcDV($d->gDatGralOpe->gEmis->dRucEm) + 1) % 10; return $d; }, '1253'];
    yield '1255 geografía del emisor' => [function () { $d = self::fe(); $d->gDatGralOpe->gEmis->cCiuEmi = 99999; return $d; }, '1255'];
    yield '1328 geografía del receptor' => [function () { $d = self::feConDireccion(); $d->gDatGralOpe->gDatRec->cCiuRec = 99999; return $d; }, '1328'];
  }

  #[DataProvider('generales')]
  public function testReglasGenerales(callable $crear, string $codigo): void
  {
    $this->assertCodigo($crear(), $codigo);
  }

  public function testTransmisionExtemporaneaEsAdvertencia1005(): void
  {
    $d = self::fe();
    $d->dFecFirma = (clone self::ahora())->modify('-4 days');
    $r = ValidadorDE::validar($d, self::ahora());
    $this->assertTrue($r->esValido(), (string) $r);
    $this->assertTrue($r->porCodigo('1005')[0]->esAdvertencia);
  }

  /** @return iterable<string, array{callable(): DE, string}> */
  public static function receptor(): iterable
  {
    yield '1315 AF con receptor no contribuyente' => [function () { $d = self::af(); $d->gDatGralOpe->gDatRec->iNatRec = 2; return $d; }, '1315'];
    yield '1300 no contribuyente en B2B' => [function () { $d = self::feNoContribuyente(); $d->gDatGralOpe->gDatRec->iTiOpe = 1; return $d; }, '1300'];
    yield '1300 B2F con contribuyente' => [function () { $d = self::fe(); $d->gDatGralOpe->gDatRec->iTiOpe = 4; return $d; }, '1300'];
    yield '1316 AF que no es B2C' => [function () { $d = self::af(); $d->gDatGralOpe->gDatRec->iTiOpe = 1; return $d; }, '1316'];
    yield '1320 B2F con país PRY' => [function () { $d = self::feNoContribuyente(); $d->gDatGralOpe->gDatRec->iTiOpe = 4; return $d; }, '1320'];
    yield '1320 país extranjero sin B2F' => [function () { $d = self::feNoContribuyente(); $d->gDatGralOpe->gDatRec->cPaisRec = 'BRA'; $d->gDatGralOpe->gDatRec->dDesPaisRe = 'Brazil'; return $d; }, '1320'];
    yield '1302 contribuyente sin tipo' => [function () { $d = self::fe(); unset($d->gDatGralOpe->gDatRec->iTiContRec); return $d; }, '1302'];
    yield '1303 no contribuyente con tipo' => [function () { $d = self::feNoContribuyente(); $d->gDatGralOpe->gDatRec->iTiContRec = 1; return $d; }, '1303'];
    yield '1304 contribuyente sin RUC' => [function () { $d = self::fe(); unset($d->gDatGralOpe->gDatRec->dRucRec); return $d; }, '1304'];
    yield '1305 no contribuyente con RUC' => [function () { $d = self::feNoContribuyente(); $d->gDatGralOpe->gDatRec->dRucRec = '80000000'; return $d; }, '1305'];
    yield '1317 AF con receptor distinto del emisor' => [function () { $d = self::af(); $d->gDatGralOpe->gDatRec->dRucRec = '80012345'; $d->gDatGralOpe->gDatRec->dDVRec = 0; return $d; }, '1317'];
    yield '1309 DV del receptor' => [function () { $d = self::fe(); $d->gDatGralOpe->gDatRec->dDVRec = ($d->gDatGralOpe->gDatRec->dDVRec + 1) % 10; return $d; }, '1309'];
    yield '1310 no contribuyente sin tipo de documento' => [function () { $d = self::feNoContribuyente(); unset($d->gDatGralOpe->gDatRec->iTipIDRec); return $d; }, '1310'];
    yield '1311 contribuyente con tipo de documento' => [function () { $d = self::fe(); $d->gDatGralOpe->gDatRec->iTipIDRec = 1; $d->gDatGralOpe->gDatRec->dDTipIDRec = 'Cédula paraguaya'; return $d; }, '1311'];
    yield '1319 innominado fuera de B2C' => [function () { $d = self::feNoContribuyente(); $d->gDatGralOpe->gDatRec->iTipIDRec = 5; $d->gDatGralOpe->gDatRec->dDTipIDRec = 'Innominado'; $d->gDatGralOpe->gDatRec->dNumIDRec = '0'; $d->gDatGralOpe->gDatRec->iTiOpe = 1; return $d; }, '1319'];
    yield '1321 innominado con 7 millones' => [function () { $d = self::feNoContribuyente(); $d->gDatGralOpe->gDatRec->iTipIDRec = 5; $d->gDatGralOpe->gDatRec->dDTipIDRec = 'Innominado'; $d->gDatGralOpe->gDatRec->dNumIDRec = '0'; $d->gTotSub->dTotGralOpe = '7000000'; return $d; }, '1321'];
    yield '1314 no contribuyente sin número de documento' => [function () { $d = self::feNoContribuyente(); unset($d->gDatGralOpe->gDatRec->dNumIDRec); return $d; }, '1314'];
    yield '1323 contribuyente con número de documento' => [function () { $d = self::fe(); $d->gDatGralOpe->gDatRec->dNumIDRec = '1234567'; return $d; }, '1323'];
    yield '1318 NR sin dirección del receptor' => [function () { $d = self::nr(); unset($d->gDatGralOpe->gDatRec->dDirRec); return $d; }, '1318'];
    yield '1330 dirección sin número de casa' => [function () { $d = self::feConDireccion(); unset($d->gDatGralOpe->gDatRec->dNumCasRec); return $d; }, '1330'];
    yield '1324 dirección sin departamento' => [function () { $d = self::feConDireccion(); unset($d->gDatGralOpe->gDatRec->cDepRec); return $d; }, '1324'];
    yield '1327 dirección sin ciudad' => [function () { $d = self::feConDireccion(); unset($d->gDatGralOpe->gDatRec->cCiuRec); return $d; }, '1327'];
  }

  #[DataProvider('receptor')]
  public function testReglasDelReceptor(callable $crear, string $codigo): void
  {
    $this->assertCodigo($crear(), $codigo);
  }

  /** @return iterable<string, array{callable(): DE, string}> */
  public static function pagos(): iterable
  {
    yield '1503 AF a crédito' => [function () { $d = self::af(); $d->gDtipDe->gCamCond->iCondOpe = 2; $d->gDtipDe->gCamCond->dDCondOpe = 'Crédito'; return $d; }, '1503'];
    yield '1550 contado sin pagos' => [function () { $d = self::fe(); $d->gDtipDe->gCamCond->gPaConEIni = []; return $d; }, '1550'];
    yield '1551 crédito con entrega inicial sin pagos' => [function () { $d = self::de(fn () => F::facturaCreditoCuotas(4, '20000')); $d->gDtipDe->gCamCond->gPaConEIni = []; return $d; }, '1551'];
    yield '1552 crédito sin entrega inicial con pagos' => [function () { $d = self::feNoContribuyente(); $d->gDtipDe->gCamCond->gPaConEIni = self::fe()->gDtipDe->gCamCond->gPaConEIni; return $d; }, '1552'];
    yield '1553 pago bancario sin operación bancaria' => [function () { $d = self::fe(); $p = $d->gDtipDe->gCamCond->gPaConEIni[0]; $p->iTiPago = 16; $p->dDesTiPag = 'Pago bancario'; return $d; }, '1553'];
    yield '1556 pago en moneda extranjera sin tipo de cambio' => [function () { $d = self::feUsd(); unset($d->gDtipDe->gCamCond->gPaConEIni[0]->dTiCamTiPag); return $d; }, '1556'];
    yield '1557 pago en PYG con tipo de cambio' => [function () { $d = self::fe(); $d->gDtipDe->gCamCond->gPaConEIni[0]->dTiCamTiPag = '7300'; return $d; }, '1557'];
    yield '1600 tarjeta sin datos de la tarjeta' => [function () { $d = self::fe(); $p = $d->gDtipDe->gCamCond->gPaConEIni[0]; $p->iTiPago = 3; $p->dDesTiPag = 'Tarjeta de crédito'; return $d; }, '1600'];
    yield '1601 efectivo con datos de tarjeta' => [function () { $d = self::fe(); $t = new GPagTarCD(); $t->iDenTarj = 1; $t->dDesDenTarj = 'Visa'; $t->iForProPa = 1; $d->gDtipDe->gCamCond->gPaConEIni[0]->gPagTarCD = $t; return $d; }, '1601'];
    yield '1650 cheque sin datos del cheque' => [function () { $d = self::fe(); $p = $d->gDtipDe->gCamCond->gPaConEIni[0]; $p->iTiPago = 2; $p->dDesTiPag = 'Cheque'; return $d; }, '1650'];
    yield '1651 efectivo con datos de cheque' => [function () { $d = self::fe(); $c = new GPagCheq(); $c->dNumCheq = '00001234'; $c->dBcoEmi = 'Banco'; $d->gDtipDe->gCamCond->gPaConEIni[0]->gPagCheq = $c; return $d; }, '1651'];
    yield '1700 crédito sin datos del crédito' => [function () { $d = self::feNoContribuyente(); unset($d->gDtipDe->gCamCond->gPagCred); return $d; }, '1700'];
    yield '1701 contado con datos del crédito' => [function () { $d = self::fe(); $d->gDtipDe->gCamCond->gPagCred = self::feNoContribuyente()->gDtipDe->gCamCond->gPagCred; return $d; }, '1701'];
    yield '1703 crédito a plazo sin plazo' => [function () { $d = self::feNoContribuyente(); $c = $d->gDtipDe->gCamCond->gPagCred; $c->iCondCred = 1; $c->dDCondCred = 'Plazo'; unset($c->dCuotas); $c->gCuotas = []; return $d; }, '1703'];
    yield '1704 crédito en cuotas con plazo' => [function () { $d = self::feNoContribuyente(); $d->gDtipDe->gCamCond->gPagCred->dPlazoCre = '30 días'; return $d; }, '1704'];
    yield '1705 crédito en cuotas sin cantidad' => [function () { $d = self::feNoContribuyente(); unset($d->gDtipDe->gCamCond->gPagCred->dCuotas); return $d; }, '1705'];
    yield '1706 crédito a plazo con cantidad de cuotas' => [function () { $d = self::feNoContribuyente(); $c = $d->gDtipDe->gCamCond->gPagCred; $c->iCondCred = 1; $c->dDCondCred = 'Plazo'; $c->dPlazoCre = '30 días'; $c->gCuotas = []; return $d; }, '1706'];
    yield '1751 crédito a plazo con cuotas' => [function () { $d = self::feNoContribuyente(); $c = $d->gDtipDe->gCamCond->gPagCred; $c->iCondCred = 1; $c->dDCondCred = 'Plazo'; $c->dPlazoCre = '30 días'; unset($c->dCuotas); return $d; }, '1751'];
  }

  #[DataProvider('pagos')]
  public function testReglasDePagos(callable $crear, string $codigo): void
  {
    $this->assertCodigo($crear(), $codigo);
  }

  /** Un documento válido de la fábrica no dispara ninguna de estas reglas (control de falsos positivos). */
  public function testLosDocumentosValidosSiguenSinErrores(): void
  {
    foreach ([self::fe(), self::feNoContribuyente(), self::feUsd(), self::nr(), self::af(), self::nc(), self::feConDireccion()] as $d) {
      $r = ValidadorDE::validar($d, self::ahora());
      $this->assertTrue($r->esValido(), (string) $r);
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
    $this->assertNotNull($e->elemento, (string) $e);
    $this->assertSame($e->getInfoValidacion()->mensaje, $e->mensaje, 'el mensaje es el del MT');
    $this->assertLessThanOrEqual(6, count($r), "una sola violación no debe disparar una cascada de códigos: $r");
  }
}
