<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\E;

use DOMElement;

/**
 * Campos que describen la condición de la operación (E600-E699)
 * ID:E600 Campos que describen la condición de la operación PADRE:E001 
 */
class GCamCond
{
  public ?int $iCondOpe = null; ///E601 iCondOpe Condición de la operación
  public ?GPaConEIni $gPaConEIni = null;
  public ?GPagCred $gPagCred = null;

  ///////////////////////////////////////////////////////////////////////
  ///Setters
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
  public function getDDCondOpe(): string | null
  {
    switch ($this->iCondOpe) {
      case 1:
        return "Contado";
        break;

      case 2:
        return "Crédito";
        break;

      default:
        return null;
        break;
    }
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML Element  
  ///////////////////////////////////////////////////////////////////////

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

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return GCAMCond
  //  */
  // public static function fromDOMElement(DOMElement $xml): GCamCond
  // {
  //   if (strcmp($xml->tagName, 'gCamCond') == 0 && $xml->childElementCount == 3) {
  //     $res = new GCamCond();
  //     $res->setICondOpe(intval($xml->getElementsByTagName('iCondOpe')->item(0)->nodeValue));
  //     ///children
  //     $res->setGPaConEIni($res->gPaConEIni->fromDOMElement($xml->getElementsByTagName('gPaConEIni')->item(0)->nodeValue));
  //     $res->setGPagCred($res->gPagCred->fromDOMElement($xml->getElementsByTagName('gPagCred')->item(0)->nodeValue));
  //     return $res;
  //   }
  // }

  ///////////////////////////////////////////////////////////////////////
  ///Others
  ///////////////////////////////////////////////////////////////////////

  /**
   * Get the value of gPaConEIni
   *
   * @return GPaConEIni
   */
  public function getGPaConEIni(): GPaConEIni | null
  {
    return $this->gPaConEIni;
  }

  /**
   * Set the value of gPaConEIni
   *
   * @param GPaConEIni $gPaConEIni
   *
   * @return self
   */
  public function setGPaConEIni(GPaConEIni $gPaConEIni): self
  {
    $this->gPaConEIni = $gPaConEIni;

    return $this;
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
