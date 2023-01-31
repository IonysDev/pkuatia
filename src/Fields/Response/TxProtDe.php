<?php

namespace Abiliomp\Pkuatia\Fields\Response;

use DateTime;
use DOMElement;

/**
 * ID:PP01 rProtDe Raíz
 */
class TxProtDe
{
  public string $id;          // PP02 - CDC del DE Procesado
  public DateTime $dFecProc;  // PP03 - Fecha y hora del procesamiento 
  public string $dDigVal;     // PP04 - DigestValue del DE procesado
  public String $dEstRes;     // PP050 - Estado del resultado
  public String $dProtAut;    // PP051 - Número de Transacción
  public TgResProc $gResProc; // PP05 - Grupo Resultado de Procesamiento 

  //====================================================//
  ///SETTERS
  //====================================================//

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
   * Set the value of dFecProc
   *
   * @param DateTime $dFecProc
   *
   * @return self
   */
  public function setDFecProc(DateTime $dFecProc): self
  {
    $this->dFecProc = $dFecProc;

    return $this;
  }


  /**
   * Set the value of dDigVal
   *
   * @param string $dDigVal
   *
   * @return self
   */
  public function setDDigVal(string $dDigVal): self
  {
    $this->dDigVal = $dDigVal;

    return $this;
  }


  /**
   * Set the value of dEstRes
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
   * Set the value of dProtAut
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

  //====================================================//
  //GETTERS
  //====================================================//


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
   * Get the value of dFecProc
   *
   * @return DateTime
   */
  public function getDFecProc(): DateTime
  {
    return $this->dFecProc;
  }

  /**
   * Get the value of dDigVal
   *
   * @return string
   */
  public function getDDigVal(): string
  {
    return $this->dDigVal;
  }

  /**
   * Get the value of dEstRes
   *
   * @return String
   */
  public function getDEstRes(): String
  {
    return $this->dEstRes;
  }

  /**
   * Get the value of dProtAut
   *
   * @return String
   */
  public function getDProtAut(): String
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

  //====================================================//
  ///XML ELEMENT
  //====================================================//

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('txProtDe');

    $res->appendChild(new DOMElement('dFecProc', $this->dFecProc->format('Y-m-d H:i:s')));
    $res->appendChild(new DOMElement('dDigVal', $this->dDigVal));
    $res->appendChild(new DOMElement('dEstRes', $this->dEstRes));
    $res->appendChild(new DOMElement('dProtAut', $this->dProtAut));
    $res->appendChild($this->gResProc->toDOMElement());
    return $res;
  }

  /**
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return TxProtDe
   */
  public static function fromDOMElement(DOMElement $xml): TxProtDe
  {
    if (strcmp($xml->tagName, 'rProtDe') == 0 && $xml->childElementCount == 6) {
      $res = new TxProtDe();
      $res->setDFecProc($xml->getElementsByTagName('dFecProc')->item(0)->nodeValue);
      $res->setDDigVal($xml->getElementsByTagName('dDigVal')->item(0)->nodeValue);
      $res->setDEstRes($xml->getElementsByTagName('dEstRes')->item(0)->nodeValue);
      $res->setDProtAut($xml->getElementsByTagName('dProtAut')->item(0)->nodeValue);

      $aux = new TgResProc();
      $aux->fromDOMElement($xml->getElementsByTagName('gResProc')->item(0)->nodeValue);
      $res->setGResProc($aux);
      return $res;
    } else {
      throw new \Exception("Invalid XML Element: $xml->tagName");
      return null;
    }
  }
}
