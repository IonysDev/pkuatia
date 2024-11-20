<?php

// namespace IonysDev\Pkuatia\Helpers;
namespace IonysDev\Pkuatia\DataMappings;

use DOMDocument;

class DepartamentoMapping
{  
  /**
   * getArray
   *
   * @return array
   */
  public static function getArray(): array
  {
    $xml = new DOMDocument();
    $xml->load(__DIR__ . '/Sources/Departamentos_v141.xsd');
    $xml->preserveWhiteSpace = true;
    $parseObj = str_replace($xml->lastChild->prefix.':',"", $xml->saveXML($xml->lastChild));
    $array = json_decode(json_encode(simplexml_load_string($parseObj)), true);
    //retorna el array con la lista de paises
    return $array['simpleType'][0]['restriction']['enumeration'];
  }

  public static function getDepName($code): String
  {
    $depCode = strtoupper($code);
    $array = self::getArray();
    ///iterate the array
    foreach ($array as $key => $value) {
      if (isset($value["@attributes"]['value']) && $value["@attributes"]['value'] == $depCode) {
        $res = $value['annotation']['documentation'];
        return $res;
      }
    }
    return null;
  }
}
