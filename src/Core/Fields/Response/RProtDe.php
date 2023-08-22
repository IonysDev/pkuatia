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
  public String $id;         // PP02 - CDC del DE Procesado
  public DateTime $dFecProc; // PP03 - Fecha y hora del procesamiento 
  public String $dDigVal;    // PP04 - DigestValue del DE procesado
  public String $dEstRes;    // PP050 - Estado del resultado
  public String $dProtAut;   // PP051 - Número de Transacción
  public array  $gResProc;   // PP05 - Grupo Resultado de Procesamiento 

  ///////////////////////////////////////////////////////////////////////
  ///SETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of id
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
   * @param String $dDigVal
   *
   * @return self
   */
  public function setDDigVal(String $dDigVal): self
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
   * @return String
   */
  public function getId(): String
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
   * @return String
   */
  public function getDDigVal(): String
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
  public static function FromDOMElement(DOMElement $xml): RProtDe
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
   * Converts XML String representation to object
   * 
   * @param String $xml
   * @return RProtDe
   */
  public static function FromXMLString(String $xmlString): RProtDe
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
  public static function FromSimpleXMLElement(SimpleXMLElement $xml): RProtDe
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

  /**
   * Converts SimpleXMLElement to object
   * 
   * @param stdClass $node
   * 
   * @return RProtDe
   */
  public static function FromSifenResponseObject($node): RProtDe
  {
    $res = new RProtDe();
    if(isset($node->id))
      $res->setId($node->id);
    if(isset($node->dFecProc))
      $res->setDFecProc(DateTime::createFromFormat('Y-m-d\TH:i:sP', $node->dFecProc));
    if(isset($node->dDigVal))
      $res->setDDigVal($node->dDigVal);
    $res->setDEstRes($node->dEstRes);
    if(isset($node->dProtAut))
      $res->setDProtAut($node->dProtAut);
    $res->gResProc = [];
    if(isset($node->gResProc))
    {
      if(is_array($node->gResProc)) {
        foreach($node->gResProc as $gResProc) {
          $res->gResProc[] = GResProc::FromSifenResponseObject($gResProc);
        }
      }
      else {
        $res->gResProc[] = GResProc::FromSifenResponseObject($node->gResProc);
      }
    }    
    return $res;
  }



}
