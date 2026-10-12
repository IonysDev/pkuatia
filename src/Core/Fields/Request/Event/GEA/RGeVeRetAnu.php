<?php

namespace IonysDev\Pkuatia\Core\Fields\Request\Event\GEA;

use DateTime;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;
use stdClass;
use IonysDev\Pkuatia\Helpers\XmlHelper;
use IonysDev\Pkuatia\Core\Exceptions\ValidacionException;

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

  // dRuc y dMonRet son obligatorios en el XSD (Evento_v150.xsd:139 y :147) aunque el MT no los lista; hasta
  // 0.2.0 la clase no los modelaba y se perdían al consultar un DE con retenciones (PK-42). Nuevos en 0.2.1.
  public String $dRuc;        // RUC (tRuc, Evento_v150.xsd:139); el XSD no documenta de quién es
  public String $dMonRet;     // Monto de la retención (tMontoBase, Evento_v150.xsd:147)

  /**
   * Establece dRuc (tRuc, Evento_v150.xsd:139). Nuevo en 0.2.1 (PK-42).
   *
   * @param String $dRuc
   *
   * @return self
   */
  public function setDRuc(String $dRuc): self
  {
    $this->dRuc = $dRuc;
    return $this;
  }

  /**
   * Establece dMonRet, el monto de la retención (tMontoBase, decimal BCMath; Evento_v150.xsd:147). Nuevo en 0.2.1 (PK-42).
   *
   * @param String $dMonRet
   *
   * @return self
   */
  public function setDMonRet(String $dMonRet): self
  {
    $this->dMonRet = $dMonRet;
    return $this;
  }

  /**
   * Obtiene dRuc, o null si no se informó. Nuevo en 0.2.1 (PK-42).
   *
   * @return String|null
   */
  public function getDRuc(): ?String
  {
    return $this->dRuc ?? null;
  }

  /**
   * Obtiene dMonRet, o null si no se informó. Nuevo en 0.2.1 (PK-42).
   *
   * @return String|null
   */
  public function getDMonRet(): ?String
  {
    return $this->dMonRet ?? null;
  }

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
    $res->appendChild(XmlHelper::elemento($doc, 'Id', $this->getId()));
    if (isset($this->dRuc))
      $res->appendChild(XmlHelper::elemento($doc, 'dRuc', $this->dRuc)); // orden de trGeVeRetAnu (Evento_v150.xsd:131-150)
    $res->appendChild(XmlHelper::elemento($doc, 'dNumTimRet', $this->getDNumTimRet()));
    $res->appendChild(XmlHelper::elemento($doc, 'dEstRet', $this->getDEstRet()));
    $res->appendChild(XmlHelper::elemento($doc, 'dPunExpRet', $this->getDPunExpRet()));
    $res->appendChild(XmlHelper::elemento($doc, 'dNumDocRet', $this->getDNumDocRet()));
    $res->appendChild(XmlHelper::elemento($doc, 'dCodConRet', $this->getDCodConRet()));
    $res->appendChild(XmlHelper::elemento($doc, 'dFeEmiRet', $this->getDFeEmiRet()->format('Y-m-d\TH:i:s')));
    $res->appendChild(XmlHelper::elemento($doc, 'dFecAnRet', $this->getDFecAnRet()->format('Y-m-d\TH:i:s')));
    if (isset($this->dMonRet))
      $res->appendChild(XmlHelper::elemento($doc, 'dMonRet', $this->dMonRet));

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
      throw new ValidacionException("Invalid XML Element: $node->getName()");

    $res = new RGeVeRetAnu();
    $res->setId($node->Id);
    if (isset($node->dRuc))
      $res->setDRuc((string) $node->dRuc);
    $res->setDNumTimRet(intval($node->dNumTimRet));
    $res->setDEstRet($node->dEstRet);
    $res->setDPunExpRet($node->dPunExpRet);
    $res->setDNumDocRet($node->dNumDocRet);
    $res->setDCodConRet($node->dCodConRet);
    $res->setDFeEmiRet(DateTime::createFromFormat('Y-m-d\TH:i:s', strval($node->dFeEmiRet)));
    $res->setDFecAnRet(DateTime::createFromFormat('Y-m-d\TH:i:s', strval($node->dFecAnRet)));
    if (isset($node->dMonRet))
      $res->setDMonRet((string) $node->dMonRet);

    return $res;
  }
}
