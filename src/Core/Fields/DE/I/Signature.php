<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\I;

use Abiliomp\Pkuatia\Core\Fields\Signature\KeyInfo;
use Abiliomp\Pkuatia\Core\Fields\Signature\SignedInfo;


/**
 * ID I001 - Firma Digital del DTE  PADRE:AA001
 */
class Signature
{
  public SignedInfo $SignedInfo;
  public String $SignatureValue;
  public KeyInfo $KeyInfo;
  
  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece la información de la firma
   *
   * @param SignedInfo $SignedInfo
   *
   * @return self
   */
  public function setSignedInfo(SignedInfo $SignedInfo): self
  {
      $this->SignedInfo = $SignedInfo;
      return $this;
  }

  /**
   * Establece el valor de la firma
   *
   * @param String $SignatureValue
   *
   * @return self
   */
  public function setSignatureValue(String $SignatureValue): self
  {
      $this->SignatureValue = $SignatureValue;
      return $this;
  }

  /**
   * Establece los datos de la llave X509
   *
   * @param KeyInfo $KeyInfo
   *
   * @return self
   */
  public function setKeyInfo(KeyInfo $KeyInfo): self
  {
      $this->KeyInfo = $KeyInfo;
      return $this;
  }

  
  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Devuelve la información de la firma
   *
   * @return SignedInfo
   */
  public function getSignedInfo(): SignedInfo
  {
      return $this->SignedInfo;
  }

  /**
   * Devuelve el valor de la firma
   *
   * @return String
   */
  public function getSignatureValue(): String
  {
      return $this->SignatureValue;
  }

  /**
   * Devuelve los datos de la llave X509
   *
   * @return KeyInfo
   */
  public function getKeyInfo(): KeyInfo
  {
      return $this->KeyInfo;
  }

  ///////////////////////////////////////////////////////////////////////
  // Instanciadores
  ///////////////////////////////////////////////////////////////////////

  /**
   * Instancia un objeto Signature a partir de un SimpleXMLElement
   * 
   * @param \SimpleXMLElement $node
   * 
   * @return self
   */
  public static function FromSimpleXMLElement(\SimpleXMLElement $node): self
  {
    if(strcmp($node->getName(), 'Signature') != 0)
      throw new \Exception("[Signature] Invalid XML Node Name: " . $node->getName());
    $res = new Signature();
    $res->setSignedInfo(SignedInfo::FromSimpleXMLElement($node->SignedInfo));
    $res->setSignatureValue($node->SignatureValue);
    $res->setKeyInfo(KeyInfo::FromSimpleXMLElement($node->KeyInfo));
    return $res;
  }
}
