<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\Event\GEA;

use DateTime;
use DOMDocument;
use DOMElement;

/**
 *  ID:GERA001 Raíz Gestión de Eventos de retención anulación PADRE:GDE007
 */
class RGeVeRetAnu
{
  public String $Id; /// GERA002CDC del DE/DTE
  public int $dNumTimRet; ///GERA003 Número de timbrado del documento de retención
  public String $dEstRet; ///GERA004 Establecimiento del documento de retención
  public String $dPunExpRet; //// GERA005 Punto de expedición  del documento de  retención
  public String $dNumDocRet; /// GERA006 Número del documento de la retención
  public String $dCodConRet; ///GERA007 Identificador de la retención 
  public DateTime $dFeEmiRet; //GERA008 Fecha de emisión de la retención
  public DateTime $dFecAnRet; ///GERA009 Fecha de anulación  de la retención 

  ///////////////////////////////////////////////////////////////////////
  //SETTERS
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
   * Set the value of dNumTimRet
   *
   * @param int $dNumTimRet
   *
   * @return self
   */
  public function setDNumTimRet(int $dNumTimRet): self
  {
    $this->dNumTimRet = $dNumTimRet;

    return $this;
  }


  /**
   * Set the value of dEstRet
   *
   * @param String $dEstRet
   *
   * @return self
   */
  public function setDEstRet(String $dEstRet): self
  {
    $this->dEstRet = $dEstRet;

    return $this;
  }


  /**
   * Set the value of dPunExpRet
   *
   * @param String $dPunExpRet
   *
   * @return self
   */
  public function setDPunExpRet(String $dPunExpRet): self
  {
    $this->dPunExpRet = $dPunExpRet;

    return $this;
  }


  /**
   * Set the value of dNumDocRet
   *
   * @param String $dNumDocRet
   *
   * @return self
   */
  public function setDNumDocRet(String $dNumDocRet): self
  {
    $this->dNumDocRet = $dNumDocRet;

    return $this;
  }

  /**
   * Set the value of dCodConRet
   *
   * @param String $dCodConRet
   *
   * @return self
   */
  public function setDCodConRet(String $dCodConRet): self
  {
    $this->dCodConRet = $dCodConRet;

    return $this;
  }


  /**
   * Set the value of dFeEmiRet
   *
   * @param DateTime $dFeEmiRet
   *
   * @return self
   */
  public function setDFeEmiRet(DateTime $dFeEmiRet): self
  {
    $this->dFeEmiRet = $dFeEmiRet;

    return $this;
  }


  /**
   * Set the value of dFecAnRet
   *
   * @param DateTime $dFecAnRet
   *
   * @return self
   */
  public function setDFecAnRet(DateTime $dFecAnRet): self
  {
    $this->dFecAnRet = $dFecAnRet;

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
   * Get the value of dNumTimRet
   *
   * @return int
   */
  public function getDNumTimRet(): int
  {
    return $this->dNumTimRet;
  }

  /**
   * Get the value of dEstRet
   *
   * @return String
   */
  public function getDEstRet(): String
  {
    return $this->dEstRet;
  }

  /**
   * Get the value of dPunExpRet
   *
   * @return String
   */
  public function getDPunExpRet(): String
  {
    return $this->dPunExpRet;
  }

  /**
   * Get the value of dNumDocRet
   *
   * @return String
   */
  public function getDNumDocRet(): String
  {
    return $this->dNumDocRet;
  }

  /**
   * Get the value of dCodConRet
   *
   * @return String
   */
  public function getDCodConRet(): String
  {
    return $this->dCodConRet;
  }

  /**
   * Get the value of dFeEmiRet
   *
   * @return DateTime
   */
  public function getDFeEmiRet(): DateTime
  {
    return $this->dFeEmiRet;
  }

  /**
   * Get the value of dFecAnRet
   *
   * @return DateTime
   */
  public function getDFecAnRet(): DateTime
  {
    return $this->dFecAnRet;
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
    $res = $doc->createElement('rGeVeRetAnu');
    $res->appendChild(new DOMElement('Id', $this->getId()));
    $res->appendChild(new DOMElement('dNumTimRet', $this->getDNumTimRet()));
    $res->appendChild(new DOMElement('dEstRet', $this->getDEstRet()));
    $res->appendChild(new DOMElement('dPunExpRet', $this->getDPunExpRet()));
    $res->appendChild(new DOMElement('dNumDocRet', $this->getDNumDocRet()));
    $res->appendChild(new DOMElement('dCodConRet', $this->getDCodConRet()));
    $res->appendChild(new DOMElement('dFeEmiRet', $this->getDFeEmiRet()->format('Y-m-d')));
    $res->appendChild(new DOMElement('dFecAnRet', $this->getDFecAnRet()->format('Y-m-d')));

    return $res;
  }


  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return TrGeVeRetAce
  //  */
  // public static function fromDOMElement(DOMElement $xml): RGeVeRetAnu
  // {
  //   if (strcmp($xml->tagName, "rGeVeRetAnu") == 0 && $xml->childElementCount == 8) {
  //     $res = new RGeVeRetAnu();
  //     $res->setId($xml->getElementsByTagName('Id')->item(0)->nodeValue);
  //     $res->setDNumTimRet(intval($xml->getElementsByTagName('dNumTimRet')->item(0)->nodeValue));
  //     $res->setDEstRet($xml->getElementsByTagName('dEstRet')->item(0)->nodeValue);
  //     $res->setDPunExpRet($xml->getElementsByTagName('dPunExpRet')->item(0)->nodeValue);
  //     $res->setDNumDocRet($xml->getElementsByTagName('dNumDocRet')->item(0)->nodeValue);
  //     $res->setDCodConRet($xml->getElementsByTagName('dCodConRet')->item(0)->nodeValue);
  //     $res->setDFeEmiRet(DateTime::createFromFormat('Y-m-d', $xml->getElementsByTagName('dFeEmiRet')->item(0)->nodeValue));
  //     $res->setDFecAnRet(DateTime::createFromFormat('Y-m-d', $xml->getElementsByTagName('dFecAnRet')->item(0)->nodeValue));
  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }
}
