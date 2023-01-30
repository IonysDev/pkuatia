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
