<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use Abiliomp\Pkuatia\Core\Constants\PagCredCondCred;
use Abiliomp\Pkuatia\Utils\ValueValidations;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;
use Abiliomp\Pkuatia\Core\Fields\BaseSifenField;

/**
 * Nodo Id:     E640
 * Nombre:      gPagCred
 * Descripción: Campos que describen la operación a crédito 
 * Nodo Padre:  E600
 */

class GPagCred extends BaseSifenField
{

  public const CONDICION_CREDITO_PLAZO = 1;	
  public const CONDICION_CREDITO_CUOTA = 2;

  public int    $iCondCred;  // E641 - 1          - 1-1   - Condición de la  operación a crédito
  public String $dDCondCred; // E642 - 5-6        - 1-1   - Descripción de la Condición de la operación a crédito
  public String $dPlazoCre;  // E643 - 2-15       - 0-1   - Plazo del crédito
  public int    $dCuotas;    // E644 - 1-3        - 0-1   - Cantidad de cuotas
  public String $dMonEnt;    // E645 - 1-15p(0-4) - 0-1   - Monto de la entrega inicial (decimal BCMath)
  public array  $gCuotas;    // E650 -            - 0-999 - Campos que describen las cuotas (GCuotas)

  /**
   * Constructor
   */
  public function __construct()
  {
    $this->gCuotas = [];
  }

  ///////////////////////////////////////////////////////////////////////
  //Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de iCondCred (E641) que representa la condición de la operación a crédito.
   * A su vez establece el valor de dDCondCred (E642) que es la descripción de la condición de la operación a crédito.
   * 
   * @param int|PagCredCondCred $iCondCred Condición de la operación a crédito
   * 
   * @return self
   */
  public function setICondCred(int|PagCredCondCred $iCondCred): self
  {
    $this->iCondCred = $iCondCred instanceof PagCredCondCred ? $iCondCred->value : $iCondCred;
    $this->dDCondCred = PagCredCondCred::getDescripcion($this->iCondCred);
    return $this;
  }

  /**
   * Establece dDCondCred (E642) que es la descripción de la condición de la operación a crédito.
   * Esta función solo debería utilizarse para deserializar un DE existente.
   * 
   * @param String $dDCondCred Descripción de la condición de la operación a crédito.
   * 
   * @return self
   */
  public function setDDCondCred(String $dDCondCred): self
  {
    $this->dDCondCred = $dDCondCred;
    return $this;
  }

  /**
   * Establece el valor de dPlazoCre
   *
   * @param String $dPlazoCre
   *
   * @return self
   */
  public function setDPlazoCre(String $dPlazoCre): self
  {
    $this->dPlazoCre = $dPlazoCre;
    return $this;
  }

  /**
   * Establece el valor de dCuotas
   *
   * @param int $dCuotas
   *
   * @return self
   */
  public function setDCuotas(int $dCuotas): self
  {
    $this->dCuotas = $dCuotas;
    return $this;
  }

  /**
   * Establece el valor de dMonEnt
   *
   * @param int $dMonEnt
   *
   * @return self
   */
  public function setDMonEnt(int $dMonEnt): self
  {
    if(!ValueValidations::isValidStringDecimal($dMonEnt, 15, 0, 4))
    {
      throw new \Exception("Monto de la entrega inicial (dMonEnt) no válido: " . $dMonEnt, 1);
    }
    $this->dMonEnt = $dMonEnt;
    return $this;
  }

  /**
   * Establece el valor de gCuotas
   *
   * @param array $gCuotas
   *
   * @return self
   */
  public function setGCuotas(array $gCuotas): self
  {
    $this->gCuotas = $gCuotas;
    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  //Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de iCondCred
   *
   * @return int
   */
  public function getICondCred(): int
  {
    return $this->iCondCred;
  }

  /**
   * E642 Descripción de la Condición de la operación a crédito
   *
   * @return String
   */
  public function getDDCondCred(): String
  {
    return $this->dDCondCred;
  }

  /**
   * Obtiene el valor de dPlazoCre
   *
   * @return String
   */
  public function getDPlazoCre(): String
  {
    return $this->dPlazoCre;
  }

  /**
   * Obtiene el valor de dCuotas
   *
   * @return int
   */
  public function getDCuotas(): ?int
  {
    if(!isset($this->dMonEnt))
      return null;
    return $this->dCuotas;
  }

  /**
   * Obtiene el valor de dMonEnt
   *
   * @return int
   */
  public function getDMonEnt(): ?int
  {
    if(!isset($this->dMonEnt))
      return null;
    return $this->dMonEnt;
  } 

  /**
   * Obtiene el valor de gCuotas
   *
   * @return GCuotas
   */
  public function getGCuotas(): array
  {
    return $this->gCuotas;
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML Element
  ///////////////////////////////////////////////////////////////////////

  /**
   * Instancia un objeto GPagCred a partir de un SimpleXMLElement
   * 
   * @param SimpleXMLElement $node
   * 
   * @return self
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node): self
  {
    if(strcmp($node->getName(), 'gPagCred') != 0)
    {
      throw new \Exception("El nombre del nodo no corresponde a gPagCred: " . $node->getName(), 1);
    }
    $res = new self();
    $res->setICondCred(intval($node->iCondCred));
    $res->setDDCondCred(strval($node->dDCondCred));
    if(isset($node->dPlazoCre))
      $res->setDPlazoCre(strval($node->dPlazoCre));
    if(isset($node->dCuotas))
      $res->setDCuotas(intval($node->dCuotas));
    if(isset($node->dMonEnt))
    {
      $res->setDMonEnt(intval($node->dMonEnt));
    }
    if(isset($node->gCuotas) && count($node->gCuotas) > 0)
    {
      foreach ($node->gCuotas as $g) {
        $res->gCuotas[] = GCuotas::FromSimpleXMLElement($g);
      }
    }
    return $res;
  }

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gPagCred');
    $res->appendChild(new DOMElement('iCondCred', $this->getICondCred()));
    $res->appendChild(new DOMElement('dDCondCred', $this->getDDCondCred()));
    if ($this->iCondCred == 1) {
      $res->appendChild(new DOMElement('dPlazoCre', $this->getDPlazoCre()));
    } else if ($this->iCondCred == 2) {
      $res->appendChild(new DOMElement('dCuotas', $this->getDCuotas()));
    }
    if(isset($this->dMonEnt))
      $res->appendChild(new DOMElement('dMonEnt', $this->getDMonEnt()));
    ///children
    // $res->appendChild($this->gCuotas->toDOMElement());
    if(isset($this->gCuotas) && count($this->gCuotas) > 0)
    {
      foreach ($this->gCuotas as $g) {
        $res->appendChild($g->toDOMElement());
      }
    }
    return $res;
  }

    
  /**
   * FromSifenResponseObject
   *
   * @param  mixed $object
   * @return self
   */
  public static function FromSifenResponseObject($object):self
  {
    $res = new GPagCred();

    if(isset($object->iCondCred))
    {
      $res->setICondCred(intval($object->iCondCred));
    }

    if(isset($object->dPlazoCre))
    {
      $res->setDPlazoCre($object->dPlazoCre);
    }

    if(isset($object->dCuotas))
    {
      $res->setDCuotas(intval($object->dCuotas));
    }

    if(isset($object->dMonEnt))
    {
      $res->setDMonEnt(intval($object->dMonEnt));
    }
    //children
    if(isset($object->gCuotas))
    {
      //$res->setGCuotas(GCuotas::FromSifenResponseObject($object->gCuotas));
      foreach ($object->gCuotas as $g) {
        $res->gCuotas[] = GCuotas::FromSifenResponseObject($g);
      }
    }
    return $res;
  }

  /**
   * Instancia un objeto GPagCred a partir de un DOMElement que representa el nodo XML del objeto GPagCred.
   * 
   * @param DOMElement $node Nodo XML que representa el objeto GPagCred
   * 
   * @return self Objeto GPagCred instanciado
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    if(strcmp($node->nodeName, 'gPagCred') != 0)
      throw new \Exception('[GPagCred] Nodo con nombre inválido: ' . $node->nodeName);
    $res = new GPagCred();
    $res->setICondCred(intval($node->getElementsByTagName('iCondCred')->item(0)->nodeValue));
    $res->setDDCondCred(strval($node->getElementsByTagName('dDCondCred')->item(0)->nodeValue));
    if($node->getElementsByTagName('dPlazoCre')->length > 0)
      $res->setDPlazoCre(strval($node->getElementsByTagName('dPlazoCre')->item(0)->nodeValue));
    if($node->getElementsByTagName('dCuotas')->length > 0)
      $res->setDCuotas(intval($node->getElementsByTagName('dCuotas')->item(0)->nodeValue));
    if($node->getElementsByTagName('dMonEnt')->length > 0)
      $res->setDMonEnt(intval($node->getElementsByTagName('dMonEnt')->item(0)->nodeValue));
    if($node->getElementsByTagName('gCuotas')->length > 0) {
      $res->gCuotas = [];
      foreach ($node->getElementsByTagName('gCuotas') as $g) {
        $res->gCuotas[] = GCuotas::FromDOMElement($g);
      }
    }
    return $res;
  }
}
