<?php

use Abiliomp\Pkuatia\Core\Config;
use Abiliomp\Pkuatia\Core\Constants;
use Abiliomp\Pkuatia\Core\Fields\DE\A\DE;
use Abiliomp\Pkuatia\Core\Fields\DE\AA\RDE;
use Abiliomp\Pkuatia\Core\Fields\DE\B\GOpeDE;
use Abiliomp\Pkuatia\Core\Fields\DE\C\GTimb;
use Abiliomp\Pkuatia\Core\Fields\DE\D\GActEco;
use Abiliomp\Pkuatia\Core\Fields\DE\D\GDatGralOpe;
use Abiliomp\Pkuatia\Core\Fields\DE\D\GDatRec;
use Abiliomp\Pkuatia\Core\Fields\DE\D\GEmis;
use Abiliomp\Pkuatia\Core\Fields\DE\D\GOpeCom;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GCamCond;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GCamFE;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GCamItem;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GCamIVA;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GDtipDE;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GPaConEIni;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GValorItem;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GValorRestaItem;
use Abiliomp\Pkuatia\Core\Fields\DE\F\GTotSub;
use Abiliomp\Pkuatia\Helpers\CDCHelper;
use Abiliomp\Pkuatia\Helpers\SignHelper;
use Abiliomp\Pkuatia\Sifen;
use Abiliomp\Pkuatia\Core\Fields\DE\I\Signature;
use Abiliomp\Pkuatia\Core\Fields\DE\J\GCamFuFD;
use Abiliomp\Pkuatia\Helpers\QRHelper;

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

////////////////////////////////////////////////////////////////////
$rDeArray = [];
$tipoDocumento = Constants::TIPO_DOCUMENTO_FACTURA;
////////////////////////////////////////////////////////////////////

$dNumDOC = 125;


//////////////////////////////////////////////////////////////////
$gOpeDe = new GOpeDE();

//////////////////////////////////////////////////////////////////

$gTimb = new GTimb();
$gTimb->setITiDE(Constants::TIPO_DOCUMENTO_FACTURA);
$gTimb->setDNumTim(12560814);
$gTimb->setDEst('001');
$gTimb->setDPunExp('001');

$dNumDOC++;
$dNumDOC = str_pad($dNumDOC, 7, '0', STR_PAD_LEFT);
$gTimb->setDNumDoc($dNumDOC);
$gTimb->setDFeIniT(new DateTime('2023-04-14'));

//////////////////////////////////////////////////////////////////

$gOpeCom = new GOpeCom();
$gOpeCom->setITipTra(Constants::TIPO_TRANSACCION_VENTA_MERCADERIA);
$gOpeCom->setITImp(Constants::TIPO_IMPUESTO_IVA);
$gOpeCom->setCMoneOpe('PYG');

//////////////////////////////////////////////////////////////////
$gEmis = new GEmis();
$gEmis->setDRucEm('80121930');
$gEmis->setDDVEmi('2');
$gEmis->setITipCont(Constants::TIPO_CONTRIBUYENTE_PERSONA_JURIDICA);
$gEmis->setDNomEmi('DE generado en ambiente de prueba - sin valor comercial ni fiscal');
$gEmis->setDDirEmi('Tte. Felix Cañete');
$gEmis->setDNumCas('1622');
$gEmis->setCDepEmi(1);
$gEmis->setDDesDepEmi('CAPITAL');
$gEmis->setCCiuEmi(1);
$gEmis->setDDesCiuEmi('ASUNCION (DISTRITO)');
$gEmis->setDTelEmi('021 295550');
$gEmis->setDEmailE('abiliomp@gmail.com');
$gActEco = new GActEco();
$gActEco->setCActEco(47411);
$gActEco->setDDesActEco('COMERCIO AL POR MENOR DE EQUIPOS INFORMÁTICOS Y SOFTWARE');
$gEmis->gActEco[] = $gActEco;
$gActEco = new GActEco();
$gActEco->setCActEco(69208);
$gActEco->setDDesActEco('OTROS SERVICIOS AUTORIZADOS');
$gEmis->gActEco[] = $gActEco;
$gActEco = new GActEco();
$gActEco->setCActEco(62020);
$gActEco->setDDesActEco('ACTIVIDADES DE CONSULTORÍA Y GESTIÓN DE SERVICIOS INFORMÁTICOS');
$gEmis->gActEco[] = $gActEco;
$gActEco = new GActEco();
$gActEco->setCActEco(46510);
$gActEco->setDDesActEco('COMERCIO AL POR MAYOR DE EQUIPOS INFORMÁTICOS Y SOFTWARE');
$gEmis->gActEco[] = $gActEco;

$gDatRec = new GDatRec();
$gDatRec->setINatRec(GDatRec::NATURALEZA_CONTRIBUYENTE);
$gDatRec->setITiOpe(GDatRec::TIPO_OPERACION_B2B);
$gDatRec->setITiContRec(GDatRec::TIPO_CONTRIBUYENTE_PERSONA_JURIDICA);
$gDatRec->setCPaisRec('PRY');
$gDatRec->setDRucRec('80059725');
$gDatRec->setDDVRec('7');
$gDatRec->setDNomRec('Savona SA');
$gDatRec->setDDirRec('Camino a Pto. Remansito');
$gDatRec->setDNumCasRec('9007');
$gDatRec->setCDepRec(15);
$gDatRec->setCDisRec(188);
$gDatRec->setCCiuRec(3609);
$gDatRec->setDTelRec('021551142');
$gDatRec->setDCelRec('0981416807');
$gDatRec->setDEmailRec('sergio.garelli@gmail.com');
$gDatRec->setDCodCliente('80059725');

$gDatGralOpe = new GDatGralOpe();
$gDatGralOpe->setDFeEmiDE(new DateTime('now', new DateTimeZone('America/Asuncion')));
$gDatGralOpe->setGOpeCom($gOpeCom);
$gDatGralOpe->setGEmis($gEmis);
$gDatGralOpe->setGDatRec($gDatRec);

//////////////////////////////////////////////////////////////////

$gCamFE = new GCamFE();

$gCamCond = new GCamCond();
$gCamCond->setICondOpe(Constants::CONDICION_OPERACION_CONTADO);
$gPaConEIni = new GPaConEIni();
$gPaConEIni->setITiPago(Constants::PAGO_EFECTIVO);
$gPaConEIni->setDMonTiPag("28819032");
$gPaConEIni->setCMoneTiPag("PYG");
$gCamCond->gPaConEIni[] = $gPaConEIni;

///////////////////////////////////////////////////////

$gDtipDE = new GDtipDE();
$gDtipDE->setGCamCond($gCamCond);
$gDtipDE->setGCamFE($gCamFE);

// Item 1

$gCamItem = new GCamItem();
$gCamItem->setDCodInt('SRVFLT');
$gCamItem->setDDesProSer('Servicio de Flete');
$gCamItem->setCUniMed(885);
$gCamItem->setDCantProSer("1");

$gValorRestaItem = new GValorRestaItem();
$gValorRestaItem->setDTotOpeItem("19419032");

$gValorItem = new GValorItem();
$gValorItem->setDPUniProSer("19419032");
$gValorItem->setDTotBruOpeItem("19419032");
$gValorItem->setGValorRestaItem($gValorRestaItem);

$gCamItem->setGValorItem($gValorItem);

$gCamIVA = new GCamIVA();
$gCamIVA->setIAfecIVA(GCamIVA::AFECTACION_IVA_GRAVADO);
$gCamIVA->setDPropIVA("100");
$gCamIVA->setDTasaIVA(10);
$gCamIVA->setDBasGravIVA('17653665');
$gCamIVA->setDLiqIVAItem('1765367');
$gCamIVA->setDBasExe("0");

$gCamItem->gCamIVA = $gCamIVA;
$gDtipDE->gCamItem[] = $gCamItem;

// Item 2

$gCamItem = new GCamItem();
$gCamItem->setDCodInt('SRVFLT');
$gCamItem->setDDesProSer('Servicio de Flete');
$gCamItem->setCUniMed(885);
$gCamItem->setDCantProSer("1");

$gValorRestaItem = new GValorRestaItem();
$gValorRestaItem->setDTotOpeItem("9400000");

$gValorItem = new GValorItem();
$gValorItem->setDPUniProSer("9400000");
$gValorItem->setDTotBruOpeItem("9400000");
$gValorItem->setGValorRestaItem($gValorRestaItem);

$gCamItem->setGValorItem($gValorItem);

$gCamIVA = new GCamIVA();
$gCamIVA->setIAfecIVA(GCamIVA::AFECTACION_IVA_GRAVADO);
$gCamIVA->setDPropIVA("100");
$gCamIVA->setDTasaIVA(10);
$gCamIVA->setDBasGravIVA('8545455');
$gCamIVA->setDLiqIVAItem('854545');
$gCamIVA->setDBasExe("0");

$gCamItem->gCamIVA = $gCamIVA;
$gDtipDE->gCamItem[] = $gCamItem;

//////////////////////////////////////////////////////////////////

$gTotSub = new GTotSub();
$gTotSub->setDSub10("28819032");
$gTotSub->setDTotOpe("28819032");
$gTotSub->setDTotGralOpe("28819032");
$gTotSub->setDIVA5("0");
$gTotSub->setDIVA10("2619912");
$gTotSub->setDTotIVA($gTotSub->getDIVA10());
$gTotSub->setDBaseGrav5("0");
$gTotSub->setDBaseGrav10("26199120");
$gTotSub->setDTBasGraIVA($gTotSub->getDBaseGrav10());

//////////////////////////////////////////////////////////////////

$de = new DE();
$de->setGOpeDE($gOpeDe);
$de->setGTimb($gTimb);
$de->setGDatGralOpe($gDatGralOpe);
$de->setGDtipDE($gDtipDE);
$de->setGTotSub($gTotSub);

$cdc = CDCHelper::Generate($de);

$de->setId($cdc);
$de->setDDVId($cdc[43]);
$de->setDFecFirma(new DateTime('now', new DateTimeZone('America/Asuncion')));

//////////////////////////////////////////////////////////////////

$rde = new RDE();
$rde->setDE($de);

//////////////////////////////////////////////////////////////////////
$rDeArray[] = $rde;

try {
  echo "Preparando lote para envío... \n";
  $xmlArray = [];
  foreach($rDeArray as $r) {
    $rdeXml = Sifen::FirmarDE($r);
    file_put_contents($r->getDE()->getGDatGralOpe()->getGEmis()->getDRucEm() . '-' . $r->getDE()->getId() . '.xml', $rdeXml);
    $xmlArray[] = $rdeXml;
  }
  echo "Enviando al SIFEN el lote de prueba... \n";
  $res = Sifen::EnviarLoteDE($xmlArray);
  echo "Resultado: \n";
  echo json_encode($res, JSON_PRETTY_PRINT);
  echo "\n";
  echo "Numero de Lote: " . $res->dProtConsLote . "\n";
} catch (SoapFault $e) {
  // Handle SOAP faults/errors
  echo 'SOAP Error: ' . $e->getMessage();
} catch (Exception $e) {
  // Handle general exceptions
  echo 'Error: ' . $e->getMessage();
}
