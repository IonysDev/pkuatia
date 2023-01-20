<?php

namespace Abiliomp\Pkuatia\Fields\AA;

use Abiliomp\Pkuatia\Fields\A\DE;
use DOMElement;

/** ID: AA001
 * Campos que identifican el formato electrónico XML (AA001-AA009)
 * PADRE: RAIZ
 */
class RDE
{
  public int $dVerFor; //AA002 Versión del formato
  public DE $dE;

  ///SETTERS

  /**
   * Set the value of dVerFor
   *
   * @param int $dVerFor
   *
   * @return self
   */
  public function setDVerFor(int $dVerFor): self
  {
    $this->dVerFor = $dVerFor;

    return $this;
  }

  ///Getters

  /**
   * Get the value of dVerFor
   *
   * @return int
   */
  public function getDVerFor(): int
  {
    return $this->dVerFor;
  }

  ///XML Element
  
  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('rDe');

    $res->appendChild(new DOMElement('dVerFor',$this->getDVerFor()));

    return $res;
  }


  ///Others
  /**
   * Get the value of dE
   *
   * @return DE
   */
  public function getDE(): DE
  {
    return $this->dE;
  }

  /**
   * Set the value of dE
   *
   * @param DE $dE
   *
   * @return self
   */
  public function setDE(DE $dE): self
  {
    $this->dE = $dE;

    return $this;
  }
}
