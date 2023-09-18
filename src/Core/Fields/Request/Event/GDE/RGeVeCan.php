<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\Event\GDE;

use DOMDocument;
use DOMElement;

/**
 * Nodo: GEC001 - rGeVeCan - Campos generales del DE
 * Padre: GDE007 - gGroupTiEvt - Grupo de campos del tipo de evento
 */
class RGeVeCan
{

  public String $Id;     // GEC002 - Identificador del DTE
  public String $mOtEve; // GEC003 - Motivo del Evento

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor Id - Identificador del DTE
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
   * Establece el valor mOtEve - Motivo del Evento
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
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor Id - Identificador del DTE
   *
   * @return String
   */
  public function getId(): String
  {
    return $this->Id;
  }

  /**
   * Obtiene el valor mOtEve - Motivo del Evento
   *
   * @return String
   */
  public function getMOtEve(): String
  {
    return $this->mOtEve;
  }

  ///////////////////////////////////////////////////////////////////////
  // Conversiones XML
  ///////////////////////////////////////////////////////////////////////
   
  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('rGeVeCan');
    $res->appendChild($doc->createElement('Id', $this->Id));
    $res->appendChild($doc->createElement('mOtEve', $this->mOtEve));
    return $res;
  }
  
  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return RGeVeCan
  //  */
  // public static function fromDOMElement(DOMElement $xml): RGeVeCan
  // {
  //   if(strcmp($xml->tagName, 'rGeVeCan') == 0 && $xml->childElementCount == 2)
  //   {
  //     $res = new RGeVeCan();
  //     $res->setId($xml->getElementsByTagName('Id')->item(0)->nodeValue);
  //     $res->setMOtEve($xml->getElementsByTagName('mOtEve')->item(0)->nodeValue);
  //     return $res;
  //   }
  //   else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }
  

}
