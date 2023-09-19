<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\Event\GEA;

use DateTime;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * ID:GECF001 Raíz Gestión de Eventos de créditos fiscales PADRE:GDE007
 */
class RGeVeCCFF
{
  public String $Id; // GECF002 CDC del DE/DTE
  public String $dNumTraCCFF; ///GECF003 Número de  transferencia de  créditos fiscales
  public DateTime $dFeAceTraCCFF; //GECF004 Fecha de aceptación del crédito fiscal

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
   * Set the value of dNumTraCCFF
   *
   * @param String $dNumTraCCFF
   *
   * @return self
   */
  public function setDNumTraCCFF(String $dNumTraCCFF): self
  {
    $this->dNumTraCCFF = $dNumTraCCFF;

    return $this;
  }


  /**
   * Set the value of dFeAceTraCCFF
   *
   * @param DateTime $dFeAceTraCCFF
   *
   * @return self
   */
  public function setDFeAceTraCCFF(DateTime $dFeAceTraCCFF): self
  {
    $this->dFeAceTraCCFF = $dFeAceTraCCFF;

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
   * Get the value of dNumTraCCFF
   *
   * @return String
   */
  public function getDNumTraCCFF(): String
  {
    return $this->dNumTraCCFF;
  }

  /**
   * Get the value of dFeAceTraCCFF
   *
   * @return DateTime
   */
  public function getDFeAceTraCCFF(): DateTime
  {
    return $this->dFeAceTraCCFF;
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML ELEMENT  
  ///////////////////////////////////////////////////////////////////////

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('rGeVeCCFF');
    $res->appendChild(new DOMElement('Id', $this->getId()));
    $res->appendChild(new DOMElement('dNumTraCCFF', $this->getDNumTraCCFF()));
    $res->appendChild(new DOMElement('dFeAceTraCCFF', $this->getDFeAceTraCCFF()->format('Y-m-d')));
    return $res;
  }

  
  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return TrGeVeRetAce
  //  */
  // public static function fromDOMElement(DOMElement $xml): RGeVeCCFF
  // {
  //   if (strcmp($xml->tagName, "rGeVeCCFF") == 0 && $xml->childElementCount == 3) {
  //     $res = new RGeVeCCFF();
  //     $res->setId($xml->getElementsByTagName('Id')->item(0)->nodeValue);
  //     $res->setDNumTraCCFF($xml->getElementsByTagName('dNumTraCCFF')->item(0)->nodeValue);
  //     $res->setDFeAceTraCCFF(DateTime::createFromFormat('Y-m-d', $xml->getElementsByTagName('dFeAceTraCCFF')->item(0)->nodeValue));
    
  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }


  public static function FromSimpleXMLElement(SimpleXMLElement $node):self
  {
    if($node->getName() != 'rGeVeCCFF')
      throw new \Exception("Invalid XML Element: $node->getName()");

    $res = new RGeVeCCFF();
    $res->setId($node->Id);
    $res->setDNumTraCCFF($node->dNumTraCCFF);
    $res->setDFeAceTraCCFF(DateTime::createFromFormat('Y-m-d', $node->dFeAceTraCCFF));
    return $res;
  }
}
