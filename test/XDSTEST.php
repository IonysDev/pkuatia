<?php

use Abiliomp\Pkuatia\Helpers\CountryHelper;
use Abiliomp\Pkuatia\Helpers\CurrencyHelper;
use Abiliomp\Pkuatia\Helpers\GeoRefHelper;
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
$dep = GeoRefHelper::getDepName('1');
echo $dep . PHP_EOL;
$dist = GeoRefHelper::getDistName('1');
echo $dist . PHP_EOL;
$cuidad = GeoRefHelper::getCiuName('1');
echo $cuidad . PHP_EOL;
?>