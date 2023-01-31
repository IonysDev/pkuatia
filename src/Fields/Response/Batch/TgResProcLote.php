<?php

namespace Abiliomp\Pkuatia\Fields\Response\Batch;

use Abiliomp\Pkuatia\Fields\Response\TgResProc;
use DOMElement;

/**
 * ID:CRSch05 Grupo Resultado de Procesamiento del Lote PADRE:CRSch01
 */
class TgResProcLote
{
  public String $id;           // CRSch050 - CDC del DE
  public String $dEstRes;     // CRSch051 - Estado del resultado
  public String $dProtAut;   // CRSch052 - Número de transacción 
  public TgResProc $gResProc; // CRSch053 - Grupo Mensaje de Resultado

  //====================================================//
  ///SETTERS
  //====================================================//

  /**
   * Set the value of id
   *
   * @param String $id
   *
   * @return self
   */
  public function setId(String $id): self
  {
    $this->id = $id;

    return $this;
  }


  /**
   * Set the value of dEstRes
   *
   * @param String $dEstRes
   *
   * @return self
   */
  public function setDEstRes(String $dEstRes): self
  {
    $this->dEstRes = $dEstRes;

    return $this;
  }


  /**
   * Set the value of dProtAut
   *
   * @param String $dProtAut
   *
   * @return self
   */
  public function setDProtAut(String $dProtAut): self
  {
    $this->dProtAut = $dProtAut;

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
   * Get the value of id
   *
   * @return String
   */
  public function getId(): String
  {
    return $this->id;
  }

  /**
   * Get the value of dEstRes
   *
   * @return String
   */
  public function getDEstRes(): String
  {
    return $this->dEstRes;
  }

  /**
   * Get the value of dProtAut
   *
   * @return String
   */
  public function getDProtAut(): String
  {
    return $this->dProtAut;
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
    $res = new DOMElement('tgResProcLote');

    $res->appendChild(new DOMElement('id', $this->getId()));
    $res->appendChild(new DOMElement('dEstRes', $this->getDEstRes()));
    $res->appendChild(new DOMElement('dProtAut', $this->getDProtAut()));
    $res->appendChild($this->gResProc->toDOMElement());
    return $res;
  }
}
