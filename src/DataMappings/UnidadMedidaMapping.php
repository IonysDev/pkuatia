<?php

namespace IonysDev\Pkuatia\DataMappings;

use DOMDocument;

/**
 * Unidades de medida (E709 cUniMed / E710 dDesUniMed) a partir de Unidades_Medida_v141.xsd de producción.
 *
 * En el XSD, la documentación de cada código de tcUniMed es "Descripción - ABREVIATURA" y el literal
 * que exige la enumeración tdDesUniMed (E710) es la abreviatura (UNI, kg, 4A, Ci, DOC…). La copia
 * empaquetada debe ser idéntica a la de producción: hasta la v0.1.5 la copia era anterior a la
 * NT-023 y los códigos 111-140 producían descripciones inválidas (PK-05).
 */
class UnidadMedidaMapping
{
  /** @var array<int, array<string, mixed>>|null Caché del catálogo (el XSD no cambia en tiempo de ejecución). */
  private static ?array $catalogo = null;

  /**
   * Devuelve un array con la lista de unidades de medida.
   *
   * @return array La lista de unidades de medida.
   */
  public static function GetArray(): array
  {
    if (self::$catalogo === null) {
      $xml = new DOMDocument();
      $xml->load(__DIR__ . '/Sources/Unidades_Medida_v141.xsd');
      $xml->preserveWhiteSpace = true;
      $parseObj = str_replace($xml->lastChild->prefix.':',"", $xml->saveXML($xml->lastChild));
      $array = json_decode(json_encode(simplexml_load_string($parseObj)), true);
      self::$catalogo = $array['simpleType'][0]['restriction']['enumeration'];
    }
    return self::$catalogo;
  }

  /**
   * Devuelve el literal de E710 (dDesUniMed) para un código de unidad de medida (E709): la abreviatura
   * que figura tras el último " - " de la documentación del XSD, o la documentación completa si no la tiene.
   *
   * @param  String $code El código de la unidad de medida
   * @return String|null El literal de la unidad de medida, o null si el código no existe en el XSD.
   */
  public static function GetDesc(String $code): ?String
  {
    $buscado = strtoupper($code);
    foreach (self::GetArray() as $value) {
      if (isset($value["@attributes"]['value']) && $value["@attributes"]['value'] == $buscado) {
        $doc = (string) $value['annotation']['documentation'];
        $pos = strrpos($doc, ' - ');
        return $pos === false ? trim($doc) : trim(substr($doc, $pos + 3));
      }
    }
    return null;
  }
}
