<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\E;


use DOMElement;


/**
 * ID:E720 gValorItem Campos que describen los precios, descuentos y valor total por ítem PADRE:E700
 */
class GValorItem
{
  public ?float $dPUniProSer = null; ///E721 Precio unitario del producto y/o servicio (incluidos impuestos)
  public ?float $dTiCamIt = null; ///E725 Tipo de cambio por ítem
  public ?float $dTotBruOpeItem = null; ///E727 Total bruto de la operación por ítem
  public ?GValorRestaItem $gValorRestaItem = null;

  ///////////////////////////////////////////////////////////////////////
  ///Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of dPUniProSer
   *
   * @param float $dPUniProSer
   *
   * @return self
   */
  public function setDPUniProSer(float $dPUniProSer): self
  {
    $this->dPUniProSer = $dPUniProSer;

    return $this;
  }


  /**
   * Set the value of dTiCamIt
   *
   * @param float $dTiCamIt
   *
   * @return self
   */
  public function setDTiCamIt(float $dTiCamIt): self
  {
    $this->dTiCamIt = $dTiCamIt;

    return $this;
  }


  /**
   * Set the value of dTotBruOpeItem
   *
   * @param float $dTotBruOpeItem
   *
   * @return self
   */
  public function setDTotBruOpeItem(float $dTotBruOpeItem): self
  {
    $this->dTotBruOpeItem = $dTotBruOpeItem;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  //Getters
  ///////////////////////////////////////////////////////////////////////


  /**
   * Get the value of dPUniProSer
   *
   * @return float
   */
  public function getDPUniProSer(): float | null
  {
    return $this->dPUniProSer;
  }

  /**
   * Get the value of dTiCamIt
   *
   * @return float
   */
  public function getDTiCamIt(): float | null
  {
    return $this->dTiCamIt;
  }

  /**
   * Get the value of dTotBruOpeItem
   *
   * @return float
   */
  public function getDTotBruOpeItem(): float | null
  {
    return $this->dTotBruOpeItem;
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
    $res = new DOMElement('gValorItem');

    $res->appendChild(new DOMElement('dPUniProSer', $this->getDPUniProSer()));
    $res->appendChild(new DOMElement('dTiCamIt', $this->getDTiCamIt()));
    $res->appendChild(new DOMElement('dTotBruOpeItem', $this->getDTotBruOpeItem())); ////Corresponde a la multiplicación del precio por ítem (E721) y la cantidad por ítem (E711)

    ///Children
    $res->appendChild($this->gValorRestaItem->toDOMElement());
    return $res;
  }
  
  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return GValorItem
  //  */
  // public static function fromDOMElement(DOMElement $xml): GValorItem
  // {
  //   if (strcmp($xml->tagName, 'gValorItem') == 0 && $xml->childElementCount == 4) {
  //     $res = new GValorItem();
  //     $res->setDPUniProSer(floatval($xml->getElementsByTagName('dPUniProSer')->item(0)->nodeValue));
  //     $res->setDTiCamIt(floatval($xml->getElementsByTagName('dTiCamIt')->item(0)->nodeValue));
  //     $res->setDTotBruOpeItem(floatval($xml->getElementsByTagName('dTotBruOpeItem')->item(0)->nodeValue));
  //     ///children
  //     $res->setGValorRestaItem($res->gValorRestaItem->fromDOMElement($xml->getElementsByTagName('gValorRestaItem')->item(0)->nodeValue));
  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  //}

  ///////////////////////////////////////////////////////////////////////
  ///Others
  ///////////////////////////////////////////////////////////////////////

  /**
   * Get the value of gValorRestaItem
   *
   * @return GValorRestaItem
   */
  public function getGValorRestaItem(): GValorRestaItem | null
  {
    return $this->gValorRestaItem;
  }

  /**
   * Set the value of gValorRestaItem
   *
   * @param GValorRestaItem $gValorRestaItem
   *
   * @return self
   */
  public function setGValorRestaItem(GValorRestaItem $gValorRestaItem): self
  {
    $this->gValorRestaItem = $gValorRestaItem;

    return $this;
  }
  
  /**
   * fromResponse
   *
   * @param  mixed $response
   * @return self
   */
  public static function fromResponse($response):self
  {
    $res = new GValorItem();
    if(isset($response->dPUniProSer))
    {
      $res->setDPUniProSer(floatval($response->dPUniProSer));
    }
    if(isset($response->dTiCamIt))
    {
      $res->setDTiCamIt(floatval($response->dTiCamIt));
    }
    if(isset($response->dTotBruOpeItem))
    {
      $res->setDTotBruOpeItem(floatval($response->dTotBruOpeItem));
    }
    ///children
    if(isset($response->gValorRestaItem))
    {
      $res->setGValorRestaItem(GValorRestaItem::fromResponse($response->gValorRestaItem));
    }
    return $res;
  }
}
