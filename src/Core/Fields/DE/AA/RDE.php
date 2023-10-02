<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\AA;

use Abiliomp\Pkuatia\Core\Constants;
use Abiliomp\Pkuatia\Core\Fields\DE\A\DE;
use Abiliomp\Pkuatia\Core\Fields\DE\I\Signature;
use Abiliomp\Pkuatia\Core\Fields\DE\J\GCamFuFD;
use DOMDocument;
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
   * Constructor de la clase RDE
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
   * Establece el valor de dVerFor (AA002) que es la versión del formato
   *
   * @param int $dVerFor Versión del formato
   *
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos.
   */
  public function setDVerFor(int $dVerFor): self
  {
    $this->dVerFor = $dVerFor;
    return $this;
  }

  /**
   * Establece el valor de DE (A001) que son los campos firmados del DE (Documento Electrónico)
   *
   * @param DE $DE Campos firmados del DE
   *
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos.
   */
  public function setDE(DE $DE): self
  {
    $this->DE = $DE;
    return $this;
  }

  /**
   * Establece el valor de Signature (I001) que es la firma digital del DTE
   *
   * @param Signature $Signature Firma Digital del DTE
   *
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos.
   */
  public function setSignature(Signature $Signature): self
  {
    $this->Signature = $Signature;
    return $this;
  }

  /**
   * Establece el valor de gCamFuFD (J001) que son los campos fuera de la firma digital
   *
   * @param GCamFuFD $gCamFuFD Campos fuera de la firma digital
   *
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos.
   */
  public function setGCamFuFD(GCamFuFD $gCamFuFD): self
  {
    $this->gCamFuFD = $gCamFuFD;
    return $this;
  }  

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Devuelve el valor de dVerFor (AA002) que es la versión del formato
   *
   * @return int Versión del formato
   */
  public function getDVerFor(): int
  {
    return $this->dVerFor;
  }

  /**
   * Devuelve el valor de DE (A001) que son los campos firmados del DE (Documento Electrónico)
   *
   * @return DE Campos firmados del DE
   */
  public function getDE(): DE
  {
    return $this->DE;
  }

  /**
   * Devuelve el valor de Signature (I001) que es la firma digital del DTE
   *
   * @return Signature Firma Digital del DTE
   */
  public function getSignature(): Signature
  {
    return $this->Signature;
  }

  /**
   * Devuelve el valor de gCamFuFD (J001) que son los campos fuera de la firma digital
   *
   * @return GCamFuFD Campos fuera de la firma digital
   */
  public function getGCamFuFD() : ?GCamFuFD
  {
    if(!isset($this->gCamFuFD))
      return null;
    return $this->gCamFuFD;
  }  

  ///////////////////////////////////////////////////////////////////////
  // Instanciadores
  ///////////////////////////////////////////////////////////////////////

  /**
   * Instancia un objeto RDE a partir de un SimpleXMLElement
   *
   * @param  mixed $node Nodo XML que representa el objeto RDE
   *
   * @return self Objeto RDE instanciado
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
   * Instancia un objeto RDE a partir de un DOMElement que representa el nodo XML del objeto RDE
   * 
   * @param DOMElement $node Nodo XML que representa el objeto RDE
   * 
   * @return self Objeto RDE instanciado
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    if(strcmp($node->nodeName, 'rDE') != 0)
      throw new \Exception('[RDE] Nodo con nombre inválido: ' . $node->nodeName);
    $res = new RDE();
    if($node->getElementsByTagName('dVerFor')->length > 0)
      $res->setDVerFor(intval($node->getElementsByTagName('dVerFor')->item(0)->nodeValue));
    if($node->getElementsByTagName('DE')->length > 0)
      $res->setDE(DE::FromDOMElement($node->getElementsByTagName('DE')->item(0)));
    if($node->getElementsByTagName('Signature')->length > 0)
      $res->setSignature(Signature::FromDOMElement($node->getElementsByTagName('Signature')->item(0)));
    if($node->getElementsByTagName('gCamFuFD')->length > 0)
      $res->setGCamFuFD(GCamFuFD::FromDOMElement($node->getElementsByTagName('gCamFuFD')->item(0)));
    return $res;
  }

  /**
   * Instancia un objeto RDE a partir de objeto tipo stdClass recibido como respuesta a una llamada SOAP al SIFEN.
   *
   * @param stdClass $object Objeto stdClass que representa el objeto RDE
   *
   * @return self Objeto RDE instanciado
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
   * @param DOMDocument $doc Objeto DOMDocument que representa el documento XML.
   *
   * @return DOMElement Objeto DOMElement que representa el objeto RDE
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    // Validaciones
    if(!isset($this->dVerFor))
      throw new \Exception('[RDE] El campo dVerFor no puede ser nulo.');
    if(!isset($this->DE))
      throw new \Exception('[RDE] El campo DE no puede ser nulo.');

    // Conversión
    $res = $doc->createElement('rDE');
    $res->setAttribute('xmlns', Constants::SIFEN_NS_URI);
    $res->setAttribute('xmlns:xsi', Constants::SIFEN_NS_XSI);
    $res->setAttribute('xsi:schemaLocation', Constants::SIFEN_NS_URI_RECEP_DE);
    $res->appendChild(new DOMElement('dVerFor', $this->getDVerFor()));
    $res->appendChild($this->DE->toDOMElement($doc));
    return $res;
  }

  /**
   * Convierte este RDE a un DOMDocument
   * 
   * @return DOMDocument Objeto DOMDocument que representa el objeto RDE
   */
  public function toDOMDocument(): DOMDocument
  {
    $doc = new DOMDocument('1.0', 'UTF-8');
    $domElement = $this->toDOMElement($doc);
    $doc->appendChild($domElement);
    return $doc;
  }

  /**
   * Serializa el objeto RDE a un String XML
   *
   * @return String Objeto RDE serializado a XML
   */
  public function toXMLString(): String
  {
    $xmlString = $this->toDOMDocument()->saveXML();
    if(!$xmlString)
      throw new \Exception('[RDE] Error al convertir el objeto a XML.');
    return $xmlString;
  }
}
