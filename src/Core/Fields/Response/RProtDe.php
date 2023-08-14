<?php

namespace Abiliomp\Pkuatia\Core\Fields\Response;

use DateTime;
use DOMElement;
use SimpleXMLElement;

/**
 * ID PP01: Protocolo  de procesamiento del DE
 */
class RProtDe
{
  public string $id;          // PP02 - CDC del DE Procesado
  public DateTime $dFecProc;  // PP03 - Fecha y hora del procesamiento 
  public string $dDigVal;     // PP04 - DigestValue del DE procesado
  public string $dEstRes;     // PP050 - Estado del resultado
  public string $dProtAut;    // PP051 - Número de Transacción
  public GResProc $gResProc; // PP05 - Grupo Resultado de Procesamiento 

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
  public function setGResProc(GResProc $gResProc): self
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
   * @return GResProc
   */
  public function getGResProc(): GResProc
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
   * @return RProtDe
   */
  public static function fromDOMElement(DOMElement $xml): RProtDe
  {
    if (strcmp($xml->tagName, 'rProtDe') == 0 && $xml->childElementCount == 6) {
      $res = new RProtDe();
      $res->setDFecProc(DateTime::createFromFormat('Y-m-d H:i:s', $xml->getElementsByTagName('dFecProc')->item(0)->nodeValue));
      $res->setDDigVal($xml->getElementsByTagName('dDigVal')->item(0)->nodeValue);
      $res->setDEstRes($xml->getElementsByTagName('dEstRes')->item(0)->nodeValue);
      $res->setDProtAut($xml->getElementsByTagName('dProtAut')->item(0)->nodeValue);

      $aux = new GResProc();
      $aux->fromDOMElement($xml->getElementsByTagName('gResProc')->item(0)->nodeValue);
      $res->setGResProc($aux);
      return $res;
    } else {
      throw new \Exception("Invalid XML Element: $xml->tagName");
      return null;
    }
  }

  /**
   * Converts XML string representation to object
   * 
   * @param string $xml
   * @return RProtDe
   */
  public static function fromXMLString(string $xmlString): RProtDe
  {
    $xml = simplexml_load_string($xmlString);
    $res = self::fromSimpleXMLElement($xml);
    return $res;
  }

  /**
   * Converts SimpleXMLElement to object
   * 
   * @param SimpleXMLElement $xml
   * 
   * @return RProtDe
   */
  public static function fromSimpleXMLElement(SimpleXMLElement $xml): RProtDe
  {
    if(strcmp($xml->getName(),'rProtDe') != 0) {
      throw new \Exception("Invalid XML Element: $xml->getName()");
      return null;
    }
    $res = new RProtDe();
    $res->setId($xml->id);
    $res->setDFecProc(DateTime::createFromFormat('Y-m-d H:i:s', $xml->dFecProc));
    $res->setDDigVal($xml->dDigVal);
    $res->setDEstRes($xml->dEstRes);
    $res->setDProtAut($xml->dProtAut);
    $res->gResProc = [];
    foreach($xml->gResProc as $gResProc) {
      $res->gResProc[] = GResProc::fromSimpleXMLElement($gResProc);
    }    
    return $res;
  }



}
