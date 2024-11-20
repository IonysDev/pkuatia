<?php

require '../vendor/autoload.php'; // Include the Composer autoloader

use IonysDev\Pkuatia\Utils\ValueValidations;

$values = [
    '13245.222', // true
    '0x25551', // false
    '12225', // false
    '122256', // false
    '1234567890123456.5555', // false
    '123456789.12345678', // true
    '123456789,123456789' // false
];

foreach ($values as $key => $value) {
    $isValid = ValueValidations::isValidStringDecimal($value, 10, 1, 8);
    echo $value . ' is ' . ($isValid ? 'valid' : 'invalid') . PHP_EOL;
}

?>