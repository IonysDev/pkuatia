<?php

namespace IonysDev\Pkuatia\Tests\Support;

use DateTime;
use IonysDev\Pkuatia\Core\Constants\EmisRecTipCont;
use IonysDev\Pkuatia\Core\Constants\RecTiOpe;
use IonysDev\Pkuatia\Core\Constants\TipIDRec;
use IonysDev\Pkuatia\Core\Constants\TimbTiDE;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\DocumentoElectronico;
use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\GGroupGesEve;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\GGroupTiEvt;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\REve;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\RGesEve;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\RGeVeCan;

/**
 * Construye RDE y sobres de eventos mínimos con datos genéricos (sin RUC/timbrado reales).
 */
final class MinimalRdeFactory
{
  public static function createRde(int $numDoc = 1): RDE
  {
    $doc = new DocumentoElectronico();
    $doc->gTimb->setITiDE(TimbTiDE::Factura);
    $doc->gTimb->setDNumTim(12345678);
    $doc->gTimb->setDEst('001');
    $doc->gTimb->setDPunExp('001');
    $doc->gTimb->setDNumDoc(str_pad((string) $numDoc, 7, '0', STR_PAD_LEFT));
    $doc->gTimb->setDFeIniT(new DateTime('2024-01-01'));
    $doc->setFechaEmision(new DateTime('2026-01-15T10:00:00'));
    $doc->setEmisor(
      '80000000',
      5,
      EmisRecTipCont::PersonaJuridica,
      null,
      'Empresa de Prueba SA',
      null,
      'Av. Principal',
      '100',
      null,
      null,
      1,
      null,
      1,
      '021000000',
      'test@example.com',
      null
    );
    $doc->setReceptor(
      'Cliente Prueba',
      false,
      RecTiOpe::B2C,
      'PRY',
      null,
      null,
      null,
      TipIDRec::CedulaParaguaya,
      '1234567',
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null
    );

    return $doc->documentoElectronicoToRDE();
  }

  public static function createCancellationEventsEnvelope(): GGroupGesEve
  {
    $events = [];
    foreach ([1, 2] as $eventId) {
      $cancel = new RGeVeCan();
      $cancel->setId(str_repeat((string) $eventId, 44));
      $cancel->setMOtEve('Cancelación de prueba unitaria');

      $gti = new GGroupTiEvt();
      $gti->setRGeVeCan($cancel);

      $rEve = new REve();
      $rEve->setId($eventId);
      $rEve->setDFecFirma(new DateTime('2026-01-15T10:00:00'));
      $rEve->setDVerFor(150);
      $rEve->setGGroupTiEvt($gti);

      $rGesEve = new RGesEve();
      $rGesEve->setREve($rEve);
      $events[] = $rGesEve;
    }

    $raiz = new GGroupGesEve();
    $raiz->setRGesEve($events);

    return $raiz;
  }
}
