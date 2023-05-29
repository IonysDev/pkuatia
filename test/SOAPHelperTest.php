<?php
require '../vendor/autoload.php'; // Include the Composer autoloader

use Abiliomp\Pkuatia\SoapSSLClient;

error_reporting(E_ALL);
ini_set('display_errors', 1);

$wsdlUrl = 'https://sifen-test.set.gov.py/de/ws/consultas/consulta-ruc.wsdl?wsdl';
$certFile = '80121930-2.cert.pem';
$keyFile = '80121930-2.key.pem';
$keyPassphrase = '171222';


$xml = '<rEnviConsRUC xmlns="http://ekuatia.set.gov.py/sifen/xsd"><dId>552</dId><dRUCCons>80057292</dRUCCons></rEnviConsRUC>';


try {
    // Create SOAP client
    echo 'Creating SOAP client...';
    SoapSSLClient::init($wsdlUrl, $certFile, $keyFile, $keyPassphrase);
    echo 'done' . PHP_EOL;

    echo var_dump(SoapSSLClient::$client->__getFunctions());
    
    $params = new SoapVar($xml, XSD_ANYXML);

    $resposeXml = SoapSSLClient::$client->rEnviConsRUC($params);
    
    echo "\n\nRequest: \n";
    echo SoapSSLClient::$client->__getLastRequest();

    echo "\n\nResponse: \n";
    echo var_dump($resposeXml);
} catch (SoapFault $e) {
    // Handle SOAP faults/errors
    echo 'SOAP Error: ' . $e->getMessage();
} catch (Exception $e) {
    // Handle general exceptions
    echo 'Error: ' . $e->getMessage();
}
