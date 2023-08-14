<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\E;

use DOMElement;

/**
 * EA001 Campos que describen los descuentos, anticipos valor total por ítem Padre:E720
 */
class GValorRestaItem
{
  public ?float $dDescItem = null; ///EA002 Descuento particular sobre el precio unitario por ítem (incluidos impuestos)
  public ?float $dPorcDesIt = null; /// EA003 Porcentaje de descuento particular por ítem
  public ?float $dDescGloItem = null; ///EA004 Descuento global sobre el precio unitario por ítem (incluidos impuestos)
  public ?float $dAntPreUniIt = null; ///EA006 Anticipo particular sobre el precio unitario por ítem (incluidos impuestos)
  public ?float $dAntGloPreUniIt = null; ///EA007 Anticipo global sobre el  precio unitario por ítem  (incluidos impuestos)
  public ?float $dTotOpeItem = null; /// EA008 Valor total de la operación por ítem 
  public ?float $dTotOpeGs = null; ///EA009 Valor total de la operación por ítem en guaraníes

  ///////////////////////////////////////////////////////////////////////
  ///Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of dDescItem
   *
   * @param float $dDescItem
   *
   * @return self
   */
  public function setDDescItem(float $dDescItem): self
  {
    $this->dDescItem = $dDescItem;

    return $this;
  }


  /**
   * Set the value of dPorcDesIt
   *
   * @param float $dPorcDesIt
   *
   * @return self
   */
  public function setDPorcDesIt(float $dPorcDesIt): self
  {
    $this->dPorcDesIt = $dPorcDesIt;

    return $this;
  }


  /**
   * Set the value of dDescGloItem
   *
   * @param float $dDescGloItem
   *
   * @return self
   */
  public function setDDescGloItem(float $dDescGloItem): self
  {
    $this->dDescGloItem = $dDescGloItem;

    return $this;
  }


  /**
   * Set the value of dAntPreUniIt
   *
   * @param float $dAntPreUniIt
   *
   * @return self
   */
  public function setDAntPreUniIt(float $dAntPreUniIt): self
  {
    $this->dAntPreUniIt = $dAntPreUniIt;

    return $this;
  }


  /**
   * Set the value of dAntGloPreUniIt
   *
   * @param float $dAntGloPreUniIt
   *
   * @return self
   */
  public function setDAntGloPreUniIt(float $dAntGloPreUniIt): self
  {
    $this->dAntGloPreUniIt = $dAntGloPreUniIt;

    return $this;
  }


  /**
   * Set the value of dTotOpeItem
   *
   * @param float $dTotOpeItem
   *
   * @return self
   */
  public function setDTotOpeItem(float $dTotOpeItem): self
  {
    $this->dTotOpeItem = $dTotOpeItem;

    return $this;
  }


  /**
   * Set the value of dTotOpeGs
   *
   * @param float $dTotOpeGs
   *
   * @return self
   */
  public function setDTotOpeGs(float $dTotOpeGs): self
  {
    $this->dTotOpeGs = $dTotOpeGs;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  ///Getters
  ///////////////////////////////////////////////////////////////////////


  /**
   * Get the value of dDescItem
   *
   * @return float
   */
  public function getDDescItem(): float | null
  {
    return $this->dDescItem;
  }

  /**
   * Get the value of dPorcDesIt
   *
   * @return float
   */
  public function getDPorcDesIt(): float | null
  {
    return $this->dPorcDesIt;
  }

  /**
   * Get the value of dDescGloItem
   *
   * @return float
   */
  public function getDDescGloItem(): float | null
  {
    return $this->dDescGloItem;
  }

  /**
   * Get the value of dAntPreUniIt
   *
   * @return float
   */
  public function getDAntPreUniIt(): float | null
  {
    return $this->dAntPreUniIt;
  }

  /**
   * Get the value of dAntGloPreUniIt
   *
   * @return float
   */
  public function getDAntGloPreUniIt(): float | null
  {
    return $this->dAntGloPreUniIt;
  }

  /**
   * Get the value of dTotOpeItem
   *
   * @return float
   */
  public function getDTotOpeItem(): float | null
  {
    return $this->dTotOpeItem;
  }

  /**
   * Get the value of dTotOpeGs
   *
   * @return float
   */
  public function getDTotOpeGs(): float | null
  {
    return $this->dTotOpeGs;
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
  //     $res->setDDescItem(floatval($xml->getElementsByTagName('dDescItem')->item(0)->nodeValue));
  //     $res->setDPorcDesIt(floatval($xml->getElementsByTagName('dPorcDesIt')->item(0)->nodeValue));
  //     $res->setDDescGloItem(floatval($xml->getElementsByTagName('dDescGloItem')->item(0)->nodeValue));
  //     $res->setDAntPreUniIt(floatval($xml->getElementsByTagName('dAntPreUniIt')->item(0)->nodeValue));
  //     $res->setDAntGloPreUniIt(floatval($xml->getElementsByTagName('dAntGloPreUniIt')->item(0)->nodeValue));
  //     $res->setDTotOpeItem(floatval($xml->getElementsByTagName('dTotOpeItem')->item(0)->nodeValue));
  //     $res->setDTotOpeGs(floatval($xml->getElementsByTagName('dTotOpeGs')->item(0)->nodeValue));
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
      $res->setDDescItem(floatval($response->dDescItem));
    }
    if( isset($response->dPorcDesIt))
    {
      $res->setDPorcDesIt(floatval($response->dPorcDesIt));
    }
    if( isset($response->dDescGloItem))
    {
      $res->setDDescGloItem(floatval($response->dDescGloItem));
    }

    if( isset($response->dAntPreUniIt))
    {
      $res->setDAntPreUniIt(floatval($response->dAntPreUniIt));
    }

    if( isset($response->dAntGloPreUniIt))
    {
      $res->setDAntGloPreUniIt(floatval($response->dAntGloPreUniIt));
    }

    if( isset($response->dTotOpeItem))
    {
      $res->setDTotOpeItem(floatval($response->dTotOpeItem));
    }

    if( isset($response->dTotOpeGs))
    {
      $res->setDTotOpeGs(floatval($response->dTotOpeGs));
    }
    
    return $res;
  }
}
