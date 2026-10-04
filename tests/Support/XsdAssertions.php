<?php

namespace IonysDev\Pkuatia\Tests\Support;

use DOMDocument;
use PHPUnit\Framework\Assert;

/**
 * Validación de XML contra los XSD de producción empaquetados en src/Resources/xsd/
 * (copias con schemaLocation relativos y el fix de dEntCont; ver el README de esa carpeta).
 */
final class XsdAssertions
{
  public const XSD_DIR = __DIR__ . '/../../src/Resources/xsd';

  /** Un rDE (firmado o no) debe validar contra siRecepDE_v150.xsd. */
  public static function assertRdeValido(string $xml, string $context = ''): void
  {
    self::assertValido($xml, self::XSD_DIR . '/siRecepDE_v150.xsd', $context);
  }

  /** Un sobre de eventos gGroupGesEve debe validar contra siRecepEvento_v150.xsd. */
  public static function assertEventoValido(string $xml, string $context = ''): void
  {
    self::assertValido($xml, self::XSD_DIR . '/siRecepEvento_v150.xsd', $context);
  }

  /** Afirma que el XML NO valida y que alguno de los errores menciona el texto esperado. */
  public static function assertRdeInvalidoPor(string $xml, string $textoEsperado, string $context = ''): void
  {
    $errores = self::errores($xml, self::XSD_DIR . '/siRecepDE_v150.xsd');
    Assert::assertNotEmpty($errores, trim("$context: se esperaba un XML inválido y validó"));
    $todo = implode("\n", $errores);
    Assert::assertStringContainsString($textoEsperado, $todo, trim("$context: errores XSD obtenidos:\n$todo"));
  }

  public static function assertValido(string $xml, string $xsd, string $context = ''): void
  {
    $errores = self::errores($xml, $xsd);
    Assert::assertSame([], $errores, trim($context . " — errores XSD (" . basename($xsd) . "):\n" . implode("\n", $errores)));
  }

  /**
   * @return list<string> Mensajes de libxml (vacío si el documento es válido).
   */
  public static function errores(string $xml, string $xsd): array
  {
    $previo = libxml_use_internal_errors(true);
    libxml_clear_errors();
    $doc = new DOMDocument();
    $doc->preserveWhiteSpace = true;
    $ok = $doc->loadXML($xml);
    $errores = [];
    if (!$ok) {
      foreach (libxml_get_errors() as $e) {
        $errores[] = 'XML mal formado: ' . trim($e->message);
      }
    } elseif (!$doc->schemaValidate($xsd)) {
      foreach (libxml_get_errors() as $e) {
        $errores[] = sprintf('línea %d: %s', $e->line, trim($e->message));
      }
    }
    libxml_clear_errors();
    libxml_use_internal_errors($previo);
    return $errores;
  }
}
