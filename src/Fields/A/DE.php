<?php

namespace Abiliomp\Pkuatia\Fields\A;

use Abiliomp\Pkuatia\Fields\B\GOpeDE;
use Abiliomp\Pkuatia\Fields\C\GTimb;
use Abiliomp\Pkuatia\Fields\D\GDatGralOpe;
use Abiliomp\Pkuatia\Fields\E\GDtipDE;
use DateTime;
use DOMElement;

/**
 * ID:A001  Campos firmados del DE PADRE:AA001
 */
class DE
{
  public string $iD; //A002 Identificador del DE
  public int $dDVId; //A003 dígito verificador del dentificador del DE 
  public DateTime $dFecFirma; //A004 Fecha de la firma
  public int $dSisFact; //A005 dSisFact Sistema de facturación
  public GOpeDE $gOpeDe;
  public GTimb $gTimb;
  public GDatGralOpe $dDatGralOpe;
  public GDtipDE $gDtipDe;

  ///Setters
  /**
   * Set the value of iD
   *
   * @param string $iD
   *
   * @return self
   */
  public function setID(string $iD): self
  {
    $this->iD = $iD;

    return $this;
  }


  /**
   * Set the value of dDVId
   *
   * @param int $dDVId
   *
   * @return self
   */
  public function setDDVId(int $dDVId): self
  {
    $this->dDVId = $dDVId;

    return $this;
  }


  /**
   * Set the value of dFecFirma
   *
   * @param DateTime $dFecFirma
   *
   * @return self
   */
  public function setDFecFirma(DateTime $dFecFirma): self
  {
    $this->dFecFirma = $dFecFirma;

    return $this;
  }


  /**
   * Set the value of dSisFact
   *
   * @param int $dSisFact
   *
   * @return self
   */
  public function setDSisFact(int $dSisFact): self
  {
    $this->dSisFact = $dSisFact;

    return $this;
  }

  ///Getters


  /**
   * Get the value of iD
   *
   * @return string
   */
  public function getID(): string
  {
    return $this->iD;
  }

  /**
   * Get the value of dDVId
   *
   * @return int
   */
  public function getDDVId(): int
  {
    return $this->dDVId;
  }

  /**
   * Get the value of dFecFirma
   *
   * @return DateTime
   */
  public function getDFecFirma(): DateTime
  {
    return $this->dFecFirma;
  }

  /**
   * Get the value of dSisFact
   *
   * @return int
   */
  public function getDSisFact(): int
  {
    return $this->dSisFact;
  }

  ///XML Element

  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('DE');

    $res->appendChild(new DOMElement('Id', $this->getID()));
    $res->appendChild(new DOMElement('dDVId', $this->getDDVId()));
    $res->appendChild(new DOMElement('dFecFirma', $this->getDFecFirma()->format('Y-m-d\TH:i:s')));
    $res->appendChild(new DOMElement('dSisFact', $this->getDSisFact()));

    return $res;
  }

  /**
   * Get the value of gOpeDe
   *
   * @return GOpeDE
   */
  public function getGOpeDe(): GOpeDE
  {
    return $this->gOpeDe;
  }

  /**
   * Set the value of gOpeDe
   *
   * @param GOpeDE $gOpeDe
   *
   * @return self
   */
  public function setGOpeDe(GOpeDE $gOpeDe): self
  {
    $this->gOpeDe = $gOpeDe;

    return $this;
  }

  /**
   * Get the value of gTimb
   *
   * @return GTimb
   */
  public function getGTimb(): GTimb
  {
    return $this->gTimb;
  }

  /**
   * Set the value of gTimb
   *
   * @param GTimb $gTimb
   *
   * @return self
   */
  public function setGTimb(GTimb $gTimb): self
  {
    $this->gTimb = $gTimb;

    return $this;
  }

  /**
   * Get the value of dDatGralOpe
   *
   * @return GDatGralOpe
   */
  public function getDDatGralOpe(): GDatGralOpe
  {
    return $this->dDatGralOpe;
  }

  /**
   * Set the value of dDatGralOpe
   *
   * @param GDatGralOpe $dDatGralOpe
   *
   * @return self
   */
  public function setDDatGralOpe(GDatGralOpe $dDatGralOpe): self
  {
    $this->dDatGralOpe = $dDatGralOpe;

    return $this;
  }

  /**
   * Get the value of gDtipDe
   *
   * @return GDtipDE
   */
  public function getGDtipDe(): GDtipDE
  {
    return $this->gDtipDe;
  }

  /**
   * Set the value of gDtipDe
   *
   * @param GDtipDE $gDtipDe
   *
   * @return self
   */
  public function setGDtipDe(GDtipDE $gDtipDe): self
  {
    $this->gDtipDe = $gDtipDe;

    return $this;
  }
}
