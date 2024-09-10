<?php

require '../vendor/autoload.php'; // Include the Composer autoloader

use Abiliomp\Pkuatia\Core\Config;
use Abiliomp\Pkuatia\Sifen;

error_reporting(E_ALL);
ini_set('display_errors', 1);
$certFile = '80121930-2.pem.crt';
$keyFile = '80121930-2.pem.key';
$keyPassphrase = '801219';

$config = new Config();
$config->env = 'dev';
$config->certificateFilePath = $certFile;
$config->privateKeyFilePath = $keyFile;
$config->privateKeyPassphrase = $keyPassphrase;

$testRuc = '80057292';
$requestDate = new DateTime('now', new DateTimeZone('America/Asuncion'));
//cast to string to avoid DateTime serialization error
$requestDate = (string) $requestDate->format('d/m/Y H:i:s');

try {
    echo "Prueba de Consulta de RUC\n";
    echo "Inicializando Sifen... ";
    Sifen::Init($config);
    echo "OK\n";
    echo "Consultando RUC " . $testRuc . "...\n";
    echo "Hora de consulta: " . $requestDate . "\n";
    $res = Sifen::ConsultarRUC($testRuc);
    echo "Resultado: \n";
    echo json_encode($res, JSON_PRETTY_PRINT);
} catch (SoapFault $e) {
    // Handle SOAP faults/errors
    echo 'SOAP Error: ' . $e->getMessage();
} catch (Exception $e) {
    // Handle general exceptions
    echo 'Error: ' . $e->getMessage();
}
