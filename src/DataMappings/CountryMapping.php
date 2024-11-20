<?php

namespace IonysDev\Pkuatia\DataMappings;

use DOMDocument;

/**
 * Read the iso3166.xml file and return an array
 */
class CountryMapping
{
  /**
   * getArray
   *
   * @return array
   */
  public static function getArray(): array
  {
    $xml = new DOMDocument();
    $xml->load(__DIR__ . '/Sources/ISO3166.xml');
    $xml->preserveWhiteSpace = true;
    $parseObj = str_replace($xml->lastChild->prefix.':',"", $xml->saveXML($xml->lastChild));
    $array = json_decode(json_encode(simplexml_load_string($parseObj)), true);
    //retorna el array con la lista de paises
    return $array['simpleType']['restriction']['enumeration'];
  }

  /**
   * getCountryDesc
   *
   * @param  mixed $country
   * @return String
   */
  public static function getCountryDesc($code): String
  {
    $country = strtoupper($code);
    $array = self::getArray();
    ///search the country name in the array, using the aplha-3 element
    foreach ($array as $key => $value) {
      ///if the country code is found, return the name
      if (isset($value["@attributes"]['value']) && $value["@attributes"]['value'] == $country) {
        return $value['annotation']['documentation'];///THE NAME OF THE COUNTRY
      }
    }
    return null;
  }
}
