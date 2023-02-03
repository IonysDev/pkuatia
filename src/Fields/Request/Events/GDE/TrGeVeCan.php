<?php

namespace Abiliomp\Pkuatia\Fields\Request\Events\GDE;

use DOMElement;

/**
 * Nodo: GEC001 - rGeVeCan - Campos generales del DE
 * Padre: GDE007 - gGroupTiEvt - Grupo de campos del tipo de evento
 */
class TrGeVeCan
{

  public string $Id;     // GEC002 - Identificador del DTE
  public string $mOtEve; // GEC003 - Motivo del Evento

  //====================================================//
  // Setters
  //====================================================//

  /**
   * Establece el valor Id - Identificador del DTE
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


  /**
   * Establece el valor mOtEve - Motivo del Evento
   *
   * @param string $mOtEve
   *
   * @return self
   */
  public function setMOtEve(string $mOtEve): self
  {
    $this->mOtEve = $mOtEve;
    return $this;
  }

  //====================================================//
  // Getters
  //====================================================//

  /**
   * Obtiene el valor Id - Identificador del DTE
   *
   * @return string
   */
  public function getId(): string
  {
    return $this->Id;
  }

  /**
   * Obtiene el valor mOtEve - Motivo del Evento
   *
   * @return string
   */
  public function getMOtEve(): string
  {
    return $this->mOtEve;
  }

  //====================================================//
  // Conversiones XML
  //====================================================//
   
  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('trGeVeCan');
    $res->appendChild(new DOMElement('Id', $this->getId()));
    $res->appendChild(new DOMElement('mOtEve', $this->getMOtEve()));
    return $res;
  }
  
  /**
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return TrGeVeCan
   */
  public static function fromDOMElement(DOMElement $xml): TrGeVeCan
  {
    if(strcmp($xml->tagName, 'trGeVeCan') == 0 && $xml->childElementCount == 2)
    {
      $res = new TrGeVeCan();
      $res->setId($xml->getElementsByTagName('Id')->item(0)->nodeValue);
      $res->setMOtEve($xml->getElementsByTagName('mOtEve')->item(0)->nodeValue);
      return $res;
    }
    else {
      throw new \Exception("Invalid XML Element: $xml->tagName");
      return null;
    }
  }
  

}
