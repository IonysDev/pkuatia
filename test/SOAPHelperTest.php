<?php

use Abiliomp\Pkuatia\Helpers\SOAPHelper;

require '../vendor/autoload.php'; // Include the Composer autoloader

/// Obtener el xml
$xmlFile = $argv[1];


// $url ="https://www.w3schools.com/xml/tempconvert.asmx?WSDL";
$url = "https://sifen-test.set.gov.py/de/ws/consultas/consulta-ruc.wsdl?wsdl";
$passphrase = "120108";
$local_cert = "test\80121930-2.pem";

$options = array(
    'soap_version' => SOAP_1_2,
    'trace' => 1,
    'exceptions' => 0,
    'local_cert' => $local_cert,
    'passphrase' => $passphrase,
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
