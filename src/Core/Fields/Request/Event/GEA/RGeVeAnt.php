<?php

namespace IonysDev\Pkuatia\Core\Fields\Request\Event\GEA;

use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * ID:GEA001 Raíz Gestión de Eventos anticipo PADRE:GDE007
 */
class RGeVeAnt
{
                // ID - DESCRIPCION- LONGITUD - OCURRENCIA
  public String $Id; // GEA002 - CDC del DTE asociado - 44 - 1-1

  ///////////////////////////////////////////////////////////////////////
  //SETTERS
  ///////////////////////////////////////////////////////////////////////


  /**
   * Establece el valor de Id
   *
   * @param String $Id
   *
   * @return self
   */
  public function setId(String $Id): self
  {
    $this->Id = $Id;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  ///GETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de Id
   *
   * @return String
   */
  public function getId(): String
  {
    return $this->Id;
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML ELEMENT
  ///////////////////////////////////////////////////////////////////////

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('rGeVeAnt');
    $res->appendChild(new DOMElement('Id', $this->getId()));

    return $res;
  }


  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return TrGeVeRetAce
  //  */
  // public static function fromDOMElement(DOMElement $xml): RGeVeAnt
  // {
  //   if (strcmp($xml->tagName, "rGeVeAnt") == 0 && $xml->childElementCount == 7) {
  //     $res = new RGeVeAnt();
  //     $res->setId($xml->getElementsByTagName('Id')->item(0)->nodeValue);

  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }

  public static function FromSimpleXMLElement(SimpleXMLElement $node):self
  {
    $res = new RGeVeAnt();
    $res->setId($node->Id);

    return $res;
  }
}
