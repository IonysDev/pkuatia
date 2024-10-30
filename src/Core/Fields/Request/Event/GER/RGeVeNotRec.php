<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\Event\GER;

use DateTime;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo: GEN001 - rGeVeNotRec - Raíz Gestión de Eventos Notificación: Recepción DE o DTE
 * Padre: GDE007 - gGroupTiEvt - Grupo de campos del tipo de evento
 */
class RGeVeNotRec
{

                              // ID - DESCRIPCION- LONGITUD - OCURRENCIA
  public String   $Id;        // GEN002 - Identificador del DE/DTE - 44 -1-1
  public DateTime $dFecEmi;   // GEN003 - Fecha de emisión del DE - 19 - 1-1
  public DateTime $dFecRecep; // GEN004 - Fecha Recepción DE - 19 - 1-1
  public int      $iTipRec;   // GEN005 - Tipo de Receptor - 1 - 1-1
  public String   $dNomRec;   // GEN006 - Nombre o Razón Social del Receptor del DE/DTE - 4-60 - 1-1
  public String   $dRucRec;   // GEN007 - RUC del Receptor - 3-8 - 0-1
  public int      $dDVRec;    // GEN008 - Dígito verificador del RUC del contribuyente receptor - 1- 0-1
  public int      $dTipIDRec; // GEN009 - Tipo de documento de identidad del receptor - 1- 0-1
  public String   $dNumID;    // GEN010 - Número de documento de identidad  - 1-20 - 0-1
  public int      $dTotalGs;  // GEN011 - Total general de la operación en Guaraníes - 1-15p(0-8) - 1-1


  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de Id - Identificador del DE/DTE
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
   * Establece el valor de dRucRec - RUC del Receptor 
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
   * @return String
   */
  public function getId(): String
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
   * @return String
   */
  public function getDNomRec(): String
  {
    return $this->dNomRec;
  }

  /**
   * Obtiene el valor de dRucRec - RUC del Receptor
   *
   * @return String
   */
  public function getDRucRec(): String
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
   * @return String
   */
  public function getDNumID(): String
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
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('rGeVeNotRec');
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

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return RGeVeNotRec
  //  */
  // public static function fromDOMElement(DOMElement $xml): RGeVeNotRec
  // {
  //   if (strcmp($xml->tagName, "rGeVeNotRec") == 0 && $xml->childElementCount >= 6) {
  //     $res = new RGeVeNotRec();
  //     $res->setId($xml->getElementsByTagName('Id')->item(0)->nodeValue);
  //     $res->setDFecEmi(DateTime::createFromFormat('Y-m-d\TH:i:s', $xml->getElementsByTagName('dFecEmi')->item(0)->nodeValue));
  //     $res->setDFecRecep(DateTime::createFromFormat('Y-m-d\TH:i:s', $xml->getElementsByTagName('dFecRecep')->item(0)->nodeValue));
  //     $res->setITipRec(intval($xml->getElementsByTagName('iTipRec')->item(0)->nodeValue));
  //     $res->setDNomRec($xml->getElementsByTagName('dNomRec')->item(0)->nodeValue);
  //     $res->setDRucRec($xml->getElementsByTagName('dRucRec')->item(0)->nodeValue);
  //     $res->setDDVRec(intval($xml->getElementsByTagName('dDVRec')->item(0)->nodeValue));
  //     $res->setDTipIDRec(intval($xml->getElementsByTagName('dTipIDRec')->item(0)->nodeValue));
  //     $res->setDNumID($xml->getElementsByTagName('dNumID')->item(0)->nodeValue);
  //     $res->setDTotalGs($xml->getElementsByTagName('dTotalGs')->item(0)->nodeValue);
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }

  //   return $res;
  // }

  public static function FromSimpleXMLElement(SimpleXMLElement $node):self
  {
    if($node->getName() != 'rGeVeNotRec')
      throw new \Exception("Invalid XML Element: $node->tagName");

    $res = new RGeVeNotRec();

    $res->setId($node->Id);
    $res->setDFecEmi(DateTime::createFromFormat('Y-m-d\TH:i:s', $node->dFecEmi));
    $res->setDFecRecep(DateTime::createFromFormat('Y-m-d\TH:i:s', $node->dFecRecep));
    $res->setITipRec(intval($node->iTipRec));
    $res->setDNomRec($node->dNomRec);
    if(isset($node->dRucRec))
    {
      $res->setDRucRec($node->dRucRec);
      $res->setDDVRec(intval($node->dDVRec));
    }

    if(isset($node->dTipIDRec))
    {
      $res->setDTipIDRec(intval($node->dTipIDRec));
      $res->setDNumID($node->dNumID);
    }

    $res->setDTotalGs(intval($node->dTotalGs));

    return $res;
  }
}
