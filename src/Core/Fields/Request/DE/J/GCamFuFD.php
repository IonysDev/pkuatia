<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\J;

use DOMElement;

/**
 * ID:J001 Campos fuera de la firma digital PADRE:AA001 
 */
class GCamFuFD
{
  public String $dCarQR;   // J002 - Caracteres correspondientes al código QR
  public String $dInfAdic; // J003 - Información adicional de interés para el emisor

  ///////////////////////////////////////////////////////////////////////
  //SETTER
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of dCarQR
   *
   * @param String $dCarQR
   *
   * @return self
   */
  public function setDCarQR(String $dCarQR): self
  {
    $this->dCarQR = $dCarQR;
    return $this;
  }


  /**
   * Set the value of dInfAdic
   *
   * @param String $dInfAdic
   *
   * @return self
   */
  public function setDInfAdic(String $dInfAdic): self
  {
    $this->dInfAdic = $dInfAdic;
    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  ///GETTER
  ///////////////////////////////////////////////////////////////////////


  /**
   * Get the value of dCarQR
   *
   * @return String
   */
  public function getDCarQR(): String
  {
    return $this->dCarQR;
  }

  /**
   * Get the value of dInfAdic
   *
   * @return String
   */
  public function getDInfAdic(): String
  {
    return $this->dInfAdic;
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML ELEMENT  
  ///////////////////////////////////////////////////////////////////////

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

  /**
   * fromSimpleXMLElement
   */
  public static function fromSimpleXMLElement(\SimpleXMLElement $xml): self
  {
    if(strcmp($xml->getName(), 'gCamFuFD') != 0)
    {
      throw new \Exception('Invalid XML Node Name: ' . $xml->getName());
    }
    $res = new GCamFuFD();
    if(isset($xml->dCarQR))
      $res->setDCarQR((string)$xml->dCarQR);
    if(isset($xml->dInfAdic))
      $res->setDInfAdic((string)$xml->dInfAdic);
    return $res;
  }
  
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
