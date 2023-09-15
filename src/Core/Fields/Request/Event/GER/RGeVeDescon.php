<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\Event\GER;

use DateTime;
use DOMElement;

/**
 * ID:GED001 Raiz Gestión de Eventos Desconocimiento PADREGDE007
 */
class RGeVeDescon
{
  public String $Id; //GED002 CDC del DE/DTE
  public DateTime $dFecEmi; //GED003 Fecha de emisión del DE/DTE
  public DateTime $dFecRecep; //GED004 Fecha Recepción DE
  public int $iTipRec; //GED005 Tipo de Receptor
  public String $dNomRec; //GED006 Nombre o Razón Social del Receptor del DE/DTE
  public String $dRucRec; //GED007 Ruc del Receptor
  public int $dDVRec; //GED008 Dígito verificador del  RUC del contribuyente  receptor
  public int $dTipIDRec; //GED009 Tipo de documento de identidad del receptor
  public String $dNumID; ///GED010 Número de documento de identidad
  public String $mOtEve; //GED011 Motivo del Evento

  ///////////////////////////////////////////////////////////////////////
  ///SETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of Id
   *
   * @param String $Id
   *
   * @return self
   */
  public function setId(String $Id): self
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
   * @param String $dNomRec
   *
   * @return self
   */
  public function setDNomRec(String $dNomRec): self
  {
    $this->dNomRec = $dNomRec;

    return $this;
  }


  /**
   * Set the value of dRucRec
   *
   * @param String $dRucRec
   *
   * @return self
   */
  public function setDRucRec(String $dRucRec): self
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
   * @param String $dNumID
   *
   * @return self
   */
  public function setDNumID(String $dNumID): self
  {
    $this->dNumID = $dNumID;

    return $this;
  }


  /**
   * Set the value of mOtEve
   *
   * @param String $mOtEve
   *
   * @return self
   */
  public function setMOtEve(String $mOtEve): self
  {
    $this->mOtEve = $mOtEve;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  ///GETTERS
  ///////////////////////////////////////////////////////////////////////


  /**
   * Get the value of Id
   *
   * @return String
   */
  public function getId(): String
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
   * @return String
   */
  public function getDNomRec(): String
  {
    return $this->dNomRec;
  }

  /**
   * Get the value of dRucRec
   *
   * @return String
   */
  public function getDRucRec(): String
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
   * @return String
   */
  public function getDNumID(): String
  {
    return $this->dNumID;
  }

  /**
   * Get the value of mOtEve
   *
   * @return String
   */
  public function getMOtEve(): String
  {
    return $this->mOtEve;
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML Element  
  ///////////////////////////////////////////////////////////////////////

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('rGeVeDescon');
    $res->appendChild(new DOMElement('Id', $this->getId()));
    $res->appendChild(new DOMElement('dFecEmi', $this->getDFecEmi()->format('Y-m-d\TH:i:s')));
    $res->appendChild(new DOMElement('dFecRecep', $this->getDFecRecep()->format('Y-m-d\TH:i:s')));
    $res->appendChild(new DOMElement('iTipRec', $this->getITipRec()));
    $res->appendChild(new DOMElement('dNomRec', $this->getDNomRec()));
    if ($this->iTipRec == 1) {
      $res->appendChild(new DOMElement('dRucRec', $this->getDRucRec()));
      $res->appendChild(new DOMElement('dDVRec', $this->getDDVRec()));
    }

    if ($this->iTipRec == 2) {
      $res->appendChild(new DOMElement('dTipIDRec', $this->getITipRec()));
      $res->appendChild(new DOMElement('dNumID', $this->getDNumID()));
    }

    $res->appendChild(new DOMElement('mOtEve', $this->getMOtEve()));
    return $res;
  }

  /**
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return RGeVeDescon
   */
  public static function fromDOMElement(DOMElement $xml): RGeVeDescon
  {
    if (strcmp($xml->tagName, 'rGeVeDescon') == 0 && $xml->childElementCount == 10) {
      $res = new RGeVeDescon();
      $res->setId($xml->getElementsByTagName('Id')->item(0)->nodeValue);
      $res->setDFecEmi(DateTime::createFromFormat('Y-m-d\TH:i:s', $xml->getElementsByTagName('dFecEmi')->item(0)->nodeValue));
      $res->setDFecRecep(DateTime::createFromFormat('Y-m-d\TH:i:s', $xml->getElementsByTagName('dFecRecep')->item(0)->nodeValue));
      $res->setITipRec(intval($xml->getElementsByTagName('iTipRec')->item(0)->nodeValue));
      $res->setDNomRec($xml->getElementsByTagName('dNomRec')->item(0)->nodeValue);
      $res->setDRucRec($xml->getElementsByTagName('dRucRec')->item(0)->nodeValue);
      $res->setDDVRec(intval($xml->getElementsByTagName('dDVRec')->item(0)->nodeValue));
      $res->setDTipIDRec(intval($xml->getElementsByTagName('dTipIDRec')->item(0)->nodeValue));
      $res->setDNumID($xml->getElementsByTagName('dNumID')->item(0)->nodeValue);
      $res->setMOtEve($xml->getElementsByTagName('mOtEve')->item(0)->nodeValue);
      return $res;
    } else {
      throw new \Exception("Invalid XML Element: $xml->tagName");
      return null;
    }
  }
}
