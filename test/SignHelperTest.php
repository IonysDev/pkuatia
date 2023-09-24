<?php
require '../vendor/autoload.php'; // Include the Composer autoloader

use Abiliomp\Pkuatia\Helpers\SignHelper;

// Obtener los nombres de archivo y contraseña del arreglo ARGS
$xmlFile = $argv[1];
$keyFile = $argv[2];
$password = $argv[3];
$certificateFile = $argv[4];

// Inicializar la clase SignHelper
SignHelper::initFromFile($keyFile, $password, $certificateFile);

// Leer el archivo XML
$xml = file_get_contents($xmlFile);

// Firmar el archivo XML
$signedXml = SignHelper::sign($xml, '#143243223443243242343232465');

// Guardar el archivo XML firmado
$signedXmlFile = 'signed_' . $xmlFile;
file_put_contents($signedXmlFile, $signedXml);

?>