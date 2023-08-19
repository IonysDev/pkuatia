<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use DOMElement;
use SimpleXMLElement;

/**
 * ID:E630 
 * Campos que describen el pago o entrega inicial de la operación con cheque
 * PADRE:E605
 */
class GPagCheq
{
  public ?string $dNumCheq = null; //E631 Número de cheque  
  public ?string $dBcoEmi = null; //E632  Banco emisor

  ///////////////////////////////////////////////////////////////////////
  ///Settets
  ///////////////////////////////////////////////////////////////////////


  /**
   * Set the value of dNumCheq
   *
   * @param string $dNumCheq
   *
   * @return self
   */
  public function setDNumCheq(string $dNumCheq): self
  {
    $this->dNumCheq = $dNumCheq;

    return $this;
  }


  /**
   * Set the value of dBcoEmi
   *
   * @param string $dBcoEmi
   *
   * @return self
   */
  public function setDBcoEmi(string $dBcoEmi): self
  {
    $this->dBcoEmi = $dBcoEmi;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  //GETTERS
  ///////////////////////////////////////////////////////////////////////


  /**
   * Get the value of dNumCheq
   *
   * @return string
   */
  public function getDNumCheq(): string | null
  {
    return $this->dNumCheq;
  }

  /**
   * Get the value of dBcoEmi
   *
   * @return string
   */
  public function getDBcoEmi(): string | null
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
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('gPagCheq');

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
}
