<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\E;

use DOMElement;

/**
 * ID:E730 Campos que describen el IVA de la operación PADRE:E700
 */
class GCamIVA
{
  public ?int $iAfecIVA  = null; /// E731  Forma de afectación tributaria del IVA
  public ?int $dPropIVA  = null; ///E733 Proporción gravada de IVA
  public ?int $dTasaIVA  = null; //E734  Tasa del IVA
  public ?float $dBasGravIVA = null; //E735 Base gravada del IVA por ítem 
  public ?float $dLiqIVAItem = null; //E736  Liquidación del IVA por ítem

  ///////////////////////////////////////////////////////////////////////
  //Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of iAfecIVA
   *
   * @param int $iAfecIVA
   *
   * @return self
   */
  public function setIAfecIVA(int $iAfecIVA): self
  {
    $this->iAfecIVA = $iAfecIVA;

    return $this;
  }


  /**
   * Set the value of dPropIVA
   *
   * @param int $dPropIVA
   *
   * @return self
   */
  public function setDPropIVA(int $dPropIVA): self
  {
    $this->dPropIVA = $dPropIVA;

    return $this;
  }


  /**
   * Set the value of dTasaIVA
   *
   * @param int $dTasaIVA
   *
   * @return self
   */
  public function setDTasaIVA(int $dTasaIVA): self
  {
    $this->dTasaIVA = $dTasaIVA;

    return $this;
  }


  /**
   * Set the value of dBasGravIVA
   *
   * @param float $dBasGravIVA
   *
   * @return self
   */
  public function setDBasGravIVA(float $dBasGravIVA): self
  {
    $this->dBasGravIVA = $dBasGravIVA;

    return $this;
  }


  /**
   * Set the value of dLiqIVAItem
   *
   * @param float $dLiqIVAItem
   *
   * @return self
   */
  public function setDLiqIVAItem(float $dLiqIVAItem): self
  {
    $this->dLiqIVAItem = $dLiqIVAItem;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  //Getter
  ///////////////////////////////////////////////////////////////////////

  /**
   * Get the value of iAfecIVA
   *
   * @return int
   */
  public function getIAfecIVA(): int | null
  {
    return $this->iAfecIVA;
  }


  /**
   * E732 Descripción de la forma de afectación tributaria del IVA
   *
   * @return string
   */
  public function getDDesAfecIVA(): string | null
  {
    switch ($this->iAfecIVA) {
      case 1:
        return "Gravado IVA";
        break;
      case 2:
        return "Exonerado (Art. 83- Ley 125/91)";
        break;
      case 3:
        return "Exento";
        break;
      case 4:
        return "Gravado parcial (Grav-Exento)";
        break;
      default:
        return null;
        break;
    }
  }

  /**
   * Get the value of dPropIVA
   *
   * @return int
   */
  public function getDPropIVA(): int | null
  {
    return $this->dPropIVA;
  }

  /**
   * Get the value of dTasaIVA
   *
   * @return int
   */
  public function getDTasaIVA(): int | null
  {
    return $this->dTasaIVA;
  }

  /**
   * Get the value of dBasGravIVA
   *
   * @return float
   */
  public function getDBasGravIVA(): float | null
  {
    return $this->dBasGravIVA;
  }

  /**
   * Get the value of dLiqIVAItem
   *
   * @return float
   */
  public function getDLiqIVAItem(): float | null
  {
    return $this->dLiqIVAItem;
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
    $res = new DOMElement('gCamIVA');

    $res->appendChild(new DOMElement('iAfecIVA', $this->getIAfecIVA()));
    $res->appendChild(new DOMElement('dDesAfecIVA', $this->getDDesAfecIVA()));
    $res->appendChild(new DOMElement('dPropIVA', $this->getDPropIVA()));
    $res->appendChild(new DOMElement('dTasaIVA', $this->getDTasaIVA()));
    $res->appendChild(new DOMElement('dBasGravIVA', $this->getDBasGravIVA()));
    $res->appendChild(new DOMElement('dLiqIVAItem', $this->getDLiqIVAItem()));

    return $res;
  }

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return GCamIVA
  //  */
  // public static function fromDOMElement(DOMElement $xml): GCamIVA
  // {
  //   if (strcmp($xml->tagName, 'gCamIVA') == 0 && $xml->childElementCount == 6) {
  //     $res = new GCamIVA();
  //     $res->setIAfecIVA(intval($xml->getElementsByTagName('iAfecIVA')->item(0)->nodeValue));
  //     $res->setDPropIVA(intval($xml->getElementsByTagName('dPropIVA')->item(0)->nodeValue));
  //     $res->setDTasaIVA(intval($xml->getElementsByTagName('dTasaIVA')->item(0)->nodeValue));
  //     $res->setDBasGravIVA(intval($xml->getElementsByTagName('dBasGravIVA')->item(0)->nodeValue));
  //     $res->setDLiqIVAItem(intval($xml->getElementsByTagName('dLiqIVAItem')->item(0)->nodeValue));
  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }
  
  /**
   * fromResponse
   *
   * @param  mixed $resposne
   * @return self
   */
  public static function fromResponse($resposne): self
  {

    $res = new GCamIVA();
    if(isset($resposne->iAfecIVA))
    {
      $res->setIAfecIVA(intval($resposne->iAfecIVA));
    }
    if(isset($resposne->dPropIVA))
    {
      $res->setDPropIVA(intval($resposne->dPropIVA));
    }
    if(isset($resposne->dTasaIVA))
    {
      $res->setDTasaIVA(intval($resposne->dTasaIVA));
    }
    if(isset($resposne->dBasGravIVA))
    {
      $res->setDBasGravIVA(floatval($resposne->dBasGravIVA));
    }
    if(isset($resposne->dLiqIVAItem))
    {
      $res->setDLiqIVAItem(floatval($resposne->dLiqIVAItem));
    }
    
     
    return $res;
  }
}
