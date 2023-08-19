<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id:     E600
 * Nombre:      gCamCond
 * Descripción: Campos que describen la condición de la operación (E600-E699)
 * Nodo Padre:  E001 - gDtipDE - Campos específicos por tipo de Documento Electrónico
 */

class GCamCond
{
                                 // Id - Longitud - Ocurrencia - Descripción
  public int        $iCondOpe;   // E601 - 1 - 1-1   - Condición de la operación: 1-Contado | 2-Crédito
  public String     $dDCondOpe;  // E602 - 7 - 1-1   - Descripción de la condición de operación
  public array      $gPaConEIni; // E605 -   - 0-999 - Descripción de la condición de operación (GPaConEIni)
  public GPagCred   $gPagCred;   // E640 -   - 0-1   - Campos que describen las informaciones de pagos a crédito


  /**
   * Constructor
   */
  public function __construct()
  {
    $this->gPaConEIni = [];
  }

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of iCondOpe
   *
   * @param int $iCondOpe
   *
   * @return self
   */
  public function setICondOpe(int $iCondOpe): self
  {
    $this->iCondOpe = $iCondOpe;
    switch ($this->iCondOpe) {
      case 1:
        $this->dDCondOpe = "Contado";
        break;

      case 2:
        $this->dDCondOpe = "Crédito";
        break;
      default:
        throw new \Exception("Condición de operación (iCondOpe) no válida: " . $iCondOpe, 1);
        break;
    }
    return $this;
  }

  /**
   * Establece el valor dDCondOpe que es la descripción de la condición de operación
   * 
   * @param string $dDCondOpe
   * 
   * @return self
   */
  public function setDDCondOpe(string $dDCondOpe): self
  {
    $this->dDCondOpe = $dDCondOpe;
    return $this;
  }

  /**
   * Set the value of gPaConEIni
   *
   * @param array $gPaConEIni
   *
   * @return self
   */
  public function setGPaConEIni(array $gPaConEIni): self
  {
    $this->gPaConEIni = $gPaConEIni;

    return $this;
  }

  /**
   * Set the value of gPagCred
   *
   * @param GPagCred $gPagCred
   *
   * @return self
   */
  public function setGPagCred(GPagCred $gPagCred): self
  {
    $this->gPagCred = $gPagCred;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  ///Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Get the value of iCondOpe
   *
   * @return int
   */
  public function getICondOpe(): int | null
  {
    return $this->iCondOpe;
  }

  /**
   * E602  Descripción de la condición de operación
   *
   * @return string
   */
  public function getDDCondOpe(): String
  {
    return $this->dDCondOpe;
  }

  /**
   * Get the value of gPaConEIni
   *
   * @return array
   */
  public function getGPaConEIni(): array | null
  {
    return $this->gPaConEIni;
  }

  /**
   * Get the value of gPagCred
   *
   * @return GPagCred
   */
  public function getGPagCred(): GPagCred | null
  {
    return $this->gPagCred;
  }

  ///////////////////////////////////////////////////////////////////////
  // XML Element  
  ///////////////////////////////////////////////////////////////////////

  /**
   * Instancia un objeto del tipo GCamCond a partir de un SimpleXMLElement
   * 
   * @param SimpleXMLElement $node
   * 
   * @return self
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node): self
  {
    if(strcmp($node->getName(), 'gCamCond') != 0){
      throw new \Exception("El nodo '" . $node->getName() . "' no corresponde a gCamCond", 1);
    }
    $res = new self();
    $res->setICondOpe(intval($node->iCondOpe));
    $res->setDDCondOpe(strval($node->dDCondOpe));
    if(isset($node->gPaConEIni) && count($node->gPaConEIni) > 0){
      foreach ($node->gPaConEIni as $g) {
        $res->gPaConEIni[] = GPaConEIni::FromSimpleXMLElement($g);
      }
    }
    if(isset($node->gPagCred)){
      $res->setGPagCred(GPagCred::FromSimpleXMLElement($node->gPagCred));
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
    $res = new DOMElement('gCamCond');

    $res->appendChild(new DOMElement('iCondOpe', $this->getICondOpe()));
    $res->appendChild(new DOMElement('dDCondOpe', $this->getDDCondOpe()));

    ///Children
    $res->appendChild($this->getGPaConEIni()->toDOMElement());
    $res->appendChild($this->gPagCred->toDOMElement());
    return $res;
  }

  ///////////////////////////////////////////////////////////////////////
  // Others
  ///////////////////////////////////////////////////////////////////////

  /**
   * fromResponse
   *
   * @param  mixed $response
   * @return self
   */
  public static function fromResponse($response): self
  {
    $res = new self();
    if (isset($response->iCondOpe)) {
      $res->setICondOpe(intval($response->iCondOpe));
    }
    ///children
    if (isset($response->gPaConEIni)) {
      $res->setGPaConEIni(GPaConEIni::fromResponse($response->gPaConEIni));
    }
    ///children
    if (isset($response->gPagCred)) {
      $res->setGPagCred(GPagCred::fromResponse($response->gPagCred));
    }
    return $res;
  }
}
