<?php
require '../vendor/autoload.php'; // Include the Composer autoloader

use Abiliomp\Pkuatia\Core\Fields\Response\Ruc\TxContRuc;
use Abiliomp\Pkuatia\Helpers\RequestXMLHelper;
use Abiliomp\Pkuatia\SoapSSLClient;

error_reporting(E_ALL);
ini_set('display_errors', 1);

$wsdlUrl = 'https://sifen.set.gov.py/de/ws/consultas/consulta-ruc.wsdl?wsdl';
$certFile = '80121930-2.cert.pem';
$keyFile = '80121930-2.key.pem';
$keyPassphrase = '171222';
$operation = 'rEnviConsRUC';
$data = array(
    'dId' => '552',
    'dRUCCons' => '80057292'
);
// $xml = '<rEnviConsRUC xmlns="http://ekuatia.set.gov.py/sifen/xsd"><dId>552</dId><dRUCCons>80057292</dRUCCons></rEnviConsRUC>';

/// Create XML for request
$myXML =  RequestXMLHelper::makeFromArray($operation, $data);

try {
    // Create SOAP client
    echo 'Creating SOAP client...' . PHP_EOL;
    SoapSSLClient::init($wsdlUrl, $certFile, $keyFile, $keyPassphrase);
    echo 'done' . PHP_EOL;

    // // create a new soap request object
    //  $params = new SoapVar($myXML->asXML(), XSD_ANYXML);

    // make the soap call
    $responseXML = SoapSSLClient::$client->rEnviConsRUC($myXML);

    // echo "\n\nRequest: \n";
    echo SoapSSLClient::$client->__getLastRequest();

    echo "Respuesta:" . PHP_EOL;
    // echo var_dump($responseXML);

    //return the response object
    $responseObject = TxContRuc::fromResponse($responseXML);
    echo  $responseObject->getDRUCCons() . PHP_EOL;
    echo  $responseObject->getDRazCons() . PHP_EOL;
    echo  $responseObject->getDDesEstCons() . PHP_EOL;
    echo  $responseObject->getDRUCFactElecDesc() . PHP_EOL;
} catch (SoapFault $e) {
    // Handle SOAP faults/errors
    echo 'SOAP Error: ' . $e->getMessage();
} catch (Exception $e) {
    // Handle general exceptions
    echo 'Error: ' . $e->getMessage();
}
