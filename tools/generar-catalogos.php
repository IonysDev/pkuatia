<?php
/**
 * Regenera los catálogos de src/Resources/codigos/ desde ekuat-ia (Fase C, paso C5).
 *
 * Uso: php tools/generar-catalogos.php [--docs=<ruta al clon de ekuat-ia>]   (por defecto docs/sifen-ai)
 *
 * Cuándo correrlo: cada vez que cambien 08-errores-y-respuestas/*.md, 03-estructura-xml/campos-obligatorios.md o
 * 00-fuentes/xsd/DE_v150.xsd en ekuat-ia. tests/Unit/Resources/CatalogosSincroniaTest.php detecta la diferencia.
 */
require_once __DIR__ . '/GeneradorCatalogos.php';

$docs = __DIR__ . '/../docs/sifen-ai';
foreach (array_slice($argv, 1) as $arg) {
  if (str_starts_with($arg, '--docs='))
    $docs = substr($arg, 7);
}
if (!is_dir("$docs/08-errores-y-respuestas")) {
  fwrite(STDERR, "No se encontró el clon de ekuat-ia en $docs (usar --docs=<ruta>).\n");
  exit(1);
}
$commit = trim((string) @shell_exec('git -C ' . escapeshellarg($docs) . ' rev-parse --short HEAD 2>&1'));
if (!preg_match('/^[0-9a-f]{7,40}$/', $commit))
  $commit = '';
$destino = __DIR__ . '/../src/Resources/codigos';
if (!is_dir($destino))
  mkdir($destino, 0777, true);

$catalogos = GeneradorCatalogos::generarTodo($docs);
foreach ($catalogos as $nombre => $datos) {
  $encabezado = $datos['origen'] . ($commit !== '' ? "\nekuat-ia @ $commit" : '');
  GeneradorCatalogos::escribir("$destino/$nombre.php", $datos, $encabezado);
  $cantidad = isset($datos['entradas']) ? count($datos['entradas']) : count($datos['elementos']) . ' elementos, ' . count($datos['tipos']) . ' tipos';
  echo str_pad("$nombre.php", 24) . " $cantidad\n";
}
