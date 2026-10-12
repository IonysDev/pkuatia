<?php

namespace IonysDev\Pkuatia\Core\Fields\Response\DE;

use DOMElement;
use IonysDev\Pkuatia\Core\Exceptions\RespuestaException;

class TxContenEv
{
  public ?RContEv $rContEv;

  ///////////////////////////////////////////////////////////////////////
  ///SETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de rContEv
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
   * Obtiene el valor de rContEv
   *
   * @return RContEv
   */
  public function getRContEv(): ?RContEv
  {
    return $this->rContEv ?? null;
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
   *
   * @deprecated 0.2.1 Nunca funcionó: espera un elemento contentEv, que no existe en el XSD, y llama a
   *             RContEv::fromDOMElement(), que está comentado (PK-43). Para los eventos de una consulta de DE usar
   *             RContDe::FromXContenDE() y RContDe::getRContEvs().
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
      throw new RespuestaException("Invalid XML Element: $xml->tagName");
    }
  }
  

  
}
