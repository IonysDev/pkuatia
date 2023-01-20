<?php

namespace Abiliomp\Pkuatia\Fields\E;

use DOMElement;

/**
 * Campos que describen la condición de la operación (E600-E699)
 * ID:E600 Campos que describen la condición de la operación PADRE:E001 
 */
class GCamCond
{
  public int $iCondOpe; ///E601 iCondOpe Condición de la operación
  public GPaConEIni $gPaConEIni;
  public GPagCred $gPagCred;

  ///Setters

  /**
   * Set the value of iCondOpe
   *
   * @param int $iCondOpe
   *
   * @return self
   */
  public function setICondOpe(int $iCondOpe): self
  {
    $this->iCondOpe = $iCondOpe;

    return $this;
  }

  ///Getters
  /**
   * Get the value of iCondOpe
   *
   * @return int
   */
  public function getICondOpe(): int
  {
    return $this->iCondOpe;
  }

  /**
   * E602  Descripción de la condición de operación
   *
   * @return string
   */
  public function getDDCondOpe(): string
  {
    switch ($this->iCondOpe) {
      case 1:
        return "Contado";
        break;

      case 2:
        return "Crédito";
        break;

      default:
        return null;
        break;
    }
  }


  ///XML Element  
  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement() : DOMElement
  {
    $res = new DOMElement('gCamCond');

    $res->appendChild(new DOMElement('iCondOpe', $this->getICondOpe()));
    $res->appendChild(new DOMElement('dDCondOpe', $this->getDDCondOpe()));

    return $res;
  }
}
?> 