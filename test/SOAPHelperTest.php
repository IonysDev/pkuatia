<?php
require '../vendor/autoload.php'; // Include the Composer autoloader

use Abiliomp\Pkuatia\SoapSSLClient;

error_reporting(E_ALL);
ini_set('display_errors', 1);

/// Obtener el xml
$xmlFile = "signed_rucTest.xml";
$xmlRequest = file_get_contents($xmlFile);

$wsdlUrl = 'https://sifen-test.set.gov.py/de/ws/consultas/consulta-ruc.wsdl?wsdl';
$certFile = '80121930-2.cert.pem';
$keyFile = '80121930-2.key.pem';
$keyPassphrase = '171222';

try {
    // Create SOAP client
    echo 'Creating SOAP client...';
    SoapSSLClient::init($wsdlUrl, $certFile, $keyFile, $keyPassphrase);
    echo 'done' . PHP_EOL;    
    //$xmlRequest = SOAPHelper::soapEnvelop($xmlRequest);
    echo "\n\nRequest: \n";
    echo $xmlRequest;
    $resposeXml = SoapSSLClient::$client->__doRequest($xmlRequest, $wsdlUrl, 'rEnviConsRUC', SOAP_1_2);
    echo "\n\nResponse: \n";
    echo $resposeXml;
} catch (SoapFault $e) {
    // Handle SOAP faults/errors
    echo 'SOAP Error: ' . $e->getMessage();
} catch (Exception $e) {
    // Handle general exceptions
    echo 'Error: ' . $e->getMessage();
}
