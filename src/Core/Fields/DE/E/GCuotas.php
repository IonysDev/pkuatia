<?php

namespace IonysDev\Pkuatia\Core\Fields\DE\E;

use IonysDev\Pkuatia\DataMappings\MonedaMapping;
use IonysDev\Pkuatia\Utils\ValueValidations;
use DateTime;
use DOMDocument;
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
   * Establece el valor de cMoneCuo
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
   * Establece el valor de dMonCuota
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
   * Establece el valor de dVencCuo
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
   * Obtiene el valor de cMoneCuo
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
   * Obtiene el valor de dMonCuota
   *
   * @return String
   */
  public function getDMonCuota(): String
  {
    return $this->dMonCuota;
  }

  /**
   * Obtiene el valor de dVencCuo
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
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gCuotas');
    $res->appendChild(new DOMElement('cMoneCuo', $this->getCMoneCuo()));
    $res->appendChild(new DOMElement('dDMoneCuo', $this->getDDMoneCuo()));
    $res->appendChild(new DOMElement('dMonCuota', $this->getDMonCuota()));
    $res->appendChild(new DOMElement('dVencCuo', $this->getDVencCuo()->format("Y-m-d")));
    return $res;
  }
  
  /**
   * FromSifenResponseObject
   *
   * @param  mixed $object
   * @return self
   */
  public static function FromSifenResponseObject($object):self
  {
    $res = new GCuotas();
    if(isset($object->cMoneCuo))
    {
      $res->setCMoneCuo($object->cMoneCuo);
    }
    if(isset($object->dMonCuota))
    {
      $res->setDMonCuota($object->dMonCuota);
    }
    if(isset($object->dVencCuo))
    {
      $res->setDVencCuo(DateTime::createFromFormat('Y-m-d', $object->dVencCuo));
    }

    return $res;

  }

  /**
   * Instancia un objeto GCuotas a partir de un DOMElement que representa el nodo XML del objeto GCuotas.
   * 
   * @param DOMElement $node Nodo XML que representa el objeto GCuotas
   * 
   * @return self Objeto GCuotas instanciado
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    if(strcmp($node->nodeName, 'gCuotas') != 0)
      throw new \Exception('[GCuotas] Nodo con nombre inválido: ' . $node->nodeName);
    $res = new GCuotas();
    $res->setCMoneCuo($node->getElementsByTagName('cMoneCuo')->item(0)->nodeValue);
    $res->setDDMoneCuo($node->getElementsByTagName('dDMoneCuo')->item(0)->nodeValue);
    $res->setDMonCuota($node->getElementsByTagName('dMonCuota')->item(0)->nodeValue);
    if($node->getElementsByTagName('dVencCuo')->length > 0)
      $res->setDVencCuo(DateTime::createFromFormat('Y-m-d', $node->getElementsByTagName('dVencCuo')->item(0)->nodeValue));
    return $res;
  }

}
