<?php

namespace Abiliomp\Pkuatia\Helpers;

use SimpleXMLElement;

class RequestXMLHelper
{
  public static function makeFromArray($operation, $data)
  {
    $xml = new SimpleXMLElement("<" . $operation . "></" . $operation . ">");
    $xml->addAttribute('xmlns', 'http://ekuatia.set.gov.py/sifen/xsd');

    foreach ($data as $key => $value) {
      $xml->addChild($key, $value);
    }
    return $xml;
  }
}
