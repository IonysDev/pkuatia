<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\events\GER;

use DOMElement;

/**
 *  ID:GDI001 Raiz Gestión de Eventos Disconformidad PADRE:GDE007
 */
class RGeVeDisconf
{
  public String $Id; // GDI002 CDC del DTE
  public String $mOtEve; ///GDI004 Motivo del Evento

  ///////////////////////////////////////////////////////////////////////
  //SETTERS
  ///////////////////////////////////////////////////////////////////////


  /**
   * Set the value of Id
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


  /**
   * Set the value of mOtEve
   *
   * @param String $mOtEve
   *
   * @return self
   */
  public function setMOtEve(String $mOtEve): self
  {
    $this->mOtEve = $mOtEve;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  ///GETTERS
  ///////////////////////////////////////////////////////////////////////



  /**
   * Get the value of Id
   *
   * @return String
   */
  public function getId(): String
  {
    return $this->Id;
  }

  /**
   * Get the value of mOtEve
   *
   * @return String
   */
  public function getMOtEve(): String
  {
    return $this->mOtEve;
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML Element
  ///////////////////////////////////////////////////////////////////////


  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('rGeVeDisconf');

    $res->appendChild(new DOMElement('Id', $this->getId()));
    $res->appendChild(new DOMElement('mOtEve', $this->getMOtEve()));

    return $res;
  }

  /**
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return DOMElement
   */
  public static function fromDOMElement(DOMElement $xml): RGeVeDisconf
  {
    if (strcmp($xml->tagName, 'rGeVeDisconf') == 0 && $xml->childElementCount == 2) {
      $res = new RGeVeDisconf();
      $res->setId($xml->getElementsByTagName('Id')->item(0)->nodeValue);
      $res->setMOtEve($xml->getElementsByTagName('mOtEve')->item(0)->nodeValue);
      return $res;
    } else {
      throw new \Exception("Invalid XML Element: $xml->tagName");
      return null;
    }
  }
}
