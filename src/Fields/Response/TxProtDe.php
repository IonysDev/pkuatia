<?php

namespace Abiliomp\Pkuatia\Fields\Response;

use DateTime;
use DOMElement;

class TxProtDe
{
  public string $id;
  public DateTime $dFecProc;
  public string $dDigVal;
  public String $dEstRes;
  public String $dProtAut;
  public TgResProc $gResProc;

  //====================================================//
  ///SETTERS
  //====================================================//

  /**
   * Set the value of id
   *
   * @param string $id
   *
   * @return self
   */
  public function setId(string $id): self
  {
    $this->id = $id;

    return $this;
  }


  /**
   * Set the value of dFecProc
   *
   * @param DateTime $dFecProc
   *
   * @return self
   */
  public function setDFecProc(DateTime $dFecProc): self
  {
    $this->dFecProc = $dFecProc;

    return $this;
  }


  /**
   * Set the value of dDigVal
   *
   * @param string $dDigVal
   *
   * @return self
   */
  public function setDDigVal(string $dDigVal): self
  {
    $this->dDigVal = $dDigVal;

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
   * @return string
   */
  public function getId(): string
  {
    return $this->id;
  }

  /**
   * Get the value of dFecProc
   *
   * @return DateTime
   */
  public function getDFecProc(): DateTime
  {
    return $this->dFecProc;
  }

  /**
   * Get the value of dDigVal
   *
   * @return string
   */
  public function getDDigVal(): string
  {
    return $this->dDigVal;
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
    $res = new DOMElement('txProtDe');
    return $res;
  }
}
