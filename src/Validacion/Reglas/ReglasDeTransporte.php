<?php

namespace IonysDev\Pkuatia\Validacion\Reglas;

use DateTime;
use DateTimeZone;
use IonysDev\Pkuatia\Core\Constants;
use IonysDev\Pkuatia\Utils\RucUtils;
use IonysDev\Pkuatia\Validacion\ResultadoValidacion;
use IonysDev\Pkuatia\Validacion\VistaDocumento;

/**
 * Reglas del transporte de mercaderías (E900-E999; errores-validacion.md, MT §12.4 E10): 2102 tipo de transporte y
 * 2107/2109 fechas de traslado obligatorios en la nota de remisión, 2108 inicio de traslado anterior a la puesta en
 * producción del SIFEN (22/11/2018, la misma fecha que 1156), 2110 fin anterior al inicio, 2252/2253 número de vuelo
 * solo en el transporte aéreo, 2254/2255 matrícula o número de identificación según E967, 2302/2305 RUC del
 * transportista según su naturaleza, 2306 dígito verificador del RUC, 2307/2308 tipo de documento de identidad según
 * la naturaleza y 2311 número del documento. 2309 y 2312 (descripciones del tipo de documento y de la nacionalidad)
 * no se aplican: el modelo las deriva del código al serializar, así que no pueden faltar. Fase C, paso C11.
 */
final class ReglasDeTransporte extends ConjuntoDeReglas
{
  public static function aplicar(VistaDocumento $v, ResultadoValidacion $r, DateTime $ahora): void
  {
    $t = $v->gTransp();
    if ($t === null)
      return;
    $ruta = 'DE.gDtipDE.gTransp';
    $esNR = $v->tipoDocumento() === 7;
    self::regla($r, $esNR && self::entero($t, 'iTipTrans') === null, '2102', 'iTipTrans', $ruta);
    $inicio = self::fecha($t, 'dIniTras');
    $fin = self::fecha($t, 'dFinTras');
    $produccion = new DateTime('2018-11-22T00:00:00', new DateTimeZone(Constants::SIFEN_TIMEZONE));
    self::regla($r, $esNR && $inicio === null, '2107', 'dIniTras', $ruta);
    self::regla($r, $inicio !== null && $inicio < $produccion, '2108', 'dIniTras', $ruta, $inicio?->format('Y-m-d'), 'El SIFEN entró en producción el 22/11/2018.');
    self::regla($r, $esNR && $fin === null, '2109', 'dFinTras', $ruta);
    self::regla($r, $inicio !== null && $fin !== null && $fin->format('Y-m-d') < $inicio->format('Y-m-d'), '2110', 'dFinTras', $ruta, $fin?->format('Y-m-d'),
      'E910 debe ser igual o posterior a E909 (' . $inicio?->format('Y-m-d') . ').');

    $modalidad = self::entero($t, 'iModTrans');
    foreach (self::lista($t, 'gVehTras') as $i => $vehiculo) {
      $rutaVehiculo = $ruta . '.gVehTras[' . ($i + 1) . ']';
      $vuelo = self::texto($vehiculo, 'dNroVuelo');
      $identificacion = self::entero($vehiculo, 'dTipIdenVeh');
      self::regla($r, $modalidad === 3 && $vuelo === null, '2252', 'dNroVuelo', $rutaVehiculo, null, 'La modalidad de transporte (E903) es aérea.');
      self::regla($r, $modalidad !== null && $modalidad !== 3 && $vuelo !== null, '2253', 'dNroVuelo', $rutaVehiculo, $vuelo, 'Solo el transporte aéreo (E903 = 3) informa el número de vuelo.');
      self::regla($r, $identificacion === 1 && self::texto($vehiculo, 'dNroIDVeh') === null, '2255', 'dNroIDVeh', $rutaVehiculo, null, 'El vehículo se identifica por número de identificación (E967 = 1).');
      self::regla($r, $identificacion === 2 && self::texto($vehiculo, 'dNroMatVeh') === null, '2254', 'dNroMatVeh', $rutaVehiculo, null, 'El vehículo se identifica por matrícula (E967 = 2).');
    }

    $transportista = self::v($t, 'gCamTrans');
    if ($transportista === null)
      return;
    $rutaTransportista = $ruta . '.gCamTrans';
    $naturaleza = self::entero($transportista, 'iNatTrans');
    $ruc = self::texto($transportista, 'dRucTrans');
    $dv = self::entero($transportista, 'dDVTrans');
    $tipoDocumento = self::entero($transportista, 'iTipIDTrans');
    self::regla($r, $naturaleza === 1 && $ruc === null, '2302', 'dRucTrans', $rutaTransportista, null, 'El transportista es contribuyente (E981 = 1).');
    self::regla($r, $naturaleza !== null && $naturaleza !== 1 && $ruc !== null, '2305', 'dRucTrans', $rutaTransportista, $ruc, 'El transportista no es contribuyente (E981 = 2).');
    if ($ruc !== null && $dv !== null)
      self::regla($r, RucUtils::CalcDV($ruc) !== $dv, '2306', 'dDVTrans', $rutaTransportista, $dv, 'El dígito verificador calculado es ' . RucUtils::CalcDV($ruc) . '.');
    self::regla($r, $naturaleza === 2 && $tipoDocumento === null, '2307', 'iTipIDTrans', $rutaTransportista, null, 'El transportista no es contribuyente (E981 = 2).');
    self::regla($r, $naturaleza === 1 && $tipoDocumento !== null, '2308', 'iTipIDTrans', $rutaTransportista, $tipoDocumento, 'El transportista es contribuyente (E981 = 1) y se identifica con el RUC.');
    self::regla($r, $tipoDocumento !== null && self::texto($transportista, 'dNumIDTrans') === null, '2311', 'dNumIDTrans', $rutaTransportista);
  }
}
