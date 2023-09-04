<?php

require '../vendor/autoload.php'; // Include the Composer autoloader

use Abiliomp\Pkuatia\Core\Config;
use Abiliomp\Pkuatia\Sifen;

error_reporting(E_ALL);
ini_set('display_errors', 1);
$certFile = '80121930-2.pem.crt';
$keyFile = '80121930-2.pem.key';
$keyPassphrase = '171222';

$config = new Config();
$config->env = 'env';
$config->certificateFilePath = $certFile;
$config->privateKeyFilePath = $keyFile;
$config->privateKeyPassphrase = $keyPassphrase;

$testCDC = '01800090853013001001802422023052910014652161';
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
    if($res->getRContDe())
        var_dump($res->getRContDe()->getRDe());
    else
        var_dump($res);

} catch (SoapFault $e) {
    // Handle SOAP faults/errors
    echo 'SOAP Error: ' . $e->getMessage();
} catch (Exception $e) {
    // Handle general exceptions
    echo 'Error: ' . $e->getMessage();
}
