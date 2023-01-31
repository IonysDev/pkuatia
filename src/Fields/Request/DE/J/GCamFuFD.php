<?php

namespace Abiliomp\Pkuatia\Fields\J;

use DOMElement;

/**
 * ID:J001 Campos fuera de la firma digital PADRE:AA001 
 */
class GCamFuFD
{
  public string $dCarQR; ///Caracteres correspondientes al código QR
  public string $dInfAdic; ///Información adicional de interés para el emisor

  //====================================================//
  //SETTER
  //====================================================//

  /**
   * Set the value of dCarQR
   *
   * @param string $dCarQR
   *
   * @return self
   */
  public function setDCarQR(string $dCarQR): self
  {
    $this->dCarQR = $dCarQR;

    return $this;
  }


  /**
   * Set the value of dInfAdic
   *
   * @param string $dInfAdic
   *
   * @return self
   */
  public function setDInfAdic(string $dInfAdic): self
  {
    $this->dInfAdic = $dInfAdic;

    return $this;
  }

  //====================================================//
  ///GETTER
  //====================================================//


  /**
   * Get the value of dCarQR
   *
   * @return string
   */
  public function getDCarQR(): string
  {
    return $this->dCarQR;
  }

  /**
   * Get the value of dInfAdic
   *
   * @return string
   */
  public function getDInfAdic(): string
  {
    return $this->dInfAdic;
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
    $res = new DOMElement('gCamFuFD');
    $res->appendChild(new DOMElement('dCarQR', $this->getDCarQR()));
    $res->appendChild(new DOMElement('dInfAdic', $this->getDInfAdic()));
    return $res;
  }

  /**
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return GCamFuFD
   */
  public static function fromDOMElement(DOMElement $xml): GCamFuFD
  {
    if (strcmp($xml->tagName, 'gCamFuFD') == 0 && $xml->childElementCount == 2) {
      $res = new GCamFuFD();
      $res->setDCarQR($xml->getElementsByTagName('dCarQR')->item(0)->nodeValue);
      $res->setDInfAdic($xml->getElementsByTagName('dInfAdic')->item(0)->nodeValue);
      return $res;
    } else {
      throw new \Exception("Invalid XML Element: $xml->tagName");
      return null;
    }
  }
}
