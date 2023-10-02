<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use DOMElement;

/**
 * Campos que componen la Nota de Crédito/Débito Electrónica NCE-NDE (E400-E499)
 * ID:E400 
 * PADRE:E001 
 */
class GCamNCDE
{
  public ?int $iMotEmi; //ID:E401  Motivo de emisión PADRE:E400

  ///////////////////////////////////////////////////////////////////////
  ///Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of iMotEmi
   *
   * @param int $iMotEmi
   *
   * @return self
   */
  public function setIMotEmi(int $iMotEmi): self
  {
    $this->iMotEmi = $iMotEmi;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  ///Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Get the value of iMotEmi
   *
   * @return int
   */
  public function getIMotEmi(): int
  {
    return $this->iMotEmi;
  }

  /**
   * E402 Descripción del motivo de emisión 
   *
   * @return String
   */
  public function getDDesMotEmi(): String
  {
    switch ($this->iMotEmi) {
      case 1:
        return "Devolución y Ajuste de precios";
        break;
      case 2:
        return "Devolución";
        break;
      case 3:
        return "Descuento";
        break;
      case 4:
        return "Bonificación";
        break;
      case 5:
        return "Crédito incobrable";
        break;
      case 6:
        return "Recupero de costo";
        break;
      case 7:
        return "Recupero de gasto";
        break;
      case 8:
        return "Ajuste de precio";
        break;
      default:
        return null;
        break;
    }
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML Element
  ///////////////////////////////////////////////////////////////////////

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public  function toDOMElement(): DOMElement
  {
    $res = new DOMElement('gCamNCDE');

    $res->appendChild(new DOMElement('iMotEmi', $this->getIMotEmi()));
    $res->appendChild(new DOMElement('dDesMotEmi', $this->getDDesMotEmi()));

    return $res;
  }
  
  /**
   * FromSimpleXMLElement
   *
   * @param  mixed $object
   * @return self
   */
  public static function FromSifenResponseObject($object): self
  {
    $res = new GCamNCDE();
    if(isset($object->iMotEmi))
    {
      $res->setIMotEmi(intval($object->iMotEmi));
    }
    return $res;
  }

  /**
   * Instancia un objeto del tipo GCamNCDE a partir de un DOMElement que representa el nodo XML del objeto GCamNCDE.
   * 
   * @param DOMElement $node
   * 
   * @return self
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    if(strcmp($node->nodeName, 'gCamNCDE') != 0)
      throw new \Exception('[GCamNCDE] El nombre del nodo no corresponde a gCamNCDE: ' . $node->nodeName, 1);
    $res = new GCamNCDE();
    $res->setIMotEmi(intval($node->getElementsByTagName('iMotEmi')->item(0)->nodeValue));
    return $res;
  }
}
