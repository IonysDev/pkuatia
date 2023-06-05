<?php

namespace Abiliomp\Pkuatia\Helpers;

/**
 * Read the iso4217.xml file and return an array
 */
class CurrencyHelper
{
  
  /**
   * getArray
   *
   * @return void
   */
  public static function getArray()
  {
    $xml = simplexml_load_file('C:\Users\USER\Desktop\pkuatia\src\Helpers\iso4217.xml');
    $json = json_encode($xml);
    $array = json_decode($json, true);
    return $array;
  }
  
  /**
   * getCurrDesc
   *
   * @param  mixed $curr
   * @return string|null
   */
  public static function getCurrDesc(string $curr) : string | null
  {
    $curr = strtoupper($curr);
    $array = self::getArray();
    ///search the curr name in the array, using the Ccy element
    foreach ($array['CcyTbl']['CcyNtry'] as $key => $value) {
     if(isset($value['Ccy']) && $value['Ccy'] == $curr){
       return $value['CcyNm'];
     }
    }
    return null;
  }
}
