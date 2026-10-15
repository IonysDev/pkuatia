<?php

namespace IonysDev\Pkuatia\Validacion\Reglas;

use DateTime;
use DateTimeZone;
use IonysDev\Pkuatia\Core\Constants;
use IonysDev\Pkuatia\DataMappings\PyGeoCodesMapping;
use IonysDev\Pkuatia\Helpers\CDCHelper;
use IonysDev\Pkuatia\Utils\RucUtils;
use IonysDev\Pkuatia\Utils\TimbradoUtils;
use IonysDev\Pkuatia\Validacion\ResultadoValidacion;
use IonysDev\Pkuatia\Validacion\VistaDocumento;

/**
 * Reglas de los grupos A, C y D del MT §12.4 (errores-validacion.md) que se pueden verificar sin conexión:
 * - A: 1003 DV del CDC (módulo 11), 1000 CDC coherente con el contenido (recalculado con CDCHelper), 1004 firma
 *   posterior al momento de referencia, 1005 transmisión a más de 72 h de la firma (AO, advertencia).
 * - C: 1103 timbrado con vigencia posterior a la emisión, 1110 serie fuera de AA-ZZ.
 * - D: 1150/1151 emisión con más de 720 h de atraso o 120 h de adelanto, 1156 anterior al 22/11/2018, 1202 tipo de
 *   transacción obligatorio, 1207-1210 condición y valor del tipo de cambio según la moneda, 1253 DV del emisor,
 *   1255/1328/2553/2557/2153/2203 departamento, distrito y ciudad relacionados (PyGeoCodes).
 * Tolerancias del SIFEN para las fechas: no publicadas [PENDIENTE DE VERIFICACIÓN]; se aplican los límites del MT.
 * Fase C, paso C10.
 */
final class ReglasGenerales extends ConjuntoDeReglas
{
  public static function aplicar(VistaDocumento $v, ResultadoValidacion $r, DateTime $ahora): void
  {
    $tipo = $v->tipoDocumento();

    // A002/A003: CDC
    $id = $v->id();
    if ($id !== null && preg_match('/^[0-9]{2}[0-9]{7}[0-9A-D][0-9]{34}$/', $id)) {
      $dv = (string) RucUtils::CalcDV(substr($id, 0, 43));
      self::regla($r, $dv !== $id[43], '1003', 'Id', 'DE', $id, "El dígito verificador calculado es $dv.");
      $de = $v->de();
      if ($de !== null) {
        try {
          $esperado = CDCHelper::Generate($de);
          self::regla($r, $esperado !== $id, '1000', 'Id', 'DE', $id, "Con el contenido actual el CDC sería $esperado: cambió algún campo que lo compone (tipo, RUC, establecimiento, punto, número, fecha, tipo de emisión o código de seguridad).");
        } catch (\Throwable) {
          // Falta algún campo del CDC: lo reporta la completitud.
        }
      }
    }

    // A004: fecha de la firma
    $firma = $v->dFecFirma();
    if ($firma !== null) {
      self::regla($r, $firma > $ahora, '1004', 'dFecFirma', 'DE', $firma->format('Y-m-d\TH:i:s'), 'La firma no puede ser posterior a la hora del SIFEN (sincronizar el reloj con aravo1/aravo2.set.gov.py).');
      self::regla($r, $firma <= $ahora && ($ahora->getTimestamp() - $firma->getTimestamp()) > 72 * 3600, '1005', 'dFecFirma', 'DE', $firma->format('Y-m-d\TH:i:s'), 'Transmitir dentro de las 72 horas de la firma para evitar la aprobación con observaciones.');
    }

    // C: timbrado
    $timb = $v->gTimb();
    $emision = $v->dFeEmiDE();
    $inicio = self::fecha($timb, 'dFeIniT');
    if ($inicio !== null && $emision !== null)
      self::regla($r, $inicio->format('Y-m-d') > $emision->format('Y-m-d'), '1103', 'dFeIniT', 'DE.gTimb', $inicio->format('Y-m-d'), 'La fecha de emisión debe ser igual o posterior al inicio de vigencia del timbrado.');
    $serie = self::texto($timb, 'dSerieNum');
    if ($serie !== null)
      self::regla($r, !TimbradoUtils::ValidarSerie($serie), '1110', 'dSerieNum', 'DE.gTimb', $serie, 'Dos letras mayúsculas de AA a ZZ.');

    // D002: fecha de emisión
    if ($emision !== null) {
      $diferencia = $ahora->getTimestamp() - $emision->getTimestamp();
      self::regla($r, $diferencia > 720 * 3600, '1150', 'dFeEmiDE', 'DE.gDatGralOpe', $emision->format('Y-m-d\TH:i:s'), 'La emisión no puede ser anterior en más de 720 horas (30 días) a la transmisión.');
      self::regla($r, -$diferencia > 120 * 3600, '1151', 'dFeEmiDE', 'DE.gDatGralOpe', $emision->format('Y-m-d\TH:i:s'), 'La emisión no puede ser posterior en más de 120 horas (5 días) a la transmisión.');
      self::regla($r, $emision < new DateTime('2018-11-22T00:00:00', new DateTimeZone(Constants::SIFEN_TIMEZONE)), '1156', 'dFeEmiDE', 'DE.gDatGralOpe', $emision->format('Y-m-d\TH:i:s'));
    }

    // D1: operación comercial
    $ope = $v->gOpeCom();
    if ($ope !== null) {
      $rutaOpe = 'DE.gDatGralOpe.gOpeCom';
      self::regla($r, in_array($tipo, [1, 2, 3, 4], true) && self::entero($ope, 'iTipTra') === null, '1202', 'iTipTra', $rutaOpe);
      $moneda = strtoupper((string) self::texto($ope, 'cMoneOpe'));
      $condicion = self::entero($ope, 'dCondTiCam');
      $cambio = self::texto($ope, 'dTiCam');
      if ($moneda !== '') {
        self::regla($r, $moneda !== 'PYG' && $condicion === null, '1207', 'dCondTiCam', $rutaOpe, null, "La moneda es $moneda.");
        self::regla($r, $moneda === 'PYG' && $condicion !== null, '1208', 'dCondTiCam', $rutaOpe, $condicion);
        self::regla($r, $condicion === 1 && $cambio === null, '1209', 'dTiCam', $rutaOpe);
        self::regla($r, ($condicion === 2 || $moneda === 'PYG') && $cambio !== null, '1210', 'dTiCam', $rutaOpe, $cambio);
      }
    }

    // D2: emisor
    $emis = $v->gEmis();
    $ruc = self::texto($emis, 'dRucEm');
    $dvEmisor = self::entero($emis, 'dDVEmi');
    if ($ruc !== null && $dvEmisor !== null)
      self::regla($r, RucUtils::CalcDV($ruc) !== $dvEmisor, '1253', 'dDVEmi', 'DE.gDatGralOpe.gEmis', $dvEmisor, 'El dígito verificador calculado es ' . RucUtils::CalcDV($ruc) . '.');
    self::geografia($r, $emis, 'cDepEmi', 'cDisEmi', 'cCiuEmi', '1255', 'DE.gDatGralOpe.gEmis');
    self::geografia($r, $v->gDatRec(), 'cDepRec', 'cDisRec', 'cCiuRec', '1328', 'DE.gDatGralOpe.gDatRec');
    $ae = $v->gCamAE();
    self::geografia($r, $ae, 'cDepVen', 'cDisVen', 'cCiuVen', '2553', 'DE.gDtipDE.gCamAE');
    self::geografia($r, $ae, 'cDepProv', 'cDisProv', 'cCiuProv', '2557', 'DE.gDtipDE.gCamAE');
    $transp = $v->gTransp();
    if ($transp !== null) {
      self::geografia($r, self::v($transp, 'gCamSal'), 'cDepSal', 'cDisSal', 'cCiuSal', '2153', 'DE.gDtipDE.gTransp.gCamSal');
      foreach (self::lista($transp, 'gCamEnt') as $i => $entrega)
        self::geografia($r, $entrega, 'cDepEnt', 'cDisEnt', 'cCiuEnt', '2203', 'DE.gDtipDE.gTransp.gCamEnt[' . ($i + 1) . ']');
    }
  }

  /** Departamento, distrito (si viene) y ciudad deben pertenecer a una misma fila de PyGeoCodes. */
  private static function geografia(ResultadoValidacion $r, ?object $g, string $depProp, string $distProp, string $ciuProp, string $codigo, string $ruta): void
  {
    if ($g === null)
      return;
    $dep = self::entero($g, $depProp);
    $dist = self::entero($g, $distProp);
    $ciu = self::entero($g, $ciuProp);
    if ($dep === null || $ciu === null)
      return;
    self::regla($r, !PyGeoCodesMapping::estanRelacionados($dep, $dist, $ciu), $codigo, $ciuProp, $ruta, "$dep/" . ($dist ?? '-') . "/$ciu", 'Códigos de PyGeoCodes.xml (departamento, distrito y ciudad de una misma fila).');
  }
}
