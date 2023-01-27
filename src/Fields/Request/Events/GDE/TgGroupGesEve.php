<?php

namespace Abiliomp\Pkuatia\Fields\Request\events\GDE;

use DOMElement;

/**
 * ID:GEC000 Raíz del grupo deeventos - Nodo padre: GSch03
 */
class TgGroupGesEve
{
  public TrGesEve $rGesEve; // GDE001 Raíz de Gestión de Eventos

  //====================================================//
  // Setters
  //====================================================//

  /**
   * Método responsable de realizar la información del grupo de eventos
   *
   * @param DOMElement $rGesEve
   */
  public function setRGesEve(string $rGesEve): self
  {
    $this->rGesEve = $rGesEve;
    return $this;
  }

   //====================================================//
   // Getters
   //====================================================//


  public function getRGesEve(): TrGesEve
  {
    return $this->rGesEve;
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
    $res = new DOMElement('rGeVeCan');
    $res->appendChild(new DOMElement('Id', $this->getId()));
    $res->appendChild(new DOMElement('mOtEve', $this->getMOtEve()));
    return $res;
  }
}
