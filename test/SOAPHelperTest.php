<?php

use Abiliomp\Pkuatia\Helpers\SOAPHelper;

require '../vendor/autoload.php'; 
$xmlFile = $argv[1];
$wsdlUrl = "https://sifen-test.set.gov.py/de/ws/consultas/consulta-ruc.wsdl?wsdl";
$pemFile = "/80121930-2.pem";
$passphrase = "179220";
$action = "siConsRUC";
$envelopedXML = SOAPHelper::soapEnvelop($xmlFile);
$options = [
    'trace' => 1,
    'soap_version' => SOAP_1_2,
    'local_cert' => $pemFile,
    'passphrase' => $passphrase,
];
$client = new SoapClient($wsdlUrl, $options);
$response = $client->__doRequest($envelopedXML, $wsdlUrl, $action, SOAP_1_2);
echo $response;
?>

