<?php

use Abiliomp\Pkuatia\Helpers\RequestXMLHelper;
use Abiliomp\Pkuatia\SoapSSLClient;

require '../vendor/autoload.php'; // Include the Composer autoloader

error_log(E_ALL);
ini_set('display_errors', 1);

$wsdl = 'https://sifen.set.gov.py/de/ws/consultas/consulta-lote.wsdl?wsdl';
$certFile = '80121930-2.cert.pem';
$keyFile = '80121930-2.key.pem';

$keyPassphrase = '171222';
$operation = 'rEnviConsLoteDe ';
$data = array(
  'dId' => '552',
  'dProtConsLote' => '123456789'

);

/// Create XML for request
$myXML =  RequestXMLHelper::makeFromArray($operation, $data);

try{

echo 'Creating SOAP client...' . PHP_EOL;
SoapSSLClient::init($wsdl, $certFile, $keyFile, $keyPassphrase);
echo 'done' . PHP_EOL;

// make the soap call
$responseXML = SoapSSLClient::$client->rEnviConsLoteDe($myXML);

echo 'Response:' . PHP_EOL;



}catch(SoapFault $e){
  echo $e->getMessage();
}catch(Exception $e){
  echo $e->getMessage();
}
