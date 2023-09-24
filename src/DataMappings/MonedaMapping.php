<?php

namespace Abiliomp\Pkuatia\DataMappings;

use DOMDocument;

/**
 * Clase que dispone de métodos para obtener información de las monedas
 * a partir del archivo XML de monedas del https://ekuatia.set.gov.py/sifen/xsd
 */

class MonedaMapping
{

  /**
   * Devuelve un array con la lista de monedas.
   *
   * @return array
   */
  public static function GetArray()
  {
    $xml = new DOMDocument();
    $xml->load(__DIR__ . '/Sources/Monedas_v150.xsd');
    $xml->preserveWhiteSpace = true;
    $parseObj = str_replace($xml->lastChild->prefix . ':', "", $xml->saveXML($xml->lastChild));
    $array = json_decode(json_encode(simplexml_load_string($parseObj)), true);
    //retorna el array con la lista de paises
    return $array['simpleType']['restriction']['enumeration'];
  }

  
  /**
   * Devuelve la descripción de la moneda a partir del código ISO 4217.
   *
   * @param  mixed $code
   * 
   * @return String
   */
  public static function GetDescription($code): String
  {
    $country = strtoupper($code);
    $array = self::getArray();
    foreach ($array as $key => $value) {
      if (isset($value["@attributes"]['value']) && $value["@attributes"]['value'] == $country) {
        return $value['annotation']['documentation']['CodeName'];
      }
    }
    return null;
  }
}
