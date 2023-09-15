<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\Event\GDE;

use DOMElement;

/**
 * Nodo: GEC000 - gGroupGesEve - Raíz del grupo deeventos 
 * Padre: GSch03 - dEvReg - Evento a ser registrado
 */
class GGroupGesEve
{
  public array $rGesEve; // GDE001 - Raíz de Gestión de Eventos
 
  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Método responsable de realizar la información del grupo de eventos
   *
   * @param DOMElement $rGesEve
   */
  public function setRGesEve(RrGesEve $rGesEve): self
  {
    $this->rGesEve = $rGesEve;
    return $this;
  }



  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  public function getRGesEve(): array
  {
    return $this->rGesEve;
  }



  ///////////////////////////////////////////////////////////////////////
  // XML Element 
  ///////////////////////////////////////////////////////////////////////

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('gGroupGesEve');
    ///children
    // $res->appendChild($this->rGesEve->toDOMElement());
    return $res;
  }
  
  /**
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return GGroupGesEve
   */
  public static function fromDOMElement(DOMElement $xml): GGroupGesEve
  {
    if(strcmp($xml->tagName, 'gGroupGesEve') == 0 && $xml->childElementCount  == 2)
    { 
      $res = new GGroupGesEve();
      //Children
      // $res->setRGesEve($res->rGesEve->fromDOMElement($xml->getElementsByTagName('rGesEve')->item(0)->nodeValue));
  
      return $res;
    }
    else {
      throw new \Exception("Invalid XML Element: $xml->tagName");
      return null;
    }
  }
}
