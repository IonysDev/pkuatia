<?php

/**
 * Anonimiza una carpeta de capturas SOAP reales del SIFEN para archivarlas en el repositorio (Fase D, 0.3.1).
 *
 * Uso: php tools/anonimizar-capturas.php --dir=<capturas> --out=<destino> --mapa=<mapa.json>
 *
 * El mapa (valores reales → ficticios) vive FUERA del repositorio; anonimizar-capturas.mapa.ejemplo.json muestra su
 * forma con valores inventados. No requiere certificado ni red. Sale con 1 si algún archivo conserva una cadena
 * sensible del mapa. Ver AnonimizadorCapturas.php y CONTRIBUTING.md ("Capturas reales del SIFEN").
 */

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/AnonimizadorCapturas.php';

$opciones = getopt('', ['dir:', 'out:', 'mapa:']);
if (!isset($opciones['dir'], $opciones['out'], $opciones['mapa'])) {
    fwrite(STDERR, "Uso: php tools/anonimizar-capturas.php --dir=<capturas> --out=<destino> --mapa=<mapa.json>\n");
    exit(2);
}
try {
    $anonimizador = AnonimizadorCapturas::desdeJson((string) $opciones['mapa']);
    $resultado = $anonimizador->procesarCarpeta(rtrim((string) $opciones['dir'], '/\\'), rtrim((string) $opciones['out'], '/\\'));
} catch (Throwable $e) {
    fwrite(STDERR, $e->getMessage() . "\n");
    exit(2);
}
$conSensibles = 0;
foreach ($resultado as $archivo => $sensibles) {
    if ($sensibles) {
        $conSensibles++;
        fwrite(STDERR, "ATENCION: en $archivo siguen presentes: " . implode(', ', $sensibles) . "\n");
    } else {
        echo "OK $archivo\n";
    }
}
echo "CDC mapeados: " . json_encode($anonimizador->getMapaCdc(), JSON_UNESCAPED_SLASHES) . "\n";
exit($conSensibles > 0 ? 1 : 0);
