<?php

namespace Abiliomp\Pkuatia\Core\Fields\Response;

use DOMElement;
use SimpleXMLElement;

/**
 * ID:PP05 Grupo Resultado de Procesamiento PADRE:PP01 
 */
class GResProc
{
                          // ID - DESC - LONG - OCURRENCIA
  public String $dCodRes; // PP052 - Código del resultado de procesamiento - 4 - 1-1
  public String $dMsgRes; // PP053 - Mensaje del resultado de procesamiento - 1-255 - 1-1

  ///////////////////////////////////////////////////////////////////////
  ///SETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of dCodRes
   *
   * @param int $dCodRes
   *
   * @return self
   */
  public function setDCodRes(String $dCodRes): self
  {
    $this->dCodRes = $dCodRes;

    return $this;
  }


  /**
   * Set the value of dMsgRes
   *
   * @param String $dMsgRes
   *
   * @return self
   */
  public function setDMsgRes(String $dMsgRes): self
  {
    $this->dMsgRes = $dMsgRes;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  //GETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Get the value of dCodRes
   *
   * @return int
   */
  public function getDCodRes(): String
  {
    return $this->dCodRes;
  }

  /**
   * Get the value of dMsgRes
   *
   * @return String
   */
  public function getDMsgRes(): String
  {
    return $this->dMsgRes;
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
    $res = new DOMElement('gResProc');
    if (isset($this->dCodRes)) {
      $res->appendChild(new DOMElement('dCodRes', $this->dCodRes));
    } else if (isset($this->dMsgRes)) {
      $res->appendChild(new DOMElement('dMsgRes', $this->dMsgRes));
    }

    return $res;
  }

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return TgResProc
  //  */
  // public static function fromDOMElement(DOMElement $xml): TgResProc
  // {
  //   if (strcmp($xml->tagName, 'gResProc') == 0 && $xml->childElementCount == 2) {
  //     $res = new TgResProc();
  //     $res->setDCodRes($xml->getElementsByTagName('dCodRes')->item(0)->nodeValue);
  //     $res->setDMsgRes($xml->getElementsByTagName('dMsgRes')->item(0)->nodeValue);
  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }

  /**
   * Converts SimpleXMLElement to object
   * 
   * @param SimpleXMLElement $xml
   * 
   * @return GResProc
   */
  public static function fromSimpleXMLElement(SimpleXMLElement $xml): GResProc
  {
    if(strcmp($xml->getName(),'gResProc') != 0) {
      throw new \Exception("Invalid XML Element: $xml->getName()");
      return null;
    }

    $res = new GResProc();
    $res->setDCodRes($xml->dCodRes);
    $res->setDMsgRes($xml->dMsgRes);
    return $res;
  }

  /**
   * Instancia un GResProc a partir de un objeto stdClass recibido como respuesta a una llamada SOAP al SIFEN.
   * 
   * @param stdClass $object
   * 
   * @return GResProc
   */
  public static function FromSifenResponseObject($object): GResProc
  {
    $res = new GResProc();
    $res->setDCodRes($object->dCodRes);
    $res->setDMsgRes($object->dMsgRes);
    return $res;
  }

}
