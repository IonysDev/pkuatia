<?php
require '../vendor/autoload.php'; // Include the Composer autoloader

use Abiliomp\Pkuatia\Core\Fields\Response\Ruc\TxContRuc;
use Abiliomp\Pkuatia\SoapSSLClient;

error_reporting(E_ALL);
ini_set('display_errors', 1);

$wsdlUrl = 'https://sifen.set.gov.py/de/ws/consultas/consulta-ruc.wsdl?wsdl';
$certFile = '80121930-2.cert.pem';
$keyFile = '80121930-2.key.pem';
$keyPassphrase = '171222';
$operation = 'rEnviConsRUC';
$tagName = "<".$operation."></".$operation.">";

// $xml = '<rEnviConsRUC xmlns="http://ekuatia.set.gov.py/sifen/xsd"><dId>552</dId><dRUCCons>80057292</dRUCCons></rEnviConsRUC>';

$xmlr = new SimpleXMLElement($tagName);
$xmlr->addAttribute('xmlns', 'http://ekuatia.set.gov.py/sifen/xsd');
$xmlr->addChild('dId', '552');
$xmlr->addChild('dRUCCons', '80057292');

try {
    // Create SOAP client
    echo 'Creating SOAP client...';
    SoapSSLClient::init($wsdlUrl, $certFile, $keyFile, $keyPassphrase);
    echo 'done' . PHP_EOL;

    // echo var_dump(SoapSSLClient::$client->__getFunctions());

    $params = new SoapVar($xmlr->asXML(), XSD_ANYXML);

    $responseXML = SoapSSLClient::$client->rEnviConsRUC($xmlr);

    // echo "\n\nRequest: \n";
    // echo SoapSSLClient::$client->__getLastRequest();

    echo "\n\nResponse: \n";
    // echo var_dump($responseXML);

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
