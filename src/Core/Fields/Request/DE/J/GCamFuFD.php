<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\J;

use DOMElement;

/**
 * ID:J001 Campos fuera de la firma digital PADRE:AA001 
 */
class GCamFuFD
{
  public ?string $dCarQR = null;   // J002 - Caracteres correspondientes al código QR
  public ?string $dInfAdic = null; // J003 - Información adicional de interés para el emisor

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
  public function getDCarQR(): string | null
  {
    return $this->dCarQR;
  }

  /**
   * Get the value of dInfAdic
   *
   * @return string
   */
  public function getDInfAdic(): string | null
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
    return $res;
  }

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return GCamFuFD
  //  */
  // public static function fromDOMElement(DOMElement $xml): GCamFuFD
  // {
  //   if (strcmp($xml->tagName, 'gCamFuFD') == 0 && $xml->childElementCount == 1) {
  //     $res = new GCamFuFD();
  //     $res->setDCarQR($xml->getElementsByTagName('dCarQR')->item(0)->nodeValue);
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
    $res = new GCamFuFD();

    if(isset($response->dCarQR))
    {
      $res->setDCarQR($response->dCarQR);
    }

    if(isset($response->dInfAdic))
    {
      $res->setDInfAdic($response->dInfAdic);
    }

    return $res;
  }
}
