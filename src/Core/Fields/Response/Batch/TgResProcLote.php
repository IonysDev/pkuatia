<?php

namespace Abiliomp\Pkuatia\Core\Fields\Response\Batch;

use Abiliomp\Pkuatia\Core\Fields\Response\TgResProc;
use DOMElement;

/**
 * ID:CRSch05 Grupo Resultado de Procesamiento del Lote PADRE:CRSch01
 */
class TgResProcLote
{
  public string $id;           // CRSch050 - CDC del DE
  public string $dEstRes;     // CRSch051 - Estado del resultado
  public string $dProtAut;   // CRSch052 - Número de transacción 
  public TgResProc $gResProc; // CRSch053 - Grupo Mensaje de Resultado

  ///////////////////////////////////////////////////////////////////////
  ///SETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of id
   *
   * @param string $id
   *
   * @return self
   */
  public function setId(string $id): self
  {
    $this->id = $id;

    return $this;
  }


  /**
   * Set the value of dEstRes
   *
   * @param string $dEstRes
   *
   * @return self
   */
  public function setDEstRes(string $dEstRes): self
  {
    $this->dEstRes = $dEstRes;

    return $this;
  }


  /**
   * Set the value of dProtAut
   *
   * @param string $dProtAut
   *
   * @return self
   */
  public function setDProtAut(string $dProtAut): self
  {
    $this->dProtAut = $dProtAut;

    return $this;
  }


  /**
   * Set the value of gResProc
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
   * Get the value of id
   *
   * @return string
   */
  public function getId(): string
  {
    return $this->id;
  }

  /**
   * Get the value of dEstRes
   *
   * @return string
   */
  public function getDEstRes(): string
  {
    return $this->dEstRes;
  }

  /**
   * Get the value of dProtAut
   *
   * @return string
   */
  public function getDProtAut(): string
  {
    return $this->dProtAut;
  }

  /**
   * Get the value of gResProc
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
