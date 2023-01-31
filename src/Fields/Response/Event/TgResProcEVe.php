<?php

namespace Abiliomp\Pkuatia\Fields\Response\Event;

use Abiliomp\Pkuatia\Fields\Response\TgResProc;
use DOMElement;

/**
 * ID:GRSch03 gResProcEVe Grupo Resultado de Procesamientodel Evento PADRE:GRSch01
 */
class TgResProcEVe
{
  public string $dEstRes;    // GRSch030 - Estado del resultado
  public int $dProtAut;      // GRSch031 - Número de transacción
  public int $id;            // GRSch032 -Identificador del evento
  public TgResProc $gResProc; // GRSch033 Grupo Resultado de Procesamiento 


  //====================================================//
  ///SETTERS
  //====================================================//

  /**
   * Set the value of dEstRes
   *
   * @param string $dEstRes
   *
   * @return self
   */
  public function setDEstRes(string $dEstRes): self
  {
    $this->dEstRes = $dEstRes;

    return $this;
  }


  /**
   * Set the value of dProtAut
   *
   * @param int $dProtAut
   *
   * @return self
   */
  public function setDProtAut(int $dProtAut): self
  {
    $this->dProtAut = $dProtAut;

    return $this;
  }


  /**
   * Set the value of id
   *
   * @param int $id
   *
   * @return self
   */
  public function setId(int $id): self
  {
    $this->id = $id;

    return $this;
  }


  /**
   * Set the value of gResProc
   *
   * @param TgResProc $gResProc
   *
   * @return self
   */
  public function setGResProc(TgResProc $gResProc): self
  {
    $this->gResProc = $gResProc;

    return $this;
  }


  //====================================================//
  //GETTERS
  //====================================================//


  /**
   * Get the value of dEstRes
   *
   * @return string
   */
  public function getDEstRes(): string
  {
    return $this->dEstRes;
  }

  /**
   * Get the value of dProtAut
   *
   * @return int
   */
  public function getDProtAut(): int
  {
    return $this->dProtAut;
  }

  /**
   * Get the value of id
   *
   * @return int
   */
  public function getId(): int
  {
    return $this->id;
  }

  /**
   * Get the value of gResProc
   *
   * @return TgResProc
   */
  public function getGResProc(): TgResProc
  {
    return $this->gResProc;
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
    $res = new DOMElement('TgResProcEVe');

    $res->appendChild(new DOMElement('dEstRes', $this->dEstRes));
    $res->appendChild(new DOMElement('dProtAut', $this->getDProtAut()));
    $res->appendChild(new DOMElement('id', $this->id));
    $res->appendChild($this->gResProc->toDOMElement());
    return $res;
  }
}
