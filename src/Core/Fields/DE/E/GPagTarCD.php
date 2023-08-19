<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id: E620 
 * Descripción: Campos que describen el pago o entrega inicial de la operación con tarjeta de crédito/débito
 * Nodo Padre: E605 
 */

class GPagTarCD
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
   * Set the value of iDenTarj
   *
   * @param int $iDenTarj
   *
   * @return self
   */
  public function setIDenTarj(int $iDenTarj): self
  {
    $this->iDenTarj = $iDenTarj;
    switch ($this->iDenTarj) {
      case  1:
        $this->setDDesDenTarj("Visa");
        break;
      case  2:
        $this->setDDesDenTarj("Mastercard");
        break;
      case  3:
        $this->setDDesDenTarj("American Express");
        break;
      case  4:
        $this->setDDesDenTarj("Maestro");
        break;
      case  5:
        $this->setDDesDenTarj("Panal");
        break;
      case  6:
        $this->setDDesDenTarj("Cabal");
        break;
      case 99:
        $this->setDDesDenTarj("Otro");
        break;
      default:
        throw new \Exception("Valor de iDenTarj inválido: $iDenTarj");
        break;
    }
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
      $this->dDesDenTarj = null;
    }
    else
    {
      $this->dDesDenTarj = substr($dDesDenTarj, 0, 20);
    }
    return $this;
  }


  /**
   * Set the value of dRSProTar
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
      $this->dRSProTar = null;
    }
    else
    {
      $this->dRSProTar = substr($dRSProTar, 0, 60);
    }
    return $this;
  }


  /**
   * Set the value of dRUCProTar
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
      $this->dRUCProTar = null;
    }
    else
    {
      $this->dRUCProTar = substr($dRUCProTar, 0, 8);
    }
    return $this;
  }


  /**
   * Set the value of dDVProTar
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
   * Set the value of iForProPa
   *
   * @param int $iForProPa
   *
   * @return self
   */
  public function setIForProPa(int $iForProPa): self
  {
    if($iForProPa != 1 && $iForProPa != 2 && $iForProPa != 9)
    {
      throw new \Exception("Valor de iForProPa inválido: $iForProPa");
    }
    $this->iForProPa = $iForProPa;
    return $this;
  }

  /**
   * Set the value of dCodAuOpe
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
   * Set the value of dNomTit
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
      $this->dNomTit = null;
    }
    else
    {
      $this->dNomTit = substr($dNomTit, 0, 30);
    }
    return $this;
  }


  /**
   * Set the value of dNumTarj
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
   * Get the value of iDenTarj
   *
   * @return int
   */
  public function getIDenTarj(): int | null
  {
    return $this->iDenTarj;
  }


  /**
   *  E622 Descripción de denominación de la tarjeta
   *
   * @return String
   */
  public function getDDesDenTarj(): String | null
  {
    return $this->dDesDenTarj;
  }

  /**
   * Get the value of dRSProTar
   *
   * @return String
   */
  public function getDRSProTar(): String | null
  { 
    return $this->dRSProTar;
  }

  /**
   * Get the value of dRUCProTar
   *
   * @return String
   */
  public function getDRUCProTar(): String | null
  {
    return $this->dRUCProTar;
  }

  /**
   * Get the value of dDVProTar
   *
   * @return int
   */
  public function getDDVProTar(): int | null
  {
    return $this->dDVProTar;
  }

  /**
   * Get the value of iForProPa
   *
   * @return int
   */
  public function getIForProPa(): int | null
  {
    return $this->iForProPa;
  }

  /**
   * Get the value of dCodAuOpe
   *
   * @return int
   */
  public function getDCodAuOpe(): int | null
  {
    return $this->dCodAuOpe;
  }

  /**
   * Get the value of dNomTit
   *
   * @return String
   */
  public function getDNomTit(): String | null
  {
    return $this->dNomTit;
  }

  /**
   * Get the value of dNumTarj
   *
   * @return int
   */
  public function getDNumTarj(): int | null
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
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('gPagTarCD');

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

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return GPagTarCD
  //  */
  // public static function fromDOMElement(DOMElement $xml): GPagTarCD
  // {
  //   if (strcmp($xml->tagName, 'gPagTarCD') == 0 && $xml->childElementCount == 9) {
  //     $res = new GPagTarCD();
  //     $res->setIDenTarj(intval($xml->getElementsByTagName('iDenTarj')->item(0)->nodeValue));
  //     $res->setDRSProTar($xml->getElementsByTagName('dRSProTar')->item(0)->nodeValue);
  //     $res->setDRUCProTar($xml->getElementsByTagName('dRUCProTar')->item(0)->nodeValue);
  //     $res->setDDVProTar($xml->getElementsByTagName('dDDVProTar')->item(0)->nodeValue);
  //     $res->setIForProPa(intval($xml->getElementsByTagName('iForProPa')->item(0)->nodeValue));
  //     $res->setDCodAuOpe(intval($xml->getElementsByTagName('dCodAuOpe')->item(0)->nodeValue));
  //     $res->setDNomTit($xml->getElementsByTagName('dNomTit')->item(0)->nodeValue);
  //     $res->setDNumTarj(intval($xml->getElementsByTagName('dNumTarj')->item(0)->nodeValue));

  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Elemement: $xml->tagName");
  //   }
  // }
  
  /**
   * fromResponse
   *
   * @param  mixed $response
   * @return self
   */
  public static function fromResponse($response): self
  {
    $res = new GPagTarCD();
    if(isset($response->iDenTarj))
    {
      $res->setIDenTarj(intval($response->iDenTarj));
    }
    if(isset($response->dRSProTar))
    {
      $res->setDRSProTar($response->dRSProTar);
    }
    if(isset($response->dRUCProTar))
    {
      $res->setDRUCProTar($response->dRUCProTar);
    }
    if(isset($response->dDVProTar))
    {
      $res->setDDVProTar(intval($response->dDVProTar));
    }
    if(isset($response->iForProPa))
    {
      $res->setIForProPa(intval($response->iForProPa));
    }
    if(isset($response->dCodAuOpe))
    {
      $res->setDCodAuOpe(intval($response->dCodAuOpe));
    }
    if(isset($response->dNomTit))
    {
      $res->setDNomTit($response->dNomTit);
    }
    if(isset($response->dNumTarj))
    {
      $res->setDNumTarj(intval($response->dNumTarj));
    }
    return $res;
  }
}
