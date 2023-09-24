<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use Abiliomp\Pkuatia\Utils\ValueValidations;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id:     E640
 * Nombre:      gPagCred
 * Descripción: Campos que describen la operación a crédito 
 * Nodo Padre:  E600
 */

class GPagCred
{
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
   * Set the value of iCondCred
   *
   * @param int $iCondCred
   *
   * @return self
   */
  public function setICondCred(int $iCondCred): self
  {
    $this->iCondCred = $iCondCred;
    switch ($this->iCondCred) {
      case 1:
        $this->dDCondCred = "Plazo";
        break;
      case 2:
        $this->dDCondCred = "Cuota";
        break;
      default:
        throw new \Exception("Condición de crédito (iCondCred) no válida: " . $iCondCred, 1);
        break;
    }
    return $this;
  }

  /**
   * Establece la descripción de la condición de la operación a crédito
   * 
   * @param String $dDCondCred
   * 
   * @return self
   */
  public function setDDCondCred(String $dDCondCred): self
  {
    $this->dDCondCred = $dDCondCred;
    return $this;
  }

  /**
   * Set the value of dPlazoCre
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
   * Set the value of dCuotas
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
   * Set the value of dMonEnt
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
   * Set the value of gCuotas
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
   * Get the value of iCondCred
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
   * Get the value of dPlazoCre
   *
   * @return String
   */
  public function getDPlazoCre(): String
  {
    return $this->dPlazoCre;
  }

  /**
   * Get the value of dCuotas
   *
   * @return int
   */
  public function getDCuotas(): int
  {
    return $this->dCuotas;
  }

  /**
   * Get the value of dMonEnt
   *
   * @return int
   */
  public function getDMonEnt(): int
  {
    return $this->dMonEnt;
  } 

  /**
   * Get the value of gCuotas
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
    {
      $res->setDPlazoCre(strval($node->dPlazoCre));
    }
    if(isset($node->dCuotas))
    {
      $res->setDCuotas(intval($node->dCuotas));
    }
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
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('gPagCred');

    $res->appendChild(new DOMElement('iCondCred', $this->getICondCred()));
    $res->appendChild(new DOMElement('dDCondCred', $this->getICondCred()));

    if ($this->iCondCred == 1) {
      $res->appendChild(new DOMElement('dPlazoCre', $this->getDPlazoCre()));
    } else if ($this->iCondCred == 2) {
      $res->appendChild(new DOMElement('dCuotas', $this->getDCuotas()));
    }

    $res->appendChild(new DOMElement('dMonEnt', $this->getDMonEnt()));
    ///children
    $res->appendChild($this->gCuotas->toDOMElement());

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
      $res->setGCuotas(GCuotas::FromSifenResponseObject($object->gCuotas));
    }
    return $res;
  }
}
