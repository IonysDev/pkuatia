<?php

namespace Abiliomp\Pkuatia\Fields\Request\events\GER;

use DOMElement;

/**
 *  ID:GDI001 Raiz Gestión de Eventos Disconformidad PADRE:GDE007
 */
class rGeVeDisconf
{
  public string $Id;// GDI002 CDC del DTE
  public string $mOtEve;///GDI004 Motivo del Evento

  //SETTERS

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


  /**
   * Set the value of mOtEve
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

  ///GETTERS
  

  /**
   * Get the value of Id
   *
   * @return string
   */
  public function getId(): string
  {
    return $this->Id;
  }

  /**
   * Get the value of mOtEve
   *
   * @return string
   */
  public function getMOtEve(): string
  {
    return $this->mOtEve;
  }

  ///XML Element
  
  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('rGeVeDisconf');

    $res->appendChild(new DOMElement('Id', $this->getId()));
    $res->appendChild(new DOMElement('mOtEve', $this->getMOtEve()));

    return $res;
  }
}
