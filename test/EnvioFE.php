<?php

require '../vendor/autoload.php'; // Include the Composer autoloader

use Abiliomp\Pkuatia\Core\Config;
use Abiliomp\Pkuatia\Core\Constants;
use Abiliomp\Pkuatia\Core\Fields\DE\AA\RDE;
use Abiliomp\Pkuatia\Core\Fields\DE\B\GOpeDE;
use Abiliomp\Pkuatia\Core\Fields\DE\C\GTimb;
use Abiliomp\Pkuatia\Core\Fields\DE\D\GActEco;
use Abiliomp\Pkuatia\Core\Fields\DE\D\GDatGralOpe;
use Abiliomp\Pkuatia\Core\Fields\DE\D\GDatRec;
use Abiliomp\Pkuatia\Core\Fields\DE\D\GEmis;
use Abiliomp\Pkuatia\Core\Fields\DE\D\GOpeCom;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GCamFE;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GCamItem;
use Abiliomp\Pkuatia\Sifen;

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

//////////////////////////////////////////////////////////////////

$gOpeDe = new GOpeDE();

//////////////////////////////////////////////////////////////////

$gTimb = new GTimb();
$gTimb->setITiDE(Constants::TIPO_DOCUMENTO_FACTURA);
$gTimb->setDNumTim(12560814);
$gTimb->setDEst('001');
$gTimb->setDPunExp('001');
$gTimb->setDNumDoc('0000001');
$gTimb->setDFeIniT(new DateTime('2023-04-14'));

//////////////////////////////////////////////////////////////////

$gOpeCom = new GOpeCom();
$gOpeCom->setITipTra(Constants::TIPO_TRANSACCION_VENTA_MERCADERIA);
$gOpeCom->setITImp(Constants::TIPO_IMPUESTO_IVA);
$gOpeCom->setCMoneOpe('PYG');

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
$gActEco->setCActEco(69208 );
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
$gDatGralOpe->setDFeEmiDE(new DateTime());
$gDatGralOpe->setGOpeCom($gOpeCom);
$gDatGralOpe->setGEmis($gEmis);
$gDatGralOpe->setGDatRec($gDatRec);

//////////////////////////////////////////////////////////////////

$gCamFE = new GCamFE();

$gCamItem = new GCamItem();
$gCamItem->setDCodInt('SERV001');
$gCamItem->setDDesProSer('Servicio de desarrollo de software');
$gCamItem->setCUniMed(77);
$gCamItem->setDCantProSer("1");













try {
    echo "Prueba de Consulta de RUC\n";
    echo "Inicializando Sifen... ";
    Sifen::Init($config);
    echo "OK\n";
    echo "Consultando RUC " . $testRuc . "...\n";
    $res = Sifen::ConsultarRUC($testRuc);
    echo "Resultado: \n";
    echo json_encode($res, JSON_PRETTY_PRINT);
} catch (SoapFault $e) {
    // Handle SOAP faults/errors
    echo 'SOAP Error: ' . $e->getMessage();
} catch (Exception $e) {
    // Handle general exceptions
    echo 'Error: ' . $e->getMessage();
}
