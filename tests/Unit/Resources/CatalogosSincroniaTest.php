<?php

namespace IonysDev\Pkuatia\Tests\Unit\Resources;

use PHPUnit\Framework\TestCase;

/**
 * Los catálogos de src/Resources/codigos/ se generan desde ekuat-ia con tools/generar-catalogos.php. Esta prueba
 * los regenera en memoria desde docs/sifen-ai y compara los datos con los versionados, como XsdResourcesTest hace
 * con los XSD. Sin docs/sifen-ai (p. ej. en CI) se omite: la carpeta es local y está excluida del repositorio.
 */
final class CatalogosSincroniaTest extends TestCase
{
  private const DOCS = __DIR__ . '/../../../docs/sifen-ai';
  private const CODIGOS = __DIR__ . '/../../../src/Resources/codigos';
  private const GENERADOR = __DIR__ . '/../../../tools/GeneradorCatalogos.php';

  protected function setUp(): void
  {
    if (!is_dir(self::DOCS . '/08-errores-y-respuestas')) {
      $this->markTestSkipped('docs/sifen-ai no está disponible en este entorno.');
    }
    require_once self::GENERADOR;
  }

  public function testLosCatalogosVersionadosCoincidenConEkuatIa(): void
  {
    $generados = \GeneradorCatalogos::generarTodo(self::DOCS);
    foreach ($generados as $nombre => $datos) {
      $versionado = require self::CODIGOS . "/$nombre.php";
      $this->assertSame($datos, $versionado, "$nombre.php difiere de lo generado desde docs/sifen-ai: correr php tools/generar-catalogos.php");
    }
    $this->assertSame(['validaciones-de', 'validaciones-evento', 'respuestas-ws', 'elementos-de'], array_keys($generados));
  }

  public function testElGeneradorCuentaLoEsperado(): void
  {
    $g = \GeneradorCatalogos::generarTodo(self::DOCS);
    $this->assertCount(300, $g['validaciones-de']['entradas']);
    $this->assertCount(282, array_filter($g['validaciones-de']['entradas'], fn (array $e) => $e['vigente']));
    $this->assertGreaterThanOrEqual(95, count($g['validaciones-evento']['entradas']));
    $this->assertGreaterThanOrEqual(40, count(array_filter($g['respuestas-ws']['entradas'], fn (array $e) => $e['vigente'])));
    $this->assertArrayHasKey('tgDTim', $g['elementos-de']['tipos']);
    $this->assertArrayHasKey('dEntCont', $g['elementos-de']['elementos']);
  }
}
