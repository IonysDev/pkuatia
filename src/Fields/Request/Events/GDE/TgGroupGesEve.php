<?php

namespace Abiliomp\Pkuatia\Fields\Request\Events\GDE;

use DOMElement;

/**
 * Nodo: GEC000 - gGroupGesEve - Raíz del grupo deeventos 
 * Padre: GSch03 - dEvReg - Evento a ser registrado
 */
class TgGroupGesEve
{
  public TrGesEve $rGesEve; // GDE001 - Raíz de Gestión de Eventos
  public TrEve $rEve;       // GDE002 - Grupos de campos generales del evento

  //====================================================//
  // Setters
  //====================================================//

  /**
   * Método responsable de realizar la información del grupo de eventos
   *
   * @param DOMElement $rGesEve
   */
  public function setRGesEve(TrGesEve $rGesEvee): self
  {
    $this->rGesEve = $rGesEvee;
    return $this;
  }

  /**
   * Set the value of rEve
   *
   * @param TrEve $rEve
   *
   * @return self
   */
  public function setREve(TrEve $rEve): self
  {
    $this->rEve = $rEve;

    return $this;
  }


  //====================================================//
  // Getters
  //====================================================//

  public function getRGesEve(): TrGesEve
  {
    return $this->rGesEve;
  }


  /**
   * Get the value of rEve
   *
   * @return TrEve
   */
  public function getREve(): TrEve
  {
    return $this->rEve;
  }


  //====================================================//
  // XML Element 
  //====================================================//

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('tgGroupGesEve');
    ///children
    $res->appendChild($this->rGesEve->toDOMElement());
    $res->appendChild($this->rEve->toDOMElement());
    return $res;
  }
  
  /**
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return TgGroupGesEve
   */
  public static function fromDOMElement(DOMElement $xml): TgGroupGesEve
  {
    if(strcmp($xml->tagName, 'tgGroupGesEve') == 0 && $xml->childElementCount  == 2)
    { 
      $res = new TgGroupGesEve();
      //Children
      $res->setRGesEve($res->rGesEve->fromDOMElement($xml->getElementsByTagName('rGesEve')->item(0)->nodeValue));
      $res->setREve($res->rEve->fromDOMElement($xml->getElementsByTagName('rEve')->item(0)->nodeValue));

      return $res;
    }
    else {
      throw new \Exception("Invalid XML Element: $xml->tagName");
      return null;
    }
  }
}
