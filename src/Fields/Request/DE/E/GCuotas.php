<?php

namespace Abiliomp\Pkuatia\Fields\E;

use DateTime;
use DOMElement;

/**
 *  ID:E650 
 *  Campos que describen las cuotas
 * PADRE: E640
 */
class GCuotas
{
  public string $cMoneCuo; //E653 Moneda de las cuotas
  public int $dMonCuota; //E651 Monto de cada cuota
  public DateTime $dVencCuo; //E652  Fecha de vencimiento de cada cuota;

  //====================================================//
  ///Setters
  //====================================================//


  /**
   * Set the value of cMoneCuo
   *
   * @param string $cMoneCuo
   *
   * @return self
   */
  public function setCMoneCuo(string $cMoneCuo): self
  {
    $this->cMoneCuo = $cMoneCuo;

    return $this;
  }


  /**
   * Set the value of dMonCuota
   *
   * @param int $dMonCuota
   *
   * @return self
   */
  public function setDMonCuota(int $dMonCuota): self
  {
    $this->dMonCuota = $dMonCuota;

    return $this;
  }


  /**
   * Set the value of dVencCuo
   *
   * @param DateTime $dVencCuo
   *
   * @return self
   */
  public function setDVencCuo(DateTime $dVencCuo): self
  {
    $this->dVencCuo = $dVencCuo;

    return $this;
  }

  //====================================================//
  ///Getters
  //====================================================//

  /**
   * Get the value of cMoneCuo
   *
   * @return string
   */
  public function getCMoneCuo(): string
  {
    return $this->cMoneCuo;
  }

  /**
   * E654  Descripción de la moneda de las cuotas
   *
   * @return string
   */
  public function getDDMoneCuo(): string
  {
    return "Moneda de Mordor";
  }

  /**
   * Get the value of dMonCuota
   *
   * @return int
   */
  public function getDMonCuota(): int
  {
    return $this->dMonCuota;
  }

  /**
   * Get the value of dVencCuo
   *
   * @return DateTime
   */
  public function getDVencCuo(): DateTime
  {
    return $this->dVencCuo;
  }

  //====================================================//
  ///XML Element
  //====================================================//

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('gCuotas');

    $res->appendChild(new DOMElement('cMoneCuo', $this->getCMoneCuo()));
    $res->appendChild(new DOMElement('dDMoneCuo', $this->getDDMoneCuo()));
    $res->appendChild(new DOMElement('dMonCuota', $this->getDMonCuota()));
    $res->appendChild(new DOMElement('dVencCuo', $this->getDVencCuo()->format("Y-m-d")));

    return $res;
  }
}
