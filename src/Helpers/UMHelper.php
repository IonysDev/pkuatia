<?php

namespace Abiliomp\Pkuatia\Helpers;

class UMHelper
{
  public static function getArray()
  {
    $xml = simplexml_load_string(file_get_contents('C:\Users\USER\Desktop\pkuatia\src\Helpers\umedidas.xml'));
    $json = json_encode($xml);
    $array = json_decode($json, true);
    return $array;
  }

  public static function getUMDesc($code): string | null
  {
    $array = self::getArray();
    ///iterate the array
    foreach ($array['unit'] as $key => $value) {
      if (isset($value['CODIGO']) && $value['CODIGO'] == $code) {
        return $value['REPRESENTACION'];
      }
    }
    return null;
  }
}
