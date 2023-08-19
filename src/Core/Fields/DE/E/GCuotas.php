<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use Abiliomp\Pkuatia\DataMappings\MonedaMapping;
use Abiliomp\Pkuatia\Utils\ValueValidations;
use DateTime;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id:     E650 
 * Nombre:      gCuotas
 * Descripción: Campos que describen las cuotas
 * Nodo Padre:  E640
 */
class GCuotas
{
                              // Id - Longitud - Ocurrencia - Descripción
  public String   $cMoneCuo;  // E653 - 3          - 1-1 - Moneda de las cuotas
  public String   $dDMoneCuo; // E654 - 3-20       - 1-1 - Descripción de la moneda de las cuotas
  public String   $dMonCuota; // E651 - 1-15p(0-4) - 1-1 - Monto de cada cuota (decimal BCMath)
  public DateTime $dVencCuo;  // E652 - 10         - 0-1 - Fecha de vencimiento de cada cuota AAAA-MM-DD

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of cMoneCuo
   *
   * @param String $cMoneCuo
   *
   * @return self
   */
  public function setCMoneCuo(String $cMoneCuo): self
  {
    $this->cMoneCuo = $cMoneCuo;
    $this->dDMoneCuo = MonedaMapping::GetDescription($cMoneCuo);
    if($this->dDMoneCuo == null)
    {
      throw new \Exception("Moneda (cMoneCuo) no válida: " . $cMoneCuo, 1);
    }
    return $this;
  }

  /**
   * Establece la descripción de la moneda de las cuotas.
   * 
   * @param String $dDMoneCuo
   * 
   * @return self
   */
  public function setDDMoneCuo(String $dDMoneCuo): self
  {
    $this->dDMoneCuo = $dDMoneCuo;
    return $this;
  }

  /**
   * Set the value of dMonCuota
   *
   * @param String $dMonCuota
   *
   * @return self
   */
  public function setDMonCuota(String $dMonCuota): self
  {
    if(!ValueValidations::isValidStringDecimal($dMonCuota, 15, 0))
      throw new \Exception("[GCuotas] Monto de la cuota (dMonCuota) no válido: " . $dMonCuota, 1);
    $this->dMonCuota = $dMonCuota;
    return $this;
  }

  /**
   * Set the value of dVencCuo
   *
   * @param DateTime $dVencCuo
   *
   * @return self
   */
  public function setDVencCuo(DateTime $dVencCuo): self
  {
    $this->dVencCuo = $dVencCuo;
    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Get the value of cMoneCuo
   *
   * @return String
   */
  public function getCMoneCuo(): String
  {
    return $this->cMoneCuo;
  }

  /**
   * E654  Descripción de la moneda de las cuotas
   *
   * @return String
   */
  public function getDDMoneCuo(): String
  {
    return $this->dDMoneCuo;
  }

  /**
   * Get the value of dMonCuota
   *
   * @return String
   */
  public function getDMonCuota(): String
  {
    return $this->dMonCuota;
  }

  /**
   * Get the value of dVencCuo
   *
   * @return DateTime
   */
  public function getDVencCuo(): DateTime
  {
    return $this->dVencCuo;
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML Element
  ///////////////////////////////////////////////////////////////////////

  /**
   * Instancia un objeto GCuotas a partir de un SimpleXMLElement
   * 
   * @param SimpleXMLElement $node
   * 
   * @return self
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node): self
  {
    if(strcmp($node->getName(), 'gCuotas') != 0)
      throw new \Exception("No corresponde a un nodo gCuotas válido: " . $node->getName(), 1);
    $res = new GCuotas();
    $res->setCMoneCuo($node->cMoneCuo);
    $res->setDMonCuota($node->dMonCuota);
    if(isset($node->dVencCuo))
      $res->setDVencCuo(DateTime::createFromFormat('Y-m-d', $node->dVencCuo));
    return $res;
  }

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('gCuotas');

    $res->appendChild(new DOMElement('cMoneCuo', $this->getCMoneCuo()));
    $res->appendChild(new DOMElement('dDMoneCuo', $this->getDDMoneCuo()));
    $res->appendChild(new DOMElement('dMonCuota', $this->getDMonCuota()));
    $res->appendChild(new DOMElement('dVencCuo', $this->getDVencCuo()->format("Y-m-d")));

    return $res;
  }

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return GCuotas
  //  */
  // public static function fromDOMElement(DOMElement $xml): GCuotas
  // {
  //   if (strcmp($xml->tagName, 'gCuotas') == 0 && $xml->childElementCount == 4) {
  //     $res = new GCuotas();
  //     $res->setCMoneCuo($xml->getElementsByTagName('cMoneCuo')->item(0)->nodeValue);
  //     $res->setDMonCuota($xml->getElementsByTagName('dDMoneCuo')->item(0)->nodeValue);
  //     $res->setDVencCuo(DateTime::createFromFormat('Y-m-d', $xml->getElementsByTagName('dVencCuo')->item(0)->nodeValue));
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
    $res = new GCuotas();
    if(isset($response->cMoneCuo))
    {
      $res->setCMoneCuo($response->cMoneCuo);
    }
    if(isset($response->dMonCuota))
    {
      $res->setDMonCuota($response->dMonCuota);
    }
    if(isset($response->dVencCuo))
    {
      $res->setDVencCuo(DateTime::createFromFormat('Y-m-d', $response->dVencCuo));
    }

    return $res;

  }
}
