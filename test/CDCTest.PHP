<?php

use Abiliomp\Pkuatia\Core\Responses\RespuestaConsultaDE;
use Abiliomp\Pkuatia\Helpers\RequestXMLHelper;
use Abiliomp\Pkuatia\SoapSSLClient;

require '../vendor/autoload.php'; // Include the Composer autoloader

error_reporting(E_ALL);
ini_set('display_errors', 1);

$wsdl = 'https://sifen.set.gov.py/de/ws/consultas/consulta.wsdl?wsdl';
$certFile = '80121930-2.cert.pem';
$keyFile = '80121930-2.key.pem';
$keyPassphrase = '171222';
$operation = 'rEnviConsDe';
$data = array(
  'dId' => '552',
  // 'dCDC' => '01800160967029015003289222023052912371717760'
  'dCDC' => '01800090853013001001802422023052910014652161'
  // 'dCDC' => '01800160967029015003289222023052912371717799'

);;
/// Create XML for request
$myXML =  RequestXMLHelper::makeFromArray($operation, $data);

if (strlen($data['dCDC']) != 44) {
  echo "CDC no valido";
  exit;
}

try {
  ///create soap client
  echo 'Creating SOAP client...' . PHP_EOL;
  SoapSSLClient::init($wsdl, $certFile, $keyFile, $keyPassphrase);
  echo 'done' . PHP_EOL;
  // make the soap call
  $responseXML = SoapSSLClient::$client->rEnviConsDe($myXML);
  echo 'Response:' . PHP_EOL;
  //return the response object
  $res = RespuestaConsultaDE::fromResponse($responseXML);
  echo $res->printData();
  if (isset($responseXML->xContenDE)) {
    file_put_contents($data['dCDC'] . '_dE.xml', $responseXML->xContenDE);
    echo "xml generado";
  }
  
} catch (SoapFault $e) {
  // Handle SOAP faults/errors
  echo 'SOAP Error: ' . $e->getMessage();
} catch (Exception $e) {
  // Handle general exceptions
  echo 'Error: ' . $e->getMessage();
}
