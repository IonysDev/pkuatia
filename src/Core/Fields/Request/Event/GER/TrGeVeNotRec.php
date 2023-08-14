<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\events\GER;

use DateTime;
use DOMElement;

/**
 * Nodo: GEN001 - rGeVeNotRec - Raíz Gestión de Eventos Notificación: Recepción DE o DTE
 * Padre: GDE007 - gGroupTiEvt - Grupo de campos del tipo de evento
 */
class TrGeVeNotRec
{

  public string   $Id;        // GEN002 - Identificador del DE/DTE
  public DateTime $dFecEmi;   // GEN003 - Fecha de emisión del DE/DTE
  public DateTime $dFecRecep; // GEN004 - Fecha Recepción DE 
  public int      $iTipRec;   // GEN005 - Tipo de Receptor
  public string   $dNomRec;   // GEN006 - Nombre o Razón Social del Receptor del DE/DTE
  public string   $dRucRec;   // GEN007 - RUC del Receptor 
  public int      $dDVRec;    // GEN008 - Dígito verificador del RUC del contribuyente receptor
  public int      $dTipIDRec; // GEN009 - Tipo de documento de identidad del receptor
  public string   $dNumID;    // GEN010 - Número de documento de identidad 
  public int      $dTotalGs;  // GEN011 - Total general de la operación en Guaraníes


  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de Id - Identificador del DE/DTE
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
   * Establece el valor de dFecEmi - Fecha de emisión del DE/DTE
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
   * Establece el valor de dFecRecep - Fecha Recepción DE 
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
   * Establece el valor de iTipRec - Tipo de Receptor
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
   * Establece el valor de dNomRec - Nombre o Razón Social del Receptor del DE/DTE
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
   * Establece el valor de dRucRec - RUC del Receptor 
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
   * Establece el valor de dDVRec - Dígito verificador del RUC del contribuyente receptor
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
   * Establece el valor de dTipIDRec - Tipo de documento de identidad del receptor
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
   * Establece el valor de dNumID - Número de documento de identidad 
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
   * Establece el valor de dTotalGs - Total general de la operación en Guaraníes
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


  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de Id - Identificador del DE/DTE
   *
   * @return string
   */
  public function getId(): string
  {
    return $this->Id;
  }

  /**
   * Obtiene el valor de dFecEmi - Fecha de emisión del DE/DTE
   *
   * @return DateTime
   */
  public function getDFecEmi(): DateTime
  {
    return $this->dFecEmi;
  }

  /**
   * Obtiene el valor de dFecRecep - Fecha Recepción DE 
   *
   * @return DateTime
   */
  public function getDFecRecep(): DateTime
  {
    return $this->dFecRecep;
  }

  /**
   * Obtiene el valor de iTipRec - Tipo de Receptor
   *
   * @return int
   */
  public function getITipRec(): int
  {
    return $this->iTipRec;
  }

  /**
   * Obtiene el valor de dNomRec - Nombre o Razón Social del Receptor del DE/DTE
   *
   * @return string
   */
  public function getDNomRec(): string
  {
    return $this->dNomRec;
  }

  /**
   * Obtiene el valor de dRucRec - RUC del Receptor
   *
   * @return string
   */
  public function getDRucRec(): string
  {
    return $this->dRucRec;
  }

  /**
   * Obtiene el valor de dDVRec - Dígito verificador del RUC del contribuyente receptor
   *
   * @return int
   */
  public function getDDVRec(): int
  {
    return $this->dDVRec;
  }

  /**
   * Obtiene el valor de dTipIDRec - Tipo de documento de identidad del receptor
   *
   * @return int
   */
  public function getDTipIDRec(): int
  {
    return $this->dTipIDRec;
  }

  /**
   * Obtiene el valor de dNumID - Número de documento de identidad
   *
   * @return string
   */
  public function getDNumID(): string
  {
    return $this->dNumID;
  }

  /**
   * Obtiene el valor de dTotalGs - Total general de la operación en Guaraníes
   *
   * @return int
   */
  public function getDTotalGs(): int
  {
    return $this->dTotalGs;
  }


  ///////////////////////////////////////////////////////////////////////
  // Conversiones XML  
  ///////////////////////////////////////////////////////////////////////

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('trGeVeNotRec');
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
      $res->appendChild(new DOMElement('dTipIDRec', $this->getDTipIDRec()));
      $res->appendChild(new DOMElement('dNumID', $this->getDNumID()));
    }

    $res->appendChild(new DOMElement('dTotalGs', $this->getDTotalGs()));
    return $res;
  }

  /**
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return TrGeVeNotRec
   */
  public static function fromDOMElement(DOMElement $xml): TrGeVeNotRec
  {
    if (strcmp($xml->tagName, "trGeVeNotRec") == 0 && $xml->childElementCount >=6) {
      $res = new TrGeVeNotRec();
      $res->setId($xml->getElementsByTagName('Id')->item(0)->nodeValue);
      $res->setDFecEmi(DateTime::createFromFormat('Y-m-d\TH:i:s', $xml->getElementsByTagName('dFecEmi')->item(0)->nodeValue));
      $res->setDFecRecep(DateTime::createFromFormat('Y-m-d\TH:i:s', $xml->getElementsByTagName('dFecRecep')->item(0)->nodeValue));
      $res->setITipRec(intval($xml->getElementsByTagName('iTipRec')->item(0)->nodeValue));
      $res->setDNomRec($xml->getElementsByTagName('dNomRec')->item(0)->nodeValue);
      $res->setDRucRec($xml->getElementsByTagName('dRucRec')->item(0)->nodeValue);
      $res->setDDVRec(intval($xml->getElementsByTagName('dDVRec')->item(0)->nodeValue));
      $res->setDTipIDRec(intval($xml->getElementsByTagName('dTipIDRec')->item(0)->nodeValue));
      $res->setDNumID($xml->getElementsByTagName('dNumID')->item(0)->nodeValue);
      $res->setDTotalGs($xml->getElementsByTagName('dTotalGs')->item(0)->nodeValue);
    } else {
      throw new \Exception("Invalid XML Element: $xml->tagName");
      return null;
    }

    return $res;
  }
}
