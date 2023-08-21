<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\AA;

use Abiliomp\Pkuatia\Core\Constants;
use Abiliomp\Pkuatia\Core\Fields\DE\A\DE;
use Abiliomp\Pkuatia\Core\Fields\DE\I\Signature;
use Abiliomp\Pkuatia\Core\Fields\DE\J\GCamFuFD;
use DOMElement;
use SimpleXMLElement;
use stdClass;

/** 
 * Nodo Id:     AA001
 * Nombre:      rDE
 * Descripción: Campos que identifican el formato electrónico XML (AA001-AA009)
 * Nodo Padre:  Es nodo raiz.
 */

class RDE
{
                               // Id - Longitud - Ocurrencia - Descripción 
  public int $dVerFor;         // AA002 - 3 - 1-1 - Versión del formato
  public DE $DE;               // A001  -   - 1-1 - Campos firmados del  DE
  public Signature $Signature; // I001  -   - 1-1 - Firma Digital del DTE
  public GCamFuFD $gCamFuFD;   // J001  -   - 1-1 - Campos fuera de la firma digital

  /**
   * Constructor
   * 
   * @return self
   */
  public function __construct()
  {
    $this->setDVerFor(Constants::SIFEN_VERSION);
  }

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de dVerFor (Versión del formato)
   *
   * @param int $dVerFor Versión del formato
   *
   * @return self
   */
  public function setDVerFor(int $dVerFor): self
  {
    $this->dVerFor = $dVerFor;
    return $this;
  }

  /**
   * Establece el valor de DE (Campos firmados del DE)
   *
   * @param DE $DE
   *
   * @return self
   */
  public function setDE(DE $DE): self
  {
    $this->DE = $DE;
    return $this;
  }

  /**
   * Establece el valor de gCamFuFD (Campos fuera de la firma digital)
   *
   * @param GCamFuFD $gCamFuFD
   *
   * @return self
   */
  public function setGCamFuFD(GCamFuFD $gCamFuFD): self
  {
    $this->gCamFuFD = $gCamFuFD;
    return $this;
  }

  
  /**
   * Establece el valor de Signature (Firma Digital del DTE)
   *
   * @param Signature $Signature
   *
   * @return self
   */
  public function setSignature(Signature $Signature): self
  {
    $this->Signature = $Signature;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Devuelve el valor de dVerFor (Versión del formato)
   *
   * @return int
   */
  public function getDVerFor(): int
  {
    return $this->dVerFor;
  }

  /**
   * Devuelve el valor de DE (Campos firmados del DE)
   *
   * @return DE
   */
  public function getDE(): DE
  {
    return $this->DE;
  }

  /**
   * Devuelve el valor de gCamFuFD (Campos fuera de la firma digital)
   *
   * @return GCamFuFD
   */
  public function getGCamFuFD(): GCamFuFD
  {
    return $this->gCamFuFD;
  }

  /**
   * Devuelve el valor de Signature (Firma Digital del DTE)
   *
   * @return Signature
   */
  public function getSignature(): Signature
  {
    return $this->Signature;
  }

  ///////////////////////////////////////////////////////////////////////
  // Instanciadores y Conversores
  ///////////////////////////////////////////////////////////////////////

  /**
   * Instancia un objeto RDE a partir de un SimpleXMLElement
   * 
   * @param  mixed $node
   * 
   * @return self
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node): self
  {
    if(strcmp($node->getName(), 'rDE') != 0)
      throw new \Exception('[RDE] Invalid XML Node Name: ' . $node->getName());
    $res = new RDE();
    if(isset($node->dVerFor))
      $res->setDVerFor(intval($node->dVerFor));
    if(isset($node->DE))
      $res->setDE(DE::FromSimpleXMLElement($node->DE));
    if(isset($node->Signature))
      $res->setSignature(Signature::FromSimpleXMLElement($node->Signature));
    if(isset($node->gCamFuFD))
      $res->setGCamFuFD(GCamFuFD::FromSimpleXMLElement($node->gCamFuFD));
    return $res;
  }

  /**
   * Instancia un objeto RDE a partir de objeto tipo stdClass recibido como respuesta a una llamada SOAP al SIFEN.
   *
   * @param stdClass $object
   * 
   * @return self
   */
  public static function FromSifenResponseObject($object) : self
  {
    $res = new RDE();
    if(isset($object->DE))
    {
      $res->setDE(DE::FromSifenResponseObject($object->DE));
    }
 
    if(isset($object->gCamFuFD))
    {
      $res->setGCamFuFD(GCamFuFD::FromSifenResponseObject($object->gCamFuFD));
    }
    return $res;
  }   

  ///////////////////////////////////////////////////////////////////////
  // Conversores
  ///////////////////////////////////////////////////////////////////////

  /**
   * Convertir el objeto RDE a un DOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    // Validaciones
    if(!isset($this->dVerFor))
      throw new \Exception('[RDE] El campo dVerFor no puede ser nulo.');
    if(!isset($this->DE))
      throw new \Exception('[RDE] El campo DE no puede ser nulo.');
    if(!isset($this->gCamFuFD))
      throw new \Exception('[RDE] El campo gCamFuFD no puede ser nulo.');

    // Conversión
    $doc = new \DOMDocument();
    $res = $doc->createElement('rDE');
    $res->appendChild(new DOMElement('dVerFor', $this->getDVerFor()));
    $res->appendChild($this->DE->toDOMElement());
    $res->appendChild($this->gCamFuFD->toDOMElement());
    return $res;
  }

  /**
   * Convierte el objeto RDE a un String XML
   *
   * @return String
   */
  public function toXMLString(): String
  {
    $domElement = $this->toDOMElement();
    $xmlString = $domElement->ownerDocument->saveXML($domElement);
    if(!$xmlString)
      throw new \Exception('[RDE] Error al convertir el objeto a XML.');
    return $xmlString;
  }
  
}
