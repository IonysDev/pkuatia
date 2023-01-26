<?php

namespace Abiliomp\Pkuatia\Fields\E;

use DOMElement;

/**
 * ID:E630 
 * Campos que describen el pago o entrega inicial de la operación con cheque
 * PADRE:E605
 */
class GPagCheq
{
  public string $dNumCheq; //E631 Número de cheque  
  public string $dBcoEmi; //E632  Banco emisor

  //====================================================//
  ///Settets
  //====================================================//


  /**
   * Set the value of dNumCheq
   *
   * @param string $dNumCheq
   *
   * @return self
   */
  public function setDNumCheq(string $dNumCheq): self
  {
    $this->dNumCheq = $dNumCheq;

    return $this;
  }


  /**
   * Set the value of dBcoEmi
   *
   * @param string $dBcoEmi
   *
   * @return self
   */
  public function setDBcoEmi(string $dBcoEmi): self
  {
    $this->dBcoEmi = $dBcoEmi;

    return $this;
  }

  //====================================================//
  //GETTERS
  //====================================================//


  /**
   * Get the value of dNumCheq
   *
   * @return string
   */
  public function getDNumCheq(): string
  {
    return $this->dNumCheq;
  }

  /**
   * Get the value of dBcoEmi
   *
   * @return string
   */
  public function getDBcoEmi(): string
  {
    return $this->dBcoEmi;
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
    $res = new DOMElement('gPagCheq');

    //Completar con 0 (cero) a la izquierda hasta alcanzar 8 (ocho) cifras
    $res->appendChild(new DOMElement('dNumCheq', str_pad($this->dNumCheq, 8, "0", STR_PAD_LEFT)));
    $res->appendChild(new DOMElement('dBcoEmi', $this->getDBcoEmi()));

    return $res;
  }
}
