<?php

namespace IonysDev\Pkuatia\Validacion;

use DOMDocument;
use IonysDev\Pkuatia\Core\Exceptions\ConfiguracionException;
use LibXMLError;

/**
 * Validación de un XML contra los XSD de producción del SIFEN incluidos en la librería (src/Resources/xsd, copias de
 * ekuat-ia con los includes relativos y el arreglo de dEntCont). Sin red (LIBXML_NONET), sin Init() y sin modificar
 * nada. Cada error de libxml se traduce a un ErrorValidacion con origen XSD, código 0160 (AE01: lo que el SIFEN
 * responde ante un XML que no cumple el esquema), el elemento, el campo del MT (catálogo de elementos), la línea y una
 * sugerencia con el método de PKuatia que informa el campo. Fase C, paso C7 (evaluación §6.3).
 */
final class ValidadorXsd
{
  /** Carpeta de los XSD incluidos en la librería. */
  public const XSD_DIR = __DIR__ . '/../Resources/xsd';
  private const RDE = 'siRecepDE_v150.xsd';
  private const EVENTO = 'siRecepEvento_v150.xsd';

  /** Valida un rDE firmado (lo que recibe EnviarDE) contra el esquema del WS de recepción, siRecepDE_v150.xsd. */
  public static function validarRde(string $xml): ResultadoValidacion
  {
    return self::validar($xml, self::XSD_DIR . '/' . self::RDE);
  }

  /** Valida un sobre de eventos firmado (gGroupGesEve, lo que envía RegistrarEvento) contra siRecepEvento_v150.xsd. */
  public static function validarEvento(string $xml): ResultadoValidacion
  {
    return self::validar($xml, self::XSD_DIR . '/' . self::EVENTO);
  }

  /**
   * Valida un XML contra un esquema local cualquiera.
   *
   * @param string $xsd Ruta del XSD (sus includes se resuelven en su misma carpeta; nunca por red).
   * @throws ConfiguracionException Si el XSD no existe.
   */
  public static function validar(string $xml, string $xsd): ResultadoValidacion
  {
    if (!is_file($xsd))
      throw new ConfiguracionException("[ValidadorXsd] No se encontró el esquema XSD: $xsd");
    $resultado = new ResultadoValidacion();
    $previo = libxml_use_internal_errors(true);
    libxml_clear_errors();
    try {
      $doc = new DOMDocument();
      $doc->preserveWhiteSpace = true;
      if (trim($xml) === '' || !$doc->loadXML($xml, LIBXML_NONET)) {
        $errores = libxml_get_errors();
        $primero = $errores[0] ?? null;
        $resultado->agregar(new ErrorValidacion(OrigenError::Xsd, 'XML mal formado: ' . ($primero !== null ? trim($primero->message) : 'el contenido está vacío.'),
          '0160', null, null, null, null, 'Revisar que el XML esté completo y bien formado antes de validarlo contra el esquema.', $primero !== null && $primero->line > 0 ? $primero->line : null));
        return $resultado;
      }
      if ($doc->schemaValidate($xsd, LIBXML_NONET)) // tampoco los includes del esquema salen a la red
        return $resultado;
      foreach (libxml_get_errors() as $error)
        $resultado->agregar(self::desdeLibxml($error));
      return $resultado;
    } finally {
      libxml_clear_errors();
      libxml_use_internal_errors($previo);
    }
  }

  /** Traduce un error de libxml2 ("Element '{ns}dSerieNum': [facet 'pattern'] ...") a un ErrorValidacion. */
  private static function desdeLibxml(LibXMLError $error): ErrorValidacion
  {
    $mensaje = trim((string) preg_replace('/\{[^}]*\}/', '', trim($error->message)));
    $elemento = preg_match("/^Element '([^']+)'/", $mensaje, $m) === 1 ? $m[1] : null;
    $campo = $elemento !== null ? CatalogoValidaciones::campoMT($elemento) : null;
    return new ErrorValidacion(OrigenError::Xsd, $mensaje, '0160', $campo, $elemento, null, null, self::sugerencia($mensaje, $elemento, $campo),
      $error->line > 0 ? $error->line : null);
  }

  private static function sugerencia(string $mensaje, ?string $elemento, ?string $campo): ?string
  {
    $partes = [];
    if (preg_match('/Missing child element\(s\)\. Expected is (?:one of )?\( (.+?) \)\.?$/', $mensaje, $m) === 1) {
      $faltantes = preg_split('/[\s,|]+/', trim($m[1]), -1, PREG_SPLIT_NO_EMPTY) ?: [];
      $partes[] = 'Falta ' . implode(' o ', $faltantes) . ($elemento !== null ? " dentro de $elemento" : '') . '.';
      foreach ($faltantes as $faltante) {
        $campoFaltante = CatalogoValidaciones::campoMT($faltante);
        $metodo = $campoFaltante !== null ? CatalogoValidaciones::metodoPkuatia($campoFaltante) : null;
        if ($metodo !== null)
          $partes[] = "Informar $faltante ($campoFaltante) con $metodo.";
      }
      return implode(' ', $partes);
    }
    if (preg_match('/This element is not expected\.(?: Expected is (?:one of )?\( (.+?) \))?/', $mensaje, $m) === 1) {
      $partes[] = ($elemento !== null ? "$elemento" : 'El elemento') . ' está fuera de lugar o no se admite aquí' . (isset($m[1]) ? '; el XSD espera ' . trim($m[1]) : '') . '.';
    } elseif (str_contains($mensaje, '[facet ')) {
      $partes[] = 'El valor no cumple el tipo que el XSD exige para ' . ($elemento ?? 'el elemento') . ($campo !== null ? " ($campo)" : '') . '.';
    }
    $metodo = $campo !== null ? CatalogoValidaciones::metodoPkuatia($campo) : null;
    if ($metodo !== null)
      $partes[] = "Ver $metodo.";
    return $partes === [] ? null : implode(' ', $partes);
  }
}
