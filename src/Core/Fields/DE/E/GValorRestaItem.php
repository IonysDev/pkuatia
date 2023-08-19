<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use Abiliomp\Pkuatia\Utils\ValueValidations;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id:     EA001 
 * Nombre:      gValorRestaItem
 * Descripción: Campos que describen los descuentos, anticipos valor total por ítem.
 * Nodo Padre:  E720
 */

class GValorRestaItem
{
  public String $dDescItem;       // EA002 - 1-15p(0-8) - 0-1 - Descuento particular sobre el precio unitario por ítem (incluidos impuestos)
  public String $dPorcDesIt;      // EA003 - 1-3p(0-8)  - 0-1 - Porcentaje de descuento particular por ítem
  public String $dDescGloItem;    // EA004 - 1-15p(0-8) - 0-1 - Descuento global sobre el precio unitario por ítem (incluidos impuestos)
  public String $dAntPreUniIt;    // EA006 - 1-15p(0-8) - 0-1 - Anticipo particular sobre el precio unitario por ítem (incluidos impuestos)
  public String $dAntGloPreUniIt; // EA007 - 1-15p(0-8) - 0-1 - Anticipo global sobre el  precio unitario por ítem  (incluidos impuestos)
  public String $dTotOpeItem;     // EA008 - 1-15p(0-8) - 1-1 - Valor total de la operación por ítem 
  public String $dTotOpeGs;       // EA009 - 1-15p(0-8) - 0-1 - Valor total de la operación por ítem en guaraníes

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of dDescItem
   *
   * @param String $dDescItem
   *
   * @return self
   */
  public function setDDescItem(String $dDescItem): self
  {
    if(!ValueValidations::isValidStringDecimal($dDescItem, 15, 0))
    {
      throw new \Exception("Valor inválido de dDescItem: $dDescItem");
    }
    $this->dDescItem = $dDescItem;
    return $this;
  }

  /**
   * Set the value of dPorcDesIt
   *
   * @param String $dPorcDesIt
   *
   * @return self
   */
  public function setDPorcDesIt(String $dPorcDesIt): self
  {
    if(!ValueValidations::isValidStringDecimal($dPorcDesIt, 3, 0))
    {
      throw new \Exception("Valor inválido de dPorcDesIt: $dPorcDesIt");
    }
    $this->dPorcDesIt = $dPorcDesIt;
    return $this;
  }


  /**
   * Set the value of dDescGloItem
   *
   * @param String $dDescGloItem
   *
   * @return self
   */
  public function setDDescGloItem(String $dDescGloItem): self
  {
    if(!ValueValidations::isValidStringDecimal($dDescGloItem, 15, 0))
    {
      throw new \Exception("Valor inválido de dDescGloItem: $dDescGloItem");
    }
    $this->dDescGloItem = $dDescGloItem;
    return $this;
  }


  /**
   * Set the value of dAntPreUniIt
   *
   * @param String $dAntPreUniIt
   *
   * @return self
   */
  public function setDAntPreUniIt(String $dAntPreUniIt): self
  {
    if(!ValueValidations::isValidStringDecimal($dAntPreUniIt, 15, 0))
    {
      throw new \Exception("Valor inválido de dAntPreUniIt: $dAntPreUniIt");
    }
    $this->dAntPreUniIt = $dAntPreUniIt;
    return $this;
  }


  /**
   * Set the value of dAntGloPreUniIt
   *
   * @param String $dAntGloPreUniIt
   *
   * @return self
   */
  public function setDAntGloPreUniIt(String $dAntGloPreUniIt): self
  {
    if(!ValueValidations::isValidStringDecimal($dAntGloPreUniIt, 15, 0))
    {
      throw new \Exception("Valor inválido de dAntGloPreUniIt: $dAntGloPreUniIt");
    }
    $this->dAntGloPreUniIt = $dAntGloPreUniIt;
    return $this;
  }


  /**
   * Set the value of dTotOpeItem
   *
   * @param String $dTotOpeItem
   *
   * @return self
   */
  public function setDTotOpeItem(String $dTotOpeItem): self
  {
    if(!ValueValidations::isValidStringDecimal($dTotOpeItem, 15, 0))
    {
      throw new \Exception("Valor inválido de dTotOpeItem: $dTotOpeItem");
    }
    $this->dTotOpeItem = $dTotOpeItem;
    return $this;
  }

  /**
   * Set the value of dTotOpeGs
   *
   * @param String $dTotOpeGs
   *
   * @return self
   */
  public function setDTotOpeGs(String $dTotOpeGs): self
  {
    if(!ValueValidations::isValidStringDecimal($dTotOpeGs, 15, 0))
    {
      throw new \Exception("Valor inválido de dTotOpeGs: $dTotOpeGs");
    }
    $this->dTotOpeGs = $dTotOpeGs;
    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  ///Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Get the value of dDescItem
   *
   * @return String
   */
  public function getDDescItem(): String
  {
    return $this->dDescItem;
  }

  /**
   * Get the value of dPorcDesIt
   *
   * @return String
   */
  public function getDPorcDesIt(): String
  {
    return $this->dPorcDesIt;
  }

  /**
   * Get the value of dDescGloItem
   *
   * @return String
   */
  public function getDDescGloItem(): String
  {
    return $this->dDescGloItem;
  }

  /**
   * Get the value of dAntPreUniIt
   *
   * @return String
   */
  public function getDAntPreUniIt(): String
  {
    return $this->dAntPreUniIt;
  }

  /**
   * Get the value of dAntGloPreUniIt
   *
   * @return String
   */
  public function getDAntGloPreUniIt(): String
  {
    return $this->dAntGloPreUniIt;
  }

  /**
   * Get the value of dTotOpeItem
   *
   * @return String
   */
  public function getDTotOpeItem(): String
  {
    return $this->dTotOpeItem;
  }

  /**
   * Get the value of dTotOpeGs
   *
   * @return String
   */
  public function getDTotOpeGs(): String
  {
    return $this->dTotOpeGs;
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML Element
  ///////////////////////////////////////////////////////////////////////

  /**
   * Instancia un objeto GValorRestaItem desde un SimpleXMLElement
   * 
   * @param  SimpleXMLElement $node
   * 
   * @return GValorRestaItem
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node): GValorRestaItem
  {
    if(strcmp($node->getName(), 'gValorRestaItem') != 0)
    {
      throw new \Exception("El nodo '" . $node->getName() . "' no corresponde a gValorRestaItem");
    }
    $res = new GValorRestaItem();
    if(isset($node->dDescItem))
    {
      $res->setDDescItem(strval($node->dDescItem));
    }
    if(isset($node->dPorcDesIt))
    {
      $res->setDPorcDesIt(strval($node->dPorcDesIt));
    }
    if(isset($node->dDescGloItem))
    {
      $res->setDDescGloItem(strval($node->dDescGloItem));
    }
    if(isset($node->dAntPreUniIt))
    {
      $res->setDAntPreUniIt(strval($node->dAntPreUniIt));
    }
    if(isset($node->dAntGloPreUniIt))
    {
      $res->setDAntGloPreUniIt(strval($node->dAntGloPreUniIt));
    }
    $res->setDTotOpeItem(strval($node->dTotOpeItem));
    if(isset($node->dTotOpeGs))
    {
      $res->setDTotOpeGs(strval($node->dTotOpeGs));
    }
    return $res;
  }

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('gValorRestaItem');
    $res->appendChild(new DOMElement('dDescItem', $this->getDDescItem()));

    if ($this->dDescItem > 0) {
      $res->appendChild(new DOMElement('dPorcDesIt', $this->getDPorcDesIt()));
    }
    $res->appendChild(new DOMElement('dDescGloItem', $this->getDDescGloItem()));
    $res->appendChild(new DOMElement('dAntPreUniIt', $this->getDAntPreUniIt()));
    $res->appendChild(new DOMElement('dAntGloPreUniIt', $this->getDAntGloPreUniIt()));
    $res->appendChild(new DOMElement('dTotOpeItem', $this->getDTotOpeItem())); ///Leer en el documento es largo Mordor;
    $res->appendChild(new DOMElement('dTotOpeGs', $this->getdTotOpeGs())); ///leer

    return $res;
  }
  
  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return GValorRestaItem
  //  */
  // public static function fromDOMElement(DOMElement $xml): GValorRestaItem
  // {
  //   if(strcmp($xml->tagName, 'gValorRestaItem') == 0 && $xml->childElementCount == 5)
  //   {
  //     $res = new GValorRestaItem();
  //     $res->setDDescItem(strval($xml->getElementsByTagName('dDescItem')->item(0)->nodeValue));
  //     $res->setDPorcDesIt(strval($xml->getElementsByTagName('dPorcDesIt')->item(0)->nodeValue));
  //     $res->setDDescGloItem(strval($xml->getElementsByTagName('dDescGloItem')->item(0)->nodeValue));
  //     $res->setDAntPreUniIt(strval($xml->getElementsByTagName('dAntPreUniIt')->item(0)->nodeValue));
  //     $res->setDAntGloPreUniIt(strval($xml->getElementsByTagName('dAntGloPreUniIt')->item(0)->nodeValue));
  //     $res->setDTotOpeItem(strval($xml->getElementsByTagName('dTotOpeItem')->item(0)->nodeValue));
  //     $res->setDTotOpeGs(strval($xml->getElementsByTagName('dTotOpeGs')->item(0)->nodeValue));
  //     return $res;
  //   }
  //   else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }
  
  /**
   * fromResponse
   *
   * @param  mixed $response
   * @return self
   */
  public static function fromResponse($response):self
  {
    $res = new GValorRestaItem();
    if( isset($response->dDescItem))
    {
      $res->setDDescItem(strval($response->dDescItem));
    }
    if( isset($response->dPorcDesIt))
    {
      $res->setDPorcDesIt(strval($response->dPorcDesIt));
    }
    if( isset($response->dDescGloItem))
    {
      $res->setDDescGloItem(strval($response->dDescGloItem));
    }

    if( isset($response->dAntPreUniIt))
    {
      $res->setDAntPreUniIt(strval($response->dAntPreUniIt));
    }

    if( isset($response->dAntGloPreUniIt))
    {
      $res->setDAntGloPreUniIt(strval($response->dAntGloPreUniIt));
    }

    if( isset($response->dTotOpeItem))
    {
      $res->setDTotOpeItem(strval($response->dTotOpeItem));
    }

    if( isset($response->dTotOpeGs))
    {
      $res->setDTotOpeGs(strval($response->dTotOpeGs));
    }
    
    return $res;
  }
}
