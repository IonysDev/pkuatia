<?php

namespace IonysDev\Pkuatia\DataMappings;


/**
 * PyGeoCodesMapping
 */
class PyGeoCodesMapping
{
  /**
   * getArray
   *
   * @return array
   */
  public static function getArray()
  {
    $xml = simplexml_load_file(__DIR__ . '/Sources/PyGeoCodes.xml');
    $json = json_encode($xml);
    $array = json_decode($json, true);
    return $array;
  }

  /**
   * getDistName
   *
   * @param  mixed $code
   * @return String
   */
  public static function getDistName($code): String
  {
    $array = self::getArray();
    ///iterate the array
    foreach ($array['geo'] as $key => $value) {
      if (isset($value['CODIGO_DIST']) && $value['CODIGO_DIST'] == $code) {
        return $value['DISTRITO'];
      }
    }
    return null;
  }

  
  /**
   * getDistName
   *
   * @param  mixed $code
   * @return String
   */
  public static function getCiudName($code): String
  {
    $array = self::getArray();
    ///iterate the array
    foreach ($array['geo'] as $key => $value) {
      if (isset($value['CODIGO_CIUD']) && $value['CODIGO_CIUD'] == $code) {
        return $value['CIUDAD'];
      }
    }
    return null;
  }

    
  /**
   * por el momento sin suo
   *
   * @param  mixed $code
   * @return String
   */
  public static function getBarrName($code): String
  {
    $array = self::getArray();
    ///iterate the array
    foreach ($array['geo'] as $key => $value) {
      if (isset($value['CODIGO_BARR']) && $value['CODIGO_BARR'] == $code) {
        return $value['BARRIO'];
      }
    }
    return null;
  }
}
