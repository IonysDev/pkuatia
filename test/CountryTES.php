<?php

use Abiliomp\Pkuatia\Helpers\CountryHelper;

require '../vendor/autoload.php'; // Include the Composer autoloader
error_reporting(E_ALL);
ini_set('display_errors', 1);

$country = 'ARG';
$countryDesc = CountryHelper::getCountryDesc($country);
echo $countryDesc;


?>