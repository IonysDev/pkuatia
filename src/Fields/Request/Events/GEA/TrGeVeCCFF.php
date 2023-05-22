<?php

namespace Abiliomp\Pkuatia\Fields\Request\events\GEA;

use DateTime;
use DOMElement;

/**
 * ID:GECF001 Raíz Gestión de Eventos de créditos fiscales PADRE:GDE007
 */
class TrGeVeCCFF
{
  public string $Id; // GECF002 CDC del DE/DTE
  public string $dNumTraCCFF; ///GECF003 Número de  transferencia de  créditos fiscales
  public DateTime $dFeAceTraCCFF; //GECF004 Fecha de aceptación del crédito fiscal

  //====================================================//
  //SETTERS
  //====================================================//

  /**
   * Set the value of Id
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
   * Set the value of dNumTraCCFF
   *
   * @param string $dNumTraCCFF
   *
   * @return self
   */
  public function setDNumTraCCFF(string $dNumTraCCFF): self
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

  //====================================================//
  ///GETTERS
  //====================================================//

  /**
   * Get the value of Id
   *
   * @return string
   */
  public function getId(): string
  {
    return $this->Id;
  }

  /**
   * Get the value of dNumTraCCFF
   *
   * @return string
   */
  public function getDNumTraCCFF(): string
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

  //====================================================//
  ///XML ELEMENT  
  //====================================================//

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('trGeVeCCFF');
    $res->appendChild(new DOMElement('Id', $this->getId()));
    $res->appendChild(new DOMElement('dNumTraCCFF', $this->getDNumTraCCFF()));
    $res->appendChild(new DOMElement('dFeAceTraCCFF', $this->getDFeAceTraCCFF()->format('Y-m-d')));
    return $res;
  }

  
  /**
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return TrGeVeRetAce
   */
  public static function fromDOMElement(DOMElement $xml): TrGeVeCCFF
  {
    if (strcmp($xml->tagName, "trGeVeCCFF") == 0 && $xml->childElementCount == 3) {
      $res = new TrGeVeCCFF();
      $res->setId($xml->getElementsByTagName('Id')->item(0)->nodeValue);
      $res->setDNumTraCCFF($xml->getElementsByTagName('dNumTraCCFF')->item(0)->nodeValue);
      $res->setDFeAceTraCCFF(DateTime::createFromFormat('Y-m-d', $xml->getElementsByTagName('dFeAceTraCCFF')->item(0)->nodeValue));
    
      return $res;
    } else {
      throw new \Exception("Invalid XML Element: $xml->tagName");
      return null;
    }
  }
}
