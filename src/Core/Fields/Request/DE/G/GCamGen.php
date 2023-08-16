<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\G;

use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id: G001
 * Descripción: Campos de uso general
 * Nodo Padre: A001 - Campos firmados del DE 
 */

class GCamGen
{
  public String $dOrdCompra; // G002 - 1-15 - 0-1 - Número de orden de compra
  public String $dOrdVta;    // G003 - 1-15 - 0-1 - Número de orden de venta 
  public String $dAsiento;   // G004 - 1-10 - 0-1 - Número de asiento contable
  public GCamCarg $gCamCarg; // G050 -      - 0-1 - Campos generales de la carga

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of dOrdCompra
   *
   * @param string $dOrdCompra
   *
   * @return self
   */
  public function setDOrdCompra(String $dOrdCompra): self
  {
    if(is_null($dOrdCompra) || strlen($dOrdCompra) == 0)
    {
      $this->dOrdCompra = null;
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
   * @param string $dOrdVta
   *
   * @return self
   */
  public function setDOrdVta(string $dOrdVta): self
  {
    if(is_null($dOrdVta) || strlen($dOrdVta) == 0)
    {
      $this->dOrdVta = null;
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
   * @param string $dAsiento
   *
   * @return self
   */
  public function setDAsiento(string $dAsiento): self
  {
    if(is_null($dAsiento) || strlen($dAsiento) == 0)
    {
      $this->dAsiento = null;
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
   * @return string
   */
  public function getDOrdCompra(): String
  {
    return $this->dOrdCompra;
  }

  /**
   * Get the value of dOrdVta
   *
   * @return string
   */
  public function getDOrdVta(): String
  {
    return $this->dOrdVta;
  }

  /**
   * Get the value of dAsiento
   *
   * @return string
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
      throw new \Exception('El nombre del nodo no corresponde a gCamGen', 1);
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
   * fromResponse
   *
   * @param  mixed $response
   * @return self
   */
  public static function fromResponse($response): self
  {
    $res = new GCamGen();
    if(isset($response->dOrdCompra))
    {
      $res->setDOrdCompra($response->dOrdCompra);
    }
    if(isset($response->dOrdVta))
    {
      $res->setDOrdVta($response->dOrdVta);
    }
    if(isset($response->dAsiento))
    {
      $res->setDAsiento($response->dAsiento);
    }
    //CHOILDREN
    if (isset($response->gCamCarg)) {
      $res->setGCamCarg(GCamCarg::fromResponse($response->gCamCarg));
    }
    return $res;
  }
}
