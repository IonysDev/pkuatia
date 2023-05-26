<?php

use Abiliomp\Pkuatia\Helpers\SOAPHelper;

require '../vendor/autoload.php'; 
$xmlFile = $argv[1];
$wsdlUrl = "https://sifen-test.set.gov.py/de/ws/consultas/consulta-ruc.wsdl?wsdl";
 $pemFile = dirname(__FILE__) . '\80121930-2.pem';
$passphrase = '171222';
$action = "siConsRUC";
$envelopedXML = SOAPHelper::soapEnvelop($xmlFile);

$options = [
    'trace' => 1,
    'soap_version' => SOAP_1_2,
    'cache_wsdl' => WSDL_CACHE_NONE,
    'local_cert' => $pemFile,
    'passphrase' => $passphrase,
    'stream_context' => stream_context_create([
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true,
        ]
    ])
];
$client = new SoapClient($wsdlUrl, $options);
$response = $client->__doRequest($envelopedXML, $wsdlUrl, $action, SOAP_1_2);
echo $response;
?>