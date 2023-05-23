<?php
require '../vendor/autoload.php'; // Include the Composer autoloader

use Abiliomp\Pkuatia\Helpers\SOAPHelper;

/// Obtener el xml
$xmlFile = $argv[1];


$test = SOAPHelper::soapEnvelop($xmlFile);

?>