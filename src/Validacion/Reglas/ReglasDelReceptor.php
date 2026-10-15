<?php

namespace IonysDev\Pkuatia\Validacion\Reglas;

use DateTime;
use IonysDev\Pkuatia\Core\Constants;
use IonysDev\Pkuatia\Utils\RucUtils;
use IonysDev\Pkuatia\Validacion\ResultadoValidacion;
use IonysDev\Pkuatia\Validacion\VistaDocumento;

/**
 * Reglas del receptor (D200-D224; errores-validacion.md, MT §12.4 D3): naturaleza y tipo de operación (1315, 1300,
 * 1316, 1320), contribuyente (1302/1303 tipo, 1304/1305 RUC, 1317 AF, 1309 DV), documento de identidad (1310/1311,
 * 1314/1323, 1319 innominado solo en B2C, 1321 NT-024) y dirección (1318, 1330, 1324, 1327).
 * 1322 y 1323 para B2F no se aplican: errores-validacion.md los deja contradictorios con la NT-023 (devolución a
 * ekuat-ia). Fase C, paso C10.
 */
final class ReglasDelReceptor extends ConjuntoDeReglas
{
  public static function aplicar(VistaDocumento $v, ResultadoValidacion $r, DateTime $ahora): void
  {
    $rec = $v->gDatRec();
    if ($rec === null)
      return;
    $ruta = 'DE.gDatGralOpe.gDatRec';
    $tipo = $v->tipoDocumento();
    $esAF = $tipo === 4;
    $esNR = $tipo === 7;
    $natRec = self::entero($rec, 'iNatRec');
    $tiOpe = self::entero($rec, 'iTiOpe');
    $pais = strtoupper((string) self::texto($rec, 'cPaisRec'));
    $contribuyente = $natRec === 1;
    $noContribuyente = $natRec === 2;

    // Naturaleza y tipo de operación
    self::regla($r, $esAF && $natRec !== null && !$contribuyente, '1315', 'iNatRec', $ruta, $natRec, 'En la autofactura el receptor es el propio emisor, contribuyente.');
    self::regla($r, !$esAF && $noContribuyente && $tiOpe !== null && $tiOpe !== 2, '1300', 'iTiOpe', $ruta, $tiOpe, 'Un receptor no contribuyente solo admite B2C (2).');
    self::regla($r, $tiOpe === 4 && $contribuyente, '1300', 'iTiOpe', $ruta, $tiOpe, 'B2F (4) exige un receptor no contribuyente.');
    self::regla($r, $esAF && $tiOpe !== null && $tiOpe !== 2, '1316', 'iTiOpe', $ruta, $tiOpe, 'La autofactura es B2C (2).');
    if ($pais !== '' && $tiOpe !== null) {
      self::regla($r, $tiOpe === 4 && $pais === 'PRY', '1320', 'cPaisRec', $ruta, $pais, 'En B2F el país del receptor no puede ser PRY.');
      self::regla($r, $tiOpe !== 4 && $pais !== 'PRY', '1320', 'cPaisRec', $ruta, $pais, 'Fuera de B2F el país del receptor debe ser PRY.');
    }

    // Contribuyente: tipo y RUC
    $tiCont = self::entero($rec, 'iTiContRec');
    $rucRec = self::texto($rec, 'dRucRec');
    $dvRec = self::entero($rec, 'dDVRec');
    self::regla($r, $contribuyente && $tiCont === null, '1302', 'iTiContRec', $ruta);
    self::regla($r, $noContribuyente && $tiCont !== null, '1303', 'iTiContRec', $ruta, $tiCont);
    self::regla($r, $contribuyente && $rucRec === null, '1304', 'dRucRec', $ruta);
    self::regla($r, $noContribuyente && $rucRec !== null, '1305', 'dRucRec', $ruta, $rucRec);
    $rucEmisor = self::texto($v->gEmis(), 'dRucEm');
    self::regla($r, $esAF && $rucRec !== null && $rucEmisor !== null && $rucRec !== $rucEmisor, '1317', 'dRucRec', $ruta, $rucRec, "En la autofactura el receptor es el emisor ($rucEmisor).");
    if ($rucRec !== null && $dvRec !== null)
      self::regla($r, RucUtils::CalcDV($rucRec) !== $dvRec, '1309', 'dDVRec', $ruta, $dvRec, 'El dígito verificador calculado es ' . RucUtils::CalcDV($rucRec) . '.');

    // Documento de identidad
    $tipId = self::entero($rec, 'iTipIDRec');
    $numId = self::texto($rec, 'dNumIDRec');
    self::regla($r, $noContribuyente && $tipId === null, '1310', 'iTipIDRec', $ruta);
    self::regla($r, $contribuyente && $tipId !== null, '1311', 'iTipIDRec', $ruta, $tipId);
    self::regla($r, $tipId === 5 && $tiOpe !== null && $tiOpe !== 2, '1319', 'iTipIDRec', $ruta, $tipId, 'El receptor innominado (5) solo se admite en B2C.');
    self::regla($r, $noContribuyente && $numId === null, '1314', 'dNumIDRec', $ruta);
    self::regla($r, $contribuyente && $numId !== null, '1323', 'dNumIDRec', $ruta, $numId);
    if ($tipId === 5)
      self::nt024($v, $r, $ruta);

    // Dirección
    $dir = self::texto($rec, 'dDirRec');
    self::regla($r, ($esNR || $tiOpe === 4) && $dir === null, '1318', 'dDirRec', $ruta);
    if ($dir !== null) {
      self::regla($r, self::entero($rec, 'dNumCasRec') === null, '1330', 'dNumCasRec', $ruta);
      self::regla($r, $tiOpe !== 4 && self::entero($rec, 'cDepRec') === null, '1324', 'cDepRec', $ruta);
      self::regla($r, $tiOpe !== 4 && self::entero($rec, 'cCiuRec') === null, '1327', 'cCiuRec', $ruta);
    }
  }

  /** NT-024 (1321): innominado con total general en guaraníes de 7.000.000 o más, salvo muestras médicas (D011 = 13). */
  private static function nt024(VistaDocumento $v, ResultadoValidacion $r, string $ruta): void
  {
    $ope = $v->gOpeCom();
    if (self::entero($ope, 'iTipTra') === 13)
      return;
    $tot = $v->gTotSub();
    if ($tot === null)
      return;
    $esPYG = strtoupper((string) (self::texto($ope, 'cMoneOpe') ?? 'PYG')) === 'PYG';
    $total = $esPYG ? self::texto($tot, 'dTotGralOpe') : self::texto($tot, 'dTotalGs');
    if ($total === null || !is_numeric($total))
      return;
    self::regla($r, bccomp($total, Constants::UMBRAL_INNOMINADO_PYG, 8) >= 0, '1321', 'iTipIDRec', $ruta, $total,
      'NT-024: desde el 01/01/2025 el receptor debe identificarse cuando el total en guaraníes llega a ' . Constants::UMBRAL_INNOMINADO_PYG . '.');
  }
}
