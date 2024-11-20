<?php

require '../vendor/autoload.php';

use IonysDev\Pkuatia\Core\Config;
use IonysDev\Pkuatia\Sifen;

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Leer los argumentos --cert, --key --pass --cdc --prod (opcional) de la línea de comandos
$shortopts = '';
$longopts = array(
    'cert:',
    'key:',
    'pass:',
    'cdc:'
);
$options = getopt($shortopts, $longopts);
if (!isset($options['cert']) || !isset($options['key']) || !isset($options['pass']) || !isset($options['cdc'])) {
    echo "Uso: php ConsultaDE.php [--prod] --cert=<certFile> --key=<keyFile> --pass=<keyPassphrase> --cdc=<cdc>\n";
    exit(1);
}

$certFile = $options['cert'];
$keyFile = $options['key'];
$keyPassphrase = $options['pass'];
$testCDC = $options['cdc'];

$config = new Config();

// Si se especifica --prod, se usará el ambiente de producción
$config->env = isset($options['prod']) ? Config::ENV_PROD : Config::ENV_DEV;
$config->certificateFilePath = $certFile;
$config->privateKeyFilePath = $keyFile;
$config->privateKeyPassphrase = $keyPassphrase;

$requestDate = new DateTime('now', new DateTimeZone('America/Asuncion'));
//cast to string to avoid DateTime serialization error
$requestDate = (string) $requestDate->format('d/m/Y H:i:s');
try {
    echo "Prueba de Consulta de DE\n";
    echo "Inicializando Sifen... ";
    Sifen::Init($config);
    echo "OK\n";
    echo "Consultando DE con CDC " . $testCDC . "...\n";
    echo "Hora de consulta: " . $requestDate . "\n";
    $res = Sifen::ConsultarDE($testCDC);
    echo "Resultado: \n";
    $res->showData();
} catch (SoapFault $e) {
    // Handle SOAP faults/errors
    echo 'SOAP Error: ' . $e->getMessage();
} catch (Exception $e) {
    // Handle general exceptions
    echo 'Error: ' . $e->getMessage();
}
