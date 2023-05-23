<?php
require '../vendor/autoload.php'; // Include the Composer autoloader

use Abiliomp\Pkuatia\Helpers\SOAPHelper;

/// Obtener el xml
$xmlFile = $argv[1];
$wsdl = 'https://sifen-test.set.gov.py/de/ws/consultas/consulta-ruc.wsdl?wsdl';

$response = SOAPHelper::makeRequest($xmlFile, $wsdl);


// $envelopedXML = SOAPHelper::soapEnvelop($xmlFile);

// // Guardar el archivo XML enveloped
// $envelopedXMLFile = 'enveloped_' . $xmlFile;

// file_put_contents($envelopedXMLFile, $envelopedXML);

?>