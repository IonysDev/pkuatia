<?php

require '../vendor/autoload.php';

use IonysDev\Pkuatia\Core\Config;
use IonysDev\Pkuatia\Sifen;

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Leer los argumentos --cert, --key --pass --lot --prod (opcional) de la línea de comandos
$shortopts = '';
$longopts = array(
    'cert:',
    'key:',
    'pass:',
    'lot:'
);
$options = getopt($shortopts, $longopts);
if (!isset($options['cert']) || !isset($options['key']) || !isset($options['pass']) || !isset($options['lot'])) {
    echo "Uso: php ConsultaLote.php [--prod] --cert=<certFile> --key=<keyFile> --pass=<keyPassphrase> --lot=<lote>\n";
    exit(1);
}

$certFile = $options['cert'];
$keyFile = $options['key'];
$keyPassphrase = $options['pass'];
$nroLote = $options['lot'];

$config = new Config();
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
    echo "Consultando el lote " . $nroLote . "...\n";
    echo "Hora de consulta: " . $requestDate . "\n";
    $res = Sifen::consultaLote($nroLote);
    echo "Resultado: \n";
    echo json_encode($res, JSON_PRETTY_PRINT);
} catch (SoapFault $e) {
    // Handle SOAP faults/errors
    echo 'SOAP Error: ' . $e->getMessage();
} catch (Exception $e) {
    // Handle general exceptions
    echo 'Error: ' . $e->getMessage();
}