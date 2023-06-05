<?php

namespace Abiliomp\Pkuatia\Helpers;

use DOMDocument;

class UMHelper
{  
  /**
   * getArray
   *
   * @return array
   */
  public static function getArray(): array
  {
    $xml = new DOMDocument();
    $xml->load(__DIR__ . '/umedidas.xml');
    $xml->preserveWhiteSpace = true;
    $parseObj = str_replace($xml->lastChild->prefix.':',"", $xml->saveXML($xml->lastChild));
    $array = json_decode(json_encode(simplexml_load_string($parseObj)), true);
    //retorna el array con la lista de paises
    return $array['simpleType'][0]['restriction']['enumeration'];
  }
  
  /**
   * getUMDesc
   *
   * @param  mixed $code
   * @return string
   */
  public static function getUMDesc($code): string | null
  {
    $country = strtoupper($code);
    $array = self::getArray();
    foreach ($array as $key => $value) {
      if (isset($value["@attributes"]['value']) && $value["@attributes"]['value'] == $country) {
        return substr($value['annotation']['documentation'], strrpos($value['annotation']['documentation'], '-' )+2);

      }
    }
    return null;
  }
}
