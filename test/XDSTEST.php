<?php

use Abiliomp\Pkuatia\Helpers\CountryHelper;
use Abiliomp\Pkuatia\Helpers\CurrencyHelper;
use Abiliomp\Pkuatia\Helpers\DepartamentoHelper;
use Abiliomp\Pkuatia\Helpers\GeoRefCodesHelper;
use Abiliomp\Pkuatia\Helpers\UMHelper;

require '../vendor/autoload.php'; // Include the Composer autoloader
error_reporting(E_ALL);
ini_set('display_errors', 1);
$country = CountryHelper::getCountryDesc('PRY');
echo $country . PHP_EOL;
$medidad = UMHelper::getUMDesc('79');
echo $medidad . PHP_EOL;
$moneda = CurrencyHelper::getCurrDesc('usd');
echo $moneda . PHP_EOL;
$depto = DepartamentoHelper::getDepName('1');
echo $depto . PHP_EOL;
$dist = GeoRefCodesHelper::getDistName('1');
echo $dist . PHP_EOL;
$ciudad = GeoRefCodesHelper::getCiudName('1');
echo $ciudad . PHP_EOL;
$barrio = GeoRefCodesHelper::getBarrName('1');
echo $barrio . PHP_EOL;
?>