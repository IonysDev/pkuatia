<?php

use Abiliomp\Pkuatia\Helpers\CountryHelper;
use Abiliomp\Pkuatia\Helpers\GeoRefHelper;
use Abiliomp\Pkuatia\Helpers\UMHelper;

require '../vendor/autoload.php'; // Include the Composer autoloader
error_reporting(E_ALL);
ini_set('display_errors', 1);

$code = "83";
CountryHelper::getArray();
?>