<?php

namespace IonysDev\Pkuatia\Validacion\Reglas;

use DateTime;
use IonysDev\Pkuatia\Validacion\ResultadoValidacion;
use IonysDev\Pkuatia\Validacion\VistaDocumento;

/**
 * Reglas de la condición de la operación y de los pagos (E600-E659; errores-validacion.md, MT §12.4 E7): 1503 AF al
 * contado, 1550/1551/1552 pagos al contado o entrega inicial, 1553 pago bancario solo con operación bancaria,
 * 1556/1557 tipo de cambio del pago según su moneda, 1600/1601 tarjeta, 1650/1651 cheque, 1700/1701 crédito,
 * 1703/1704 plazo, 1705/1706 cuotas y 1751 grupo de cuotas. Fase C, paso C10.
 */
final class ReglasDePagos extends ConjuntoDeReglas
{
  public static function aplicar(VistaDocumento $v, ResultadoValidacion $r, DateTime $ahora): void
  {
    $cond = $v->gCamCond();
    if ($cond === null)
      return;
    $ruta = 'DE.gDtipDE.gCamCond';
    $tipo = $v->tipoDocumento();
    $condicion = self::entero($cond, 'iCondOpe');
    $pagos = self::lista($cond, 'gPaConEIni');
    $credito = self::v($cond, 'gPagCred');
    $entregaInicial = self::texto($credito, 'dMonEnt');

    self::regla($r, $tipo === 4 && $condicion !== null && $condicion !== 1, '1503', 'iCondOpe', $ruta, $condicion, 'La autofactura es siempre al contado.');
    self::regla($r, $condicion === 1 && $pagos === [], '1550', 'gPaConEIni', $ruta);
    self::regla($r, $condicion === 2 && $entregaInicial !== null && $pagos === [], '1551', 'gPaConEIni', $ruta, null, 'Con entrega inicial (E645) hay que informar cómo se pagó.');
    self::regla($r, $condicion === 2 && $entregaInicial === null && $pagos !== [], '1552', 'gPaConEIni', $ruta, null, 'A crédito sin entrega inicial no se informan pagos.');

    $presencia = self::entero($v->gCamFE(), 'iIndPres');
    foreach ($pagos as $i => $pago) {
      $rutaPago = $ruta . '.gPaConEIni[' . ($i + 1) . ']';
      $tiPago = self::entero($pago, 'iTiPago');
      self::regla($r, $tiPago === 16 && $tipo === 1 && $presencia !== 5, '1553', 'iTiPago', $rutaPago, $tiPago, 'El pago bancario (16) exige indicador de presencia 5 (operación bancaria).');
      $moneda = strtoupper((string) self::texto($pago, 'cMoneTiPag'));
      $cambio = self::texto($pago, 'dTiCamTiPag');
      if ($moneda !== '') {
        self::regla($r, $moneda !== 'PYG' && $cambio === null, '1556', 'dTiCamTiPag', $rutaPago, null, "El pago es en $moneda.");
        self::regla($r, $moneda === 'PYG' && $cambio !== null, '1557', 'dTiCamTiPag', $rutaPago, $cambio);
      }
      $tarjeta = self::v($pago, 'gPagTarCD');
      $cheque = self::v($pago, 'gPagCheq');
      self::regla($r, in_array($tiPago, [3, 4], true) && $tarjeta === null, '1600', 'gPagTarCD', $rutaPago);
      self::regla($r, $tiPago !== null && !in_array($tiPago, [3, 4], true) && $tarjeta !== null, '1601', 'gPagTarCD', $rutaPago, $tiPago);
      self::regla($r, $tiPago === 2 && $cheque === null, '1650', 'gPagCheq', $rutaPago);
      self::regla($r, $tiPago !== null && $tiPago !== 2 && $cheque !== null, '1651', 'gPagCheq', $rutaPago, $tiPago);
    }

    self::regla($r, $condicion === 2 && $credito === null, '1700', 'gPagCred', $ruta);
    self::regla($r, $condicion !== null && $condicion !== 2 && $credito !== null, '1701', 'gPagCred', $ruta, $condicion);
    if ($credito !== null) {
      $rutaCred = $ruta . '.gPagCred';
      $condCred = self::entero($credito, 'iCondCred');
      $plazo = self::texto($credito, 'dPlazoCre');
      $cuotas = self::entero($credito, 'dCuotas');
      $grupoCuotas = self::lista($credito, 'gCuotas');
      self::regla($r, $condCred === 1 && $plazo === null, '1703', 'dPlazoCre', $rutaCred);
      self::regla($r, $condCred !== null && $condCred !== 1 && $plazo !== null, '1704', 'dPlazoCre', $rutaCred, $plazo);
      self::regla($r, $condCred === 2 && $cuotas === null, '1705', 'dCuotas', $rutaCred);
      self::regla($r, $condCred !== null && $condCred !== 2 && $cuotas !== null, '1706', 'dCuotas', $rutaCred, $cuotas);
      self::regla($r, $condCred !== null && $condCred !== 2 && $grupoCuotas !== [], '1751', 'gCuotas', $rutaCred);
    }
  }
}
