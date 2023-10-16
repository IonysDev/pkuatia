<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\Event\GEA;

use DateTime;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 *  ID:GER001 rGeVeRetAce Raíz Gestión de Eventos de retención PADRE:GDE007
 */
class RGeVeRetAce
{
                              // ID - DESCRIPCION- LONGITUD - OCURRENCIA
  public String $Id;          // GER002 -  CDC del DE/DTE - 4 - 1-1
  public int $dNumTimRet;     // GER003 - Número de timbrado del documento de retención - 8 - 1-1
  public String $dEstRet;     // GER004 - Establecimiento - 3 - 1-1
  public String $dPunExpRet;  // GER005 - Punto de expedición - 3 - 1-1
  public String $dNumDocRet;  // GER006 - Número del documento - 7 - 1-1
  public String $dCodConRet;  // GER007 - Identificador de la retención - 40 - 1-1
  public DateTime $dFeEmiRet; // GER008 - Fecha de emisión de  la retención - 19 - 1-1

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
   * Establece el valor de dNumTimRet
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
   * Establece el valor de dEstRet
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
   * Establece el valor de dPunExpRet
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
   * Establece el valor de dNumDocRet
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
   * Establece el valor de dCodConRet
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
   * Establece el valor de dFeEmiRet
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
   * Obtiene el valor de Id
   *
   * @return String
   */
  public function getId(): String
  {
    return $this->Id;
  }

  /**
   * Obtiene el valor de dNumTimRet
   *
   * @return int
   */
  public function getDNumTimRet(): int
  {
    return $this->dNumTimRet;
  }

  /**
   * Obtiene el valor de dEstRet
   *
   * @return String
   */
  public function getDEstRet(): String
  {
    return $this->dEstRet;
  }

  /**
   * Obtiene el valor de dPunExpRet
   *
   * @return String
   */
  public function getDPunExpRet(): String
  {
    return $this->dPunExpRet;
  }

  /**
   * Obtiene el valor de dNumDocRet
   *
   * @return String
   */
  public function getDNumDocRet(): String
  {
    return $this->dNumDocRet;
  }

  /**
   * Obtiene el valor de dCodConRet
   *
   * @return String
   */
  public function getDCodConRet(): String
  {
    return $this->dCodConRet;
  }

  /**
   * Obtiene el valor de dFeEmiRet
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
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('rGeVeRetAce');
    $res->appendChild(new DOMElement('Id', $this->getId()));
    $res->appendChild(new DOMElement('dNumTimRet', $this->getDNumTimRet()));
    $res->appendChild(new DOMElement('dEstRet', $this->getDEstRet()));
    $res->appendChild(new DOMElement('dPunExpRet', $this->getDPunExpRet()));
    $res->appendChild(new DOMElement('dNumDocRet', $this->getDNumDocRet()));
    $res->appendChild(new DOMElement('dCodConRet', $this->getDCodConRet()));
    $res->appendChild(new DOMElement('dFeEmiRet', $this->getDFeEmiRet()->format('Y-m-d')));
    return $res;
  }

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return RGeVeRetAce
  //  */
  // public static function fromDOMElement(DOMElement $xml): RGeVeRetAce
  // {
  //   if (strcmp($xml->tagName, "rGeVeRetAce") == 0 && $xml->childElementCount == 7) {
  //     $res = new RGeVeRetAce();
  //     $res->setId($xml->getElementsByTagName('Id')->item(0)->nodeValue);
  //     $res->setDNumTimRet(intval($xml->getElementsByTagName('dNumTimRet')->item(0)->nodeValue));
  //     $res->setDEstRet($xml->getElementsByTagName('dEstRet')->item(0)->nodeValue);
  //     $res->setDPunExpRet($xml->getElementsByTagName('dPunExpRet')->item(0)->nodeValue);
  //     $res->setDNumDocRet($xml->getElementsByTagName('dNumDocRet')->item(0)->nodeValue);
  //     $res->setDCodConRet($xml->getElementsByTagName('dCodConRet')->item(0)->nodeValue);
  //     $res->setDFeEmiRet(DateTime::createFromFormat('Y-m-d', $xml->getElementsByTagName('dFeEmiRet')->item(0)->nodeValue));

  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }
  
  /**
   * FromSimpleXMLElement
   *
   * @param  mixed $node
   * @return self
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node):self
  {
    if($node->getName() != 'rGeVeRetAce')
      throw new \Exception("Invalid XML Element: $node->getName()");


    $res = new self();
    $res->setId($node->Id);
    $res->setDNumTimRet($node->dNumTimRet);
    $res->setDEstRet($node->dEstRet);
    $res->setDPunExpRet($node->dPunExpRet);
    $res->setDNumDocRet($node->dNumDocRet);
    $res->setDCodConRet($node->dCodConRet);
    $res->setDFeEmiRet(DateTime::createFromFormat('Y-m-d', $node->dFeEmiRet));
     return $res;
  }
}
