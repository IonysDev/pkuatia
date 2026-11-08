<?php

/**
 * Comprueba la cobertura de líneas de un informe Clover de PHPUnit contra un umbral (Fase D, D11; lo usa el CI).
 *
 * Uso: php tools/cobertura-minima.php <clover.xml> <umbral-porcentaje>
 * Sale con 0 si la cobertura de líneas del proyecto es mayor o igual al umbral; con 1 si es menor; con 2 si el
 * archivo no existe o no tiene la métrica. Imprime siempre el porcentaje medido.
 */

if ($argc < 3) {
    fwrite(STDERR, "Uso: php tools/cobertura-minima.php <clover.xml> <umbral-porcentaje>\n");
    exit(2);
}
[, $archivo, $umbral] = $argv;
if (!is_file($archivo)) {
    fwrite(STDERR, "No existe el informe $archivo\n");
    exit(2);
}
$xml = simplexml_load_file($archivo, 'SimpleXMLElement', LIBXML_NONET);
if ($xml === false) {
    fwrite(STDERR, "No se pudo leer $archivo\n");
    exit(2);
}
$metricas = $xml->xpath('/coverage/project/metrics');
if (!$metricas) {
    fwrite(STDERR, "El informe no tiene /coverage/project/metrics\n");
    exit(2);
}
$m = $metricas[0];
$total = (int) $m['statements'];
$cubiertas = (int) $m['coveredstatements'];
if ($total === 0) {
    fwrite(STDERR, "El informe no cuenta sentencias\n");
    exit(2);
}
$porcentaje = $cubiertas * 100 / $total;
printf("Cobertura de líneas: %.2f %% (%d de %d sentencias); umbral %s %%\n", $porcentaje, $cubiertas, $total, $umbral);
exit($porcentaje + 1e-9 >= (float) $umbral ? 0 : 1);
