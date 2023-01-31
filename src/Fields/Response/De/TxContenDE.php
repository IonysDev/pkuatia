<?php

namespace Abiliomp\Pkuatia\Fields\Response\De;

use Abiliomp\Pkuatia\Fields\AA\RDE;
use DOMElement;

/**
 * ContDE01 Raíz
 */
class TxContenDE
{
  public RDE $rDe; //ContDE02 - Archivo XML del DE ContDE01 
  public string $dProtAut; //ContDE03 - Número De Transacción 
  public TxContenEv $xContEv; //ContDE04 - Contenedor de Evento

  //====================================================//
  ///SETTERS
  //====================================================//

  /**
   * Set the value of rDe
   *
   * @param RDE $rDe
   *
   * @return self
   */
  public function setRDe(RDE $rDe): self
  {
    $this->rDe = $rDe;

    return $this;
  }


  /**
   * Set the value of dProtAut
   *
   * @param string $dProtAut
   *
   * @return self
   */
  public function setDProtAut(string $dProtAut): self
  {
    $this->dProtAut = $dProtAut;

    return $this;
  }


  /**
   * Set the value of xContEv
   *
   * @param TxContenEv $xContEv
   *
   * @return self
   */
  public function setXContEv(TxContenEv $xContEv): self
  {
    $this->xContEv = $xContEv;

    return $this;
  }


  //====================================================//
  //GETTERS
  //====================================================//
  

  /**
   * Get the value of rDe
   *
   * @return RDE
   */
  public function getRDe(): RDE
  {
    return $this->rDe;
  }

  /**
   * Get the value of dProtAut
   *
   * @return string
   */
  public function getDProtAut(): string
  {
    return $this->dProtAut;
  }

  /**
   * Get the value of xContEv
   *
   * @return TxContenEv
   */
  public function getXContEv(): TxContenEv
  {
    return $this->xContEv;
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
    $res = new DOMElement('TxContenDe');
    $res->appendChild($this->rDe->toDOMElement());
    $res->appendChild(new DOMElement('dProtAut',$this->dProtAut));
    $res->appendChild($this->xContEv->toDOMElement());

    return $res;
  }
}
