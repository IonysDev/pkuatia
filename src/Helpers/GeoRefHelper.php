<?php

namespace Abiliomp\Pkuatia\Helpers;

/**
 * GeoRefHelper
 */
class GeoRefHelper
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
   * INNCESARIO PERO SE PODRIAN HACER COSAS ALGUN DIA
   *
   * @param  mixed $code
   * @return string | null
   */
  public static function getDepName($code): string | null
  {
    $array = self::getArray();
    ///iterate the array
    foreach ($array['georef'] as $key => $value) {
      if (isset($value['CODIGO_DEPARTAMENTO']) && $value['CODIGO_DEPARTAMENTO'] == $code) {
        return $value['DEPARTAMENTO'];
      }
    }

    return null;
  }

  /**
   * getDiscName
   *
   * @param  mixed $code
   * @return string | null
   */
  public static function getDistName($code): string | null
  {
    $array = self::getArray();
    ///iterate the array
    foreach ($array['georef'] as $key => $value) {
      if (isset($value['CODIGO_DISTRITO']) && $value['CODIGO_DISTRITO'] == $code) {
        return $value['DISTRITO'];
      }
    }
    return null;
  }
  
  /**
   * getCiuName
   *
   * @return string | null
   */
  public static function getCiuName($code): string | null
  {
    $array = self::getArray();
    ///iterate the array
    foreach ($array['georef'] as $key => $value) {
      if (isset($value['CODIGO_CIUDAD']) && $value['CODIGO_CIUDAD'] == $code) {
        return $value['CIUDAD'];
      }
    }
  }
}
