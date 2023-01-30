<?php

namespace Abiliomp\Pkuatia\Fields\Request\Events\GDE;

use DOMElement;

/**
 * Nodo: GEI001 - rGeVeInu - Campos generales del DE
 * Padre: GDE007 - gGroupTiEvt - Grupo de campos del tipo de evento
 */
class TrGeVeInu
{
  public int    $dNumTim; // GEI002 - Número del Timbrado
  public string $dEst;    // GEI003 - Establecimiento
  public string $dPunExp; // GEI004 - Punto de expedición
  public string $dNumIn;  // GEI005 - Número Inicio del rango del documento
  public string $dNumFin; // GEI006 - Número Final del rango del documento
  public int    $iTiDE;   // GEI007 - Tipo de Documento Electrónico
  public string $mOtEve;  // GEI008 - Motivo del Evento

  //====================================================//
  // Setters
  //====================================================//

  /**
   * Establece el valor de dNumTim - Número del Timbrado
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
   * Establece el valor de dEst - Establecimiento
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
   * Establece el valor de dPunExp - Punto de expedición
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
   * Establece el valor de dNumIn - Número Inicio del rango del documento
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
   * Establece el valor de dNumFin - Número Final del rango del documento
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
   * Establece el valor de iTiDE - Tipo de Documento Electrónico
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
   * Establece el valor de mOtEve - Motivo del Evento
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


  //====================================================//
  // Getters
  //====================================================//

  /**
   * Obtiene el valor de dNumTim - Número del Timbrado
   *
   * @return int
   */
  public function getDNumTim(): int
  {
    return $this->dNumTim;
  }

  /**
   * Obtiene el valor de dEst - Establecimiento
   *
   * @return string
   */
  public function getDEst(): string
  {
    return $this->dEst;
  }

  /**
   * Obtiene el valor de dPunExp - Punto de expedición
   *
   * @return string
   */
  public function getDPunExp(): string
  {
    return $this->dPunExp;
  }

  /**
   * Obtiene el valor de dNumIn - Número Inicio del rango del documento
   *
   * @return string
   */
  public function getDNumIn(): string
  {
    return $this->dNumIn;
  }

  /**
   * Obtiene el valor de dNumFin - Número Final del rango del documento
   *
   * @return string
   */
  public function getDNumFin(): string
  {
    return $this->dNumFin;
  }

  /**
   * Obtiene el valor de iTiDE - Tipo de Documento Electrónico
   *
   * @return int
   */
  public function getITiDE(): int
  {
    return $this->iTiDE;
  }

  /**
   * Obtiene el valor de mOtEve - Motivo del Evento
   *
   * @return string
   */
  public function getMOtEve(): string
  {
    return $this->mOtEve;
  }

  
  //====================================================//
  // Conversiones XML
  //====================================================//

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
