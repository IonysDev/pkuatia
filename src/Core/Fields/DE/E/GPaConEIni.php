<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use Abiliomp\Pkuatia\DataMappings\MonedaMapping;
use Abiliomp\Pkuatia\Utils\ValueValidations;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id:     E605
 * Nombre:      GPaConEIni
 * Descripción: Campos que describen la forma de pago al contado o del monto de la entrega inicial.
 * Nodo Padre:  E600
 */

class GPaConEIni
{
  public int $iTiPago;         // E606 - 1-2        - 1-1 - Tipo de pago
  public String $dDesTiPag;    // E607 - 4-30       - 1-1 - Descripción del tipo de pago
  public String $dMonTiPag;    // E608 - 1-15p(0-4) - 1-1 - Monto por tipo de pago (decimal BCMath)
  public String $cMoneTiPag;   // E609 - 3          - 1-1 - Moneda por tipo de pago
  public String $dDMoneTiPag;  // E610 - 3-20       - 1-1 - Descripción de la moneda por tipo de pago
  public String $dTiCamTiPag;  // E611 - 1-5p(0-4)  - 0-1 - Tasa de cambio por tipo de pago (decimal BCMath)
  public GPagTarCD $gPagTarCD; // E620 -            - 0-1 - Campos que describen el pago o entrega inicial de la operación con tarjeta de crédito o débito
  public GPagCheq $gPagCheq;   // E630 -            - 0-1 - Campos que describen el pago o entrega inicial de la operación con cheque
  
  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////
  
  /**
   * Establece el código de tipo de pago y la descrición en caso de que sea un tipo de pago soportado. Usar código de tipo de pago 99 para otros tipos de pago.
   *
   * @param int $iTiPago
   *
   * @return self
   */
  public function setITiPago(int $iTiPago): self
  {
    $this->iTiPago = $iTiPago;
    switch ($this->iTiPago) {
      case 1:
        $this->dDesTiPag = "Efectivo";
        break;
      case 2:
        $this->dDesTiPag = "Cheque";
        break;
      case 3:
        $this->dDesTiPag = "Tarjeta de crédito";
        break;
      case 4:
        $this->dDesTiPag = "Tarjeta de débito";
        break;
      case 5:
        $this->dDesTiPag = "Transferencia";
        break;
      case 6:
        $this->dDesTiPag = "Giro";
        break;
      case 7:
        $this->dDesTiPag = "Billetera electrónica";
        break;
      case 8:
        $this->dDesTiPag = "Tarjeta empresarial";
        break;
      case 9:
        $this->dDesTiPag = "Vale";
        break;
      case 10:
        $this->dDesTiPag = "Retención";
        break;
      case 11:
        $this->dDesTiPag = "Pago por anticipo";
        break;
      case 12:
        $this->dDesTiPag = "Valor fiscal";
        break;
      case 13:
        $this->dDesTiPag = "Valor comercial";
        break;
      case 14:
        $this->dDesTiPag = "Compensación";
        break;
      case 15:
        $this->dDesTiPag = "Permuta";
        break;
      case 16:
        $this->dDesTiPag = "Pago bancario";
        break;
      case 17:
        $this->dDesTiPag = "Pago Móvil";
        break;
      case 18:
        $this->dDesTiPag = "Donación";
        break;
      case 19:
        $this->dDesTiPag = "Promoción";
        break;
      case 20:
        $this->dDesTiPag = "Consumo Interno";
        break;
      case 21:
        $this->dDesTiPag = "Pago Electrónico";
        break;
      case 99:
        break;
      default:
        throw new \Exception("Tipo de pago no soportado");
        break;
    }
    return $this;
  }

  /**
   * Establece la descripción del tipo de pago
   * 
   * @param String $dDesTiPag
   * 
   * @return self
   */
  public function setDDesTiPag(String $dDesTiPag): self
  {
    if(is_null($dDesTiPag) || strlen($dDesTiPag) == 0)
    {
      $this->$dDesTiPag;
    }
    else
    {
      $this->$dDesTiPag = substr($dDesTiPag, 0, 30);
    }
    return $this;
  }

  /**
   * Set the value of dMonTiPag
   *
   * @param String $dMonTiPag Monto por tipo de pago en cadena de formato decimal.
   *
   * @return self
   */
  public function setDMonTiPag(String $dMonTiPag): self
  {
    if(ValueValidations::isValidStringDecimal($dMonTiPag, 15, 0, 4))
    {
      $this->dMonTiPag = $dMonTiPag;
    }
    else
    {
      throw new \Exception("El valor monto por tipo de pago a ser asignado no es válido");
    }
    return $this;
  }


  /**
   * Set the value of cMoneTiPag
   *
   * @param String $cMoneTiPag
   *
   * @return self
   */
  public function setCMoneTiPag(String $cMoneTiPag): self
  {
    $this->cMoneTiPag = $cMoneTiPag;
    $this->dDMoneTiPag = MonedaMapping::GetDescription($cMoneTiPag);
    return $this;
  }

  /**
   * Establece el valor dDMoneTiPag que es la descripción de la moneda por tipo de pago.
   * Este valor debería establecerse automáticamente mediante setCMoneTiPag.
   * Se recomienda no usar esta función.
   * 
   * @param String $dDMoneTiPag
   * 
   * @return self
   */
  public function setDDMoneTiPag(String $dDMoneTiPag): self
  {
    if(is_null($dDMoneTiPag) || strlen($dDMoneTiPag) == 0)
    {
      $this->$dDMoneTiPag;
    }
    else
    {
      $this->$dDMoneTiPag = substr($dDMoneTiPag, 0, 20);
    }
    return $this;
  }


  /**
   * Set the value of dTiCamTiPag
   *
   * @param String $dTiCamTiPag
   *
   * @return self
   */
  public function setDTiCamTiPag(String $dTiCamTiPag): self
  {
    if(ValueValidations::isValidStringDecimal($dTiCamTiPag, 5, 0, 4))
    {
      $this->dTiCamTiPag = $dTiCamTiPag;
    }
    else
    {
      throw new \Exception("El valor tasa de cambio por tipo de pago a ser asignado no es válido");
    }
    return $this;
  }

  /**
   * Set the value of gPagTarCD
   *
   * @param GPagTarCD $gPagTarCD
   *
   * @return self
   */
  public function setGPagTarCD(GPagTarCD $gPagTarCD): self
  {
    $this->gPagTarCD = $gPagTarCD;

    return $this;
  }

  /**
   * Set the value of gPagCheq
   *
   * @param GPagCheq $gPagCheq
   *
   * @return self
   */
  public function setGPagCheq(GPagCheq $gPagCheq): self
  {
    $this->gPagCheq = $gPagCheq;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Get the value of iTiPago
   *
   * @return int
   */
  public function getITiPago(): int
  {
    return $this->iTiPago;
  }

  /**
   * E607 Descripción del tipo de pago
   *
   * @return String
   */
  public function getDDesTiPag(): String
  {
    return $this->dDesTiPag;
  }


  /**
   * Get the value of dMonTiPag
   *
   * @return int
   */
  public function getDMonTiPag(): int
  {
    return $this->dMonTiPag;
  }

  /**
   * Get the value of cMoneTiPag
   *
   * @return String
   */
  public function getCMoneTiPag(): String
  {
    return $this->cMoneTiPag;
  }

  /**
   *  E610 Descripción de la moneda por tipo de pago
   *
   * @return String
   */
  public function getDDMoneTiPag(): String
  {
    return $this->dDMoneTiPag;
  }


  /**
   * Get the value of dTiCamTiPag
   *
   * @return String
   */
  public function getDTiCamTiPag(): String
  {
    return $this->dTiCamTiPag;
  }

  /**
   * Get the value of gPagTarCD
   *
   * @return GPagTarCD
   */
  public function getGPagTarCD(): GPagTarCD
  {
    return $this->gPagTarCD;
  }

  /**
   * Get the value of gPagCheq
   *
   * @return GPagCheq
   */
  public function getGPagCheq(): GPagCheq
  {
    return $this->gPagCheq;
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML Element
  ///////////////////////////////////////////////////////////////////////

  /**
   * Instancia un objeto GPaConEIni a partir de un SimpleXMLElement
   * 
   * @param SimpleXMLElement $node
   * 
   * @return self
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node): self
  {
    if(strcmp($node->getName(), 'gPaConEIni') != 0)
    {
      throw new \Exception("El elemento '" . $node->getName() . "' no es gPaConEIni");
    }
    $res = new GPaConEIni();
    $res->setITiPago(intval($node->iTiPago));
    $res->setDDesTiPag(strval($node->dDesTiPag));
    $res->setDMonTiPag(intval($node->dMonTiPag));
    $res->setCMoneTiPag($node->cMoneTiPag);
    $res->setDDMoneTiPag(strval($node->dDMoneTiPag));
    if(isset($node->dTiCamTiPag))
    {
      $res->setDTiCamTiPag(strval($node->dTiCamTiPag));
    }
    if(isset($node->gPagTarCD))
    {
      $res->setGPagTarCD(GPagTarCD::FromSimpleXMLElement($node->gPagTarCD));
    }
    if(isset($node->gPagCheq))
    {
      $res->setGPagCheq(GPagCheq::FromSimpleXMLElement($node->gPagCheq));
    }
    return $res;
  }

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gPaConEIni');
    $res->appendChild(new DOMElement('iTiPago', $this->getITiPago()));
    $res->appendChild(new DOMElement('dDesTiPag', $this->getDDesTiPag()));
    $res->appendChild(new DOMElement('dMonTiPag', $this->getDMonTiPag()));
    $res->appendChild(new DOMElement('cMoneTiPag', $this->getCMoneTiPag()));
    $res->appendChild(new DOMElement('dDMoneTiPag', $this->getDDMoneTiPag()));
    if ($this->cMoneTiPag != 'PYG') {
      $res->appendChild(new DOMElement('dTiCamTiPag', $this->getDTiCamTiPag()));
    }
    if(isset($this->gPagTarCD))
      $res->appendChild($this->gPagTarCD->toDOMElement($doc));
    if(isset($this->gPagCheq))
      $res->appendChild($this->gPagCheq->toDOMElement($doc));
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
    $res = new GPaConEIni();
    if(isset($object->iTiPago))
    {
      $res->setITiPago(intval($object->iTiPago));
    }
    if(isset($object->dMonTiPag))
    {
      $res->setDMonTiPag(intval($object->dMonTiPag));
    }
    if(isset($object->cMoneTiPag))
    {
      $res->setCMoneTiPag($object->cMoneTiPag);
    }
    if(isset($object->dTiCamTiPag))
    {
      $res->setDTiCamTiPag($object->dTiCamTiPag);
    }
    //Children
    if(isset($object->gPagTarCD))
    {
      $res->setGPagTarCD(GPagTarCD::FromSifenResponseObject($object->gPagTarCD));
    }
    if(isset($object->gPagCheq))
    {
      $res->setGPagCheq(GPagCheq::FromSifenResponseObject($object->gPagCheq));
    } 

    return $res;
  }

  /**
   * Instancia un objeto GPaConEIni a partir de un DOMElement que representa el nodo XML del objeto GPaConEIni.
   * 
   * @param DOMElement $node Nodo XML que representa el objeto GPaConEIni
   * 
   * @return self Objeto GPaConEIni instanciado
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    if(strcmp($node->nodeName, 'gPaConEIni') != 0)
      throw new \Exception('[GPaConEIni] Nodo con nombre inválido: ' . $node->nodeName);
    $res = new GPaConEIni();
    $res->setITiPago(intval(trim($node->getElementsByTagName('iTiPago')->item(0)->nodeValue)));
    $res->setDDesTiPag(trim($node->getElementsByTagName('dDesTiPag')->item(0)->nodeValue));
    $res->setDMonTiPag(intval(trim($node->getElementsByTagName('dMonTiPag')->item(0)->nodeValue)));
    $res->setCMoneTiPag(trim($node->getElementsByTagName('cMoneTiPag')->item(0)->nodeValue));
    if($node->getElementsByTagName('dTiCamTiPag')->length > 0)
      $res->setDTiCamTiPag(trim($node->getElementsByTagName('dTiCamTiPag')->item(0)->nodeValue));
    if($node->getElementsByTagName('gPagTarCD')->length > 0)
      $res->setGPagTarCD(GPagTarCD::FromDOMElement($node->getElementsByTagName('gPagTarCD')->item(0)));
    if($node->getElementsByTagName('gPagCheq')->length > 0)
      $res->setGPagCheq(GPagCheq::FromDOMElement($node->getElementsByTagName('gPagCheq')->item(0)));
    return $res;
  }
  
  
}
