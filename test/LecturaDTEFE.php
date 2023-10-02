<?php

use Abiliomp\Pkuatia\Core\Fields\DE\AA\RDE;

require '../vendor/autoload.php'; // Include the Composer autoloader

try {
    $xml = file_get_contents('testDTE.xml');    
    $xmlDoc = new DOMDocument();
    $xmlDoc->loadXML($xml);
    $rde = RDE::FromDOMElement($xmlDoc->documentElement);
    echo json_encode($rde, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    // Handle general exceptions
    echo 'Error: ' . $e->getMessage();
}
