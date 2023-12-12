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
use Abiliomp\Pkuatia\Core\Fields\DE\E\GCamNCDE;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GDtipDE;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GPagCred;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GValorItem;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GValorRestaItem;
use Abiliomp\Pkuatia\Core\Fields\DE\F\GTotSub;
use Abiliomp\Pkuatia\Core\Fields\DE\H\GCamDEAsoc;
use Abiliomp\Pkuatia\Helpers\CDCHelper;
use Abiliomp\Pkuatia\Sifen;

require '../vendor/autoload.php'; // Include the Composer autoloader

error_reporting(E_ALL);
ini_set('display_errors', 1);
$certFile = '80007530.pem.crt';
$keyFile = '80007530.pem.key';
$keyPassphrase = '4iZKi0+T';

$config = new Config();
$config->env = 'prod';
$config->certificateFilePath = $certFile;
$config->privateKeyFilePath = $keyFile;
$config->privateKeyPassphrase = $keyPassphrase;
$config->setCsc('c8a20C961d46Efd59b2Fed09A15e1114');

Sifen::Init($config);

////////////////////////////////////////////////////////////////////

$rDeArray = [];
$tipoDocumento = Constants::TIPO_DOCUMENTO_NOTA_CREDITO;

//////////////////////////////////////////////////////////////////
// NC 1

$gOpeDe = new GOpeDE();

//////////////////////////////////////////////////////////////////

$gTimb = new GTimb();
$gTimb->setITiDE(Constants::TIPO_DOCUMENTO_NOTA_CREDITO);
$gTimb->setDNumTim(16703603);
$gTimb->setDEst('001');
$gTimb->setDPunExp('001');
$dNumDOC = str_pad('2', 7, '0', STR_PAD_LEFT);
$gTimb->setDNumDoc($dNumDOC);
$gTimb->setDFeIniT(new DateTime('2023-09-28'));

//////////////////////////////////////////////////////////////////

$gOpeCom = new GOpeCom();
$gOpeCom->setITImp(Constants::TIPO_IMPUESTO_IVA);
$gOpeCom->setCMoneOpe('PYG');

//////////////////////////////////////////////////////////////////

$gEmis = new GEmis();
$gEmis->setDRucEm('80007530');
$gEmis->setDDVEmi('7');
$gEmis->setITipCont(Constants::TIPO_CONTRIBUYENTE_PERSONA_JURIDICA);
$gEmis->setDNomEmi('Garelli Estructuras SRL');
$gEmis->setDDirEmi('Rca. Argentina esq. Incas');
$gEmis->setDNumCas('2346');
$gEmis->setCDepEmi(1);
$gEmis->setDDesDepEmi('CAPITAL');
$gEmis->setCCiuEmi(1);
$gEmis->setDDesCiuEmi('ASUNCION (DISTRITO)');
$gEmis->setDTelEmi('021551142');
$gEmis->setDEmailE('garelliram@hotmail.com');
$gActEco = new GActEco();
$gActEco->setCActEco(46632);
$gActEco->setDDesActEco('COMERCIO AL POR MAYOR DE MATERIALES DE CONSTRUCCIÓN');
$gEmis->gActEco[] = $gActEco;

// Para Savona
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
$gDatRec->setDCelRec('0981416807');
$gDatRec->setDTelRec('021551142');
$gDatRec->setDCodCliente('80059725');
$gDatRec->setDEmailRec('sergio.garelli@gmail.com');


// Para Ceramica
/*$gDatRec = new GDatRec();
$gDatRec->setINatRec(GDatRec::NATURALEZA_CONTRIBUYENTE);
$gDatRec->setITiOpe(GDatRec::TIPO_OPERACION_B2B);
$gDatRec->setITiContRec(GDatRec::TIPO_CONTRIBUYENTE_PERSONA_JURIDICA);
$gDatRec->setCPaisRec('PRY');
$gDatRec->setDRucRec('80001619');
$gDatRec->setDDVRec('0');
$gDatRec->setDNomRec('CERAMICA DEL CHACO SA');
$gDatRec->setDDirRec('Avenida Rca. Argentina');
$gDatRec->setDNumCasRec('2346');
$gDatRec->setCDepRec(1);
$gDatRec->setCDisRec(1);
$gDatRec->setCCiuRec(1);
$gDatRec->setDTelRec('021551142');
$gDatRec->setDCodCliente('80001619');*/


$gDatGralOpe = new GDatGralOpe();
$fecha = new DateTime('2023-12-06 17:01:00', new DateTimeZone('America/Asuncion'));
// $fecha->modify('-1 hour');
$gDatGralOpe->setDFeEmiDE($fecha);
$gDatGralOpe->setGOpeCom($gOpeCom);
$gDatGralOpe->setGEmis($gEmis);
$gDatGralOpe->setGDatRec($gDatRec);

//////////////////////////////////////////////////////////////////

$gCamNCDE = new GCamNCDE();
$gCamNCDE->setIMotEmi(GCamNCDE::MOTIVO_EMISION_DEVOLUCION);

///////////////////////////////////////////////////////

$gDtipDE = new GDtipDE();
$gDtipDE->setGCamNCDE($gCamNCDE);

///////////////////////////////////////////////////////

// Item 1

$gCamItem = new GCamItem();
$gCamItem->setDCodInt('RSRVFLT');
$gCamItem->setDDesProSer('Reversión - Servicio de Flete');
// Global
 $gCamItem->setCUniMed(885);
// Hora
// $gCamItem->setCUniMed(100);
// Unidad
// $gCamItem->setCUniMed(77);
$gCamItem->setDCantProSer("1");

$gValorRestaItem = new GValorRestaItem();
$gValorRestaItem->setDTotOpeItem("5720000");

$gValorItem = new GValorItem();
$gValorItem->setDPUniProSer("5720000");
$gValorItem->setDTotBruOpeItem("5720000");
$gValorItem->setGValorRestaItem($gValorRestaItem);

$gCamItem->setGValorItem($gValorItem);

$gCamIVA = new GCamIVA();
$gCamIVA->setIAfecIVA(GCamIVA::AFECTACION_IVA_GRAVADO);
$gCamIVA->setDPropIVA("100");
$gCamIVA->setDTasaIVA(10);
$gCamIVA->setDBasGravIVA('5200000');
$gCamIVA->setDLiqIVAItem( '520000');
$gCamIVA->setDBasExe("0");

$gCamItem->gCamIVA = $gCamIVA;
$gDtipDE->gCamItem[] = $gCamItem;

//////////////////////////////////////////////////////////////////

$gTotSub = new GTotSub();
$gTotSub->setDSub10("5720000");
$gTotSub->setDTotOpe("5720000");
$gTotSub->setDTotGralOpe("5720000");
$gTotSub->setDIVA5("0");
$gTotSub->setDIVA10("520000");
$gTotSub->setDTotIVA($gTotSub->getDIVA10());
$gTotSub->setDBaseGrav5("0");
$gTotSub->setDBaseGrav10("5200000");
$gTotSub->setDTBasGraIVA($gTotSub->getDBaseGrav10());

//////////////////////////////////////////////////////////////////

// Documento Asociado
$gCamDEAsoc = new GCamDEAsoc();
$gCamDEAsoc->setITipDocAso(GCamDEAsoc::TIPO_DE_DOCUMENTO_ASOCIADO_ELECTRONICO);
$gCamDEAsoc->setDCdCDERef('01800075307001001000001122023120213067447859');

//////////////////////////////////////////////////////////////////

$de = new DE();
$de->setGOpeDE($gOpeDe);
$de->setGTimb($gTimb);
$de->setGDatGralOpe($gDatGralOpe);
$de->setGDtipDE($gDtipDE);
$de->setGTotSub($gTotSub);
$de->setGCamDEAsoc([$gCamDEAsoc]);

$cdc = CDCHelper::Generate($de);

$de->setId($cdc);
$de->setDDVId($cdc[43]);
$de->setDFecFirma($fecha);

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
