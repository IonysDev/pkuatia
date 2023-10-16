<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use DOMDocument;
use DOMElement;
use SimpleXMLElement;
use Abiliomp\Pkuatia\Core\Fields\BaseSifenField;

/**
 * Nodo Id:     E600
 * Nombre:      gCamCond
 * Descripción: Campos que describen la condición de la operación (E600-E699)
 * Nodo Padre:  E001 - gDtipDE - Campos específicos por tipo de Documento Electrónico
 */

class GCamCond extends BaseSifenField
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
   * Establece el valor de iCondOpe
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
   * @param String $dDCondOpe
   * 
   * @return self
   */
  public function setDDCondOpe(String $dDCondOpe): self
  {
    $this->dDCondOpe = $dDCondOpe;
    return $this;
  }

  /**
   * Establece el valor de gPaConEIni
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
   * Establece el valor de gPagCred
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
   * Obtiene el valor de iCondOpe
   *
   * @return int
   */
  public function getICondOpe(): int
  {
    return $this->iCondOpe;
  }

  /**
   * E602  Descripción de la condición de operación
   *
   * @return String
   */
  public function getDDCondOpe(): String
  {
    return $this->dDCondOpe;
  }

  /**
   * Obtiene el valor de gPaConEIni
   *
   * @return array
   */
  public function getGPaConEIni(): array
  {
    return $this->gPaConEIni;
  }

  /**
   * Obtiene el valor de gPagCred
   *
   * @return GPagCred
   */
  public function getGPagCred(): GPagCred
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
   * Convierte este objeto GCamCond a un DOMElement insertable en el DOMDocument indicado.
   * 
   * @param DOMDocument $doc Documento DOM en el que se insertará el DOMElement
   *
   * @return DOMElement Objeto DOMElement que representa a este GCamCond
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gCamCond');
    if(isset($this->iCondOpe))
      $res->appendChild(new DOMElement('iCondOpe', $this->getICondOpe()));
    if(isset($this->dDCondOpe))
      $res->appendChild(new DOMElement('dDCondOpe', $this->getDDCondOpe()));
    if(isset($this->gPaConEIni) && count($this->getGPaConEIni()) > 0){
      foreach ($this->getGPaConEIni() as $g) {
        $res->appendChild($g->toDOMElement($doc));
      }
    }
    if(isset($this->gPagCred)) {
      $res->appendChild($this->gPagCred->toDOMElement($doc));
    }
    return $res;
  }

  ///////////////////////////////////////////////////////////////////////
  // Others
  ///////////////////////////////////////////////////////////////////////

  /**
   * FromSifenResponseObject
   *
   * @param  mixed $object
   * @return self
   */
  public static function FromSifenResponseObject($object): self
  {
    $res = new self();
    if (isset($object->iCondOpe)) {
      $res->setICondOpe(intval($object->iCondOpe));
    }
    if (isset($object->gPaConEIni) && count($object->gPaConEIni) > 0) {
      foreach ($object->gPaConEIni as $g) {
        $res->gPaConEIni[] = GPaConEIni::FromSifenResponseObject($g);
      }
    }
    if (isset($object->gPagCred)) {
      $res->setGPagCred(GPagCred::FromSifenResponseObject($object->gPagCred));
    }
    return $res;
  }

  /**
   * Instancia un objeto del tipo GCamCond a partir de un DOMElement que representa el nodo XML del objeto GCamCond.
   * 
   * @param DOMElement $node
   * 
   * @return self
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    if(strcmp($node->nodeName, 'gCamCond') != 0){
      throw new \Exception("El nodo '" . $node->nodeName . "' no corresponde a gCamCond", 1);
    }
    $res = new self();
    if($node->getElementsByTagName('iCondOpe')->length > 0){
      $res->setICondOpe(intval($node->getElementsByTagName('iCondOpe')->item(0)->nodeValue));
    }
    if($node->getElementsByTagName('dDCondOpe')->length > 0){
      $res->setDDCondOpe(strval($node->getElementsByTagName('dDCondOpe')->item(0)->nodeValue));
    }
    if($node->getElementsByTagName('gPaConEIni')->length > 0){
      foreach ($node->getElementsByTagName('gPaConEIni') as $g) {
        $res->gPaConEIni[] = GPaConEIni::FromDOMElement($g);
      }
    }
    if($node->getElementsByTagName('gPagCred')->length > 0){
      $res->setGPagCred(GPagCred::FromDOMElement($node->getElementsByTagName('gPagCred')->item(0)));
    }
    return $res;
  }
}
