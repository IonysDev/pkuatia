<?php

namespace Abiliomp\Pkuatia\Fields\Request\events\GEA;

use DateTime;
use DOMElement;

/**
 * ID:GECF001 Raíz Gestión de Eventos de créditos fiscales PADRE:GDE007
 */
class RGeVeCCFF
{
  public string $Id; // GECF002 CDC del DE/DTE
  public string $dNumTraCCFF; ///GECF003 Número de  transferencia de  créditos fiscales
  public DateTime $dFeAceTraCCFF; //GECF004 Fecha de aceptación del crédito fiscal

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


  /**
   * Set the value of dNumTraCCFF
   *
   * @param string $dNumTraCCFF
   *
   * @return self
   */
  public function setDNumTraCCFF(string $dNumTraCCFF): self
  {
    $this->dNumTraCCFF = $dNumTraCCFF;

    return $this;
  }


  /**
   * Set the value of dFeAceTraCCFF
   *
   * @param DateTime $dFeAceTraCCFF
   *
   * @return self
   */
  public function setDFeAceTraCCFF(DateTime $dFeAceTraCCFF): self
  {
    $this->dFeAceTraCCFF = $dFeAceTraCCFF;

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

  /**
   * Get the value of dNumTraCCFF
   *
   * @return string
   */
  public function getDNumTraCCFF(): string
  {
    return $this->dNumTraCCFF;
  }

  /**
   * Get the value of dFeAceTraCCFF
   *
   * @return DateTime
   */
  public function getDFeAceTraCCFF(): DateTime
  {
    return $this->dFeAceTraCCFF;
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
    $res = new DOMElement('rGeVeCCFF');
    $res->appendChild(new DOMElement('Id', $this->getId()));
    $res->appendChild(new DOMElement('dNumTraCCFF', $this->getDNumTraCCFF()));
    $res->appendChild(new DOMElement('dFeAceTraCCFF', $this->getDFeAceTraCCFF()->format('Y-m-d')));
    return $res;
  }
}
