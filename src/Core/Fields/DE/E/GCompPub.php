<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use DateTime;
use DOMElement;
use SimpleXMLElement;


/**
 * Nodo Id: E020
 * Descripción: Campos que describen las informaciones de compras públicas
 * Nodo Padre: E010 - gCamFE - Campos que componen la FE
 */

class GCompPub
{
  public String   $dModCont;   // E021 -  2 - 1-1 - Modalidad, Código emitido por la DNCP
  public int      $dEntCont;   // E022 -  5 - 1-1 - Entidad, Código emitido por la DNCP
  public int      $dAnoCont;   // E023 -  2 - 1-1 - Año, Código emitido por la DNCP
  public int      $dSecCont;   // E024 -  7 - 1-1 - Secuencia, emitido por la DNCP
  public DateTime $dFeCodCont; // E025 - 10 - 1-1 - Fecha de emisión del código de contratación por la DNCP

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of dModCont
   *
   * @param String $dModCont
   *
   * @return self
   */
  public function setDModCont(String $dModCont): self
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
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Get the value of dModCont
   */
  public function getDModCont(): String
  {
    return $this->dModCont;
  }

  /**
   * Get the value of dEntCont
   */
  public function getDEntCont(): int
  {
    return $this->dEntCont;
  }

  /**
   * Get the value of dAnoCont
   */
  public function getDAnoCont(): int
  {
    return $this->dAnoCont;
  }

  /**
   * Get the value of dSecCont
   */
  public function getDSecCont(): int
  {
    return $this->dSecCont;
  }

  /**
   * Get the value of dFeCodCont
   */
  public function getDFeCodCont(): DateTime
  {
    return $this->dFeCodCont;
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML Element
  ///////////////////////////////////////////////////////////////////////
  
  /**
   * Instancia un objeto GCompPub a partir de un SimpleXMLElement
   * 
   * @param  SimpleXMLElement $node
   * 
   * @return GCompPub
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node): GCompPub
  {
    if(strcmp($node->getName(), 'gCompPub') != 0)
    {
      throw new \Exception("El nodo '" . $node->getName() . "' no corresponde a 'gCompPub'."); 
    }
    $res = new GCompPub();
    $res->setDModCont($node->dModCont);
    $res->setDEntCont(intval($node->dEntCont));
    $res->setDAnoCont(intval($node->dAnoCont));
    $res->setDSecCont(intval($node->dSecCont));
    $res->setDFeCodCont(DateTime::createFromFormat('Y-m-d', $node->dFeCodCont));
    return $res;
  }
  
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
   * FromSifenResponseObject
   *
   * @param  mixed $object
   * @return self
   */
  public static function FromSifenResponseObject($object):self
  {
    $res = new GCompPub();
    if(isset($object->dModCont))
    {
      $res->setDModCont($object->dModCont);
    }
    if(isset($object->dEntCont))
    {
      $res->setDEntCont($object->dEntCont);
    }
    if(isset($object->dAnoCont))
    {
      $res->setDAnoCont($object->dAnoCont);
    }
    if(isset($object->dSecCont))
    {
      $res->setDSecCont($object->dSecCont);
    }
    if(isset($object->dFeCodCont))
    {
      $res->setDFeCodCont(DateTime::createFromFormat('Y-m-d', $object->dFeCodCont));
    }
    
    return $res;
  }
}
