<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use Abiliomp\Pkuatia\Core\Fields\BaseSifenField;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * ID:E630 
 * Campos que describen el pago o entrega inicial de la operación con cheque
 * PADRE:E605
 */
class GPagCheq extends BaseSifenField
{
  public String $dNumCheq; //E631 Número de cheque  
  public String $dBcoEmi; //E632  Banco emisor

  ///////////////////////////////////////////////////////////////////////
  ///Settets
  ///////////////////////////////////////////////////////////////////////


  /**
   * Establece el valor de dNumCheq
   *
   * @param String $dNumCheq
   *
   * @return self
   */
  public function setDNumCheq(String $dNumCheq): self
  {
    $this->dNumCheq = $dNumCheq;

    return $this;
  }


  /**
   * Establece el valor de dBcoEmi
   *
   * @param String $dBcoEmi
   *
   * @return self
   */
  public function setDBcoEmi(String $dBcoEmi): self
  {
    $this->dBcoEmi = $dBcoEmi;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  //GETTERS
  ///////////////////////////////////////////////////////////////////////


  /**
   * Obtiene el valor de dNumCheq
   *
   * @return String
   */
  public function getDNumCheq(): String
  {
    return $this->dNumCheq;
  }

  /**
   * Obtiene el valor de dBcoEmi
   *
   * @return String
   */
  public function getDBcoEmi(): String
  {
    return $this->dBcoEmi;
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML Element
  ///////////////////////////////////////////////////////////////////////
  
  /**
   * Instancia un objeto GPagCheq a partir de un SimpleXMLElement
   * 
   * @param  SimpleXMLElement $xml
   * 
   * @return GPagCheq
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $xml): self
  {
    $res = new GPagCheq();
    $res->setDNumCheq($xml->dNumCheq);
    $res->setDBcoEmi($xml->dBcoEmi);
    return $res;
  }
  
  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gPagCheq');
    //Completar con 0 (cero) a la izquierda hasta alcanzar 8 (ocho) cifras
    $res->appendChild(new DOMElement('dNumCheq', str_pad($this->dNumCheq, 8, "0", STR_PAD_LEFT)));
    $res->appendChild(new DOMElement('dBcoEmi', $this->getDBcoEmi()));

    return $res;
  }
  
  /**
   * FromSifenResponseObject
   *
   * @param  mixed $object
   * @return self
   */
  public static function FromSifenResponseObject($object): self
  {
    $res = new GPagCheq();
    if(isset($object->dNumCheq))
    {
      $res->setDNumCheq($object->dNumCheq);
    }
    if(isset($object->dBcoEmi))
    {
      $res->setDBcoEmi($object->dBcoEmi);
    }
    return $res;
  }

  /**
   * Instancia un objeto GPagCheq a partir de un DOMElement que representa el nodo XML del objeto GPagCheq.
   * 
   * @param DOMElement $node Nodo XML que representa el objeto GPagCheq
   * 
   * @return self Objeto GPagCheq instanciado
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    if(strcmp($node->nodeName, 'gPagCheq') != 0)
      throw new \Exception("El nodo '" . $node->nodeName . "' no corresponde a gPagCheq", 1);
    $res = new GPagCheq();
    if($node->getElementsByTagName('dNumCheq')->length > 0)
      $res->setDNumCheq($node->getElementsByTagName('dNumCheq')->item(0)->nodeValue);
    if($node->getElementsByTagName('dBcoEmi')->length > 0)
      $res->setDBcoEmi($node->getElementsByTagName('dBcoEmi')->item(0)->nodeValue);
    return $res;
  }
}
