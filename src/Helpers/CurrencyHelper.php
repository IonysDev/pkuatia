<?php

namespace Abiliomp\Pkuatia\Helpers;

use DOMDocument;

/**
 * Read the iso4217.xml file and return an array
 */
class CurrencyHelper
{

  /**
   * getArray
   *
   * @return array
   */
  public static function getArray()
  {
    $xml = new DOMDocument();
    $xml->load('C:\Users\USER\Desktop\pkuatia\src\Helpers\iso4217.xml');
    $xml->preserveWhiteSpace = true;
    $parseObj = str_replace($xml->lastChild->prefix . ':', "", $xml->saveXML($xml->lastChild));
    $array = json_decode(json_encode(simplexml_load_string($parseObj)), true);
    //retorna el array con la lista de paises
    return $array['simpleType']['restriction']['enumeration'];
  }

  
  /**
   * getCurrDesc
   *
   * @param  mixed $code
   * @return string
   */
  public static function getCurrDesc($code): string | null
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
