<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\E;

use DateTime;
use DOMElement;


/**
 * Campos que describen las informaciones de compras públicas
 * ID: E020
 * PADRE: E010
 */
class GCompPub
{
  public ?string $dModCont  = null; //Modalidad - Código emitido por la DNCP ID:E021 PADRE:E020
  public ?int $dEntCont  = null; //Entidad - Código emitido por la DNC ID:E022 PADRE:E020
  public ?int $dAnoCont  = null; //Año - Código emitido por la DNCP ID:E023 PADRE:E020
  public ?int $dSecCont  = null; //Secuencia - emitido por la DNCP ID:E024 PADRE:E020
  public ?DateTime $dFeCodCont  = null; //Fecha de emisión del código de contratación por la DNCP ID:E025 PADRE:E020

  ///////////////////////////////////////////////////////////////////////
  ///Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of dModCont
   *
   * @param string $dModCont
   *
   * @return self
   */
  public function setDModCont(string $dModCont): self
  {
    $this->dModCont = $dModCont;

    return $this;
  }


  /**
   * Set the value of dEntCont
   *
   * @param int $dEntCont
   *
   * @return self
   */
  public function setDEntCont(int $dEntCont): self
  {
    $this->dEntCont = $dEntCont;

    return $this;
  }


  /**
   * Set the value of dAnoCont
   *
   * @param int $dAnoCont
   *
   * @return self
   */
  public function setDAnoCont(int $dAnoCont): self
  {
    $this->dAnoCont = $dAnoCont;

    return $this;
  }


  /**
   * Set the value of dSecCont
   *
   * @param int $dSecCont
   *
   * @return self
   */
  public function setDSecCont(int $dSecCont): self
  {
    $this->dSecCont = $dSecCont;

    return $this;
  }


  /**
   * Set the value of dFeCodCont
   *
   * @param DateTime $dFeCodCont
   *
   * @return self
   */
  public function setDFeCodCont(DateTime $dFeCodCont): self
  {
    $this->dFeCodCont = $dFeCodCont;

    return $this;
  }


  ///////////////////////////////////////////////////////////////////////
  ///Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Get the value of dModCont
   */
  public function getDModCont(): string | null
  {
    return $this->dModCont;
  }

  /**
   * Get the value of dEntCont
   */
  public function getDEntCont(): int | null
  {
    return $this->dEntCont;
  }

  /**
   * Get the value of dAnoCont
   */
  public function getDAnoCont(): int | null
  {
    return $this->dAnoCont;
  }

  /**
   * Get the value of dSecCont
   */
  public function getDSecCont(): int | null
  {
    return $this->dSecCont;
  }

  /**
   * Get the value of dFeCodCont
   */
  public function getDFeCodCont(): DateTime | null
  {
    return $this->dFeCodCont;
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
    $res = new DOMElement('gCompPub');
    $res->appendChild(new DOMElement('dModCont', $this->dModCont));
    $res->appendChild(new DOMElement('dEntCont', $this->dEntCont));
    $res->appendChild(new DOMElement('dAnoCont', $this->dAnoCont));
    $res->appendChild(new DOMElement('dSecCont', $this->dSecCont));
    $res->appendChild(new DOMElement('dFeCodCont', $this->dFeCodCont->format('Y-m-d')));
    return $res;
  }

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return GCompPub
  //  */
  // public static function fromDOMElement(DOMElement $xml): GCompPub
  // {
  //   if (strcmp($xml->tagName, 'gComPub') == 0 && $xml->childElementCount == 5) {
  //     $res = new GCompPub();
  //     $res->setDModCont($xml->getElementsByTagName('gComPub')->item(0)->nodeValue);
  //     $res->setDEntCont(intval($xml->getElementsByTagName('dEntCont')->item(0)->nodeValue));
  //     $res->setDAnoCont(intval($xml->getElementsByTagName('dAnoCont')->item(0)->nodeValue));
  //     $res->setDSecCont(intval($xml->getElementsByTagName('dSecCont')->item(0)->nodeValue));
  //     $res->setDFeCodCont(DateTime::createFromFormat('Y-m-d', $xml->getElementsByTagName('dFeCodCont')->item(0)->nodeValue));
  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }
  
  /**
   * fromResponse
   *
   * @param  mixed $response
   * @return self
   */
  public static function fromResponse($response):self
  {
    $res = new GCompPub();
    if(isset($response->dModCont))
    {
      $res->setDModCont($response->dModCont);
    }
    if(isset($response->dEntCont))
    {
      $res->setDEntCont($response->dEntCont);
    }
    if(isset($response->dAnoCont))
    {
      $res->setDAnoCont($response->dAnoCont);
    }
    if(isset($response->dSecCont))
    {
      $res->setDSecCont($response->dSecCont);
    }
    if(isset($response->dFeCodCont))
    {
      $res->setDFeCodCont(DateTime::createFromFormat('Y-m-d', $response->dFeCodCont));
    }
    
    return $res;
  }
}
