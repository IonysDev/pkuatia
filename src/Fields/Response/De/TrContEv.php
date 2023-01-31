<?php

namespace Abiliomp\Pkuatia\Fields\Response\De;

use Abiliomp\Pkuatia\Fields\Request\Events\GDE\TrGesEve;
use Abiliomp\Pkuatia\Fields\Response\Event\TgResProcEVe;
use DOMElement;

/**
 * ContEv01 Raíz
 */
class TrContEv
{
  public TrGesEve $xEvento; //ContEv02 - XML del Evento
  public TgResProcEVe $rResEnviEventoDe; //ContEv03 - Respuesta del WS Recepción Evento 

  //====================================================//
  ///SETTERS
  //====================================================//

  /**
   * Set the value of xEvento
   *
   * @param TrGesEve $xEvento
   *
   * @return self
   */
  public function setXEvento(TrGesEve $xEvento): self
  {
    $this->xEvento = $xEvento;

    return $this;
  }


  /**
   * Set the value of rResEnviEventoDe
   *
   * @param TgResProcEVe $rResEnviEventoDe
   *
   * @return self
   */
  public function setRResEnviEventoDe(TgResProcEVe $rResEnviEventoDe): self
  {
    $this->rResEnviEventoDe = $rResEnviEventoDe;

    return $this;
  }

  //====================================================//
  //GETTERS
  //====================================================//


  /**
   * Get the value of xEvento
   *
   * @return TrGesEve
   */
  public function getXEvento(): TrGesEve
  {
    return $this->xEvento;
  }

  /**
   * Get the value of rResEnviEventoDe
   *
   * @return TgResProcEVe
   */
  public function getRResEnviEventoDe(): TgResProcEVe
  {
    return $this->rResEnviEventoDe;
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
    $res = new DOMElement('TrContEv');

    $res->appendChild($this->xEvento->toDOMElement());
    $res->appendChild($this->rResEnviEventoDe->toDOMElement());
    return $res;
  }
}
