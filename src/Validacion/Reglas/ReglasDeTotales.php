<?php

namespace IonysDev\Pkuatia\Validacion\Reglas;

use DateTime;
use IonysDev\Pkuatia\Validacion\ResultadoValidacion;
use IonysDev\Pkuatia\Validacion\VistaDocumento;

/**
 * Reglas de los subtotales y totales (F001-F037; errores-validacion.md, MT §12.4 F, campos-obligatorios.md y NT-013):
 * presencia y cálculo de los subtotales por afectación (2352-2359), total de la operación (2362), descuentos
 * (2363/2364), total general (2365), liquidación del IVA (2366-2371), bases gravadas (2372-2377) y total en guaraníes
 * (2382/2385/2386). Cada total se recalcula desde los ítems informados con las fórmulas que calcTotSub() aplica y el
 * SIFEN aprobó en sifen-test. Donde el MT se contradice se sigue campos-obligatorios.md: F014 = F008 − F013 + F025
 * (la fila 2365 dice F008 − F011 − F012 − F013, pero EA008 ya descuenta EA002, EA004, EA006 y EA007) y
 * F017 = F015 + F016 − F036 − F037 + F026. F004 y F005 (y sus liquidaciones y bases) solo se exigen cuando D013 es
 * 1 o 5 (NT-013: "no debe existir el campo si D013 ≠ 1 o D013 ≠ 5"). Fase C, paso C10b.
 */
final class ReglasDeTotales extends ConjuntoDeReglas
{
  public static function aplicar(VistaDocumento $v, ResultadoValidacion $r, DateTime $ahora): void
  {
    $tot = $v->gTotSub();
    if ($tot === null)
      return;
    $ruta = 'DE.gTotSub';
    $opeCom = $v->gOpeCom();
    $moneda = strtoupper((string) self::texto($opeCom, 'cMoneOpe'));
    $condCambio = self::entero($opeCom, 'dCondTiCam');
    $impuesto = self::entero($opeCom, 'iTImp');
    $esAF = $v->tipoDocumento() === 4;
    $conIva = !$esAF && in_array($impuesto, [1, 3, 4, 5], true); // D013 = 2 (ISC) no lleva gCamIVA (1902)
    $liquidaIva = !$esAF && ($impuesto === 1 || $impuesto === 5);

    // Sumas desde los ítems informados, a escala 8 como calcTotSub()
    $s = ['exe' => '0', 'exo' => '0', 'sub5' => '0', 'sub10' => '0', 'iva5' => '0', 'iva10' => '0', 'base5' => '0', 'base10' => '0',
      'desc' => '0', 'descGlo' => '0', 'items' => '0', 'gs' => '0'];
    $hay = ['exe' => false, 'exo' => false, 5 => false, 10 => false];
    foreach ($v->items() as $item) {
      $cantidad = self::monto($item, 'dCantProSer') ?? '0';
      $resta = self::v(self::v($item, 'gValorItem'), 'gValorRestaItem');
      $total = self::monto($resta, 'dTotOpeItem') ?? '0';
      $s['items'] = bcadd($s['items'], $total, 8);
      $s['gs'] = bcadd($s['gs'], self::monto($resta, 'dTotOpeGs') ?? '0', 8);
      $s['desc'] = bcadd($s['desc'], bcmul(self::monto($resta, 'dDescItem') ?? '0', $cantidad, 8), 8);
      $s['descGlo'] = bcadd($s['descGlo'], bcmul(self::monto($resta, 'dDescGloItem') ?? '0', $cantidad, 8), 8);
      $iva = self::v($item, 'gCamIVA');
      if ($iva === null)
        continue;
      $afectacion = self::entero($iva, 'iAfecIVA');
      $tasa = self::entero($iva, 'dTasaIVA');
      $base = self::monto($iva, 'dBasGravIVA') ?? '0';
      $liquidacion = self::monto($iva, 'dLiqIVAItem') ?? '0';
      if ($afectacion === 3) {
        $hay['exe'] = true;
        $s['exe'] = bcadd($s['exe'], $total, 8);
      } elseif ($afectacion === 2) {
        $hay['exo'] = true;
        $s['exo'] = bcadd($s['exo'], $total, 8);
      } elseif ($afectacion === 4) {
        $s['exe'] = bcadd($s['exe'], self::monto($iva, 'dBasExe') ?? '0', 8); // NT-013: la base exenta del gravado parcial va en F002
      }
      if (($afectacion === 1 || $afectacion === 4) && ($tasa === 5 || $tasa === 10)) {
        $hay[$tasa] = true;
        // NT-013: F004/F005 suman EA008 del gravado y E735 + E736 del gravado parcial
        $s['sub' . $tasa] = bcadd($s['sub' . $tasa], $afectacion === 1 ? $total : bcadd($base, $liquidacion, 8), 8);
        $s['iva' . $tasa] = bcadd($s['iva' . $tasa], $liquidacion, 8);
        $s['base' . $tasa] = bcadd($s['base' . $tasa], $base, 8);
      }
    }

    $f = fn (string $campo): ?string => self::monto($tot, $campo);
    /** Presencia (código de "no informado") y cálculo (código de "incorrecto") de un total. */
    $revisar = function (string $campo, string $codigoFalta, string $codigoCalculo, bool $requerido, string $esperado, string $formula) use ($r, $ruta, $f): void {
      $informado = $f($campo);
      self::regla($r, $requerido && $informado === null, $codigoFalta, $campo, $ruta, null, "$formula = $esperado.");
      self::regla($r, $informado !== null && self::difiere($informado, $esperado), $codigoCalculo, $campo, $ruta, $informado, "$formula = $esperado.");
    };

    $totOpe = $f('dTotOpe');
    if ($conIva) {
      $revisar('dSubExe', '2352', '2353', $hay['exe'], $s['exe'], 'F002 = suma de EA008 de los ítems exentos más E737 de los gravados parciales (NT-013)');
      $revisar('dSubExo', '2354', '2355', $hay['exo'], $s['exo'], 'F003 = suma de EA008 de los ítems exonerados');
      $revisar('dSub5', '2356', '2357', $liquidaIva && $hay[5], $s['sub5'], 'F004 = suma de EA008 de los ítems gravados al 5 % más E735 + E736 de los gravados parciales al 5 % (NT-013)');
      $revisar('dSub10', '2358', '2359', $liquidaIva && $hay[10], $s['sub10'], 'F005 = suma de EA008 de los ítems gravados al 10 % más E735 + E736 de los gravados parciales al 10 % (NT-013)');
      $esperado = bcadd(bcadd($f('dSubExe') ?? '0', $f('dSubExo') ?? '0', 8), bcadd($f('dSub5') ?? '0', $f('dSub10') ?? '0', 8), 8);
      self::regla($r, $totOpe !== null && self::difiere($totOpe, $esperado), '2362', 'dTotOpe', $ruta, $totOpe, "F008 = F002 + F003 + F004 + F005 = $esperado.");
      $iva5 = $f('dIVA5');
      $iva10 = $f('dIVA10');
      $revisar('dIVA5', '2366', '2367', $liquidaIva && $hay[5], $s['iva5'], 'F015 = suma de E736 de los ítems con tasa 5 %');
      $revisar('dIVA10', '2368', '2369', $liquidaIva && $hay[10], $s['iva10'], 'F016 = suma de E736 de los ítems con tasa 10 %');
      $totIva = bcadd(bcsub(bcadd($iva5 ?? '0', $iva10 ?? '0', 8), bcadd($f('dLiqTotIVA5') ?? '0', $f('dLiqTotIVA10') ?? '0', 8), 8), $f('dIVAComi') ?? '0', 8);
      $revisar('dTotIVA', '2370', '2371', $iva5 !== null || $iva10 !== null, $totIva, 'F017 = F015 + F016 − F036 − F037 + F026 (campos-obligatorios.md)');
      $base5 = $f('dBaseGrav5');
      $base10 = $f('dBaseGrav10');
      $revisar('dBaseGrav5', '2372', '2373', $liquidaIva && $hay[5], $s['base5'], 'F018 = suma de E735 de los ítems con tasa 5 %');
      $revisar('dBaseGrav10', '2374', '2375', $liquidaIva && $hay[10], $s['base10'], 'F019 = suma de E735 de los ítems con tasa 10 %');
      $revisar('dTBasGraIVA', '2376', '2377', $base5 !== null || $base10 !== null, bcadd($base5 ?? '0', $base10 ?? '0', 8), 'F020 = F018 + F019');
    } elseif ($esAF) {
      self::regla($r, $totOpe !== null && self::difiere($totOpe, $s['items']), '2362', 'dTotOpe', $ruta, $totOpe, "F008 = suma de EA008 de todos los ítems = {$s['items']}.");
    }

    $totDesc = $f('dTotDesc');
    self::regla($r, $totDesc !== null && self::difiere($totDesc, $s['desc']), '2363', 'dTotDesc', $ruta, $totDesc, "F009 = suma de EA002 × E711 = {$s['desc']}.");
    $descTotal = $f('dDescTotal');
    $descEsperado = bcadd($s['desc'], $s['descGlo'], 8);
    self::regla($r, $descTotal !== null && self::difiere($descTotal, $descEsperado), '2364', 'dDescTotal', $ruta, $descTotal, "F011 = suma de (EA002 + EA004) × E711 = $descEsperado.");
    $totGral = $f('dTotGralOpe');
    if ($totGral !== null && $totOpe !== null) {
      $esperado = bcadd(bcsub($totOpe, $f('dRedon') ?? '0', 8), $f('dComi') ?? '0', 8);
      self::regla($r, self::difiere($totGral, $esperado), '2365', 'dTotGralOpe', $ruta, $totGral, "F014 = F008 − F013 + F025 = $esperado (campos-obligatorios.md).");
    }

    $totalGs = $f('dTotalGs');
    if (!$esAF && $moneda !== '' && $moneda !== 'PYG') {
      self::regla($r, $totalGs === null, '2382', 'dTotalGs', $ruta, null, "La moneda de la operación es $moneda.");
      $tiCam = self::monto($opeCom, 'dTiCam');
      if ($totalGs !== null && $condCambio === 1 && $totGral !== null && $tiCam !== null) {
        $esperado = bcmul($totGral, $tiCam, 10);
        self::regla($r, self::difiere($totalGs, $esperado), '2385', 'dTotalGs', $ruta, $totalGs, "F023 = F014 × D018 = $esperado.");
      }
      self::regla($r, $totalGs !== null && $condCambio === 2 && self::difiere($totalGs, $s['gs']), '2386', 'dTotalGs', $ruta, $totalGs, "F023 = suma de EA009 = {$s['gs']}.");
    }
  }
}
