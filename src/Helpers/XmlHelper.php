<?php

namespace IonysDev\Pkuatia\Helpers;

use DOMDocument;
use DOMElement;

/**
 * Construcción segura de nodos XML con contenido de texto.
 *
 * `new DOMElement($nombre, $valor)` y `DOMDocument::createElement($nombre, $valor)` NO escapan el
 * valor: libxml lo interpreta como contenido XML, de modo que un `&` en una razón social
 * ("Pérez & Hijos S.A.") produce el warning "unterminated entity reference" y el elemento queda
 * VACÍO (`<dNomEmi/>`), con rechazo del SIFEN en los campos obligatorios y pérdida silenciosa de
 * datos en los opcionales (PK-01 de la evaluación del 02/10/2026). Este helper crea el elemento
 * vacío y le agrega el valor como nodo de texto, que libxml serializa escapado (`&amp;`, `&lt;`).
 *
 * Los literales del SIFEN se comparan byte a byte tras decodificar las entidades, así que
 * `Pérez &amp; Hijos` en el XML equivale a `Pérez & Hijos` para el validador.
 */
final class XmlHelper
{
  private function __construct()
  {
  }

  /**
   * Crea `<nombre>valor</nombre>` con el valor como texto escapado. Un valor `null` o `''` produce
   * el elemento vacío (mismo resultado que `new DOMElement($nombre, '')`).
   *
   * @param mixed $valor Escalar o Stringable; se convierte con `(string)` (true → "1", false → "").
   */
  public static function elemento(DOMDocument $doc, string $nombre, mixed $valor = null): DOMElement
  {
    $elemento = $doc->createElement($nombre);
    $texto = self::texto($valor);
    if ($texto !== '') {
      $elemento->appendChild($doc->createTextNode($texto));
    }
    return $elemento;
  }

  /**
   * Variante para métodos que construyen nodos sin un DOMDocument a mano (`new DOMElement(...)`
   * sueltos): el valor se pre-escapa para que libxml lo interprete como el texto original.
   * Preferir elemento() cuando se dispone del documento.
   */
  public static function elementoSuelto(string $nombre, mixed $valor = null): DOMElement
  {
    $texto = self::texto($valor);
    if ($texto === '') {
      return new DOMElement($nombre);
    }
    return new DOMElement($nombre, htmlspecialchars($texto, ENT_XML1 | ENT_QUOTES, 'UTF-8'));
  }

  /**
   * Convierte el valor a la cadena que se emite en el XML, con la misma coerción que aplicaba
   * `new DOMElement($nombre, $valor)` (int/float/bool/Stringable → string).
   */
  public static function texto(mixed $valor): string
  {
    if ($valor === null) {
      return '';
    }
    if (is_bool($valor)) {
      return $valor ? '1' : '';
    }
    return (string) $valor;
  }
}
