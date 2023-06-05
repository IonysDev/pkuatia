<?php

namespace Abiliomp\Pkuatia\Helpers;


/**
 * GeoRefCodesHelper
 */
class GeoRefCodesHelper
{
  /**
   * getArray
   *
   * @return array
   */
  public static function getArray()
  {
    $xml = simplexml_load_file('C:\Users\USER\Desktop\pkuatia\src\Helpers\georef.xml');
    $json = json_encode($xml);
    $array = json_decode($json, true);
    return $array;
  }

  /**
   * getDistName
   *
   * @param  mixed $code
   * @return string
   */
  public static function getDistName($code): string | null
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
   * @return string
   */
  public static function getCiudName($code): string | null
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
   * @return string
   */
  public static function getBarrName($code): string | null
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
