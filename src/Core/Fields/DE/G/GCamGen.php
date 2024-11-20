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
  public String   $dOrdCompra; // G002 - 1-15 - 0-1 - Número de orden de compra
  public String   $dOrdVta;    // G003 - 1-15 - 0-1 - Número de orden de venta 
  public String   $dAsiento;   // G004 - 1-10 - 0-1 - Número de asiento contable
  public GCamCarg $gCamCarg;   // G050 -      - 0-1 - Campos generales de la carga

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
  public function setDOrdCompra(String $dOrdCompra): self
  {
    if(isset($dOrdCompra) && strlen($dOrdCompra) > 0)
    {
      $this->dOrdCompra = substr($dOrdCompra, 0, 15);
    }
    return $this;
  }


  /**
   * Establece el valor de dOrdVta
   *
   * @param String $dOrdVta
   *
   * @return self
   */
  public function setDOrdVta(String $dOrdVta): self
  {
    if(is_null($dOrdVta) || strlen($dOrdVta) == 0)
    {
      $this->dOrdVta;
    }
    else
    {
      $this->dOrdVta = substr($dOrdVta, 0, 15);
    }
    return $this;
  }


  /**
   * Establece el valor de dAsiento
   *
   * @param String $dAsiento
   *
   * @return self
   */
  public function setDAsiento(String $dAsiento): self
  {
    if(is_null($dAsiento) || strlen($dAsiento) == 0)
    {
      $this->dAsiento;
    }
    else
    {
      $this->dAsiento = substr($dAsiento, 0, 10);
    }
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
   * @return String
   */
  public function getDOrdCompra(): String
  {
    return $this->dOrdCompra;
  }

  /**
   * Obtiene el valor de dOrdVta
   *
   * @return String
   */
  public function getDOrdVta(): String
  {
    return $this->dOrdVta;
  }

  /**
   * Obtiene el valor de dAsiento
   *
   * @return String
   */
  public function getDAsiento(): String
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
    $res->appendChild(new DOMElement('dOrdCompra', $this->getDOrdCompra()));
    $res->appendChild(new DOMElement('dOrdVta', $this->getDOrdVta()));
    $res->appendChild(new DOMElement('dAsiento', $this->getDAsiento()));
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
