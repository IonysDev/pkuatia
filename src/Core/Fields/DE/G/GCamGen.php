<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\G;

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
   * Set the value of dOrdCompra
   *
   * @param String $dOrdCompra
   *
   * @return self
   */
  public function setDOrdCompra(String $dOrdCompra): self
  {
    if(is_null($dOrdCompra) || strlen($dOrdCompra) == 0)
    {
      $this->dOrdCompra;
    }
    else
    {
      $this->dOrdCompra = substr($dOrdCompra, 0, 15);
    }
    return $this;
  }


  /**
   * Set the value of dOrdVta
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
   * Set the value of dAsiento
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
   * Get the value of dOrdCompra
   *
   * @return String
   */
  public function getDOrdCompra(): String
  {
    return $this->dOrdCompra;
  }

  /**
   * Get the value of dOrdVta
   *
   * @return String
   */
  public function getDOrdVta(): String
  {
    return $this->dOrdVta;
  }

  /**
   * Get the value of dAsiento
   *
   * @return String
   */
  public function getDAsiento(): String
  {
    return $this->dAsiento;
  }

  /**
   * Get the value of gCamCarg
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
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('gCamGen');
    $res->appendChild(new DOMElement('dOrdCompra', $this->getDOrdCompra()));
    $res->appendChild(new DOMElement('dOrdVta', $this->getDOrdVta()));
    $res->appendChild(new DOMElement('dAsiento', $this->getDAsiento()));
    //Children
    $res->appendChild($this->gCamCarg->toDOMElement());
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
}
