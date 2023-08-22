<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use Abiliomp\Pkuatia\Utils\ValueValidations;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id:     E730
 * Nombre:      gCamIVA
 * Descripción: Campos que describen el IVA de la operación
 * Nodo Padre:  E700
 */
class GCamIVA
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
  public String $dBasExe;      // E730 - 1-15p(0-8) - 1-1 - Base Exenta por ítem 

  ///////////////////////////////////////////////////////////////////////
  //Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of iAfecIVA
   *
   * @param int $iAfecIVA
   *
   * @return self
   */
  public function setIAfecIVA(int $iAfecIVA): self
  {
    $this->iAfecIVA = $iAfecIVA;
    switch ($this->iAfecIVA) {
      case 1:
        $this->dDesAfecIVA = "Gravado IVA";
        break;
      case 2:
        $this->dDesAfecIVA = "Exonerado (Art. 83- Ley 125/91)";
        break;
      case 3:
        $this->dDesAfecIVA = "Exento";
        break;
      case 4:
        $this->dDesAfecIVA = "Gravado parcial (Grav-Exento)";
        break;
      default:
        throw new \Exception("Invalid iAfecIVA: $iAfecIVA");
        break;
    }
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
   * Set the value of dPropIVA
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
   * Set the value of dTasaIVA
   *
   * @param int $dTasaIVA
   *
   * @return self
   */
  public function setDTasaIVA(int $dTasaIVA): self
  {
    $this->dTasaIVA = $dTasaIVA;

    return $this;
  }


  /**
   * Set the value of dBasGravIVA
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
   * Set the value of dLiqIVAItem
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
   * Get the value of iAfecIVA
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
   * Get the value of dPropIVA
   *
   * @return String
   */
  public function getDPropIVA(): String
  {
    return $this->dPropIVA;
  }

  /**
   * Get the value of dTasaIVA
   *
   * @return int
   */
  public function getDTasaIVA(): int
  {
    return $this->dTasaIVA;
  }

  /**
   * Get the value of dBasGravIVA
   *
   * @return String
   */
  public function getDBasGravIVA(): String
  {
    return $this->dBasGravIVA;
  }

  /**
   * Get the value of dLiqIVAItem
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
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $doc = new \DOMDocument();
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
      $res->setDBasGravIVA(Stringval($resposne->dBasGravIVA));
    }
    if(isset($resposne->dLiqIVAItem))
    {
      $res->setDLiqIVAItem(Stringval($resposne->dLiqIVAItem));
    }
    if(isset($resposne->dBasExe))
    {
      $res->setDBasExe(Stringval($resposne->dBasExe));
    }    
     
    return $res;
  }

  /**
   * Get the value of dBasExe
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
   * Set the value of dBasExe
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
}
