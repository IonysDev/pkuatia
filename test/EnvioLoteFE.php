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

$zipDir = __DIR__ . '/compressMe';

$config = new Config();
$config->env = 'dev';
$config->certificateFilePath = $certFile;
$config->privateKeyFilePath = $keyFile;
$config->privateKeyPassphrase = $keyPassphrase;
echo "===============================================================\n";
echo "Prueba de Envío de Lote de Documentos Electrónicos\n";
echo "Inicializando Sifen... \n";
echo "===============================================================\n";
Sifen::Init($config);

////////////////////////////////////////////////////////////////////
$rDeArray = [];
$tipoDocumento = Constants::TIPO_DOCUMENTO_FACTURA;
////////////////////////////////////////////////////////////////////
echo "===============================================================\n";
echo "Tipo de Documento Electrónico a poner en lote TIPO: " . $tipoDocumento . "\n";
echo "Maximo de Documentos Electrónicos por lote permitidos por el SIFEN: " . Constants::MAX_DOCUMENTOS_ELECTRONICOS_POR_LOTE . "\n";
echo "Creando Documento Electrónicos \n";
echo "===============================================================\n";

///HARDCODEADO
while (count($rDeArray) < 10) {
  //////////////////////////////////////////////////////////////////
  $gOpeDe = new GOpeDE();

  //////////////////////////////////////////////////////////////////

  $gTimb = new GTimb();
  $gTimb->setITiDE(Constants::TIPO_DOCUMENTO_FACTURA);
  $gTimb->setDNumTim(12560814);
  $gTimb->setDEst('001');
  $gTimb->setDPunExp('001');
  $gTimb->setDNumDoc('0000023');
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
  $gPaConEIni->setDMonTiPag("100000");
  $gPaConEIni->setCMoneTiPag("PYG");
  $gCamCond->gPaConEIni[] = $gPaConEIni;


  $gCamItem = new GCamItem();
  $gCamItem->setDCodInt('SERV001');
  $gCamItem->setDDesProSer('Servicio de desarrollo de software');
  $gCamItem->setCUniMed(77);
  $gCamItem->setDCantProSer("1");

  $gValorRestaItem = new GValorRestaItem();
  $gValorRestaItem->setDTotOpeItem("100000");

  $gValorItem = new GValorItem();
  $gValorItem->setDPUniProSer("100000");
  $gValorItem->setDTotBruOpeItem("100000");
  $gValorItem->setGValorRestaItem($gValorRestaItem);

  $gCamItem->setGValorItem($gValorItem);

  $gCamIVA = new GCamIVA();
  $gCamIVA->setIAfecIVA(GCamIVA::AFECTACION_IVA_GRAVADO);
  $gCamIVA->setDPropIVA("100");
  $gCamIVA->setDTasaIVA(10);
  $gCamIVA->setDBasGravIVA('90909');
  $gCamIVA->setDLiqIVAItem('9091');
  $gCamIVA->setDBasExe("0");

  $gCamItem->gCamIVA = $gCamIVA;

  $gDtipDE = new GDtipDE();
  $gDtipDE->setGCamCond($gCamCond);
  $gDtipDE->setGCamFE($gCamFE);
  $gDtipDE->gCamItem[] = $gCamItem;

  //////////////////////////////////////////////////////////////////

  $gTotSub = new GTotSub();
  $gTotSub->setDSub10("100000");
  $gTotSub->setDTotOpe("100000");
  $gTotSub->setDTotGralOpe("100000");
  $gTotSub->setDIVA5("0");
  $gTotSub->setDIVA10("9091");
  $gTotSub->setDTotIVA($gTotSub->getDIVA10());
  $gTotSub->setDBaseGrav5("0");
  $gTotSub->setDBaseGrav10("90909");
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

  echo "Documento Electrónico " . count($rDeArray) . " creado\n";
}
////////////////////////////////////////////////////////////////////
echo "===============================================================\n";
echo count($rDeArray) . " Documentos Electrónicos creados\n";
echo "===============================================================\n";
////////////////////////////////////////////////////////////////////

////recheck tipo de documento
echo "Revision de tipo de documento electrónico \n";
echo "===============================================================\n";
foreach ($rDeArray as $key => $value) {
  echo "Tipo DE admitido: " . $tipoDocumento . " Tipo DE actual: " . $value->getDE()->getGTimb()->getITiDE() . "\n";
  if ($value->getDE()->getGTimb()->getITiDE() != $tipoDocumento) {
    echo "Tipo de Documento Electrónico no admitido\n";
    unset($rDeArray[$key]);
  }
}
////////////////////////////////////////////////////////////////////
echo "===============================================================\n";
echo "Proceso de firma de Documentos Electrónicos\n";
echo "===============================================================\n";

foreach ($rDeArray as $key => $value) {
  echo "Firmando Documento Electrónico " . ($key + 1) . "\n";
  // Firma el documento electrónico
  $xmlDocument = SignHelper::SignRDE($value);
  // Extrae la firma del documento electrónico
  $signatureNode = $xmlDocument->getElementsByTagName("Signature")->item(0);
  $signature = Signature::FromDOMElement($signatureNode);

  // Verifica si en los campos fuera de la firma hay datos
  $gCamFuFD = $rde->getGCamFuFD();
  if (is_null($gCamFuFD))
    $gCamFuFD = new GCamFuFD();
  else {
    // Eliminar el nodo del gCamFuFD si es que existe del xmlDocument firmado
    $rdeNode = $xmlDocument->getElementsByTagName("rDE")->item(0);
    for ($i = 0; $i < $rdeNode->childNodes->length; $i++) {
      $node = $rdeNode->childNodes->item($i);
      if (strcmp($node->nodeName, 'gCamFuFD') == 0) {
        $rdeNode->removeChild($node);
      }
    }
  }

  // Establece el valor del link para el QR 
  $gCamFuFD->setDCarQR(QRHelper::GenerateQRContent($config, $rde->getDE(), $signature));
  $gCamFuFDNode = $gCamFuFD->toDOMElement($xmlDocument);

  // Agrega el nodo del QR al documento electrónico
  $xmlDocument->getElementsByTagName("rDE")->item(0)->appendChild($gCamFuFDNode);

  // Genera la cadena XML a ser enviada al SIFEN
  $signedXML = $xmlDocument->saveXML($xmlDocument->getElementsByTagName("rDE")->item(0));

  echo "Documento Electrónico " . ($key + 1) . " firmado\n";

  // Guarda el documento electrónico firmado en un archivo
  file_put_contents($zipDir . '/rde' . ($key + 1) . '.xml', $signedXML);

  echo "Documento Electrónico " . ($key + 1) . " guardado en " . $zipDir . "/rde" . ($key + 1) . ".xml\n";
}
////////////////////////////////////////////////////////////////////
echo "===============================================================\n";
echo "Proceso de compresión de Documentos Electrónicos\n";
echo "===============================================================\n";
$zip = new ZipArchive();
$zip->open($zipDir . '/rDEs.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);
foreach ($rDeArray as $key => $value) {
  $zip->addFile($zipDir . '/rde' . ($key + 1) . '.xml', 'rde' . ($key + 1) . '.xml');
}
$zip->close();
echo "Archivo comprimido guardado en " . $zipDir . "/rde.zip\n";
////////////////////////////////////////////////////////////////////
echo "===============================================================\n";
echo "Proceso de envío de Lote de Documentos Electrónicos\n";

//enconde to base64
$zipFile = base64_encode(file_get_contents($zipDir . '/rDEs.zip'));


// Crea el objeto de envío de lote de documentos electrónicos
try {
  $envioLote = Sifen::EnviarLoteDE($zipFile);
} catch(SoapFault $e) {
  echo 'SOAP Fault: ' . $e->getMessage() . "\n";
}
catch(Exception $e) {
  echo 'Exception: ' . $e->getMessage() . "\n";
}