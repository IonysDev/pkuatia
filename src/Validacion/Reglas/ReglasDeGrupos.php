<?php

namespace IonysDev\Pkuatia\Validacion\Reglas;

use DateTime;
use IonysDev\Pkuatia\Validacion\ResultadoValidacion;
use IonysDev\Pkuatia\Validacion\VistaDocumento;

/**
 * Presencia de los grupos que cada tipo de documento (C002) exige o prohíbe (errores-validacion.md, MT §12.4):
 * 1200/1201 gOpeCom, 1350/1351 gCamFE, 2550/2551 gCamAE, 1450/1451 gCamNCDE, 2600/2601 gCamNRE, 1500/1501 gCamCond,
 * 2350/2351 gTotSub, 2400 gCamDEAsoc, 2100/2101 gTransp y sus grupos (2150/2151, 2200/2201, 2250/2251, 2300/2301),
 * por ítem 1850/1851 gValorItem y 1900/1901/1902 gCamIVA, y 2390 gCamCarg. Fase C, paso C9.
 */
final class ReglasDeGrupos extends ConjuntoDeReglas
{
  public static function aplicar(VistaDocumento $v, ResultadoValidacion $r, DateTime $ahora): void
  {
    $tipo = $v->tipoDocumento();
    if ($tipo === null)
      return;
    $esNR = $tipo === 7;
    $esAF = $tipo === 4;
    $esNC = $tipo === 5 || $tipo === 6;
    $esFE = $tipo === 1;
    $sinOperacion = in_array($tipo, [4, 5, 6, 8], true);

    self::regla($r, !$esNR && $v->gOpeCom() === null, '1200', 'gOpeCom', 'DE.gDatGralOpe');
    self::regla($r, $esNR && $v->gOpeCom() !== null, '1201', 'gOpeCom', 'DE.gDatGralOpe');
    self::regla($r, $esFE && $v->gCamFE() === null, '1350', 'gCamFE', 'DE.gDtipDE');
    self::regla($r, !$esFE && $v->gCamFE() !== null, '1351', 'gCamFE', 'DE.gDtipDE');
    self::regla($r, $esAF && $v->gCamAE() === null, '2550', 'gCamAE', 'DE.gDtipDE');
    self::regla($r, !$esAF && $v->gCamAE() !== null, '2551', 'gCamAE', 'DE.gDtipDE');
    self::regla($r, $esNC && $v->gCamNCDE() === null, '1450', 'gCamNCDE', 'DE.gDtipDE');
    self::regla($r, !$esNC && $v->gCamNCDE() !== null, '1451', 'gCamNCDE', 'DE.gDtipDE');
    self::regla($r, $esNR && $v->gCamNRE() === null, '2600', 'gCamNRE', 'DE.gDtipDE');
    self::regla($r, !$esNR && $v->gCamNRE() !== null, '2601', 'gCamNRE', 'DE.gDtipDE');
    self::regla($r, ($esFE || $esAF) && $v->gCamCond() === null, '1500', 'gCamCond', 'DE.gDtipDE');
    self::regla($r, !($esFE || $esAF) && $v->gCamCond() !== null, '1501', 'gCamCond', 'DE.gDtipDE');
    self::regla($r, !$esNR && $v->gTotSub() === null, '2350', 'gTotSub', 'DE');
    self::regla($r, $esNR && $v->gTotSub() !== null, '2351', 'gTotSub', 'DE');
    self::regla($r, ($esAF || $esNC) && $v->gCamDEAsoc() === [], '2400', 'gCamDEAsoc', 'DE');

    $transp = $v->gTransp();
    self::regla($r, $esNR && $transp === null, '2100', 'gTransp', 'DE.gDtipDE');
    self::regla($r, $sinOperacion && $transp !== null, '2101', 'gTransp', 'DE.gDtipDE');
    if ($transp !== null) {
      $salida = self::v($transp, 'gCamSal');
      $entrega = self::lista($transp, 'gCamEnt');
      $vehiculos = self::lista($transp, 'gVehTras');
      $transportista = self::v($transp, 'gCamTrans');
      self::regla($r, $esNR && $salida === null, '2150', 'gCamSal', 'DE.gDtipDE.gTransp');
      self::regla($r, $sinOperacion && $salida !== null, '2151', 'gCamSal', 'DE.gDtipDE.gTransp');
      self::regla($r, $esNR && $entrega === [], '2200', 'gCamEnt', 'DE.gDtipDE.gTransp');
      self::regla($r, $sinOperacion && $entrega !== [], '2201', 'gCamEnt', 'DE.gDtipDE.gTransp');
      self::regla($r, $esNR && $vehiculos === [], '2250', 'gVehTras', 'DE.gDtipDE.gTransp');
      self::regla($r, $sinOperacion && $vehiculos !== [], '2251', 'gVehTras', 'DE.gDtipDE.gTransp');
      self::regla($r, $esNR && $transportista === null, '2300', 'gCamTrans', 'DE.gDtipDE.gTransp');
      self::regla($r, $sinOperacion && $transportista !== null, '2301', 'gCamTrans', 'DE.gDtipDE.gTransp');
    }

    $impuesto = self::entero($v->gOpeCom(), 'iTImp');
    foreach ($v->items() as $i => $item) {
      $ruta = 'DE.gDtipDE.gCamItem[' . ($i + 1) . ']';
      $valor = self::v($item, 'gValorItem');
      $iva = self::v($item, 'gCamIVA');
      self::regla($r, !$esNR && $valor === null, '1850', 'gValorItem', $ruta);
      self::regla($r, $esNR && $valor !== null, '1851', 'gValorItem', $ruta);
      self::regla($r, !$esAF && !$esNR && $iva === null && in_array($impuesto, [1, 3, 4, 5], true), '1900', 'gCamIVA', $ruta);
      self::regla($r, ($esAF || $esNR) && $iva !== null, '1901', 'gCamIVA', $ruta);
      self::regla($r, $impuesto === 2 && $iva !== null, '1902', 'gCamIVA', $ruta);
    }

    $gen = $v->gCamGen();
    self::regla($r, $gen !== null && self::v($gen, 'gCamCarg') !== null && !$esFE && !$esNR, '2390', 'gCamCarg', 'DE.gCamGen');

    // J003 va fuera de la firma y el SIFEN rechaza el DE con 2503 si se informa (verificado en sifen-test el 13/10/2026,
    // captura 02-rEnviDe-2503 del 2026-10-13); PKuatia lo emite solo si se pasa $infoAdicionalEmisor a FirmarDE(). C10b/C14.
    self::regla($r, $v->dInfAdic() !== null, '2503', 'dInfAdic', 'rDE.gCamFuFD', $v->dInfAdic(), 'El SIFEN rechaza el DE si J003 va informado (sifen-test, 13/10/2026): no pasar $infoAdicionalEmisor a FirmarDE().');
  }
}
