<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use Abiliomp\Pkuatia\Core\Constants\CamIVAAfecIVA;
use Abiliomp\Pkuatia\Core\Constants\CamIVATasaIVA;
use Abiliomp\Pkuatia\Core\Fields\BaseSifenField;
use Abiliomp\Pkuatia\Utils\ValueValidations;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id:     E730
 * Nombre:      gCamIVA
 * Descripción: Campos que describen el IVA de la operación
 * Nodo Padre:  E700
 */
class GCamIVA extends BaseSifenField
{

  public const AFECTACION_IVA_GRAVADO = 1;
  public const AFECTACION_IVA_EXONERADO = 2;
  public const AFECTACION_IVA_EXENTO = 3;
  public const AFECTACION_IVA_GRAVADO_PARCIAL = 4;

  public int    $iAfecIVA;    // E731 - 1          - 1-1 - Forma de afectación tributaria del IVA: 1 - Gravado | 2 - Exonerado (Art. 83- Ley 125/91) | 3 - Exento | 4 - Gravado parcial (Grav-Exento)
  public String $dDesAfecIVA; // E732 - 6-15       - 1-1 - Descripción de la forma de afectación tributaria del IVA
  public String $dPropIVA;    // E733 - 1-3p(0-8)  - 1-1 - Proporción gravada de IVA
  public int    $dTasaIVA;    // E734 - 1-2        - 1-1 - Tasa del IVA (% en número entero)
  public String $dBasGravIVA; // E735 - 1-15p(0-8) - 1-1 - Base gravada del IVA por ítem 
  public String $dLiqIVAItem; // E736 - 1-15p(0-8) - 1-1 - Liquidación del IVA por ítem
  public String $dBasExe;     // E737 - 1-15p(0-8) - 1-1 - Base Exenta por ítem 

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de iAfecIVA
   *
   * @param int $iAfecIVA
   *
   * @return self
   */
  public function setIAfecIVA(int|CamIVAAfecIVA $iAfecIVA): self
  {
    $this->iAfecIVA = $iAfecIVA instanceof CamIVAAfecIVA ? $iAfecIVA->value : $iAfecIVA;
    $this->dDesAfecIVA = CamIVAAfecIVA::getDescripcion($this->iAfecIVA);
    return $this;
  }

  /**
   * Establece la descripción de la forma de afectación tributaria del IVA
   * 
   * @param String $dDesAfecIVA
   * 
   * @return self
   */
  public function setDDesAfecIVA(String $dDesAfecIVA): self
  {
    $this->dDesAfecIVA = $dDesAfecIVA;
    return $this;
  }


  /**
   * Establece el valor de dPropIVA
   *
   * @param String $dPropIVA
   *
   * @return self
   */
  public function setDPropIVA(String $dPropIVA): self
  {
    $this->dPropIVA = $dPropIVA;

    return $this;
  }


  /**
   * Establece el valor de dTasaIVA
   *
   * @param int $dTasaIVA
   *
   * @return self
   */
  public function setDTasaIVA(int|CamIVATasaIVA $dTasaIVA): self
  {
    $this->dTasaIVA = $dTasaIVA instanceof CamIVATasaIVA ? $dTasaIVA->value : $dTasaIVA;
    return $this;
  }


  /**
   * Establece el valor de dBasGravIVA
   *
   * @param String $dBasGravIVA
   *
   * @return self
   */
  public function setDBasGravIVA(String $dBasGravIVA): self
  {
    if(!ValueValidations::isValidStringDecimal($dBasGravIVA, 15, 0))
      throw new \Exception("Invalid dBasGravIVA: $dBasGravIVA");
    $this->dBasGravIVA = $dBasGravIVA;
    return $this;
  }


  /**
   * Establece el valor de dLiqIVAItem
   *
   * @param String $dLiqIVAItem
   *
   * @return self
   */
  public function setDLiqIVAItem(String $dLiqIVAItem): self
  {
    if(!ValueValidations::isValidStringDecimal($dLiqIVAItem, 15, 0))
      throw new \Exception("Invalid dBasGravIVA: $dLiqIVAItem");
    $this->dLiqIVAItem = $dLiqIVAItem;
    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  //Getter
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de iAfecIVA
   *
   * @return int
   */
  public function getIAfecIVA(): int
  {
    return $this->iAfecIVA;
  }


  /**
   * Devuelve la descripción de la forma de afectación tributaria del IVA
   *
   * @return String
   */
  public function getDDesAfecIVA(): String
  {
    return $this->dDesAfecIVA;
  }

  /**
   * Obtiene el valor de dPropIVA
   *
   * @return String
   */
  public function getDPropIVA(): String
  {
    return $this->dPropIVA;
  }

  /**
   * Obtiene el valor de dTasaIVA
   *
   * @return int
   */
  public function getDTasaIVA(): int
  {
    return $this->dTasaIVA;
  }

  /**
   * Obtiene el valor de dBasGravIVA
   *
   * @return String
   */
  public function getDBasGravIVA(): String
  {
    return $this->dBasGravIVA;
  }

  /**
   * Obtiene el valor de dLiqIVAItem
   *
   * @return String
   */
  public function getDLiqIVAItem(): String
  {
    return $this->dLiqIVAItem;
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML Element
  ///////////////////////////////////////////////////////////////////////

  /**
   * Instancia un objeto GCamIVA desde un SimpleXMLElement
   * 
   * @param SimpleXMLElement $node
   * 
   * @return self
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node): self
  {
    if(strcmp($node->getName(), 'gCamIVA') != 0)
      throw new \Exception("Invalid gCamIVA XML Node Name: " . $node->getName());
    $res = new GCamIVA();
    $res->iAfecIVA    = intval($node->iAfecIVA);
    $res->dDesAfecIVA = strval($node->dDesAfecIVA);
    $res->dPropIVA    = strval($node->dPropIVA);
    $res->dTasaIVA    = intval($node->dTasaIVA);
    $res->dBasGravIVA = strval($node->dBasGravIVA);
    $res->dLiqIVAItem = strval($node->dLiqIVAItem);
    return $res;
  }

  /**
   * Convierte este GCamIVA en un DOMElement que puede ser insertado en el DOMDocument especificado.
   * 
   * @param DOMDocument $doc Documento DOM que creará el DOMElement sin insertarlo.
   * 
   * @return DOMElement El DOMElement creado.
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gCamIVA');
    $res->appendChild(new DOMElement('iAfecIVA', $this->getIAfecIVA()));
    $res->appendChild(new DOMElement('dDesAfecIVA', $this->getDDesAfecIVA()));
    $res->appendChild(new DOMElement('dPropIVA', $this->getDPropIVA()));
    $res->appendChild(new DOMElement('dTasaIVA', $this->getDTasaIVA()));
    $res->appendChild(new DOMElement('dBasGravIVA', $this->getDBasGravIVA()));
    $res->appendChild(new DOMElement('dLiqIVAItem', $this->getDLiqIVAItem()));
    $res->appendChild(new DOMElement('dBasExe', $this->getDBasExe()));
    return $res;
  }

  
  /**
   * FromSifenResponseObject
   *
   * @param  mixed $resposne
   * @return self
   */
  public static function FromSifenResponseObject($resposne): self
  {

    $res = new GCamIVA();
    if(isset($resposne->iAfecIVA))
    {
      $res->setIAfecIVA(intval($resposne->iAfecIVA));
    }
    if(isset($resposne->dPropIVA))
    {
      $res->setDPropIVA(strval($resposne->dPropIVA));
    }
    if(isset($resposne->dTasaIVA))
    {
      $res->setDTasaIVA(intval($resposne->dTasaIVA));
    }
    if(isset($resposne->dBasGravIVA))
    {
      $res->setDBasGravIVA(strval($resposne->dBasGravIVA));
    }
    if(isset($resposne->dLiqIVAItem))
    {
      $res->setDLiqIVAItem(strval($resposne->dLiqIVAItem));
    }
    if(isset($resposne->dBasExe))
    {
      $res->setDBasExe(strval($resposne->dBasExe));
    }    
     
    return $res;
  }

  /**
   * Obtiene el valor de dBasExe
   *
   * @return String
   */
  public function getDBasExe(): String | null
  {
    if(isset($this->dBasExe))
    return $this->dBasExe;
    else
    return null;
  }

  /**
   * Establece el valor de dBasExe
   *
   * @param String $dBasExe
   *
   * @return self
   */
  public function setDBasExe(String $dBasExe): self
  {
    $this->dBasExe = $dBasExe;

    return $this;
  }

  /**
   * Instancia un objeto GCamIVA a partir de un DOMElement que lo representa.
   * 
   * @param DOMElement $node El DOMElement que representa el objeto.
   * 
   * @return self El objeto instanciado.
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    if(strcmp($node->nodeName, 'gCamIVA') != 0)
        throw new \Exception('[GCamIVA] Nodo con nombre inválido: ' . $node->nodeName);
    $res = new self();
    $res->iAfecIVA = intval(trim($node->getElementsByTagName('iAfecIVA')->item(0)->nodeValue));
    $res->dDesAfecIVA = trim($node->getElementsByTagName('dDesAfecIVA')->item(0)->nodeValue);
    $res->dPropIVA = trim($node->getElementsByTagName('dPropIVA')->item(0)->nodeValue);
    $res->dTasaIVA = intval(trim($node->getElementsByTagName('dTasaIVA')->item(0)->nodeValue));
    $res->dBasGravIVA = trim($node->getElementsByTagName('dBasGravIVA')->item(0)->nodeValue);
    $res->dLiqIVAItem = trim($node->getElementsByTagName('dLiqIVAItem')->item(0)->nodeValue);
    $res->dBasExe = trim($node->getElementsByTagName('dBasExe')->item(0)->nodeValue);
    return $res;
  }
}
