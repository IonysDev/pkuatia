<?php

namespace Abiliomp\Pkuatia\Fields\Request\events\GER;

use DateTime;
use DOMElement;

/**
 * ID:GEN001 Raíz Gestión de Eventos Notificación – Recepción DE o DTE PADRE:GDE007
 */
class RGeVeNotRec
{
  public string $Id; ///GEN002 Identificador del DE/DTE
  public DateTime $dFecEmi; ///GEN003 Fecha de emisión del DE/DTE
  public DateTime $dFecRecep; //EN004 Fecha Recepción DE 
  public int $iTipRec; //GEN005 Tipo de Receptor
  public string $dNomRec; //GEN006 Nombre o Razón Social del Receptor del DE/DTE
  public string $dRucRec; //GEN007 Ruc del Receptor 
  public int $dDVRec; ///GEN008 Dígito verificador del RUC del contribuyente receptor
  public int $dTipIDRec; //GEN009 Tipo de documento de identidad del receptor
  public string $dNumID; ///GEN010 Número de documento de identidad 
  public int $dTotalGs; //GEN011 Total general de la operación en Guaraníes

  ///SETTERS
  /**
   * Set the value of Id
   *
   * @param string $Id
   *
   * @return self
   */
  public function setId(string $Id): self
  {
    $this->Id = $Id;

    return $this;
  }


  /**
   * Set the value of dFecEmi
   *
   * @param DateTime $dFecEmi
   *
   * @return self
   */
  public function setDFecEmi(DateTime $dFecEmi): self
  {
    $this->dFecEmi = $dFecEmi;

    return $this;
  }


  /**
   * Set the value of dFecRecep
   *
   * @param DateTime $dFecRecep
   *
   * @return self
   */
  public function setDFecRecep(DateTime $dFecRecep): self
  {
    $this->dFecRecep = $dFecRecep;

    return $this;
  }


  /**
   * Set the value of iTipRec
   *
   * @param int $iTipRec
   *
   * @return self
   */
  public function setITipRec(int $iTipRec): self
  {
    $this->iTipRec = $iTipRec;

    return $this;
  }


  /**
   * Set the value of dNomRec
   *
   * @param string $dNomRec
   *
   * @return self
   */
  public function setDNomRec(string $dNomRec): self
  {
    $this->dNomRec = $dNomRec;

    return $this;
  }


  /**
   * Set the value of dRucRec
   *
   * @param string $dRucRec
   *
   * @return self
   */
  public function setDRucRec(string $dRucRec): self
  {
    $this->dRucRec = $dRucRec;

    return $this;
  }


  /**
   * Set the value of dDVRec
   *
   * @param int $dDVRec
   *
   * @return self
   */
  public function setDDVRec(int $dDVRec): self
  {
    $this->dDVRec = $dDVRec;

    return $this;
  }


  /**
   * Set the value of dTipIDRec
   *
   * @param int $dTipIDRec
   *
   * @return self
   */
  public function setDTipIDRec(int $dTipIDRec): self
  {
    $this->dTipIDRec = $dTipIDRec;

    return $this;
  }


  /**
   * Set the value of dNumID
   *
   * @param string $dNumID
   *
   * @return self
   */
  public function setDNumID(string $dNumID): self
  {
    $this->dNumID = $dNumID;

    return $this;
  }

  /**
   * Set the value of dTotalGs
   *
   * @param int $dTotalGs
   *
   * @return self
   */
  public function setDTotalGs(int $dTotalGs): self
  {
    $this->dTotalGs = $dTotalGs;

    return $this;
  }

  ///GETTERS


  /**
   * Get the value of Id
   *
   * @return string
   */
  public function getId(): string
  {
    return $this->Id;
  }

  /**
   * Get the value of dFecEmi
   *
   * @return DateTime
   */
  public function getDFecEmi(): DateTime
  {
    return $this->dFecEmi;
  }

  /**
   * Get the value of dFecRecep
   *
   * @return DateTime
   */
  public function getDFecRecep(): DateTime
  {
    return $this->dFecRecep;
  }

  /**
   * Get the value of iTipRec
   *
   * @return int
   */
  public function getITipRec(): int
  {
    return $this->iTipRec;
  }

  /**
   * Get the value of dNomRec
   *
   * @return string
   */
  public function getDNomRec(): string
  {
    return $this->dNomRec;
  }

  /**
   * Get the value of dRucRec
   *
   * @return string
   */
  public function getDRucRec(): string
  {
    return $this->dRucRec;
  }

  /**
   * Get the value of dDVRec
   *
   * @return int
   */
  public function getDDVRec(): int
  {
    return $this->dDVRec;
  }

  /**
   * Get the value of dTipIDRec
   *
   * @return int
   */
  public function getDTipIDRec(): int
  {
    return $this->dTipIDRec;
  }

  /**
   * Get the value of dNumID
   *
   * @return string
   */
  public function getDNumID(): string
  {
    return $this->dNumID;
  }

  /**
   * Get the value of dTotalGs
   *
   * @return int
   */
  public function getDTotalGs(): int
  {
    return $this->dTotalGs;
  }



  ////XML ELEMENT  
  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('rGeVeNotRec');
    $res->appendChild(new DOMElement('Id', $this->getId()));
    $res->appendChild(new DOMElement('dFecEmi', $this->getDFecEmi()->format('Y-m-d\TH:i:s')));
    $res->appendChild(new DOMElement('dFecRecep', $this->getDFecRecep()->format('Y-m-d\TH:i:s')));
    $res->appendChild(new DOMElement('iTipRec', $this->getITipRec()));
    $res->appendChild(new DOMElement('dNomRec', $this->getDNomRec()));
    if ($this->iTipRec == 1) {
      $res->appendChild(new DOMElement('dRucRec', $this->getDRucRec()));
      $res->appendChild(new DOMElement('dRucRec', $this->getDRucRec()));
    }

    if ($this->iTipRec == 2) {
      $res->appendChild(new DOMElement('dTipIDRec', $this->getDTipIDRec()));
      $res->appendChild(new DOMElement('dNumID', $this->getDNumID()));
    }

    $res->appendChild(new DOMElement('dTotalGs', $this->getDTotalGs()));
    return $res;
  }
}
