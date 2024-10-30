<?php

namespace Abiliomp\Pkuatia\Core\Fields\Response\Batch;

use Abiliomp\Pkuatia\Core\Fields\Response\TgResProc;
use DOMElement;

/**
 * ID:CRSch05 Grupo Resultado de Procesamiento del Lote PADRE:CRSch01
 */
class TgResProcLote
{
  public String $id;           // CRSch050 - CDC del DE
  public String $dEstRes;     // CRSch051 - Estado del resultado
  public String $dProtAut;   // CRSch052 - Número de transacción 
  public TgResProc $gResProc; // CRSch053 - Grupo Mensaje de Resultado

  ///////////////////////////////////////////////////////////////////////
  ///SETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de id
   *
   * @param String $id
   *
   * @return self
   */
  public function setId(String $id): self
  {
    $this->id = $id;

    return $this;
  }


  /**
   * Establece el valor de dEstRes
   *
   * @param String $dEstRes
   *
   * @return self
   */
  public function setDEstRes(String $dEstRes): self
  {
    $this->dEstRes = $dEstRes;

    return $this;
  }


  /**
   * Establece el valor de dProtAut
   *
   * @param String $dProtAut
   *
   * @return self
   */
  public function setDProtAut(String $dProtAut): self
  {
    $this->dProtAut = $dProtAut;

    return $this;
  }


  /**
   * Establece el valor de gResProc
   *
   * @param TgResProc $gResProc
   *
   * @return self
   */
  public function setGResProc(TgResProc $gResProc): self
  {
    $this->gResProc = $gResProc;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  //GETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de id
   *
   * @return String
   */
  public function getId(): String
  {
    return $this->id;
  }

  /**
   * Obtiene el valor de dEstRes
   *
   * @return String
   */
  public function getDEstRes(): String
  {
    return $this->dEstRes;
  }

  /**
   * Obtiene el valor de dProtAut
   *
   * @return String
   */
  public function getDProtAut(): String
  {
    return $this->dProtAut;
  }

  /**
   * Obtiene el valor de gResProc
   *
   * @return TgResProc
   */
  public function getGResProc(): TgResProc
  {
    return $this->gResProc;
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
    $res = new DOMElement('tgResProcLote');

    $res->appendChild(new DOMElement('id', $this->getId()));
    $res->appendChild(new DOMElement('dEstRes', $this->getDEstRes()));
    $res->appendChild(new DOMElement('dProtAut', $this->getDProtAut()));
    $res->appendChild($this->gResProc->toDOMElement());
    return $res;
  }
  
  /**
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return TgResProcLote
   */
  public static function fromDOMElement(DOMElement $xml): TgResProcLote
  {
    if(strcmp($xml->tagName, 'tgResProcLote') == 0 && $xml->childElementCount == 4)
    {
      $res = new TgResProcLote();
      $res->setId($xml->getElementsByTagName('id')->item(0)->nodeValue);
      $res->setDEstRes($xml->getElementsByTagName('dEstRes')->item(0)->nodeValue);
      $res->setDProtAut($xml->getElementsByTagName('dProtAut')->item(0)->nodeValue);
      ///Children
      $res->setGResProc($res->gResProc->fromDOMElement($xml->getElementsByTagName('tgResProc')->item(0)->nodeValue));
      return $res;
    }
    else {
      throw new \Exception("Invalid XML Element: $xml->tagName");
      return null;
    }
  }
}
