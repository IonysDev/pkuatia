<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\Event\GEA;

use DateTime;
use DOMElement;

/**
 *  ID:GER001 rGeVeRetAce Raíz Gestión de Eventos de retención PADRE:GDE007
 */
class RGeVeRetAce
{
  public String $Id; ///GER002 CDC del DE/DTE
  public int $dNumTimRet; /// GER003 Número de timbrado del documento de retención
  public String $dEstRet; //GER004 Establecimiento
  public String $dPunExpRet; ///GER005 Punto de expedición
  public String $dNumDocRet; ///GER006  Número del documento
  public String $dCodConRet; /// GER007 Identificador de la retención
  public DateTime $dFeEmiRet; ///GER008  Fecha de emisión de  la retención

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
    $res = new DOMElement('rGeVeRetAce');
    $res->appendChild(new DOMElement('Id', $this->getId()));
    $res->appendChild(new DOMElement('dNumTimRet', $this->getDNumTimRet()));
    $res->appendChild(new DOMElement('dEstRet', $this->getDEstRet()));
    $res->appendChild(new DOMElement('dPunExpRet', $this->getDPunExpRet()));
    $res->appendChild(new DOMElement('dNumDocRet', $this->getDNumDocRet()));
    $res->appendChild(new DOMElement('dCodConRet', $this->getDCodConRet()));
    $res->appendChild(new DOMElement('dFeEmiRet', $this->getDFeEmiRet()->format('Y-m-d')));
    return $res;
  }

  /**
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return RGeVeRetAce
   */
  public static function fromDOMElement(DOMElement $xml): RGeVeRetAce
  {
    if (strcmp($xml->tagName, "rGeVeRetAce") == 0 && $xml->childElementCount == 7) {
      $res = new RGeVeRetAce();
      $res->setId($xml->getElementsByTagName('Id')->item(0)->nodeValue);
      $res->setDNumTimRet(intval($xml->getElementsByTagName('dNumTimRet')->item(0)->nodeValue));
      $res->setDEstRet($xml->getElementsByTagName('dEstRet')->item(0)->nodeValue);
      $res->setDPunExpRet($xml->getElementsByTagName('dPunExpRet')->item(0)->nodeValue);
      $res->setDNumDocRet($xml->getElementsByTagName('dNumDocRet')->item(0)->nodeValue);
      $res->setDCodConRet($xml->getElementsByTagName('dCodConRet')->item(0)->nodeValue);
      $res->setDFeEmiRet(DateTime::createFromFormat('Y-m-d', $xml->getElementsByTagName('dFeEmiRet')->item(0)->nodeValue));

      return $res;
    } else {
      throw new \Exception("Invalid XML Element: $xml->tagName");
      return null;
    }
  }
}
