<?php

namespace Abiliomp\Pkuatia\Fields\Request\events\GEA;

use DOMElement;

/**
 *  ID:GERE001  Raíz Gestión de Eventos remisión PADRE:GDE007
 */
class TrGeVeRem
{
  public string $Id;///GERE002 CDC del DTE asociado

   //====================================================//
  ///SETTERS
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
    $res = new DOMElement('rGeVeRem');
    $res->appendChild(new DOMElement('Id',$this->getId()));

    return $res;
  }
}
