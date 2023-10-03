<?php

use Abiliomp\Pkuatia\Core\Config;
use Abiliomp\Pkuatia\Core\Constants;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GDE\GGroupGesEve;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GDE\GGroupTiEvt;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GDE\rEve;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GDE\RGesEve;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GDE\RGeVeCan;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GDE\RGeVeInu;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GDE\RGeVeTr;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GEA\RGeDevCCFFCue;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GEA\RGeDevCCFFDev;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GEA\RGeVeAnt;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GEA\RGeVeCCFF;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GEA\RGeVeRem;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GEA\RGeVeRetAce;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GEA\RGeVeRetAnu;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GER\RGeVeConf;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GER\RGeVeDescon;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GER\RGeVeDisconf;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GER\RGeVeNotRec;
use Abiliomp\Pkuatia\Sifen;

require '../vendor/autoload.php'; // Include the Composer autoloader

error_reporting(E_ALL);
ini_set('display_errors', 1);
$certFile = '80121930-2.pem.crt';
$keyFile = '80121930-2.pem.key';
$keyPassphrase = '171222';

$config = new Config();
$config->env = 'dev';
$config->certificateFilePath = $certFile;
$config->privateKeyFilePath = $keyFile;
$config->privateKeyPassphrase = $keyPassphrase;

Sifen::Init($config);

///creamos la raiz del grupo de eventos
$evento = new GGroupGesEve();
///creamos un array para la raiz de gestion de eventos
$rGesEve = [];
///creamos una raiz de gestion de eventos
$trGesEve = new RGesEve();
//creamos el grupo de campos generales del evento
$rEve = new rEve();
$rEve->setId(123);
$rEve->setDFecFirma(new DateTime());
$rEve->setDVerFor(150);
///se crea el grupo de campos del tipo de evento
$gGroupTiEvt = new GGroupTiEvt();

//another
$trGesEve2 = new RGesEve();
$rEve2 = new rEve();
$rEve2->setId(124);
$rEve2->setDFecFirma(new DateTime());
$rEve2->setDVerFor(150);
$gGroupTiEvt2 = new GGroupTiEvt();


//=====================================================================
//Eventos de EMISOR
//=====================================================================


///////////////////////////////////////////////////////////////
///EVENTO DE CANCELACION
///////////////////////////////////////////////////////////////
///creamos una raiz de evento de cancelacion
$rGeVeCan = new RGeVeCan();
$rGeVeCan->setId('01801219302001001000016622023100311674909785'); ///poner un cdc
$rGeVeCan->setMOtEve('lorem ipsum circa mia pectora suspiria tenebris');
///////////////////////////////////////////////////////////////
///EVENTO DE INUTILIZACION
///////////////////////////////////////////////////////////////
$rGeVeInu = new RGeVeInu();
$rGeVeInu->setDNumTim(12560814); ///////////poner un numero de timbrado
$rGeVeInu->setDEst('001');
$rGeVeInu->setDPunExp('001');
$rGeVeInu->setDNumIn('0000167'); ///////////poner un numero de inicio
$rGeVeInu->setDNumFin('0000167'); ///////////poner un numero de fin
$rGeVeInu->setITiDE(Constants::TIPO_DOCUMENTO_FACTURA); ///////////poner un tipo de documento
$rGeVeInu->setMOtEve('Motivo de inutilizacion xD');
//====================================================================
//Ecentos de RECEPTOR
//====================================================================


///////////////////////////////////////////////////////////////
///EVENTO DE NOTIFICACION
///////////////////////////////////////////////////////////////
$rGeVeNotRec = new RGeVeNotRec();
$rGeVeNotRec->setId('00000000000000000000000000000000000'); ///poner un cdc
$rGeVeNotRec->setDFecEmi(new DateTime());
$rGeVeNotRec->setDFecRecep(new DateTime());
$rGeVeNotRec->setITipRec(1); ////1 contribuyente 2 no contribuyente
$rGeVeNotRec->setDNomRec('Nombre o razon social del receptor');
if ($rGeVeNotRec->getITipRec() == 1) {
  $rGeVeNotRec->setDRucRec('00000000'); ///////////poner un ruc
  $rGeVeNotRec->setDDVRec(0); ///////////poner un digito verificador
} else {
  ///no contribuyente
  $rGeVeNotRec->setDTipIDRec(1); ///////////poner un tipo de documento
  $rGeVeNotRec->setDNumID('00000000'); ///////////poner un numero de documento
}
$rGeVeNotRec->setDTotalGs(0); ///////////poner un total general de la operacion
///////////////////////////////////////////////////////////////
//Evento de conformidad
///////////////////////////////////////////////////////////////
$trGeVeConf = new RGeVeConf();
$trGeVeConf->setId('000000000000000000000000000000000000000000000000000000000000'); ///poner un cdc
$trGeVeConf->setITipConf(1); //// conformidad: 1 total 2 parcial
if ($trGeVeConf->getITipConf() == 2) {
  $trGeVeConf->setDFecRecep(new DateTime());
}
/////////////////////////////////////////////////////////////
//Evento de disconformidad
/////////////////////////////////////////////////////////////
$rGeVeDisconf = new RGeVeDisconf();
$rGeVeDisconf->setId('000000000000000000000000000000000000000000000000000000000000'); ///poner un cdc
$rGeVeDisconf->setMOtEve('Motivo de disconformidad');
/////////////////////////////////////////////////////////////
///Evento de desconocimiento
/////////////////////////////////////////////////////////////
$rGeVeDescon = new RGeVeDescon();
$rGeVeDescon->setId('00000000000000000000000000000000000000000000000000000000000000000'); ///poner un cdc
$rGeVeDescon->setDFecEmi(new DateTime());
$rGeVeDescon->setDFecRecep(new DateTime());
$rGeVeDescon->setITipRec(1); ////1 contribuyente 2 no contribuyente
$rGeVeDescon->setDNomRec('Nombre o razon social del receptor');
if ($rGeVeDescon->getITipRec() == 1) {
  $rGeVeDescon->setDRucRec('00000000'); ///////////poner un ruc
  $rGeVeDescon->setDDVRec(0); ///////////poner un digito verificador
} else {
  ///no contribuyente
  $rGeVeDescon->setDTipIDRec(1); ///////////poner un tipo de documento
  $rGeVeDescon->setDNumID('00000000'); ///////////poner un numero de documento
}
$rGeVeDescon->setMOtEve('Motivo de desconocimiento');
/////////////////////////////////////////////////////////////////////
//vento por actualización de datos: Datos del transporte
/////////////////////////////////////////////////////////////////////
$trGeVeTra = new RGeVeTr();
$trGeVeTra->setId('00000000000000000000000000000000000000000000000000000000000000000'); ///poner un cdc
$trGeVeTra->setDMotEv(1);
if ($trGeVeTra->getDMotEv() == 1) {
  ///1 cambio del local de entrega
  $trGeVeTra->setCDepEnt(1);
  $trGeVeTra->setCCiuEnt(1);
  $trGeVeTra->setDDirEnt('Direccion de entrega');
  $trGeVeTra->setDNumCas(2345);
  $trGeVeTra->setDCompDir1('Complemento de direccion 1');
}


//==================================================================
//EVENTOS AUTOMATICOS
//====================================================================


///////////////////////////////////////////////////////////////
//Evento automático por interoperabilidad: Evento asociación Retención
///////////////////////////////////////////////////////////////
$trGeVeReAce = new RGeVeRetAce();
$trGeVeReAce->setId('00000000000000000000000000000000000000000000000000000000000000000'); ///poner un cdc
$trGeVeReAce->setDNumTimRet(1); ///////////poner un numero de timbrado
$trGeVeReAce->setDEstRet('Establecimiento');
$trGeVeReAce->setDPunExpRet('Punto de expedicion');
$trGeVeReAce->setDNumDocRet('000000000000'); ///////////poner un numero de documento
$trGeVeReAce->setDCodConRet('000000000000'); ///////////poner un codigo de control
$trGeVeReAce->setDFeEmiRet(new DateTime());
///////////////////////////////////////////////////////////////
//Evento automático por interoperabilidad: Evento asociación de anulación de la Retención
///////////////////////////////////////////////////////////////
$trGeVeReAnu = new RGeVeRetAnu();
$trGeVeReAnu->setId('00000000000000000000000000000000000000000000000000000000000000000'); ///poner un cdc
$trGeVeReAnu->setDNumTimRet(1); ///////////poner un numero de timbrado
$trGeVeReAnu->setDEstRet('Establecimiento');
$trGeVeReAnu->setDPunExpRet('Punto de expedicion');
$trGeVeReAnu->setDNumDocRet('000000000000'); ///////////poner un numero de documento
$trGeVeReAnu->setDCodConRet('000000000000'); ///////////poner un codigo de control
$trGeVeReAnu->setDFeEmiRet(new DateTime());
///////////////////////////////////////////////////////////////
//Evento automático por interoperabilidad: Evento transferencia de créditos fiscales
///////////////////////////////////////////////////////////////
$trGeveCCFF = new RGeVeCCFF();
$trGeveCCFF->setId('00000000000000000000000000000000000000000000000000000000000000000'); ///poner un cdc
$trGeveCCFF->setDNumTraCCFF('000000000000'); ///////////poner un numero de transferencia
$trGeveCCFF->setDFeAceTraCCFF(new DateTime());
///////////////////////////////////////////////////////////////
//Evento automático por interoperabilidad: Evento devolución de créditos fiscales - Cuestionado
///////////////////////////////////////////////////////////////
$trGeDevCCFFCue = new RGeDevCCFFCue();
$trGeDevCCFFCue->setId('000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000'); ///poner un cdc
$trGeDevCCFFCue->setDNumDevSol('000000000000'); ///////////poner un numero de devolucion
$trGeDevCCFFCue->setDNumDevInf('000000000000'); ///////////poner un numero de informe
$trGeDevCCFFCue->setDNumDevRes('000000000000'); ///////////poner un numero de resolucion
$trGeDevCCFFCue->setDFeEmiSol(new DateTime());
$trGeDevCCFFCue->setDFeEmiInf(new DateTime());
$trGeDevCCFFCue->setDFeEmiRes(new DateTime());
///////////////////////////////////////////////////////////////
//Evento automático por interoperabilidad: Evento devolución de créditos fiscales - Devuelto
///////////////////////////////////////////////////////////////
$RGeDevCCFFDev = new RGeDevCCFFDev();
$RGeDevCCFFDev->setId('000000000000000000000000000000000000000000000000000000000000000 '); ///poner un cdc
$RGeDevCCFFDev->setDNumDevSol('000000000000'); ///////////poner un numero de devolucion
$RGeDevCCFFDev->setDNumDevInf('000000000000'); ///////////poner un numero de informe
$RGeDevCCFFDev->setDNumDevRes('000000000000'); ///////////poner un numero de resolucion
$RGeDevCCFFDev->setDFeEmiSol(new DateTime());
$RGeDevCCFFDev->setDFeEmiInf(new DateTime());
$RGeDevCCFFDev->setDFeEmiRes(new DateTime());
///////////////////////////////////////////////////////////////
//Evento automático por SIFEN: Evento anticipO
///////////////////////////////////////////////////////////////
$trGeVeAnt = new RGeVeAnt();
$trGeVeAnt->setId('00000000000000000000000000000000000000000000000000000000000000000'); ///poner un cdc
////////////////////////////////////////////////////////////////
//Evento automático por SIFEN: Evento remisión 
////////////////////////////////////////////////////////////////
$trGeVeRem = new RGeVeRem();
$trGeVeRem->setId('000000000000000000000000000000000000000000000000000000000000000000000000000000000000000'); ///poner un cdc
////////////////////////////////////////////////////////////////


////se asigna el evento de cancelacion al grupo de campos de tipo evento
$gGroupTiEvt->setRGeVeCan($rGeVeCan);
// $gGroupTiEvt->setRGeVeInu($rGeVeInu);
////se asigna el grupo de campos  de tipo evento al grupo de campos generales del evento
$rEve->setGGroupTiEvt($gGroupTiEvt);
// $rEve2->setGGroupTiEvt($gGroupTiEvt2);
////se asigna el grupo de campos generales del evento a la raiz de gestion de eventos
$trGesEve->setREve($rEve);
// $trGesEve2->setREve($rEve2);
////se asigna la raiz de gestion de eventos al array de raices de gestion de eventos
$rGesEve[] = $trGesEve;
// $rGesEve[] = $trGesEve2;
///se asigna el array al grupo de eventos
$evento->setRGesEve($rGesEve);

//se envia el request
try {
  echo "OK\n";
  echo "Envio de evento\n";
  $res = Sifen::RegistrarEvento($evento, $config);
  echo "Respuesta:\n";
  echo json_encode($res, JSON_PRETTY_PRINT);
} catch (SoapFault $e) {
  // Handle SOAP faults/errors
  echo 'SOAP Error: ' . $e->getMessage();
} catch (Exception $e) {
  // Handle general exceptions
  echo 'Error: ' . $e->getMessage();
}
