<?php

namespace IonysDev\Pkuatia\Tests\Unit\Resources;

use DOMDocument;
use IonysDev\Pkuatia\Tests\Support\RespuestasSifenFactory;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Las capturas de tests/Resources/sifen/respuestas-ws/ son copias byte a byte de
 * ekuat-ia/06-ejemplos/respuestas-ws/ (fuente de verdad del formato real de las respuestas).
 */
final class RespuestasWsSincroniaTest extends TestCase
{
  private const ORIGEN_EKUATIA = __DIR__ . '/../../../docs/sifen-ai/06-ejemplos/respuestas-ws';

  public function testLasCapturasDeclaradasEnLaFabricaExisten(): void
  {
    $constantes = (new ReflectionClass(RespuestasSifenFactory::class))->getConstants();
    unset($constantes['DIR']);
    $this->assertCount(29, $constantes);
    foreach ($constantes as $nombre => $captura) {
      $this->assertFileExists(RespuestasSifenFactory::DIR . '/' . $captura, $nombre);
    }
  }

  /**
   * El SIFEN responde con LF; .gitattributes desactiva la conversión de fin de línea en la carpeta
   * para que un clon con core.autocrlf no altere los bytes (xContenDE incluye saltos y tabulaciones).
   */
  public function testLasCapturasSeGuardanSinRetornoDeCarro(): void
  {
    foreach (self::archivos(RespuestasSifenFactory::DIR) as $relativo) {
      $this->assertStringNotContainsString("\r", file_get_contents(RespuestasSifenFactory::DIR . '/' . $relativo), $relativo);
    }
  }

  public function testLasRespuestasSonSobresSoap12BienFormados(): void
  {
    $respuestas = array_filter(self::archivos(RespuestasSifenFactory::DIR), fn (string $r): bool => str_contains($r, '-response'));
    $this->assertCount(28, $respuestas);
    foreach ($respuestas as $relativo) {
      $doc = new DOMDocument();
      $this->assertTrue($doc->loadXML(file_get_contents(RespuestasSifenFactory::DIR . '/' . $relativo)), $relativo);
      $this->assertSame('http://www.w3.org/2003/05/soap-envelope', $doc->documentElement->namespaceURI, $relativo);
      $this->assertSame('http://ekuatia.set.gov.py/sifen/xsd', RespuestasSifenFactory::elementoRespuesta($relativo)->namespaceURI, $relativo);
    }
  }

  /**
   * Mismo conjunto de archivos y mismo contenido que ekuat-ia. El clon local puede tener CRLF por
   * core.autocrlf, así que el origen se normaliza a LF. Sin docs/sifen-ai (p. ej. en CI) se omite.
   */
  public function testLasCopiasCoincidenConEkuatIa(): void
  {
    if (!is_dir(self::ORIGEN_EKUATIA)) {
      $this->markTestSkipped('docs/sifen-ai/06-ejemplos/respuestas-ws no está disponible en este entorno.');
    }
    $origen = self::archivos(self::ORIGEN_EKUATIA);
    $this->assertSame($origen, self::archivos(RespuestasSifenFactory::DIR), 'conjunto de archivos distinto: copiar de nuevo desde ekuat-ia');
    foreach ($origen as $relativo) {
      $esperado = str_replace("\r\n", "\n", file_get_contents(self::ORIGEN_EKUATIA . '/' . $relativo));
      $this->assertSame(md5($esperado), md5_file(RespuestasSifenFactory::DIR . '/' . $relativo), "$relativo difiere de ekuat-ia");
    }
  }

  /** @return list<string> rutas relativas, ordenadas */
  private static function archivos(string $dir): array
  {
    $res = [];
    $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS));
    foreach ($it as $archivo) {
      $res[] = str_replace('\\', '/', substr($archivo->getPathname(), strlen($dir) + 1));
    }
    sort($res);
    return $res;
  }
}
