<?php

namespace IonysDev\Pkuatia\Core\Fields\Request\Event\GEA;

use DateTime;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;
use stdClass;

/**
 *  ID:GERA001 Raíz Gestión de Eventos de retención anulación PADRE:GDE007
 */
class RGeVeRetAnu
{ 
                              // ID - DESCRIPCION- LONGITUD - OCURRENCIA
  public String $Id;          // GERA002 - CDC del DE/DTE - 44 - 1-1
  public int $dNumTimRet;     // GERA003 - Número de timbrado del documento de retención - 8 - 1-1
  public String $dEstRet;     // GERA004 - Establecimiento del documento de retención - 3 - 1-1
  public String $dPunExpRet;  // GERA005 - Punto de expedición  del documento de  retención - 3 - 1-1
  public String $dNumDocRet;  // GERA006 - Número del documento de la retención - 7 - 1-1
  public String $dCodConRet;  // GERA007 - Identificador de la retención - 40 - 1-1
  public DateTime $dFeEmiRet; // GERA008 - Fecha de emisión de la retención - 19 - 1-1
  public DateTime $dFecAnRet; // GERA009 - Fecha de anulación  de la retención - 19 - 1-1

  ///////////////////////////////////////////////////////////////////////
  //SETTERS
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


  /**
   * Establece el valor de dFecAnRet
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

  /**
   * Obtiene el valor de dFecAnRet
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

  public static function FromSimpleXMLElement(SimpleXMLElement $node):Self
  {
    if($node->getName() != 'rGeVeRetAnu')
      throw new \Exception("Invalid XML Element: $node->getName()");

    $res = new RGeVeRetAnu();
    $res->setId($node->Id);
    $res->setDNumTimRet(intval($node->dNumTimRet));
    $res->setDEstRet($node->dEstRet);
    $res->setDPunExpRet($node->dPunExpRet);
    $res->setDNumDocRet($node->dNumDocRet);
    $res->setDCodConRet($node->dCodConRet);
    $res->setDFeEmiRet(DateTime::createFromFormat('Y-m-d', $node->dFeEmiRet));
    $res->setDFecAnRet(DateTime::createFromFormat('Y-m-d', $node->dFecAnRet));

    return $res;
  }
}
