<?php

namespace IonysDev\Pkuatia\Validacion\Reglas;

use DateTime;
use IonysDev\Pkuatia\Validacion\ResultadoValidacion;
use IonysDev\Pkuatia\Validacion\VistaDocumento;

/**
 * Reglas de los documentos asociados (H001-H018; errores-validacion.md, MT §12.4 H): 2415 un solo asociado en la
 * autofactura y las notas de crédito y débito, 2416/2434 constancia electrónica solo en la autofactura, 2402/2418 CDC
 * solo en el asociado electrónico, 2405-2409 y 2411 campos del documento impreso obligatorios con H002 = 2 y
 * 2419-2423 y 2425 prohibidos con H002 = 1 o 3, 2424/2435 descripción del tipo de impreso con su código, 2436
 * comprobante de retención solo con pago por retención (E606 = 10), 2413 resolución de crédito fiscal con D011 = 12,
 * 2426/2427 tipo de constancia solo con H002 = 3 y 2430-2433 número y control de la constancia (obligatorios con
 * H014 = 2, prohibidos sin constancia). Fuera de alcance, porque dependen de datos del SIFEN: 2403, 2404, 2414, 2417,
 * 2437, 2438 y 2440. Fase C, paso C11.
 */
final class ReglasDeDocumentosAsociados extends ConjuntoDeReglas
{
  /** Campos del documento impreso: propiedad, código si falta con H002 = 2 y código si sobra con H002 = 1 o 3. */
  private const IMPRESO = [['dNTimDI', '2405', '2419'], ['dEstDocAso', '2406', '2420'], ['dPExpDocAso', '2407', '2421'], ['dNumDocAso', '2408', '2422'],
    ['iTipoDocAso', '2409', '2423'], ['dFecEmiDI', '2411', '2425']];

  public static function aplicar(VistaDocumento $v, ResultadoValidacion $r, DateTime $ahora): void
  {
    $asociados = $v->gCamDEAsoc();
    $tipo = $v->tipoDocumento();
    self::regla($r, in_array($tipo, [4, 5, 6], true) && count($asociados) > 1, '2415', 'gCamDEAsoc', 'DE', count($asociados),
      'La autofactura y las notas de crédito y débito llevan un solo documento asociado.');
    $pagoPorRetencion = false;
    foreach (self::lista($v->gCamCond(), 'gPaConEIni') as $pago)
      $pagoPorRetencion = $pagoPorRetencion || self::entero($pago, 'iTiPago') === 10;
    $conResolucion = false;

    foreach ($asociados as $i => $a) {
      $ruta = 'DE.gCamDEAsoc[' . ($i + 1) . ']';
      $h002 = self::entero($a, 'iTipDocAso');
      $electronicoOImpreso = $h002 === 1 || $h002 === 2;
      $electronicoOConstancia = $h002 === 1 || $h002 === 3;
      self::regla($r, $tipo === 4 && $h002 !== null && $h002 !== 3, '2416', 'iTipDocAso', $ruta, $h002, 'La autofactura asocia la constancia electrónica (H002 = 3).');
      self::regla($r, in_array($tipo, [1, 5, 6, 7], true) && $h002 === 3, '2434', 'iTipDocAso', $ruta, $h002, 'Solo la autofactura asocia una constancia electrónica.');
      $cdc = self::texto($a, 'dCdCDERef');
      self::regla($r, $h002 === 1 && $cdc === null, '2402', 'dCdCDERef', $ruta);
      self::regla($r, ($h002 === 2 || $h002 === 3) && $cdc !== null, '2418', 'dCdCDERef', $ruta, $cdc, 'Solo el documento asociado electrónico (H002 = 1) lleva CDC.');
      foreach (self::IMPRESO as [$campo, $falta, $sobra]) {
        $valor = self::v($a, $campo);
        $presente = $valor !== null && $valor !== '';
        self::regla($r, $h002 === 2 && !$presente, $falta, $campo, $ruta);
        self::regla($r, $electronicoOConstancia && $presente, $sobra, $campo, $ruta, self::texto($a, $campo), 'Solo el documento impreso (H002 = 2) lleva este campo.');
      }
      $h009 = self::entero($a, 'iTipoDocAso');
      $h010 = self::texto($a, 'dDTipoDocAso');
      self::regla($r, $h009 !== null && $h010 === null, '2424', 'dDTipoDocAso', $ruta);
      self::regla($r, $h009 === null && $h010 !== null, '2435', 'dDTipoDocAso', $ruta, $h010);
      $retencion = self::texto($a, 'dNumComRet');
      self::regla($r, $retencion !== null && !$pagoPorRetencion, '2436', 'dNumComRet', $ruta, $retencion, 'Con comprobante de retención (H012) la forma de pago (E606) debe ser 10, retención.');
      $conResolucion = $conResolucion || self::texto($a, 'dNumResCF') !== null;
      $h014 = self::entero($a, 'iTipCons');
      self::regla($r, $h002 === 3 && $h014 === null, '2426', 'iTipCons', $ruta);
      self::regla($r, $electronicoOImpreso && $h014 !== null, '2427', 'iTipCons', $ruta, $h014, 'Solo la constancia electrónica (H002 = 3) lleva tipo de constancia.');
      $numero = self::texto($a, 'dNumCons');
      $control = self::texto($a, 'dNumControl');
      self::regla($r, $h002 === 3 && $h014 === 2 && $numero === null, '2430', 'dNumCons', $ruta, null, 'La constancia de microproductor (H014 = 2) lleva número.');
      self::regla($r, $electronicoOImpreso && $numero !== null, '2431', 'dNumCons', $ruta, $numero, 'Solo la constancia electrónica (H002 = 3) lleva número de constancia.');
      self::regla($r, $h002 === 3 && $h014 === 2 && $control === null, '2432', 'dNumControl', $ruta, null, 'La constancia de microproductor (H014 = 2) lleva número de control.');
      self::regla($r, $electronicoOImpreso && $control !== null, '2433', 'dNumControl', $ruta, $control, 'Solo la constancia electrónica (H002 = 3) lleva número de control.');
    }

    self::regla($r, self::entero($v->gOpeCom(), 'iTipTra') === 12 && !$conResolucion, '2413', 'dNumResCF', 'DE.gCamDEAsoc', null,
      'La venta de crédito fiscal (D011 = 12) informa el número de resolución (H013) en el documento asociado.');
  }
}
