<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\J;

use Abiliomp\Pkuatia\Core\Fields\BaseSifenField;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id:     J001 
 * Nombre:      gCamFuFD
 * Descripción: Campos fuera de la firma digital.
 * Nodo Padre:  AA001 - rDE - Documento Electrónico elemento raíz
 */

class GCamFuFD extends BaseSifenField
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
    $this->dInfAdic = substr($dInfAdic, 0, 5000);
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
  // Instanciadores
  ///////////////////////////////////////////////////////////////////////

  /**
   * Instancia un objeto GCamFuFD a partir de un SimpleXMLElement
   * 
   * @param SimpleXMLElement $xml
   * 
   * @return self
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $xml): self
  {
    if (strcmp($xml->getName(), 'gCamFuFD') != 0) {
      throw new \Exception('[GCamFuFD] Nodo XML con nombre inválido: ' . $xml->getName());
    }
    $res = new GCamFuFD();
    $res->setDCarQR((string)$xml->dCarQR);
    if (isset($xml->dInfAdic))
      $res->setDInfAdic((string)$xml->dInfAdic);
    return $res;
  }

  /**
   * Instancia un objeto GCamFuFD a partir de un objeto stdClass recibido como respuesta a una llamada SOAP al SIFEN.
   *
   * @param  mixed $object
   * 
   * @return self
   */
  public static function FromSifenResponseObject($object): self
  {
    $res = new GCamFuFD();
    $res->setDCarQR($object->dCarQR);
    if (isset($object->dInfAdic)) {
      $res->setDInfAdic($object->dInfAdic);
    }
    return $res;
  }

  ///////////////////////////////////////////////////////////////////////
  // Conversores
  ///////////////////////////////////////////////////////////////////////

  /**
   * Convierte el objeto GCamFuFD a un DOMElement
   * 
   * @param DOMDocument $doc Documento DOM donde se agregará el nodo
   *
   * @return DOMElement Nodo DOM que representa el objeto
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    // Validaciones
    if(!isset($this->dCarQR) || empty($this->dCarQR))
    {
      throw new \Exception('[GCamFuFD] dCarQR no puede estar vacío.');
    }
    else if(strlen($this->dCarQR) < 100 || strlen($this->dCarQR) > 600)
    {
      throw new \Exception('[GCamFuFD] dCarQR debe tener entre 100 y 600 caracteres. Se encontraron ' . strlen($this->dCarQR) . '.');
    }
    if(isset($this->dInfAdic) && strlen($this->dInfAdic) > 5000)
    {
      throw new \Exception('[GCamFuFD] dInfAdic no puede tener más de 5000 caracteres.');
    }
    // Conversión
    $res = $doc->createElement('gCamFuFD');
    
    $qr = new DOMElement('dCarQR');
    $qr->textContent = $this->getDCarQR();
    
    $res->appendChild($qr);
    if (isset($this->dInfAdic))
      $res->appendChild(new DOMElement('dInfAdic', $this->getDInfAdic()));

    return $res;
  }

  /**
   * Instancia un objeto GCamFuFD a partir de un DOMElement que representa el nodo XML del objeto.
   * 
   * @param DOMElement $node Nodo XML que representa el objeto GCamFuFD
   * 
   * @return GCamFuFD Objeto GCamFuFD instanciado
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    if(strcmp($node->nodeName, 'gCamFuFD') != 0)
        throw new \Exception('[GCamFuFD] Nodo con nombre inválido: ' . $node->nodeName);
    $res = new self();
    $res->setDCarQR(trim($node->getElementsByTagName('dCarQR')->item(0)->nodeValue));
    if($node->getElementsByTagName('dInfAdic')->length > 0)
        $res->setDInfAdic(trim($node->getElementsByTagName('dInfAdic')->item(0)->nodeValue));
    return $res;
  }
}
