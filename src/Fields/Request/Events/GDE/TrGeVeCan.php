<?php

namespace Abiliomp\Pkuatia\Fields\Request\events\GDE;

use DOMElement;

/**
 * Nodo: GEC001 - rGeVeCan - Campos generales del DE
 * Padre: GDE007 - gGroupTiEvt - Grupo de campos del tipo de evento
 */
class TrGeVeCan
{

  public string $Id; // GEC002 - Identificador del DTE
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
    $res = new DOMElement('rGeVeCan');
    $res->appendChild(new DOMElement('Id', $this->getId()));
    $res->appendChild(new DOMElement('mOtEve', $this->getMOtEve()));
    return $res;
  }

}
