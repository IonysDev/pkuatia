<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use Abiliomp\Pkuatia\Core\Fields\BaseSifenField;
use Abiliomp\Pkuatia\Utils\ValueValidations;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;


/**
 * Nodo Id:     E720
 * Nombre:      gValorItem 
 * Descripción: Campos que describen los precios, descuentos y valor total por ítem.
 * Nodo Padre:  E700
 */
class GValorItem extends BaseSifenField
{
  public String $dPUniProSer;              // E721  - 1-15p(0-8) - 1-1 - Precio unitario del producto y/o servicio (incluidos impuestos)
  public String $dTiCamIt;                 // E725  - 1-5p(0-4)  - 0-1 - Tipo de cambio por ítem
  public String $dTotBruOpeItem;           // E727  - 1-15p(0-8) - 1-1 - Total bruto de la operación por ítem
  public GValorRestaItem $gValorRestaItem; // EA001 -            - 1-1 - Campos que describen los descuentos, anticipos valor total por ítem 

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of dPUniProSer
   *
   * @param String $dPUniProSer
   *
   * @return self
   */
  public function setDPUniProSer(String $dPUniProSer): self
  {
    if(ValueValidations::isValidStringDecimal($dPUniProSer, 15, 0) === false)
    {
      throw new \Exception("El valor dPUniProSer no es válido:" . $dPUniProSer);
    }
    $this->dPUniProSer = $dPUniProSer;
    return $this;
  }


  /**
   * Set the value of dTiCamIt
   *
   * @param String $dTiCamIt
   *
   * @return self
   */
  public function setDTiCamIt(String $dTiCamIt): self
  {
    if(ValueValidations::isValidStringDecimal($dTiCamIt, 5, 0) === false)
    {
      throw new \Exception("El valor dTiCamIt no es válido:" . $dTiCamIt);
    }
    $this->dTiCamIt = $dTiCamIt;
    return $this;
  }


  /**
   * Set the value of dTotBruOpeItem
   *
   * @param String $dTotBruOpeItem
   *
   * @return self
   */
  public function setDTotBruOpeItem(String $dTotBruOpeItem): self
  {
    if(ValueValidations::isValidStringDecimal($dTotBruOpeItem, 15, 0) === false)
    {
      throw new \Exception("El valor dTotBruOpeItem no es válido:" . $dTotBruOpeItem);
    }
    $this->dTotBruOpeItem = $dTotBruOpeItem;
    return $this;
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

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////


  /**
   * Get the value of dPUniProSer
   *
   * @return String
   */
  public function getDPUniProSer(): String
  {
    return $this->dPUniProSer;
  }

  /**
   * Get the value of dTiCamIt
   *
   * @return String
   */
  public function getDTiCamIt(): String
  {
    return $this->dTiCamIt;
  }

  /**
   * Get the value of dTotBruOpeItem
   *
   * @return String
   */
  public function getDTotBruOpeItem(): String
  {
    return $this->dTotBruOpeItem;
  }

  /**
   * Get the value of gValorRestaItem
   *
   * @return GValorRestaItem
   */
  public function getGValorRestaItem(): GValorRestaItem
  {
    return $this->gValorRestaItem;
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML Element
  ///////////////////////////////////////////////////////////////////////

  /**
   * Instancia un objeto GValorItem a partir de un SimpleXMLElement
   * 
   * @param SimpleXMLElement $node
   * 
   * @return GValorItem
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node): GValorItem
  {
    if(strcmp($node->getName(), 'gValorItem') !== 0)
    {
      throw new \Exception("El elemento '" . $node->getName() . "' no corresponde a un gValorItem.");
    }
    $res = new GValorItem();
    $res->setDPUniProSer(strval($node->dPUniProSer));
    if(isset($node->dTiCamIt))
    {
      $res->setDTiCamIt(strval($node->dTiCamIt));
    }
    if(isset($node->dTotBruOpeItem))
    {
      $res->setDTotBruOpeItem(strval($node->dTotBruOpeItem));
    }
    $res->setGValorRestaItem(GValorRestaItem::fromSimpleXMLElement($node->gValorRestaItem));
    return $res;
  }

  /**
   * Convierte este GValorItem en un DOMElement que puede ser insertado en el DOMDocument especificado.
   * 
   * @param DOMDocument $doc Documento DOM que creará el DOMElement sin insertarlo.
   *
   * @return DOMElement El DOMElement creado.
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gValorItem');
    $res->appendChild(new DOMElement('dPUniProSer', $this->getDPUniProSer()));
    if(isset($this->dTiCamIt))
      $res->appendChild(new DOMElement('dTiCamIt', $this->getDTiCamIt()));
    $res->appendChild(new DOMElement('dTotBruOpeItem', $this->getDTotBruOpeItem()));
    $res->appendChild($this->gValorRestaItem->toDOMElement($doc));
    return $res;
  }

  ///////////////////////////////////////////////////////////////////////
  // Others
  ///////////////////////////////////////////////////////////////////////

  
  
  /**
   * FromSifenResponseObject
   *
   * @param  mixed $object
   * @return self
   */
  public static function FromSifenResponseObject($object):self
  {
    $res = new GValorItem();
    if(isset($object->dPUniProSer))
    {
      $res->setDPUniProSer(strval($object->dPUniProSer));
    }
    if(isset($object->dTiCamIt))
    {
      $res->setDTiCamIt(strval($object->dTiCamIt));
    }
    if(isset($object->dTotBruOpeItem))
    {
      $res->setDTotBruOpeItem(strval($object->dTotBruOpeItem));
    }
    ///children
    if(isset($object->gValorRestaItem))
    {
      $res->setGValorRestaItem(GValorRestaItem::FromSifenResponseObject($object->gValorRestaItem));
    }
    return $res;
  }

  /**
   * Instancia un objeto GValorItem a partir de un DOMElement que lo representa.
   * 
   * @param  DOMElement $node
   * 
   * @return self
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    if(strcmp($node->nodeName, 'gValorItem') != 0)
        throw new \Exception('[GValorItem] Nodo con nombre inválido: ' . $node->nodeName);
    $res = new self();
    $res->setDPUniProSer(trim($node->getElementsByTagName('dPUniProSer')->item(0)->nodeValue));
    if($node->getElementsByTagName('dTiCamIt')->length > 0)
      $res->setDTiCamIt(trim($node->getElementsByTagName('dTiCamIt')->item(0)->nodeValue));
    $res->setDTotBruOpeItem(trim($node->getElementsByTagName('dTotBruOpeItem')->item(0)->nodeValue));
    $res->setGValorRestaItem(GValorRestaItem::FromDOMElement($node->getElementsByTagName('gValorRestaItem')->item(0)));
    return $res;
  }
}
