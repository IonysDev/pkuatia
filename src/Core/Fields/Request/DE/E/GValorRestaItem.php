<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\E;

use DOMElement;

/**
 * EA001 Campos que describen los descuentos, anticipos valor total por ítem Padre:E720
 */
class GValorRestaItem
{
  public ?int $dDescItem = null; ///EA002 Descuento particular sobre el precio unitario por ítem (incluidos impuestos)
  public ?int $dPorcDesIt = null; /// EA003 Porcentaje de descuento particular por ítem
  public ?int $dDescGloItem = null; ///EA004 Descuento global sobre el precio unitario por ítem (incluidos impuestos)
  public ?int $dAntPreUniIt = null; ///EA006 Anticipo particular sobre el precio unitario por ítem (incluidos impuestos)
  public ?int $dAntGloPreUniIt = null; ///EA007 Anticipo global sobre el  precio unitario por ítem  (incluidos impuestos)
  public ?int $dTotOpeItem = null; /// EA008 Valor total de la operación por ítem 
  public ?int $dTotOpeGs = null; ///EA009 Valor total de la operación por ítem en guaraníes

  //====================================================//
  ///Setters
  //====================================================//

  /**
   * Set the value of dDescItem
   *
   * @param int $dDescItem
   *
   * @return self
   */
  public function setDDescItem(int $dDescItem): self
  {
    $this->dDescItem = $dDescItem;

    return $this;
  }


  /**
   * Set the value of dPorcDesIt
   *
   * @param int $dPorcDesIt
   *
   * @return self
   */
  public function setDPorcDesIt(int $dPorcDesIt): self
  {
    $this->dPorcDesIt = $dPorcDesIt;

    return $this;
  }


  /**
   * Set the value of dDescGloItem
   *
   * @param int $dDescGloItem
   *
   * @return self
   */
  public function setDDescGloItem(int $dDescGloItem): self
  {
    $this->dDescGloItem = $dDescGloItem;

    return $this;
  }


  /**
   * Set the value of dAntPreUniIt
   *
   * @param int $dAntPreUniIt
   *
   * @return self
   */
  public function setDAntPreUniIt(int $dAntPreUniIt): self
  {
    $this->dAntPreUniIt = $dAntPreUniIt;

    return $this;
  }


  /**
   * Set the value of dAntGloPreUniIt
   *
   * @param int $dAntGloPreUniIt
   *
   * @return self
   */
  public function setDAntGloPreUniIt(int $dAntGloPreUniIt): self
  {
    $this->dAntGloPreUniIt = $dAntGloPreUniIt;

    return $this;
  }


  /**
   * Set the value of dTotOpeItem
   *
   * @param int $dTotOpeItem
   *
   * @return self
   */
  public function setDTotOpeItem(int $dTotOpeItem): self
  {
    $this->dTotOpeItem = $dTotOpeItem;

    return $this;
  }


  /**
   * Set the value of dTotOpeGs
   *
   * @param int $dTotOpeGs
   *
   * @return self
   */
  public function setDTotOpeGs(int $dTotOpeGs): self
  {
    $this->dTotOpeGs = $dTotOpeGs;

    return $this;
  }

  //====================================================//
  ///Getters
  //====================================================//


  /**
   * Get the value of dDescItem
   *
   * @return int
   */
  public function getDDescItem(): int | null
  {
    return $this->dDescItem;
  }

  /**
   * Get the value of dPorcDesIt
   *
   * @return int
   */
  public function getDPorcDesIt(): int | null
  {
    return $this->dPorcDesIt;
  }

  /**
   * Get the value of dDescGloItem
   *
   * @return int
   */
  public function getDDescGloItem(): int | null
  {
    return $this->dDescGloItem;
  }

  /**
   * Get the value of dAntPreUniIt
   *
   * @return int
   */
  public function getDAntPreUniIt(): int | null
  {
    return $this->dAntPreUniIt;
  }

  /**
   * Get the value of dAntGloPreUniIt
   *
   * @return int
   */
  public function getDAntGloPreUniIt(): int | null
  {
    return $this->dAntGloPreUniIt;
  }

  /**
   * Get the value of dTotOpeItem
   *
   * @return int
   */
  public function getDTotOpeItem(): int | null
  {
    return $this->dTotOpeItem;
  }

  /**
   * Get the value of dTotOpeGs
   *
   * @return int
   */
  public function getDTotOpeGs(): int | null
  {
    return $this->dTotOpeGs;
  }

  //====================================================//
  ///XML Element
  //====================================================//

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
  //     $res->setDDescItem(intval($xml->getElementsByTagName('dDescItem')->item(0)->nodeValue));
  //     $res->setDPorcDesIt(intval($xml->getElementsByTagName('dPorcDesIt')->item(0)->nodeValue));
  //     $res->setDDescGloItem(intval($xml->getElementsByTagName('dDescGloItem')->item(0)->nodeValue));
  //     $res->setDAntPreUniIt(intval($xml->getElementsByTagName('dAntPreUniIt')->item(0)->nodeValue));
  //     $res->setDAntGloPreUniIt(intval($xml->getElementsByTagName('dAntGloPreUniIt')->item(0)->nodeValue));
  //     $res->setDTotOpeItem(intval($xml->getElementsByTagName('dTotOpeItem')->item(0)->nodeValue));
  //     $res->setDTotOpeGs(intval($xml->getElementsByTagName('dTotOpeGs')->item(0)->nodeValue));
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
      $res->setDDescItem(intval($response->dDescItem));
    }
    if( isset($response->dPorcDesIt))
    {
      $res->setDPorcDesIt(intval($response->dPorcDesIt));
    }
    if( isset($response->dDescGloItem))
    {
      $res->setDDescGloItem(intval($response->dDescGloItem));
    }

    if( isset($response->dAntPreUniIt))
    {
      $res->setDAntPreUniIt(intval($response->dAntPreUniIt));
    }

    if( isset($response->dAntGloPreUniIt))
    {
      $res->setDAntGloPreUniIt(intval($response->dAntGloPreUniIt));
    }

    if( isset($response->dTotOpeItem))
    {
      $res->setDTotOpeItem(intval($response->dTotOpeItem));
    }

    if( isset($response->dTotOpeGs))
    {
      $res->setDTotOpeGs(intval($response->dTotOpeGs));
    }
    
    return $res;
  }
}
