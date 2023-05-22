<?php

namespace Abiliomp\Pkuatia\Core\Fields\E;

use DOMElement;

/**
 * ID:E640  Campos que describen la operación a crédito Padre:E600
 */
class GPagCred
{
  public int $iCondCred; //E641  Condición de la  operación a crédito 
  public string $dPlazoCre; //E643  Plazo del crédito
  public int $dCuotas; //E644  Cantidad de cuotas
  public int $dMonEnt; //E645  Monto de la entrega inicial
  public GCuotas $gCuotas;

  //====================================================//
  //Setters
  //====================================================//

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

    return $this;
  }


  /**
   * Set the value of dPlazoCre
   *
   * @param string $dPlazoCre
   *
   * @return self
   */
  public function setDPlazoCre(string $dPlazoCre): self
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
    $this->dMonEnt = $dMonEnt;

    return $this;
  }

  //====================================================//
  //Getters
  //====================================================//

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
   * @return string
   */
  public function getDDCondCred(): string
  {
    switch ($this->iCondCred) {
      case 1:
        return "Plazo";
        break;
      case 2:
        return "Cuota";
        break;

      default:
        return null;
        break;
    }
  }

  /**
   * Get the value of dPlazoCre
   *
   * @return string
   */
  public function getDPlazoCre(): string
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

  //====================================================//
  ///XML Element
  //====================================================//

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
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return GPagCred
   */
  public static function fromDOMElement(DOMElement $xml): GPagCred
  {
    if (strcmp($xml->tagName, 'gPagCred') == 0 && $xml->childElementCount == 4) {
      $res = new GPagCred();
      $res->setICondCred(intval($xml->getElementsByTagName('iCondCred')->item(0)->nodeValue));
      $res->setDPlazoCre($xml->getElementsByTagName('dPlazoCre')->item(0)->nodeValue);
      $res->setDCuotas(intval($xml->getElementsByTagName('dCuotas')->item(0)->nodeValue));
      $res->setDMonEnt(intval($xml->getElementsByTagName('dMonEnt')->item(0)->nodeValue));
      //children
      $res->setGCuotas($res->gCuotas->fromDOMElement($xml->getElementsByTagName('gCuotas')));
      return $res;
    } else {
      throw new \Exception("Invalid XML Element: $xml->tagName");
      return null;
    }
  }

  //====================================================//
  //Cuotas
  //====================================================//

  /**
   * Get the value of gCuotas
   *
   * @return GCuotas
   */
  public function getGCuotas(): GCuotas
  {
    return $this->gCuotas;
  }

  /**
   * Set the value of gCuotas
   *
   * @param GCuotas $gCuotas
   *
   * @return self
   */
  public function setGCuotas(GCuotas $gCuotas): self
  {
    $this->gCuotas = $gCuotas;

    return $this;
  }
}
