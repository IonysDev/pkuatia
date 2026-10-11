<?php

namespace IonysDev\Pkuatia\Helpers;

use SimpleXMLElement;

/**
 * @deprecated 0.2.1 Sin uso en la librería (PK-43): las solicitudes se arman con las clases de Core\Requests.
 */
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
