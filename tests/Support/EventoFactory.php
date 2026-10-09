<?php

namespace IonysDev\Pkuatia\Tests\Support;

use DateTime;
use DateTimeZone;
use IonysDev\Pkuatia\Core\Constants\RecNat;
use IonysDev\Pkuatia\Core\Constants\RecTiOpe;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\GGroupGesEve;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\GGroupTiEvt;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\REve;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\RGesEve;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\RGEveNom;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\RGeVeCan;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\RGeVeTr;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GER\RGeVeConf;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GER\RGeVeDescon;
use IonysDev\Pkuatia\Helpers\SignHelper;

/**
 * Sobres de eventos (gGroupGesEve > rGesEve > rEve[@Id] > gGroupTiEvt > evento) con datos ficticios,
 * listos para firmar con SignHelper::SingEvents y validar contra siRecepEvento_v150.xsd.
 */
final class EventoFactory
{
  public const CDC = '01800000005001001000000122026011517391544291';

  public static function fecha(): DateTime
  {
    return new DateTime('2026-01-16T09:00:00', new DateTimeZone('America/Asuncion'));
  }

  /** Envuelve un gGroupTiEvt ya conformado en un rEve con el Id indicado. */
  public static function rGesEve(GGroupTiEvt $gti, int $id = 1): RGesEve
  {
    $rEve = new REve();
    $rEve->setId($id);
    $rEve->setDFecFirma(self::fecha());
    $rEve->setDVerFor(150);
    $rEve->setGGroupTiEvt($gti);
    $rGesEve = new RGesEve();
    $rGesEve->setREve($rEve);
    return $rGesEve;
  }

  /** @param list<RGesEve> $eventos */
  public static function sobre(array $eventos): GGroupGesEve
  {
    $raiz = new GGroupGesEve();
    $raiz->setRGesEve($eventos);
    return $raiz;
  }

  public static function sobreDe(GGroupTiEvt $gti, int $id = 1): GGroupGesEve
  {
    return self::sobre([self::rGesEve($gti, $id)]);
  }

  public static function cancelacion(string $cdc = self::CDC, string $motivo = 'Cancelación de prueba unitaria'): GGroupTiEvt
  {
    $ev = new RGeVeCan();
    $ev->setId($cdc);
    $ev->setMOtEve($motivo);
    $gti = new GGroupTiEvt();
    $gti->setRGeVeCan($ev);
    return $gti;
  }

  public static function conformidad(int $tipo, ?DateTime $fechaRecepcion = null, string $cdc = self::CDC): GGroupTiEvt
  {
    $ev = new RGeVeConf();
    $ev->setId($cdc);
    $ev->setITipConf($tipo);
    if ($fechaRecepcion !== null) {
      $ev->setDFecRecep($fechaRecepcion);
    }
    $gti = new GGroupTiEvt();
    $gti->setRGeVeConf($ev);
    return $gti;
  }

  /** Desconocimiento por un receptor NO contribuyente identificado con cédula (tipo 1). */
  public static function desconocimientoNoContribuyente(int $tipoDocumento = 1, string $cdc = self::CDC): GGroupTiEvt
  {
    $ev = new RGeVeDescon();
    $ev->setId($cdc);
    $ev->setDFecEmi(new DateTime('2026-01-15T10:00:00'));
    $ev->setDFecRecep(new DateTime('2026-01-15T18:00:00'));
    $ev->setITipRec(2);
    $ev->setDNomRec('Juan Perez');
    $ev->setDTipIDRec($tipoDocumento);
    $ev->setDNumID('1234567');
    $ev->setMOtEve('No reconozco esta operación comercial');
    $gti = new GGroupTiEvt();
    $gti->setRGeVeDescon($ev);
    return $gti;
  }

  /** Actualización de transporte: motivo 1 = cambio del local de entrega. */
  public static function transporteCambioLocalEntrega(string $cdc = self::CDC): GGroupTiEvt
  {
    $ev = new RGeVeTr();
    $ev->setId($cdc);
    $ev->setDMotEv(1);
    $ev->setCDepEnt(1);
    $ev->setCDisEnt(1);
    $ev->setCCiuEnt(1);
    $ev->setDDirEnt('Nueva Calle de Entrega');
    $ev->setDNumCas(456);
    $gti = new GGroupTiEvt();
    $gti->setRGeVeTr($ev);
    return $gti;
  }

  /** Actualización de transporte: motivo 2 = cambio del chofer. */
  public static function transporteCambioChofer(string $cdc = self::CDC): GGroupTiEvt
  {
    $ev = new RGeVeTr();
    $ev->setId($cdc);
    $ev->setDMotEv(2);
    $ev->setDNomChof('Chofer Nuevo Lopez');
    $ev->setDNumIDChof('7654321');
    $gti = new GGroupTiEvt();
    $gti->setRGeVeTr($ev);
    return $gti;
  }

  /** Actualización de transporte: motivo 4 = cambio de vehículo identificado por matrícula (6 caracteres). */
  public static function transporteCambioVehiculo(string $matricula = 'ABC123', string $cdc = self::CDC): GGroupTiEvt
  {
    $ev = new RGeVeTr();
    $ev->setId($cdc);
    $ev->setDMotEv(4);
    $ev->setITipTrans(1);
    $ev->setIModTrans(1);
    $ev->setDTiVehTras('Camion');
    $ev->setDMarVeh('Mercedes');
    $ev->setDTipIdenVeh(2);
    $ev->setDNroMatVeh($matricula);
    $gti = new GGroupTiEvt();
    $gti->setRGeVeTr($ev);
    return $gti;
  }

  /** Nominación de una FE innominada a un receptor no contribuyente B2C. */
  public static function nominacion(int|RecTiOpe $tipoOperacion = RecTiOpe::B2C, string $cdc = self::CDC): GGroupTiEvt
  {
    $ev = new RGEveNom();
    $ev->setId($cdc);
    $ev->setMOtEve('Nominación de factura innominada');
    $ev->setINatRec(RecNat::NoContribuyente);
    $ev->setITiOpe($tipoOperacion);
    $ev->setCPaisRec('PRY');
    $ev->setITipIDRec(1);
    $ev->setDNumIDRec('1234567');
    $ev->setDNomRec('Juan Perez');
    $gti = new GGroupTiEvt();
    $gti->setRGeVeNom($ev);
    return $gti;
  }

  /** Firma el sobre con el entorno de prueba inicializado y devuelve el XML del gGroupGesEve. */
  public static function firmar(GGroupGesEve $raiz): string
  {
    $doc = SignHelper::SingEvents($raiz, null);
    return $doc->saveXML($doc->documentElement);
  }
}
