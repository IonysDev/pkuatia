<?php

require '../vendor/autoload.php';

use IonysDev\Pkuatia\Core\Fields\DE\G\GCamCarg;

error_reporting(E_ALL);
ini_set('display_errors', 1);

$failures = 0;

function assertEq($expected, $actual, string $msg): void
{
    global $failures;
    if ($expected === $actual) {
        echo "  OK  $msg\n";
    } else {
        $failures++;
        echo "  FAIL $msg\n";
        echo "       expected: " . var_export($expected, true) . "\n";
        echo "       actual:   " . var_export($actual, true) . "\n";
    }
}

function makeGCamCargWithInts(): GCamCarg
{
    // Setea los ints directamente (los setters dependen de UnidadMedidaMapping
    // y mezclarian su auto-poblado de strings con los casos de test).
    $g = new GCamCarg();
    $g->cUniMedTotVol = 87;
    $g->dTotVolMerc   = 100;
    $g->cUniMedTotPes = 99;
    $g->dTotPesMerc   = 50;
    $g->iCarCarga     = 1;
    return $g;
}

function renderGCamCarg(GCamCarg $g): string
{
    $doc = new DOMDocument('1.0', 'UTF-8');
    $doc->appendChild($g->toDOMElement($doc));
    return $doc->saveXML($doc->documentElement);
}

echo "Caso 1: sin strings opcionales\n";
$g = makeGCamCargWithInts();
$xml = renderGCamCarg($g);
assertEq(true, strpos($xml, '<dDesUniMedTotVol') === false, 'dDesUniMedTotVol omitido');
assertEq(true, strpos($xml, '<dDesUniMedTotPes') === false, 'dDesUniMedTotPes omitido');
assertEq(true, strpos($xml, '<dDesCarCarga')    === false, 'dDesCarCarga omitido');

echo "Caso 2: solo dDesUniMedTotVol\n";
$g = makeGCamCargWithInts();
$g->setDDesUniMedTotVol('m3');
$xml = renderGCamCarg($g);
assertEq(true, strpos($xml, '<dDesUniMedTotVol>m3</dDesUniMedTotVol>') !== false, 'dDesUniMedTotVol presente');
assertEq(true, strpos($xml, '<dDesUniMedTotPes') === false, 'dDesUniMedTotPes omitido');
assertEq(true, strpos($xml, '<dDesCarCarga')    === false, 'dDesCarCarga omitido');

echo "Caso 3: solo dDesUniMedTotPes\n";
$g = makeGCamCargWithInts();
$g->setDDesUniMedTotPes('KG');
$xml = renderGCamCarg($g);
assertEq(true, strpos($xml, '<dDesUniMedTotVol') === false, 'dDesUniMedTotVol omitido');
assertEq(true, strpos($xml, '<dDesUniMedTotPes>KG</dDesUniMedTotPes>') !== false, 'dDesUniMedTotPes presente con descripcion real, no codigo');
assertEq(true, strpos($xml, '<dDesCarCarga')    === false, 'dDesCarCarga omitido');

echo "Caso 4: solo dDesCarCarga\n";
$g = makeGCamCargWithInts();
$g->setDDesCarCarga('Mercaderias con cadena de frio');
$xml = renderGCamCarg($g);
assertEq(true, strpos($xml, '<dDesUniMedTotVol') === false, 'dDesUniMedTotVol omitido');
assertEq(true, strpos($xml, '<dDesUniMedTotPes') === false, 'dDesUniMedTotPes omitido');
assertEq(true, strpos($xml, '<dDesCarCarga>Mercaderias con cadena de frio</dDesCarCarga>') !== false, 'dDesCarCarga presente');

echo "Caso 5: los tres juntos\n";
$g = makeGCamCargWithInts();
$g->setDDesUniMedTotVol('m3')
  ->setDDesUniMedTotPes('KG')
  ->setDDesCarCarga('Carga peligrosa');
$xml = renderGCamCarg($g);
assertEq(true, strpos($xml, '<dDesUniMedTotVol>m3</dDesUniMedTotVol>') !== false, 'dDesUniMedTotVol presente');
assertEq(true, strpos($xml, '<dDesUniMedTotPes>KG</dDesUniMedTotPes>') !== false, 'dDesUniMedTotPes presente');
assertEq(true, strpos($xml, '<dDesCarCarga>Carga peligrosa</dDesCarCarga>') !== false, 'dDesCarCarga presente');

echo "Caso 6: cUniMedTotVol ahora emite el codigo correcto (no copia de cUniMedTotPes)\n";
$g = makeGCamCargWithInts(); // cUniMedTotVol=87, cUniMedTotPes=99
$xml = renderGCamCarg($g);
assertEq(true, strpos($xml, '<cUniMedTotVol>87</cUniMedTotVol>') !== false, 'cUniMedTotVol emite 87 (su propio valor, no el de cUniMedTotPes)');
assertEq(true, strpos($xml, '<cUniMedTotPes>99</cUniMedTotPes>') !== false, 'cUniMedTotPes emite 99');

echo "Caso 7: truncado a maximos por spec\n";
$g = new GCamCarg();
$g->setDDesUniMedTotVol(str_repeat('A', 30)); // max 10
$g->setDDesUniMedTotPes(str_repeat('B', 30)); // max 10
$g->setDDesCarCarga(str_repeat('C', 80));     // max 50
assertEq(10, strlen($g->getDDesUniMedTotVol()), 'dDesUniMedTotVol truncado a 10');
assertEq(10, strlen($g->getdDesUniMedTotPes()), 'dDesUniMedTotPes truncado a 10');
assertEq(50, strlen($g->getDDesCarCarga()),    'dDesCarCarga truncado a 50');

echo "Caso 8: setter con vacio limpia el valor\n";
$g = new GCamCarg();
$g->setDDesCarCarga('algo');
$g->setDDesCarCarga('');
assertEq(null, $g->getDDesCarCarga(), 'dDesCarCarga vuelve a null');

echo "Caso 9: setter con null no rompe\n";
$g = new GCamCarg();
$g->setDDesUniMedTotVol(null);
$g->setDDesUniMedTotPes(null);
$g->setDDesCarCarga(null);
assertEq(null, $g->getDDesUniMedTotVol(),  'dDesUniMedTotVol sigue null');
assertEq(null, $g->getdDesUniMedTotPes(), 'dDesUniMedTotPes sigue null');
assertEq(null, $g->getDDesCarCarga(),     'dDesCarCarga sigue null');

echo "\n";
if ($failures === 0) {
    echo "Todos los casos OK\n";
    exit(0);
} else {
    echo "$failures fallo(s)\n";
    exit(1);
}
