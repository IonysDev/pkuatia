<?php
require '../vendor/autoload.php'; // Include the Composer autoloader

use Abiliomp\Pkuatia\Helpers\SOAPHelper;

/// Obtener el xml
$xmlFile = $argv[1];


$envelopedXML = SOAPHelper::soapEnvelop($xmlFile);

// Guardar el archivo XML enveloped
$envelopedXMLFile = 'enveloped_' . $xmlFile;

file_put_contents($envelopedXMLFile, $envelopedXML);

?>