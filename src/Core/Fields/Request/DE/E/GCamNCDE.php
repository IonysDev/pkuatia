<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\E;

use DOMElement;

/**
 * Campos que componen la Nota de Crédito/Débito Electrónica NCE-NDE (E400-E499)
 * ID:E400 
 * PADRE:E001 
 */
class GCamNCDE
{
  public ?int $iMotEmi  = null; //ID:E401  Motivo de emisión PADRE:E400

  //====================================================//
  ///Setters
  //====================================================//

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

  //====================================================//
  ///Getters
  //====================================================//

  /**
   * Get the value of iMotEmi
   *
   * @return int
   */
  public function getIMotEmi(): int | null
  {
    return $this->iMotEmi;
  }

  /**
   * E402 Descripción del motivo de emisión 
   *
   * @return string
   */
  public function getDDesMotEmi(): string | null
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

  //====================================================//
  ///XML Element
  //====================================================//

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

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return GCamNCDE
  //  */
  // public static function fromDOMElement(DOMElement $xml): GCamNCDE
  // {
  //   if (strcmp($xml->tagName, 'gCamNCDE') == 0 && $xml->childElementCount == 2) {
  //     $res = new GCamNCDE();
  //     $res->setIMotEmi(intval($xml->getElementsByTagName('iMotE')->item(0)->nodeValue));
  //     return $res;
  //   } else {
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
  public static function fromResponse($response): self
  {
    $res = new GCamNCDE();
    $res->setIMotEmi(intval($response->iMotEmi));
    return $res;
  }
}
