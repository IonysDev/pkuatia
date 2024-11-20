<?php

namespace IonysDev\Pkuatia\DataMappings;

use DOMDocument;

class UnidadMedidaMapping
{  
  /**
   * Devuelve un array con la lista de unidades de medida.
   * 
   * @return array La lista de unidades de medida.
   */
  public static function GetArray(): array
  {
    $xml = new DOMDocument();
    $xml->load(__DIR__ . '/Sources/Unidades_Medida_v141.xsd');
    $xml->preserveWhiteSpace = true;
    $parseObj = str_replace($xml->lastChild->prefix.':',"", $xml->saveXML($xml->lastChild));
    $array = json_decode(json_encode(simplexml_load_string($parseObj)), true);
    //retorna el array con la lista de paises
    return $array['simpleType'][0]['restriction']['enumeration'];
  }
  
  /**
   * Devuelve la descripción de la unidad de medida a partir del código
   *
   * @param  String $code El código de la unidad de medida
   * @return String La descripción de la unidad de medida o null si no se encuentra.
   */
  public static function GetDesc(String $code): String
  {
    $country = strtoupper($code);
    $array = self::GetArray();
    foreach ($array as $key => $value) {
      if (isset($value["@attributes"]['value']) && $value["@attributes"]['value'] == $country) {
        return substr($value['annotation']['documentation'], strrpos($value['annotation']['documentation'], '-' )+2);

      }
    }
    return null;
  }
}
