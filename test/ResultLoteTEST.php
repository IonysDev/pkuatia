<?php

use Abiliomp\Pkuatia\Core\Responses\RespuestaConsultaLoteDE;
use Abiliomp\Pkuatia\Helpers\RequestXMLHelper;
use Abiliomp\Pkuatia\SoapSSLClient;

require '../vendor/autoload.php'; // Include the Composer autoloader

error_reporting(E_ALL);
ini_set('display_errors', 1);

$wsdl = 'https://sifen.set.gov.py/de/ws/consultas/consulta-lote.wsdl?wsdl';
$certFile = '80121930-2.cert.pem';
$keyFile = '80121930-2.key.pem';
$keyPassphrase = '171222';
$operation = 'rEnviConsLoteDe ';
$data = array(
  'dId' => '552',
  'dProtConsLote' => '999'
);

// /// Create XML for request
$myXML =  RequestXMLHelper::makeFromArray($operation, $data);

try {
  echo 'Creating SOAP client...' . PHP_EOL;
  SoapSSLClient::init($wsdl, $certFile, $keyFile, $keyPassphrase);
  echo 'done' . PHP_EOL;
  // make the soap call
  $responseXML = SoapSSLClient::$client->rEnviConsLoteDe($myXML);
  // echo 'request' . PHP_EOL;
  // echo SoapSSLClient::$client->__getLastRequest();
  echo 'Response:' . PHP_EOL;
  $res = RespuestaConsultaLoteDE::fromResponse($responseXML);
  echo $res->printData();
} catch (SoapFault $e) {
  echo $e->getMessage();
} catch (Exception $e) {
  echo $e->getMessage();
}
