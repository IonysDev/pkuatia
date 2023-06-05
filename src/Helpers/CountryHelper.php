<?php

namespace Abiliomp\Pkuatia\Helpers;

/**
 * Read the iso3166.xml file and return an array
 */
class CountryHelper
{  
  /**
   * getArray
   *
   * @return array
   */
  public static function getArray() : array
  {
    $xml = simplexml_load_file('C:\Users\USER\Desktop\pkuatia\src\Helpers\iso3166.xml');
    $json = json_encode($xml);
    $array = json_decode($json, true);
    return $array;
  }

  /**
   * getCountryDesc
   *
   * @param  mixed $country
   * @return string|null
   */
  public static function getCountryDesc(string $code) : string | null
  {
    $country = strtoupper($code);
    $array = self::getArray();
    ///search the country name in the array, using the aplha-3 element
    foreach ($array['country'] as $key => $value) {
      if(isset($value['@attributes']['alpha-3']) && $value['@attributes']['alpha-3'] == $country){
        return $value['@attributes']['name'];
      }
    }
    return null;
  }
  
}
