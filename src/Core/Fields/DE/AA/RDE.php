<?php

namespace IonysDev\Pkuatia\Core\Fields\DE\AA;

use IonysDev\Pkuatia\Core\Constants;
use IonysDev\Pkuatia\Core\Fields\BaseSifenField;
use IonysDev\Pkuatia\Core\Fields\DE\A\DE;
use IonysDev\Pkuatia\Core\Fields\DE\I\Signature;
use IonysDev\Pkuatia\Core\Fields\DE\J\GCamFuFD;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;
use stdClass;
use IonysDev\Pkuatia\Helpers\XmlHelper;

/**
 * Nodo Id:     AA001
 * Nombre:      rDE
 * Descripción: Campos que identifican el formato electrónico XML (AA001-AA009)
 * Nodo Padre:  Es nodo raiz.
 * Ocurrencia:  1-1 (obligatorio)
 */

class RDE extends BaseSifenField
{
                               // Id - Longitud - Ocurrencia - Descripción
  public int $dVerFor;         // AA002 - 3 - 1-1 - Versión del formato
  
  public DE $DE;               // A001  - G - 1-1 - Campos firmados del  DE
  public Signature $Signature; // I001  - G - 1-1 - Firma Digital del DTE
  public GCamFuFD $gCamFuFD;   // J001  - G - 1-1 - Campos fuera de la firma digital

  // PK-32 (0.2.1): un rDE leído de un XML firmado (FromSimpleXMLElement/FromDOMElement) guarda su Signature tal
  // como vino y toDOMElement() la reemite junto con gCamFuFD, para que la ida y vuelta sea exacta y la firma siga
  // verificando (SignedInfo se firma con sus espacios). Un rDE armado a mano se serializa como hasta 0.2.0.
  private ?String $signatureXml = null;
  private bool $leidoDeXml = false;

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
    // Una firma armada a mano no se reemite: la serialización de los objetos de firma no reproduce los espacios
    // de SignedInfo y no verificaría. Para reemitir una firma, leer el rDE con FromSimpleXMLElement/FromDOMElement.
    $this->signatureXml = null;
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
    if(isset($node->Signature)) {
      $res->setSignature(Signature::FromSimpleXMLElement($node->Signature));
      $res->signatureXml = $node->Signature->asXML();
    }
    if(isset($node->gCamFuFD))
      $res->setGCamFuFD(GCamFuFD::FromSimpleXMLElement($node->gCamFuFD));
    $res->leidoDeXml = true;
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
    if($node->getElementsByTagName('Signature')->length > 0) {
      $firma = $node->getElementsByTagName('Signature')->item(0);
      $res->setSignature(Signature::FromDOMElement($firma));
      $res->signatureXml = $firma->ownerDocument->saveXML($firma);
    }
    if($node->getElementsByTagName('gCamFuFD')->length > 0)
      $res->setGCamFuFD(GCamFuFD::FromDOMElement($node->getElementsByTagName('gCamFuFD')->item(0)));
    $res->leidoDeXml = true;
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
    $res->appendChild(XmlHelper::elemento($doc, 'dVerFor', $this->getDVerFor()));
    $res->appendChild($this->DE->toDOMElement($doc));
    // Orden de rDE: dVerFor, DE, Signature, gCamFuFD (DE_v150.xsd:1939-1960). Hasta 0.2.0 se perdían Signature y
    // gCamFuFD al re-serializar un rDE leído (PK-32). Ver $signatureXml.
    if($this->signatureXml !== null)
      $res->appendChild(self::copiarFirma($doc, $this->signatureXml));
    if($this->leidoDeXml && isset($this->gCamFuFD))
      $res->appendChild($this->gCamFuFD->toDOMElement($doc));
    return $res;
  }

  /**
   * Copia la Signature original en $doc con el mismo estilo que el resto del rDE: elementos sin espacio de nombres
   * y xmlns como atributo. Insertarla con su espacio de nombres real hace que libxml declare un prefijo "default"
   * en rDE, lo que cambia los bytes y contagia el prefijo a una firma nueva. Los nodos de texto (los espacios de
   * SignedInfo, que forman parte de lo firmado) se copian tal cual.
   */
  private static function copiarFirma(DOMDocument $doc, String $xml): DOMElement
  {
    $origen = new DOMDocument();
    $origen->loadXML($xml);
    return self::copiarNodo($doc, $origen->documentElement, null);
  }

  private static function copiarNodo(DOMDocument $doc, \DOMNode $nodo, ?String $nsPadre): \DOMNode
  {
    if(!$nodo instanceof DOMElement)
      return $doc->importNode($nodo, true);
    $copia = $doc->createElement($nodo->nodeName);
    if($nodo->namespaceURI !== null && $nodo->namespaceURI !== $nsPadre)
      $copia->setAttribute($nodo->prefix ? 'xmlns:' . $nodo->prefix : 'xmlns', $nodo->namespaceURI);
    foreach($nodo->attributes as $atributo)
      $copia->setAttribute($atributo->nodeName, $atributo->nodeValue);
    foreach($nodo->childNodes as $hijo)
      $copia->appendChild(self::copiarNodo($doc, $hijo, $nodo->namespaceURI));
    return $copia;
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
