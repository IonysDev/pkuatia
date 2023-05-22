<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\events\GEA;

use DOMElement;

/**
 * ID:GEA001 Raíz Gestión de Eventos anticipo PADRE:GDE007
 */
class TrGeVeAnt
{
  public string $Id; //GEA002 CDC del DTE asociado

  //====================================================//
  //SETTERS
  //====================================================//


  /**
   * Set the value of Id
   *
   * @param string $Id
   *
   * @return self
   */
  public function setId(string $Id): self
  {
    $this->Id = $Id;

    return $this;
  }

  //====================================================//
  ///GETTERS
  //====================================================//

  /**
   * Get the value of Id
   *
   * @return string
   */
  public function getId(): string
  {
    return $this->Id;
  }

  //====================================================//
  ///XML ELEMENT
  //====================================================//

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('rGeVeAnt');
    $res->appendChild(new DOMElement('Id', $this->getId()));

    return $res;
  }


  /**
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return TrGeVeRetAce
   */
  public static function fromDOMElement(DOMElement $xml): TrGeVeAnt
  {
    if (strcmp($xml->tagName, "rGeVeAnt") == 0 && $xml->childElementCount == 7) {
      $res = new TrGeVeAnt();
      $res->setId($xml->getElementsByTagName('Id')->item(0)->nodeValue);

      return $res;
    } else {
      throw new \Exception("Invalid XML Element: $xml->tagName");
      return null;
    }
  }
}
