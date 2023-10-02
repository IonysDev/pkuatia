<?php
require '../vendor/autoload.php'; // Include the Composer autoloader

$str = "nVersion=150&Id=01800075307001001000000122023092915964182162&dFeEmiDE=323032332d30392d32395430373a30313a3237&dRucRec=80059725&dTotGralOpe=28819032&dTotIVA=2619912&cItems=2&DigestValue=726235737067442f445949656c756d6f2b79682b6a33616f3174734e623473494b4a6b7230486d513776593d&IdCSC=0001c8a20C961d46Efd59b2Fed09A15e114";
echo "String: " . $str . "\n";
$givenHash = "490c2d3d658c73aa3abb4be994452d7a5da2dc58961e89dcf74edc5337b8ce75";
$calculatedHash = hash('sha256', $str);
$comparison = strcmp($givenHash, $calculatedHash);

echo "\nString: " . $str . "\n";
echo "Given Hash: " . $givenHash . "\n";
echo "Calc. Hash: " . $calculatedHash . "\n";
echo "Comparison: " . $comparison . "\n";