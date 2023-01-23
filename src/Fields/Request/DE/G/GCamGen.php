<?php

namespace Abiliomp\Pkuatia\Fields\G;

use DOMElement;

/**
 *  ID:G001 Campos de uso general PADRE:A001 
 */
class GCamGen
{
  public string $dOrdCompra; //G002 Número de orden de compra
  public string $dOrdVta; ///G003 Número de orden de venta 
  public string $dAsiento; ///G004 Número de asiento contable
  public GCamCarg $gCamCarg;
  ///SETTER



  /**
   * Set the value of dOrdCompra
   *
   * @param string $dOrdCompra
   *
   * @return self
   */
  public function setDOrdCompra(string $dOrdCompra): self
  {
    $this->dOrdCompra = $dOrdCompra;

    return $this;
  }


  /**
   * Set the value of dOrdVta
   *
   * @param string $dOrdVta
   *
   * @return self
   */
  public function setDOrdVta(string $dOrdVta): self
  {
    $this->dOrdVta = $dOrdVta;

    return $this;
  }


  /**
   * Set the value of dAsiento
   *
   * @param string $dAsiento
   *
   * @return self
   */
  public function setDAsiento(string $dAsiento): self
  {
    $this->dAsiento = $dAsiento;

    return $this;
  }


  ///GETTERS


  /**
   * Get the value of dOrdCompra
   *
   * @return string
   */
  public function getDOrdCompra(): string
  {
    return $this->dOrdCompra;
  }

  /**
   * Get the value of dOrdVta
   *
   * @return string
   */
  public function getDOrdVta(): string
  {
    return $this->dOrdVta;
  }

  /**
   * Get the value of dAsiento
   *
   * @return string
   */
  public function getDAsiento(): string
  {
    return $this->dAsiento;
  }

  ///XML Element

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('gCamGen');
    $res->appendChild(new DOMElement('dOrdCompra', $this->getDOrdCompra()));
    $res->appendChild(new DOMElement('dOrdVta', $this->getDOrdVta()));
    $res->appendChild(new DOMElement('dAsiento', $this->getDAsiento()));
    return $res;
  }

  /**
   * Get the value of gCamCarg
   *
   * @return GCamCarg
   */
  public function getGCamCarg(): GCamCarg
  {
    return $this->gCamCarg;
  }

  /**
   * Set the value of gCamCarg
   *
   * @param GCamCarg $gCamCarg
   *
   * @return self
   */
  public function setGCamCarg(GCamCarg $gCamCarg): self
  {
    $this->gCamCarg = $gCamCarg;

    return $this;
  }
}
