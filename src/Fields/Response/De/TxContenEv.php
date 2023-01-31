<?php

namespace Abiliomp\Pkuatia\Fields\Response\De;

use DOMElement;

class TxContenEv
{
  public TrContEv $rContEv;

  //====================================================//
  ///SETTERS
  //====================================================//

  /**
   * Set the value of rContEv
   *
   * @param TrContEv $rContEv
   *
   * @return self
   */
  public function setRContEv(TrContEv $rContEv): self
  {
    $this->rContEv = $rContEv;

    return $this;
  }

  //====================================================//
  //GETTERS
  //====================================================//

  /**
   * Get the value of rContEv
   *
   * @return TrContEv
   */
  public function getRContEv(): TrContEv
  {
    return $this->rContEv;
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
    $res = new DOMElement('TxContenEv');

    $res->appendChild($this->rContEv->toDOMElement());

    return $res;
  }
}
