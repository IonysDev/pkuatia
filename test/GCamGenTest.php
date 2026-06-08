<?php

require '../vendor/autoload.php';

use IonysDev\Pkuatia\Core\Fields\DE\G\GCamGen;

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

function renderGCamGen(GCamGen $g): string
{
    $doc = new DOMDocument('1.0', 'UTF-8');
    $doc->appendChild($g->toDOMElement($doc));
    return $doc->saveXML($doc->documentElement);
}

echo "Caso 1: ninguno seteado\n";
$g = new GCamGen();
$xml = renderGCamGen($g);
assertEq(true, strpos($xml, '<dOrdCompra') === false, 'dOrdCompra omitido');
assertEq(true, strpos($xml, '<dOrdVta')    === false, 'dOrdVta omitido');
assertEq(true, strpos($xml, '<dAsiento')   === false, 'dAsiento omitido');
assertEq('<gCamGen/>', $xml, 'gCamGen vacio se serializa autocerrado');

echo "Caso 2: solo dOrdCompra\n";
$g = new GCamGen();
$g->setDOrdCompra('PO-123');
$xml = renderGCamGen($g);
assertEq(true, strpos($xml, '<dOrdCompra>PO-123</dOrdCompra>') !== false, 'dOrdCompra presente');
assertEq(true, strpos($xml, '<dOrdVta')    === false, 'dOrdVta omitido');
assertEq(true, strpos($xml, '<dAsiento')   === false, 'dAsiento omitido');

echo "Caso 3: solo dOrdVta\n";
$g = new GCamGen();
$g->setDOrdVta('SO-456');
$xml = renderGCamGen($g);
assertEq(true, strpos($xml, '<dOrdCompra') === false, 'dOrdCompra omitido');
assertEq(true, strpos($xml, '<dOrdVta>SO-456</dOrdVta>') !== false, 'dOrdVta presente');
assertEq(true, strpos($xml, '<dAsiento')   === false, 'dAsiento omitido');

echo "Caso 4: solo dAsiento\n";
$g = new GCamGen();
$g->setDAsiento('AS-789');
$xml = renderGCamGen($g);
assertEq(true, strpos($xml, '<dOrdCompra') === false, 'dOrdCompra omitido');
assertEq(true, strpos($xml, '<dOrdVta')    === false, 'dOrdVta omitido');
assertEq(true, strpos($xml, '<dAsiento>AS-789</dAsiento>') !== false, 'dAsiento presente');

echo "Caso 5: los tres juntos\n";
$g = new GCamGen();
$g->setDOrdCompra('PO-1')->setDOrdVta('SO-2')->setDAsiento('AS-3');
$xml = renderGCamGen($g);
assertEq(true, strpos($xml, '<dOrdCompra>PO-1</dOrdCompra>') !== false, 'dOrdCompra presente');
assertEq(true, strpos($xml, '<dOrdVta>SO-2</dOrdVta>')       !== false, 'dOrdVta presente');
assertEq(true, strpos($xml, '<dAsiento>AS-3</dAsiento>')     !== false, 'dAsiento presente');

echo "Caso 6: truncado a maximos por spec\n";
$g = new GCamGen();
$g->setDOrdCompra(str_repeat('A', 30)); // max 15
$g->setDOrdVta(str_repeat('B', 30));    // max 15
$g->setDAsiento(str_repeat('C', 30));   // max 10
assertEq(15, strlen($g->getDOrdCompra()), 'dOrdCompra truncado a 15');
assertEq(15, strlen($g->getDOrdVta()),    'dOrdVta truncado a 15');
assertEq(10, strlen($g->getDAsiento()),   'dAsiento truncado a 10');

echo "Caso 7: setter con vacio limpia el valor\n";
$g = new GCamGen();
$g->setDOrdCompra('PO-123');
$g->setDOrdCompra('');
assertEq(null, $g->getDOrdCompra(), 'dOrdCompra vuelve a null al setear vacio');

echo "Caso 8: setter con null no rompe\n";
$g = new GCamGen();
$g->setDOrdVta(null);
$g->setDAsiento(null);
assertEq(null, $g->getDOrdVta(),  'dOrdVta sigue null');
assertEq(null, $g->getDAsiento(), 'dAsiento sigue null');

echo "\n";
if ($failures === 0) {
    echo "Todos los casos OK\n";
    exit(0);
} else {
    echo "$failures fallo(s)\n";
    exit(1);
}
