<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\E;


use DOMElement;


/**
 * ID:E720 gValorItem Campos que describen los precios, descuentos y valor total por ítem PADRE:E700
 */
class GValorItem
{
  public int $dPUniProSer; ///E721 Precio unitario del producto y/o servicio (incluidos impuestos)
  public int $dTiCamIt; ///E725 Tipo de cambio por ítem
  public int $dTotBruOpeItem; ///E727 Total bruto de la operación por ítem
  public GValorRestaItem $gValorRestaItem;

  //====================================================//
  ///Setters
  //====================================================//

  /**
   * Set the value of dPUniProSer
   *
   * @param int $dPUniProSer
   *
   * @return self
   */
  public function setDPUniProSer(int $dPUniProSer): self
  {
    $this->dPUniProSer = $dPUniProSer;

    return $this;
  }


  /**
   * Set the value of dTiCamIt
   *
   * @param int $dTiCamIt
   *
   * @return self
   */
  public function setDTiCamIt(int $dTiCamIt): self
  {
    $this->dTiCamIt = $dTiCamIt;

    return $this;
  }


  /**
   * Set the value of dTotBruOpeItem
   *
   * @param int $dTotBruOpeItem
   *
   * @return self
   */
  public function setDTotBruOpeItem(int $dTotBruOpeItem): self
  {
    $this->dTotBruOpeItem = $dTotBruOpeItem;

    return $this;
  }

  //====================================================//
  //Getters
  //====================================================//


  /**
   * Get the value of dPUniProSer
   *
   * @return int
   */
  public function getDPUniProSer(): int
  {
    return $this->dPUniProSer;
  }

  /**
   * Get the value of dTiCamIt
   *
   * @return int
   */
  public function getDTiCamIt(): int
  {
    return $this->dTiCamIt;
  }

  /**
   * Get the value of dTotBruOpeItem
   *
   * @return int
   */
  public function getDTotBruOpeItem(): int
  {
    return $this->dTotBruOpeItem;
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
    $res = new DOMElement('gValorItem');

    $res->appendChild(new DOMElement('dPUniProSer', $this->getDPUniProSer()));
    $res->appendChild(new DOMElement('dTiCamIt', $this->getDTiCamIt()));
    $res->appendChild(new DOMElement('dTotBruOpeItem', $this->getDTotBruOpeItem())); ////Corresponde a la multiplicación del precio por ítem (E721) y la cantidad por ítem (E711)

    ///Children
    $res->appendChild($this->gValorRestaItem->toDOMElement());
    return $res;
  }
  
  /**
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return GValorItem
   */
  public static function fromDOMElement(DOMElement $xml): GValorItem
  {
    if (strcmp($xml->tagName, 'gValorItem') == 0 && $xml->childElementCount == 4) {
      $res = new GValorItem();
      $res->setDPUniProSer(intval($xml->getElementsByTagName('dPUniProSer')->item(0)->nodeValue));
      $res->setDTiCamIt(intval($xml->getElementsByTagName('dTiCamIt')->item(0)->nodeValue));
      $res->setDTotBruOpeItem(intval($xml->getElementsByTagName('dTotBruOpeItem')->item(0)->nodeValue));
      ///children
      $res->setGValorRestaItem($res->gValorRestaItem->fromDOMElement($xml->getElementsByTagName('gValorRestaItem')->item(0)->nodeValue));
      return $res;
    } else {
      throw new \Exception("Invalid XML Element: $xml->tagName");
      return null;
    }
  }

  //====================================================//
  ///Others
  //====================================================//

  /**
   * Get the value of gValorRestaItem
   *
   * @return GValorRestaItem
   */
  public function getGValorRestaItem(): GValorRestaItem
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
}
