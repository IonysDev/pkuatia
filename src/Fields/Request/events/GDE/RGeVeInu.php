<?php

namespace Abiliomp\Pkuatia\Fields\Request\events\GDE;

use DOMElement;

/**
 * ID:GEI001 Raiz Gestión de Eventos Inutilización PADRE:GDE007
 */
class RGeVeInu
{
  public int $dNumTim; ///GEI002 Número del Timbrado
  public string $dEst; ///GEI003 Establecimiento
  public string $dPunExp; ///GEI004 Punto de expedición
  public string $dNumIn; ///GEI005 Número Inicio del rango del documento
  public string $dNumFin; ///GEI006 Número Final del rango del documento
  public int $iTiDE; ///GEI007 Tipo de Documento Electrónico
  public string $mOtEve; ///GEI008 Motivo del Evento

   //====================================================//
  ///SETTERS
   //====================================================//

  /**
   * Set the value of dNumTim
   *
   * @param int $dNumTim
   *
   * @return self
   */
  public function setDNumTim(int $dNumTim): self
  {
    $this->dNumTim = $dNumTim;

    return $this;
  }


  /**
   * Set the value of dEst
   *
   * @param string $dEst
   *
   * @return self
   */
  public function setDEst(string $dEst): self
  {
    $this->dEst = $dEst;

    return $this;
  }


  /**
   * Set the value of dPunExp
   *
   * @param string $dPunExp
   *
   * @return self
   */
  public function setDPunExp(string $dPunExp): self
  {
    $this->dPunExp = $dPunExp;

    return $this;
  }


  /**
   * Set the value of dNumIn
   *
   * @param string $dNumIn
   *
   * @return self
   */
  public function setDNumIn(string $dNumIn): self
  {
    $this->dNumIn = $dNumIn;

    return $this;
  }


  /**
   * Set the value of dNumFin
   *
   * @param string $dNumFin
   *
   * @return self
   */
  public function setDNumFin(string $dNumFin): self
  {
    $this->dNumFin = $dNumFin;

    return $this;
  }


  /**
   * Set the value of iTiDE
   *
   * @param int $iTiDE
   *
   * @return self
   */
  public function setITiDE(int $iTiDE): self
  {
    $this->iTiDE = $iTiDE;

    return $this;
  }


  /**
   * Set the value of mOtEve
   *
   * @param string $mOtEve
   *
   * @return self
   */
  public function setMOtEve(string $mOtEve): self
  {
    $this->mOtEve = $mOtEve;

    return $this;
  }

  ///GETTERS

  /**
   * Get the value of dNumTim
   *
   * @return int
   */
  public function getDNumTim(): int
  {
    return $this->dNumTim;
  }

  /**
   * Get the value of dEst
   *
   * @return string
   */
  public function getDEst(): string
  {
    return $this->dEst;
  }

  /**
   * Get the value of dPunExp
   *
   * @return string
   */
  public function getDPunExp(): string
  {
    return $this->dPunExp;
  }

  /**
   * Get the value of dNumIn
   *
   * @return string
   */
  public function getDNumIn(): string
  {
    return $this->dNumIn;
  }

  /**
   * Get the value of dNumFin
   *
   * @return string
   */
  public function getDNumFin(): string
  {
    return $this->dNumFin;
  }

  /**
   * Get the value of iTiDE
   *
   * @return int
   */
  public function getITiDE(): int
  {
    return $this->iTiDE;
  }

  /**
   * Get the value of mOtEve
   *
   * @return string
   */
  public function getMOtEve(): string
  {
    return $this->mOtEve;
  }

  ///XML Element  
  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('rGeVeInu');
    $res->appendChild(new DOMElement('dNumTim', $this->getDNumTim()));
    $res->appendChild(new DOMElement('dEst', str_pad($this->dEst, 3, '0', STR_PAD_LEFT)));
    $res->appendChild(new DOMElement('dPunExp', str_pad($this->dPunExp, 3, '0', STR_PAD_LEFT)));
    $res->appendChild(new DOMElement('dNumIn', str_pad($this->dNumIn, 7, '0', STR_PAD_LEFT)));
    $res->appendChild(new DOMElement('dNumFin', str_pad($this->dNumFin,7,'0',STR_PAD_LEFT)));
    $res->appendChild(new DOMElement('iTiDE', $this->getITiDE()));
    $res->appendChild(new DOMElement('mOtEve', $this->getMOtEve()));
    return $res;
  }
}
