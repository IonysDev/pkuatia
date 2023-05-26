<?php
require '../vendor/autoload.php'; // Include the Composer autoloader

use Abiliomp\Pkuatia\Helpers\SOAPHelper;

error_reporting(E_ALL);
ini_set('display_errors', 1);

/// Obtener el xml
$xmlFile = "signed_rucTest.xml";
$xmlRequest = file_get_contents($xmlFile);

$wsdlUrl = 'https://sifen-test.set.gov.py/de/ws/consultas/consulta-ruc.wsdl?wsdl';
$certFile = '80121930-2.cert.pem';
$keyFile = '80121930-2.key.pem';
$keyPassphrase = '171222';

// SSL options
$sslOptions = [
    'local_cert' => $certFile,
    'local_pk' => $keyFile,
    'passphrase' => $keyPassphrase,
    'verify_peer' => true,
    'verify_peer_name' => true,
    'allow_self_signed' => false,
];
$streamContext = stream_context_create(['ssl' => $sslOptions]);

// SOAP client options
$clientOptions = [
    'trace' => true, // Enable request/response tracing
    'exceptions' => true, // Enable exceptions for SOAP errors
    'stream_context' => $streamContext,
    // Add any additional client options as needed
];
echo json_encode($clientOptions, JSON_PRETTY_PRINT);

try {
    // Create SOAP client
    echo 'Creating SOAP client...';
    $client = new SoapClient($wsdlUrl, $clientOptions);
    echo 'done' . PHP_EOL;    
    //$xmlRequest = SOAPHelper::soapEnvelop($xmlRequest);
    echo "\n\nRequest: \n";
    echo $xmlRequest;
    $resposeXml = $client->__doRequest($xmlRequest, $wsdlUrl, 'rEnviConsRUC', SOAP_1_2);
    echo "\n\nResponse: \n";
    echo $resposeXml;
} catch (SoapFault $e) {
    // Handle SOAP faults/errors
    echo 'SOAP Error: ' . $e->getMessage();
} catch (Exception $e) {
    // Handle general exceptions
    echo 'Error: ' . $e->getMessage();
}
