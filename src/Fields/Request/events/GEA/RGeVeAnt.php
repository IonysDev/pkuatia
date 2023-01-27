<?php

namespace Abiliomp\Pkuatia\Fields\Request\events\GEA;

use DOMElement;

/**
 * ID:GEA001 Raíz Gestión de Eventos anticipo PADRE:GDE007
 */
class RGeVeAnt
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
}
