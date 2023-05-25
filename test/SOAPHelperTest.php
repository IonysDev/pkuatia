<?php

use Abiliomp\Pkuatia\Helpers\SOAPHelper;

require '../vendor/autoload.php'; // Include the Composer autoloader

/// Obtener el xml
$xmlFile = $argv[1];
$local_cert = $argv[2];
$local_pk = $argv[3];

// $url ="https://www.w3schools.com/xml/tempconvert.asmx?WSDL";
$url = "https://sifen-test.set.gov.py/de/ws/consultas/consulta-ruc.wsdl?wsdl";
$passphrase = "171222";

if (!file_exists($xmlFile)) {
    echo "El archivo  no existe\n";
    return false;
}

if (!file_exists($local_cert)) {
    echo "El archivo  no existe\n";
    return false;
}

if (!file_exists($local_pk)) {
    echo "El archivo  no existe\n";
    return false;
}

$options = array(
    'soap_version' => SOAP_1_2,
    'use' => SOAP_DOCUMENT,
    'exceptions' => true,
    'trace' => true,
    'cache_wsdl' => WSDL_CACHE_NONE,
    'stream_context' => stream_context_create(array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true,
            'local_cert' => $local_cert,
            'local_pk' => $local_pk,
            'passphrase' => $passphrase,
        ),
    )),
);

// //////////////////////////////////////////////////SOAPCLIENT//////////////////////////////////////
try {

    $client = new SoapClient($url, $options);

    $xml_envelope = SOAPHelper::soapEnvelop($xmlFile);
    echo $xml_envelope;
    try {
        $result = $client->__doRequest($xml_envelope, $url, 'siConsRUC', SOAP_1_2, 0);
        if ($result) {
            file_put_contents('response.xml', $result);
            echo "Se ha creado el archivo response.xml\n";
            return $result;
        } else {
            return false;
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        return $e;
    }
} catch (Exception $e) {
    echo nl2br("\n");
    echo $e->getMessage();
}
//////////////////////////////////////////////////SOAPCLIENT//////////////////////////////////////
