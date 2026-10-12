<?php

namespace IonysDev\Pkuatia\Validacion\Reglas;

use DateTime;
use IonysDev\Pkuatia\Validacion\ResultadoValidacion;
use IonysDev\Pkuatia\Validacion\VistaDocumento;

/**
 * Reglas de los campos específicos por tipo de documento (errores-validacion.md, MT §12.4 E1, E6 y E9): compras
 * públicas 1400/1401 (E020 solo y siempre en operaciones B2G) y 1402 (fecha del código de contratación no posterior
 * a la emisión); nota de remisión 2604 (mes de la fecha futura de la factura no posterior al de la emisión), 2605
 * (traslado por venta sin documento asociado exige esa fecha) y 2606 (en el traslado entre locales el receptor es el
 * emisor); ciclos de los datos adicionales de uso comercial 2050-2055 (E821 ⇒ E822 ⇒ E823, fin no anterior al
 * inicio, vencimiento del pago no anterior a la emisión). Fase C, paso C11.
 */
final class ReglasEspecificas extends ConjuntoDeReglas
{
  public static function aplicar(VistaDocumento $v, ResultadoValidacion $r, DateTime $ahora): void
  {
    $tipo = $v->tipoDocumento();
    $emision = $v->dFeEmiDE();
    $receptor = $v->gDatRec();

    // E020 compras públicas
    $tipoOperacion = self::entero($receptor, 'iTiOpe');
    $compras = $v->gCompPub();
    self::regla($r, $tipo === 1 && $tipoOperacion === 3 && $compras === null, '1400', 'gCompPub', 'DE.gDtipDE.gCamFE', null, 'La operación es B2G (D202 = 3).');
    self::regla($r, $compras !== null && $tipoOperacion !== 3, '1401', 'gCompPub', 'DE.gDtipDE.gCamFE', $tipoOperacion, 'Las compras públicas solo van en operaciones B2G (D202 = 3).');
    $fechaCodigo = self::fecha($compras, 'dFeCodCont');
    self::regla($r, $fechaCodigo !== null && $emision !== null && $fechaCodigo->format('Y-m-d') > $emision->format('Y-m-d'), '1402', 'dFeCodCont', 'DE.gDtipDE.gCamFE.gCompPub',
      $fechaCodigo?->format('Y-m-d'), 'No puede ser posterior a la fecha de emisión (' . $emision?->format('Y-m-d') . ').');

    // E500 nota de remisión
    $nre = $v->gCamNRE();
    if ($nre !== null) {
      $ruta = 'DE.gDtipDE.gCamNRE';
      $motivo = self::entero($nre, 'iMotEmiNR');
      $fechaFactura = self::fecha($nre, 'dFecEm');
      self::regla($r, $fechaFactura !== null && $emision !== null && $fechaFactura->format('Ym') > $emision->format('Ym'), '2604', 'dFecEm', $ruta, $fechaFactura?->format('Y-m-d'),
        'El mes de E506 no puede ser posterior al mes de emisión (' . $emision?->format('Y-m') . ').');
      self::regla($r, $motivo === 1 && $fechaFactura === null && $v->gCamDEAsoc() === [], '2605', 'dFecEm', $ruta, null,
        'Traslado por venta (E501 = 1) sin documento asociado: informar la fecha futura de emisión de la factura.');
      $rucEmisor = self::texto($v->gEmis(), 'dRucEm');
      $rucReceptor = self::texto($receptor, 'dRucRec');
      self::regla($r, $motivo === 7 && $rucEmisor !== null && $rucReceptor !== null && $rucEmisor !== $rucReceptor, '2606', 'dRucRec', 'DE.gDatGralOpe.gDatRec', $rucReceptor,
        "En el traslado entre locales (E501 = 7) el receptor es el propio emisor ($rucEmisor).");
    }

    // E820 ciclos de los datos adicionales de uso comercial
    $adicionales = $v->gGrupAdi();
    if ($adicionales !== null) {
      $ruta = 'DE.gDtipDE.gCamEsp.gGrupAdi';
      $ciclo = self::texto($adicionales, 'dCiclo');
      $inicio = self::fecha($adicionales, 'dFecIniC');
      $fin = self::fecha($adicionales, 'dFecFinC');
      $vencimiento = self::fecha($adicionales, 'dVencPag');
      self::regla($r, $ciclo !== null && $inicio === null, '2050', 'dFecIniC', $ruta, null, "El ciclo (E821) es $ciclo.");
      self::regla($r, $ciclo === null && $inicio !== null, '2051', 'dFecIniC', $ruta, $inicio?->format('Y-m-d'), 'Sin ciclo (E821) no se informa su fecha de inicio.');
      self::regla($r, $inicio !== null && $fin === null, '2052', 'dFecFinC', $ruta);
      self::regla($r, $inicio === null && $fin !== null, '2053', 'dFecFinC', $ruta, $fin?->format('Y-m-d'), 'Sin fecha de inicio (E822) no se informa la de fin.');
      self::regla($r, $inicio !== null && $fin !== null && $fin->format('Y-m-d') < $inicio->format('Y-m-d'), '2054', 'dFecFinC', $ruta, $fin?->format('Y-m-d'),
        'E823 debe ser igual o posterior a E822 (' . $inicio?->format('Y-m-d') . ').');
      self::regla($r, $vencimiento !== null && $emision !== null && $vencimiento->format('Y-m-d') < $emision->format('Y-m-d'), '2055', 'dVencPag', $ruta, $vencimiento?->format('Y-m-d'),
        'E824 no puede ser anterior a la fecha de emisión (' . $emision?->format('Y-m-d') . ').');
    }
  }
}
