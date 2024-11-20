<?php

namespace IonysDev\Pkuatia\Core\Fields\DE\E;

use IonysDev\Pkuatia\Core\Constants\PagTarCDDenTarj;
use IonysDev\Pkuatia\Core\Constants\PagTarCDForProPa;
use IonysDev\Pkuatia\Core\Fields\BaseSifenField;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id: E620 
 * Descripción: Campos que describen el pago o entrega inicial de la operación con tarjeta de crédito/débito
 * Nodo Padre: E605 
 */

class GPagTarCD extends BaseSifenField
{
  public int $iDenTarj;       // E621 - 1-2  - 1-1 - Denominación de la tarjeta
  public String $dDesDenTarj; // E622 - 4-20 - 1-1 - Descripción de la Denominación de la tarjeta
  public String $dRSProTar;   // E623 - 4-60 - 0-1 - Razón social de la procesadora de tarjeta
  public String $dRUCProTar;  // E624 - 3-8  - 0-1 - RUC de la procesadora de tarjeta
  public int $dDVProTar;      // E625 - 1    - 0-1 - Dígito verificador del  RUC de la procesadora  de tarjeta
  public int $iForProPa;      // E626 - 1    - 1-1 - Forma de procesamiento de pago: 1 - POS | 2 - Online | 9 - Otro
  public int $dCodAuOpe;      // E627 - 6-10 - 0-1 - Código de autorización de la operación
  public String $dNomTit;     // E628 - 4-30 - 0-1 - Nombre del titular de la tarjeta 
  public int $dNumTarj;       // E629 - 4    - 0-1 - Ultimos 4 dígitos del número de la tarjeta;

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de iDenTarj
   *
   * @param int $iDenTarj
   *
   * @return self
   */
  public function setIDenTarj(int|PagTarCDDenTarj $iDenTarj): self
  {
    $this->iDenTarj = $iDenTarj instanceof PagTarCDDenTarj ? $iDenTarj->value : $iDenTarj;
    $this->dDesDenTarj = PagTarCDDenTarj::getDescripcion($this->iDenTarj);
    return $this;
  }

  /**
   * Establece la descripción de la Denominación de la tarjeta
   * 
   * @param String $dDesDenTarj
   * 
   * @return self
   */
  public function setDDesDenTarj(String $dDesDenTarj): self
  {
    $this->dDesDenTarj = $dDesDenTarj;
    if(is_null($dDesDenTarj) || strlen($dDesDenTarj) == 0)
    {
      $this->dDesDenTarj;
    }
    else
    {
      $this->dDesDenTarj = substr($dDesDenTarj, 0, 20);
    }
    return $this;
  }


  /**
   * Establece el valor de dRSProTar
   *
   * @param String $dRSProTar
   *
   * @return self
   */
  public function setDRSProTar(String $dRSProTar): self
  {
    $this->dRSProTar = $dRSProTar;
    if(is_null($dRSProTar) || strlen($dRSProTar) == 0)
    {
      $this->dRSProTar;
    }
    else
    {
      $this->dRSProTar = substr($dRSProTar, 0, 60);
    }
    return $this;
  }


  /**
   * Establece el valor de dRUCProTar
   *
   * @param String $dRUCProTar
   *
   * @return self
   */
  public function setDRUCProTar(String $dRUCProTar): self
  {
    $this->dRUCProTar = $dRUCProTar;
    if(is_null($dRUCProTar) || strlen($dRUCProTar) == 0)
    {
      $this->dRUCProTar;
    }
    else
    {
      $this->dRUCProTar = substr($dRUCProTar, 0, 8);
    }
    return $this;
  }


  /**
   * Establece el valor de dDVProTar
   *
   * @param int $dDVProTar
   *
   * @return self
   */
  public function setDDVProTar(int $dDVProTar): self
  {
    $this->dDVProTar = $dDVProTar;
    return $this;
  }


  /**
   * Establece el valor de iForProPa
   *
   * @param int $iForProPa
   *
   * @return self
   */
  public function setIForProPa(int|PagTarCDForProPa $iForProPa): self
  {
    if(is_int($iForProPa) && $iForProPa != 1 && $iForProPa != 2 && $iForProPa != 9)
    {
      throw new \Exception("[GPagTarCD] Valor de iForProPa inválido: $iForProPa");
    }
    $this->iForProPa = $iForProPa instanceof PagTarCDForProPa ? $iForProPa->value : $iForProPa;
    return $this;
  }

  /**
   * Establece el valor de dCodAuOpe
   *
   * @param int $dCodAuOpe
   *
   * @return self
   */
  public function setDCodAuOpe(int $dCodAuOpe): self
  {
    $this->dCodAuOpe = $dCodAuOpe;
    return $this;
  }


  /**
   * Establece el valor de dNomTit
   *
   * @param String $dNomTit
   *
   * @return self
   */
  public function setDNomTit(String $dNomTit): self
  {
    $this->dNomTit = $dNomTit;
    if(is_null($dNomTit) || strlen($dNomTit) == 0)
    {
      $this->dNomTit;
    }
    else
    {
      $this->dNomTit = substr($dNomTit, 0, 30);
    }
    return $this;
  }


  /**
   * Establece el valor de dNumTarj
   *
   * @param int $dNumTarj
   *
   * @return self
   */
  public function setDNumTarj(int $dNumTarj): self
  {
    $this->dNumTarj = $dNumTarj;
    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de iDenTarj
   *
   * @return int
   */
  public function getIDenTarj(): int
  {
    return $this->iDenTarj;
  }


  /**
   *  E622 Descripción de denominación de la tarjeta
   *
   * @return String
   */
  public function getDDesDenTarj(): String
  {
    return $this->dDesDenTarj;
  }

  /**
   * Obtiene el valor de dRSProTar
   *
   * @return String
   */
  public function getDRSProTar(): String
  { 
    return $this->dRSProTar;
  }

  /**
   * Obtiene el valor de dRUCProTar
   *
   * @return String
   */
  public function getDRUCProTar(): String
  {
    return $this->dRUCProTar;
  }

  /**
   * Obtiene el valor de dDVProTar
   *
   * @return int
   */
  public function getDDVProTar(): int
  {
    return $this->dDVProTar;
  }

  /**
   * Obtiene el valor de iForProPa
   *
   * @return int
   */
  public function getIForProPa(): int
  {
    return $this->iForProPa;
  }

  /**
   * Obtiene el valor de dCodAuOpe
   *
   * @return int
   */
  public function getDCodAuOpe(): int
  {
    return $this->dCodAuOpe;
  }

  /**
   * Obtiene el valor de dNomTit
   *
   * @return String
   */
  public function getDNomTit(): String
  {
    return $this->dNomTit;
  }

  /**
   * Obtiene el valor de dNumTarj
   *
   * @return int
   */
  public function getDNumTarj(): int
  {
    return $this->dNumTarj;
  }

  ///////////////////////////////////////////////////////////////////////
  //XML Element
  ///////////////////////////////////////////////////////////////////////

  /**
   * Instancia un objeto gPagTarCD a partir de un SimpleXMLElement
   * 
   * @param SimpleXMLElement $node
   * 
   * @return GPagTarCD
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node): GPagTarCD
  {
    if(strcmp($node->getName(), 'gPagTarCD') != 0)
    {
      throw new \Exception("El nodo '" . $node->getName() . "' no es gPagTarCD");
    }
    $res = new GPagTarCD();
    $res->setIDenTarj(intval($node->iDenTarj));
    $res->setDDesDenTarj(strval($node->dDesDenTarj));
    if(isset($node->dRSProTar))
    {
      $res->setDRSProTar(strval($node->dRSProTar));
    }
    if(isset($node->dRUCProTar))
    {
      $res->setDRUCProTar(strval($node->dRUCProTar));
    }
    if(isset($node->dDVProTar))
    {
      $res->setDDVProTar(intval($node->dDVProTar));
    }
    $res->setIForProPa(intval($node->iForProPa));
    if(isset($node->dCodAuOpe))
    {  
      $res->setDCodAuOpe(intval($node->dCodAuOpe));
    }
    if(isset($node->dNomTit))
    {
      $res->setDNomTit(strval($node->dNomTit));
    }
    if(isset($node->dNumTarj))
    {
      $res->setDNumTarj(intval($node->dNumTarj));
    }
    return $res;
  }

  /**
   * Convierte este objeto a un DOMElement para embutirse en un DOMDocument especifico.
   * 
   * @param DOMDocument $doc Documento DOM en el que se va a embutir el DOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gPagTarCD');
    $res->appendChild(new DOMElement('iDenTarj', $this->getIDenTarj()));
    $res->appendChild(new DOMElement('dDesDenTarj', $this->getDDesDenTarj()));
    $res->appendChild(new DOMElement('dRSProTar', $this->getDRSProTar()));
    $res->appendChild(new DOMElement('dRUCProTar', $this->getDRUCProTar()));
    $res->appendChild(new DOMElement('dDVProTar', $this->getDDVProTar()));
    $res->appendChild(new DOMElement('iForProPa', $this->getIForProPa()));
    $res->appendChild(new DOMElement('dCodAuOpe', $this->getDCodAuOpe()));
    $res->appendChild(new DOMElement('dNomTit', $this->getDNomTit()));
    $res->appendChild(new DOMElement('dNumTarj', $this->getDNumTarj()));
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
    $res = new GPagTarCD();
    if(isset($object->iDenTarj))
    {
      $res->setIDenTarj(intval($object->iDenTarj));
    }
    if(isset($object->dRSProTar))
    {
      $res->setDRSProTar($object->dRSProTar);
    }
    if(isset($object->dRUCProTar))
    {
      $res->setDRUCProTar($object->dRUCProTar);
    }
    if(isset($object->dDVProTar))
    {
      $res->setDDVProTar(intval($object->dDVProTar));
    }
    if(isset($object->iForProPa))
    {
      $res->setIForProPa(intval($object->iForProPa));
    }
    if(isset($object->dCodAuOpe))
    {
      $res->setDCodAuOpe(intval($object->dCodAuOpe));
    }
    if(isset($object->dNomTit))
    {
      $res->setDNomTit($object->dNomTit);
    }
    if(isset($object->dNumTarj))
    {
      $res->setDNumTarj(intval($object->dNumTarj));
    }
    return $res;
  }

  /**
   * Instancia un objeto gPagTarCD a partir de un DOMElement que representa el nodo XML del objeto gPagTarCD.
   * 
   * @param DOMElement $node Nodo XML que representa el gPagTarCD
   * 
   * @return GPagTarCD Objeto instanciado
   */
  public static function FromDOMElement(DOMElement $node): GPagTarCD
  {
    if(strcmp($node->nodeName, 'gPagTarCD') != 0)
      throw new \Exception('[GPagTarCD] Nodo con nombre inválido: ' . $node->nodeName);
    $res = new GPagTarCD();
    $res->setIDenTarj(intval($node->getElementsByTagName('iDenTarj')->item(0)->nodeValue));
    $res->setDDesDenTarj(strval($node->getElementsByTagName('dDesDenTarj')->item(0)->nodeValue));
    if($node->getElementsByTagName('dRSProTar')->length > 0)
      $res->setDRSProTar(strval($node->getElementsByTagName('dRSProTar')->item(0)->nodeValue));
    if($node->getElementsByTagName('dRUCProTar')->length > 0)
      $res->setDRUCProTar(strval($node->getElementsByTagName('dRUCProTar')->item(0)->nodeValue));
    if($node->getElementsByTagName('dDVProTar')->length > 0)
      $res->setDDVProTar(intval($node->getElementsByTagName('dDVProTar')->item(0)->nodeValue));
    $res->setIForProPa(intval($node->getElementsByTagName('iForProPa')->item(0)->nodeValue));
    if($node->getElementsByTagName('dCodAuOpe')->length > 0)
      $res->setDCodAuOpe(intval($node->getElementsByTagName('dCodAuOpe')->item(0)->nodeValue));
    if($node->getElementsByTagName('dNomTit')->length > 0)
      $res->setDNomTit(strval($node->getElementsByTagName('dNomTit')->item(0)->nodeValue));
    if($node->getElementsByTagName('dNumTarj')->length > 0)
      $res->setDNumTarj(intval($node->getElementsByTagName('dNumTarj')->item(0)->nodeValue));
    return $res;
  }
}
