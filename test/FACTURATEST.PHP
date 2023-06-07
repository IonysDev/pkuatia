<?php
require '../vendor/autoload.php'; // Include the Composer autoloader

use Abiliomp\Pkuatia\Config;
use Abiliomp\Pkuatia\Core\DocumentoElectronico;
use Abiliomp\Pkuatia\Core\Factura;

error_reporting(E_ALL);
ini_set('display_errors', 1);

$factura = new Factura();

var_dump($factura);