<?php

namespace IonysDev\Pkuatia\Core\Fields\Request\Event\GER;

use DateTime;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * ID:GED001 Raiz Gestión de Eventos Desconocimiento PADREGDE007
 */
class RGeVeDescon
{
                              // ID - DESCRIPCION- LONGITUD - OCURRENCIA
  public String $Id;          // GED002 CDC del DE/DTE - 44- 1-1
  public DateTime $dFecEmi;   // GED003 Fecha de emisión del DE - 19 - 1-1
  public DateTime $dFecRecep; // GED004 Fecha Recepción DE - 19 - 1-1
  public int $iTipRec;        // GED005 Tipo de Receptor - 1 - 1-1
  public String $dNomRec;     // GED006 Nombre o Razón Social del Receptor del DE/DTE - 4-60 - 1-1
  public String $dRucRec;     // GED007 Ruc del Receptor - 3-8 - 0-1
  public int $dDVRec;         // GED008 Dígito verificador del RUC del contribuyente receptor - 1- 0-1
  public int $dTipIDRec;      // GED009 Tipo de documento de identidad del receptor 1 - 0-1
  public String $dNumID;      // GED010 Número de documento de identidad - 1-20 -0-1
  public String $mOtEve;      // GED011 Motivo del Evento - 5-500 - 1-1

  ///////////////////////////////////////////////////////////////////////
  ///SETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de Id
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
   * Establece el valor de dFecEmi
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
   * Establece el valor de dFecRecep
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
   * Establece el valor de iTipRec
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
   * Establece el valor de dNomRec
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
   * Establece el valor de dRucRec
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
   * Establece el valor de dDVRec
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
   * Establece el valor de dTipIDRec
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
   * Establece el valor de dNumID
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
   * Establece el valor de mOtEve
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
   * Obtiene el valor de Id
   *
   * @return String
   */
  public function getId(): String
  {
    return $this->Id;
  }

  /**
   * Obtiene el valor de dFecEmi
   *
   * @return DateTime
   */
  public function getDFecEmi(): DateTime
  {
    return $this->dFecEmi;
  }

  /**
   * Obtiene el valor de dFecRecep
   *
   * @return DateTime
   */
  public function getDFecRecep(): DateTime
  {
    return $this->dFecRecep;
  }

  /**
   * Obtiene el valor de iTipRec
   *
   * @return int
   */
  public function getITipRec(): int
  {
    return $this->iTipRec;
  }

  /**
   * Obtiene el valor de dNomRec
   *
   * @return String
   */
  public function getDNomRec(): String
  {
    return $this->dNomRec;
  }

  /**
   * Obtiene el valor de dRucRec
   *
   * @return String
   */
  public function getDRucRec(): String
  {
    return $this->dRucRec;
  }

  /**
   * Obtiene el valor de dDVRec
   *
   * @return int
   */
  public function getDDVRec(): int
  {
    return $this->dDVRec;
  }

  /**
   * Obtiene el valor de dTipIDRec
   *
   * @return int
   */
  public function getDTipIDRec(): int
  {
    return $this->dTipIDRec;
  }

  /**
   * Obtiene el valor de dNumID
   *
   * @return String
   */
  public function getDNumID(): String
  {
    return $this->dNumID;
  }

  /**
   * Obtiene el valor de mOtEve
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
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('rGeVeDescon');
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

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return RGeVeDescon
  //  */
  // public static function fromDOMElement(DOMElement $xml): RGeVeDescon
  // {
  //   if (strcmp($xml->tagName, 'rGeVeDescon') == 0 && $xml->childElementCount == 10) {
  //     $res = new RGeVeDescon();
  //     $res->setId($xml->getElementsByTagName('Id')->item(0)->nodeValue);
  //     $res->setDFecEmi(DateTime::createFromFormat('Y-m-d\TH:i:s', $xml->getElementsByTagName('dFecEmi')->item(0)->nodeValue));
  //     $res->setDFecRecep(DateTime::createFromFormat('Y-m-d\TH:i:s', $xml->getElementsByTagName('dFecRecep')->item(0)->nodeValue));
  //     $res->setITipRec(intval($xml->getElementsByTagName('iTipRec')->item(0)->nodeValue));
  //     $res->setDNomRec($xml->getElementsByTagName('dNomRec')->item(0)->nodeValue);
  //     $res->setDRucRec($xml->getElementsByTagName('dRucRec')->item(0)->nodeValue);
  //     $res->setDDVRec(intval($xml->getElementsByTagName('dDVRec')->item(0)->nodeValue));
  //     $res->setDTipIDRec(intval($xml->getElementsByTagName('dTipIDRec')->item(0)->nodeValue));
  //     $res->setDNumID($xml->getElementsByTagName('dNumID')->item(0)->nodeValue);
  //     $res->setMOtEve($xml->getElementsByTagName('mOtEve')->item(0)->nodeValue);
  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }

  public static function FromSimpleXMLElement(SimpleXMLElement $node):self
  {
    if($node->getName() != 'rGeVeDescon')
      throw new \Exception("Invalid XML Element: $node->getName()");


    $res = new RGeVeDescon();
    $res->setId($node->Id);
    $res->setDFecEmi(DateTime::createFromFormat('Y-m-d\TH:i:s', $node->dFecEmi));
    $res->setDFecRecep(DateTime::createFromFormat('Y-m-d\TH:i:s', $node->dFecRecep));
    $res->setITipRec($node->iTipRec);
    $res->setDNomRec($node->dNomRec);
    if(isset($node->dRucRec))
    {
      $res->setDRucRec($node->dRucRec);
      $res->setDDVRec($node->dDVRec);
    }
    if(isset($node->dTipIDRec))
    {
      $res->setDTipIDRec($node->dTipIDRec);
      $res->setDNumID($node->dNumID);
    }
    $res->setMOtEve($node->mOtEve);

    return $res;
  }
}
