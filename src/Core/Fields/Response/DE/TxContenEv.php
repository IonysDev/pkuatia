<?php

namespace IonysDev\Pkuatia\Core\Fields\Response\DE;

use DOMElement;
use IonysDev\Pkuatia\Core\Exceptions\PkuatiaException;
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
   *
   * @deprecated 0.3.1 Nunca funcionó: llamaba a RContEv::toDOMElement(), que no existe (hasta 0.3.0 terminaba en
   *             `Error: Call to undefined method`), y el XSD no define un elemento TxContenEv. Para los eventos de una
   *             consulta de DE usar RContDe::FromXContenDE() y RContDe::getRContEvs(). Lanza PkuatiaException.
   */
  public function toDOMElement(): DOMElement
  {
    throw new PkuatiaException('[TxContenEv] toDOMElement() no está implementado: TxContenEv no es un elemento del XSD. '
      . 'Para los eventos de una consulta de DE usar RContDe::FromXContenDE() y RContDe::getRContEvs().');
  }

  /**
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return TxContenEv
   *
   * @deprecated 0.2.1 Nunca funcionó: espera un elemento contentEv, que no existe en el XSD, y llama a
   *             RContEv::fromDOMElement(), que está comentado (PK-43). Para los eventos de una consulta de DE usar
   *             RContDe::FromXContenDE() y RContDe::getRContEvs(). Desde 0.3.1 lanza PkuatiaException en vez de
   *             `Error: Call to undefined method` cuando recibe un contentEv (Fase D, D1).
   */
  public static function fromDOMElement(DOMElement $xml): TxContenEv
  {
    if (strcmp($xml->tagName, 'contentEv') == 0 && $xml->childElementCount == 1) {
      throw new PkuatiaException('[TxContenEv] fromDOMElement() no está implementado: RContEv no se lee desde DOM. '
        . 'Para los eventos de una consulta de DE usar RContDe::FromXContenDE() y RContDe::getRContEvs().');
    } else {
      throw new RespuestaException("Invalid XML Element: $xml->tagName");
    }
  }
  

  
}
