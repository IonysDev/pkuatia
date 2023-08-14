<?php

namespace Abiliomp\Pkuatia\Core\Fields\Response\De;

use DOMElement;

class TxContenEv
{
  public ?RContEv $rContEv = null;

  ///////////////////////////////////////////////////////////////////////
  ///SETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of rContEv
   *
   * @param RContEv $rContEv
   *
   * @return self
   */
  public function setRContEv(RContEv $rContEv): self
  {
    $this->rContEv = $rContEv;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  //GETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Get the value of rContEv
   *
   * @return RContEv
   */
  public function getRContEv(): RContEv
  {
    return $this->rContEv;
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML ELEMENT
  ///////////////////////////////////////////////////////////////////////  

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('TxContenEv');

    $res->appendChild($this->rContEv->toDOMElement());

    return $res;
  }

  /**
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return TxContenEv
   */
  public static function fromDOMElement(DOMElement $xml): TxContenEv
  {
    if (strcmp($xml->tagName, 'contentEv') == 0 && $xml->childElementCount == 1) {
      $res = new TxContenEv();

      $aux = new RContEv;
      $aux->fromDOMElement($xml->getElementsByTagName('rContEv')->item(0)->nodeValue);
      $res->setRContEv($aux);

      return $res;
    } else {
      throw new \Exception("Invalid XML Element: $xml->tagName");
      return null;
    }
  }
  

  
}
