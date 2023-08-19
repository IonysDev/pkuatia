<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\I;

/**
 * ID I001 - Firma Digital del DTE  PADRE:AA001
 */
class Signature
{
  public String $dSig; // I002 - Firma Digital del DTE
  
  /**
   * Get the value of dSig
   *
   * @return String
   */
  public function getDSig(): String
  {
    return $this->dSig;
  }

  /**
   * Set the value of dSig
   *
   * @param String $dSig
   *
   * @return self
   */
  public function setDSig(String $dSig): self
  {
    $this->dSig = $dSig;
    return $this;
  }

  /**
   * fromSimpleXMLElement
   */
  public static function FromSimpleXMLElement(\SimpleXMLElement $xml): self
  {
    if(strcmp($xml->getName(), 'Signature') != 0)
      throw new \Exception("[Signature] Invalid XML Node Name: " . $xml->getName());
    $res = new Signature();
    $res->setDSig((String)$xml->dSig);
    return $res;
  }
}
