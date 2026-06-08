<?php

namespace IonysDev\Pkuatia\Core\Fields\DE\G;

use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id: G001
 * Descripción: Campos de uso general
 * Nodo Padre: A001 - Campos firmados del DE 
 */

class GCamGen
{
  public ?String  $dOrdCompra = null; // G002 - 1-15 - 0-1 - Número de orden de compra
  public ?String  $dOrdVta    = null; // G003 - 1-15 - 0-1 - Número de orden de venta
  public ?String  $dAsiento   = null; // G004 - 1-10 - 0-1 - Número de asiento contable
  public GCamCarg $gCamCarg;          // G050 -      - 0-1 - Campos generales de la carga

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de dOrdCompra
   *
   * @param String $dOrdCompra
   *
   * @return self
   */
  public function setDOrdCompra(?String $dOrdCompra): self
  {
    $this->dOrdCompra = (is_null($dOrdCompra) || strlen($dOrdCompra) === 0)
      ? null
      : substr($dOrdCompra, 0, 15);
    return $this;
  }


  /**
   * Establece el valor de dOrdVta
   *
   * @param String|null $dOrdVta
   *
   * @return self
   */
  public function setDOrdVta(?String $dOrdVta): self
  {
    $this->dOrdVta = (is_null($dOrdVta) || strlen($dOrdVta) === 0)
      ? null
      : substr($dOrdVta, 0, 15);
    return $this;
  }


  /**
   * Establece el valor de dAsiento
   *
   * @param String|null $dAsiento
   *
   * @return self
   */
  public function setDAsiento(?String $dAsiento): self
  {
    $this->dAsiento = (is_null($dAsiento) || strlen($dAsiento) === 0)
      ? null
      : substr($dAsiento, 0, 10);
    return $this;
  }

  public function setGCamCarg(GCamCarg $gCamCarg): self
  {
    $this->gCamCarg = $gCamCarg;
    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de dOrdCompra
   *
   * @return String|null
   */
  public function getDOrdCompra(): ?String
  {
    return $this->dOrdCompra;
  }

  /**
   * Obtiene el valor de dOrdVta
   *
   * @return String|null
   */
  public function getDOrdVta(): ?String
  {
    return $this->dOrdVta;
  }

  /**
   * Obtiene el valor de dAsiento
   *
   * @return String|null
   */
  public function getDAsiento(): ?String
  {
    return $this->dAsiento;
  }

  /**
   * Obtiene el valor de gCamCarg
   *
   * @return GCamCarg
   */
  public function getGCamCarg(): GCamCarg
  {
    return $this->gCamCarg;
  }

  ///////////////////////////////////////////////////////////////////////
  // XML Element
  ///////////////////////////////////////////////////////////////////////

  /**
   * Instancia un objeto de esta clase a partir de un SimpleXMLElement
   * 
   * @param  SimpleXMLElement $node
   * 
   * @return self
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node): self
  {
    if(strcmp($node->getName(), 'gCamGen') != 0)
    {
      throw new \Exception('[GCamGen] El nombre del nodo no corresponde a gCamGen: ' . $node->getName(), 1);
    }
    $res = new GCamGen();
    if(isset($node->dOrdCompra))
    {
      $res->setDOrdCompra($node->dOrdCompra);
    }
    if(isset($node->dOrdVta))
    {
      $res->setDOrdVta($node->dOrdVta);
    }
    if(isset($node->dAsiento))
    {
      $res->setDAsiento($node->dAsiento);
    }
    if(isset($node->gCamCarg))
    {
      $res->setGCamCarg(GCamCarg::FromSimpleXMLElement($node->gCamCarg));
    }
    return $res;
  }

  /**
   * Convierte este GCamGen en un DOMElement perteneciente a un DOMDocument
   * 
   * @param  DOMDocument $doc Documento DOM en el que se generará el DOMElement, sin insertarlo
   *
   * @return DOMElement El DOMElement que representa a este GCamGen
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gCamGen');
    if(!is_null($this->dOrdCompra) && strlen($this->dOrdCompra) > 0)
      $res->appendChild(new DOMElement('dOrdCompra', $this->dOrdCompra));
    if(!is_null($this->dOrdVta) && strlen($this->dOrdVta) > 0)
      $res->appendChild(new DOMElement('dOrdVta', $this->dOrdVta));
    if(!is_null($this->dAsiento) && strlen($this->dAsiento) > 0)
      $res->appendChild(new DOMElement('dAsiento', $this->dAsiento));
    if(isset($this->gCamCarg))
      $res->appendChild($this->gCamCarg->toDOMElement($doc));
    return $res;
  }

  /**
   * FromSifenResponseObject
   *
   * @param  mixed $object
   * @return self
   */
  public static function FromSifenResponseObject($object): self
  {
    $res = new GCamGen();
    if(isset($object->dOrdCompra))
    {
      $res->setDOrdCompra($object->dOrdCompra);
    }
    if(isset($object->dOrdVta))
    {
      $res->setDOrdVta($object->dOrdVta);
    }
    if(isset($object->dAsiento))
    {
      $res->setDAsiento($object->dAsiento);
    }
    //CHOILDREN
    if (isset($object->gCamCarg)) {
      $res->setGCamCarg(GCamCarg::FromSifenResponseObject($object->gCamCarg));
    }
    return $res;
  }

  /**
   * Instancia un objeto GCamGen a partir de un DOMElement que representa el nodo XML del objeto.
   * 
   * @param DOMElement $node Nodo XML que representa el objeto.
   * 
   * @return self Objeto instanciado.
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    if(strcmp($node->nodeName, 'gCamGen') != 0)
      throw new \Exception('[GCamGen] El nombre del nodo no corresponde a gCamGen: ' . $node->nodeName, 1);
    $res = new GCamGen();
    if($node->getElementsByTagName('dOrdCompra')->length > 0)
      $res->setDOrdCompra($node->getElementsByTagName('dOrdCompra')->item(0)->nodeValue);
    if($node->getElementsByTagName('dOrdVta')->length > 0)
      $res->setDOrdVta($node->getElementsByTagName('dOrdVta')->item(0)->nodeValue);
    if($node->getElementsByTagName('dAsiento')->length > 0)
      $res->setDAsiento($node->getElementsByTagName('dAsiento')->item(0)->nodeValue);
    if($node->getElementsByTagName('gCamCarg')->length > 0)
      $res->setGCamCarg(GCamCarg::FromDOMElement($node->getElementsByTagName('gCamCarg')->item(0)));
    return $res;
  }
}
