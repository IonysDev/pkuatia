<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\J;

use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id:     J001 
 * Nombre:      gCamFuFD
 * Descripción: Campos fuera de la firma digital.
 * Nodo Padre:  AA001 - rDE - Documento Electrónico elemento raíz
 */

class GCamFuFD
{
                           // Id - Longitud - Ocurrencia - Descripción
  public String $dCarQR;   // J002 - 100-600 - 1-1 - Caracteres correspondientes al código QR
  public String $dInfAdic; // J003 - 1-5000  - 0-1 - Información adicional de interés para el emisor

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece los caracteres correspondientes al código QR
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
   * Establece la información adicional de interés para el emisor
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
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Devuelve los caracteres correspondientes al código QR
   *
   * @return String
   */
  public function getDCarQR(): String
  {
    return $this->dCarQR;
  }

  /**
   * Devuelve la información adicional de interés para el emisor
   *
   * @return String
   */
  public function getDInfAdic(): String
  {
    return $this->dInfAdic;
  }

  ///////////////////////////////////////////////////////////////////////
  // XML Element
  ///////////////////////////////////////////////////////////////////////

  /**
   * Instancia un objeto GCamFuFD a partir de un SimpleXMLElement
   * 
   * @param SimpleXMLElement $xml
   * 
   * @return self
   */
  public static function fromSimpleXMLElement(SimpleXMLElement $xml): self
  {
    if(strcmp($xml->getName(), 'gCamFuFD') != 0)
    {
      throw new \Exception('[GCamFuFD] Nodo XML con nombre inválido: ' . $xml->getName());
    }
    $res = new GCamFuFD();
    if(isset($xml->dCarQR))
      $res->setDCarQR((string)$xml->dCarQR);
    if(isset($xml->dInfAdic))
      $res->setDInfAdic((string)$xml->dInfAdic);
    return $res;
  }

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
