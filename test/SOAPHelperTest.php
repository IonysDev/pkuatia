<?php
require '../vendor/autoload.php'; // Include the Composer autoloader

use Abiliomp\Pkuatia\Helpers\SOAPHelper;

/// Obtener el xml
$xmlFile = $argv[1];
$wsdl = 'https://sifen-test.set.gov.py/de/ws/consultas/consulta-ruc.wsdl?wsdl';

/// Enviar el xml al servidor
try{
  $client = new SoapClient($wsdl, array('trace' => 1, 'soap_version' => SOAP_1_2));
} catch (Exception $e) {
  echo $e->getMessage();
  echo PHP_EOL;
}
