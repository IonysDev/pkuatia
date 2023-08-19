<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\H;

use DateTime;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id:H001
 * Descripción: Campos que identifican al DE asociado
 * Nodo Padre: A001 - Campos firmados del DE
 */

class GCamDEAsoc
{

  public int      $iTipDocAso;    // H002 - 1     - 1-1 - Tipo de documento asociado
  public String   $dDesTipDocAso; // H003 - 7-11  - 1-1 - Descripción del tipo de documento asociado
  public String   $dCdCDERef;     // H004 - 44    - 0-1 - CDC del DTE referenciado
  public int      $dNTimDI;       // H005 - 8     - 0-1 - Nro. timbrado documento impreso de referencia
  public String   $dEstDocAso;    // H006 - 3     - 0-1 - Establecimiento
  public String   $dPExpDocAso;   // H007 - 3     - 0-1 - Punto de expedición
  public String   $dNumDocAso;    // H008 - 7     - 0-1 - Número del documento
  public int      $iTipoDocAso;   // H009 - 1     - 0-1 - Tipo de documento  impreso
  public String   $dDTipoDocAso;  // H010 - 7-16  - 0-1 - Descripción del tipo de documento impreso
  public DateTime $dFecEmiDI;     // H011 - 10    - 0-1 - Fecha de emisión del documento impreso de referencia AAAA-MM-DD
  public String   $dNumComRet;    // H012 - 15    - 0-1 - Número de comprobante de retención
  public String   $dNumResCF;     // H013 - 15    - 0-1 - Número de resolución de crédito fiscal
  public int      $iTipCons;      // H014 - 1     - 0-1 - Tipo de constancia
  public String   $dDesTipCons;   // H015 - 30-34 - 0-1 - Descripción del tipo de constancia
  public int      $dNumCons;      // H016 - 11    - 0-1 - Número de constancia 
  public String   $dNumControl;   // H017 - 8     - 0-1 - Número de control de la constancia 

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of iTipDocAso
   *
   * @param int $iTipDocAso
   *
   * @return self
   */
  public function setITipDocAso(int $iTipDocAso): self
  {
    $this->iTipDocAso = $iTipDocAso;
    switch ($this->iTipDocAso) {
      case 1:
        $this->setDDesTipDocAso("Electrónico");
        break;
      case 2:
        $this->setDDesTipDocAso("Impreso");
        break;
      case 3:
        $this->setDDesTipDocAso("Constancia Electrónica");
        break;
      default:
        throw new \Exception("Invalid iTipDocAso: $iTipDocAso");
        break;
    }
    return $this;
  }

  /**
   * Set the value of dDesTipDocAso
   * 
   * @param string $dDesTipDocAso
   * 
   * @return self
   */
  public function setDDesTipDocAso(string $dDesTipDocAso): self
  {
    if(is_null($dDesTipDocAso) || strlen($dDesTipDocAso) == 0)
    {
      $this->dDesTipDocAso = null;
    }
    else
    {
      $this->dDesTipDocAso = substr($dDesTipDocAso, 0, 11);
    }
    return $this;
  }


  /**
   * Set the value of dCdCDERef
   *
   * @param string $dCdCDERef
   *
   * @return self
   */
  public function setDCdCDERef(string $dCdCDERef): self
  {
    $this->dCdCDERef = $dCdCDERef;

    return $this;
  }


  /**
   * Set the value of dNTimDI
   *
   * @param int $dNTimDI
   *
   * @return self
   */
  public function setDNTimDI(int $dNTimDI): self
  {
    $this->dNTimDI = $dNTimDI;

    return $this;
  }


  /**
   * Set the value of dEstDocAso
   *
   * @param string $dEstDocAso
   *
   * @return self
   */
  public function setDEstDocAso(string $dEstDocAso): self
  {
    $this->dEstDocAso = $dEstDocAso;

    return $this;
  }


  /**
   * Set the value of dPExpDocAso
   *
   * @param string $dPExpDocAso
   *
   * @return self
   */
  public function setDPExpDocAso(string $dPExpDocAso): self
  {
    $this->dPExpDocAso = $dPExpDocAso;

    return $this;
  }


  /**
   * Set the value of dNumDocAso
   *
   * @param string $dNumDocAso
   *
   * @return self
   */
  public function setDNumDocAso(string $dNumDocAso): self
  {
    $this->dNumDocAso = $dNumDocAso;

    return $this;
  }


  /**
   * Set the value of iTipoDocAso
   *
   * @param int $iTipoDocAso
   *
   * @return self
   */
  public function setITipoDocAso(int $iTipoDocAso): self
  {
    $this->iTipoDocAso = $iTipoDocAso;
    switch ($this->iTipDocAso) {
      case 1:
        $this->setDDTipoDocAso("Factura");
        break;
      case 2:
        $this->setDDTipoDocAso("Nota de crédito");
        break;
      case 3:
        $this->setDDTipoDocAso("Nota de débito");
        break;
      case 4:
        $this->setDDTipoDocAso("Nota de remisión");
        break;
      case 5:
        $this->setDDTipoDocAso("Comprobante de retención");
        break;
      default:
        throw new \Exception("Invalid iTipoDocAso: $iTipoDocAso");
        break;
    }
    return $this;
  }

  /**
   * Set the value of dDTipoDocAso
   * 
   * @param string $dDTipoDocAso
   * 
   * @return self
   */
  public function setDDTipoDocAso(string $dDTipoDocAso): self
  {
    if(is_null($dDTipoDocAso) || strlen($dDTipoDocAso) == 0)
    {
      $this->dDesTipDocAso = null;
    }
    else
    {
      $this->dDesTipDocAso = substr($dDTipoDocAso, 0, 16);
    }
    return $this;
  }


  /**
   * Set the value of dFecEmiDI
   *
   * @param DateTime $dFecEmiDI
   *
   * @return self
   */
  public function setDFecEmiDI(DateTime $dFecEmiDI): self
  {
    $this->dFecEmiDI = $dFecEmiDI;

    return $this;
  }


  /**
   * Set the value of dNumComRet
   *
   * @param string $dNumComRet
   *
   * @return self
   */
  public function setDNumComRet(string $dNumComRet): self
  {
    $this->dNumComRet = $dNumComRet;

    return $this;
  }


  /**
   * Set the value of dNumResCF
   *
   * @param string $dNumResCF
   *
   * @return self
   */
  public function setDNumResCF(string $dNumResCF): self
  {
    $this->dNumResCF = $dNumResCF;

    return $this;
  }

  /**
   * Set the value of iTipCons
   *
   * @param int $iTipCons
   *
   * @return self
   */
  public function setITipCons(int $iTipCons): self
  {
    $this->iTipCons = $iTipCons;
    switch ($this->iTipCons) {
      case 1:
        $this->setDDesTipCons("Constancia de no ser contribuyente");
        break;
      case 2:
        $this->setDDesTipCons("Constancia de microproductores");
        break;
      default:
        throw new \Exception("Invalid iTipCons: $iTipCons");
        break;
    }
    return $this;
  }

  /**
   * Set the value of dDesTipCons
   * 
   * @param string $dDesTipCons
   * 
   * @return self
   */
  public function setDDesTipCons(string $dDesTipCons): self
  {
    if(is_null($dDesTipCons) || strlen($dDesTipCons) == 0)
    {
      $this->dDesTipCons = null;
    }
    else
    {
      $this->dDesTipCons = substr($dDesTipCons, 0, 34);
    }
    return $this;
  }


  /**
   * Set the value of dNumCons
   *
   * @param int $dNumCons
   *
   * @return self
   */
  public function setDNumCons(int $dNumCons): self
  {
    $this->dNumCons = $dNumCons;

    return $this;
  }


  /**
   * Set the value of dNumControl
   *
   * @param string $dNumControl
   *
   * @return self
   */
  public function setDNumControl(string $dNumControl): self
  {
    $this->dNumControl = $dNumControl;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Get the value of iTipDocAso
   *
   * @return int
   */
  public function getITipDocAso(): int
  {
    return $this->iTipDocAso;
  }

  /**
   * Get the value of dDesTipDocAso
   *
   * @return string
   */
  public function getDDesTipDocAso(): string
  {
    return $this->dDesTipDocAso;
  }

  /**
   * Get the value of dCdCDERef
   *
   * @return string
   */
  public function getDCdCDERef(): string
  {
    return $this->dCdCDERef;
  }

  /**
   * Get the value of dNTimDI
   *
   * @return int
   */
  public function getDNTimDI(): int
  {
    return $this->dNTimDI;
  }  

  /**
   * Get the value of dEstDocAso
   *
   * @return string
   */
  public function getDEstDocAso(): string
  {
    return $this->dEstDocAso;
  }

  /**
   * Get the value of dPExpDocAso
   *
   * @return string
   */
  public function getDPExpDocAso(): string
  {
    return $this->dPExpDocAso;
  }

  /**
   * Get the value of dNumDocAso
   *
   * @return string
   */
  public function getDNumDocAso(): string
  {
    return $this->dNumDocAso;
  }

  /**
   * Get the value of iTipoDocAso
   *
   * @return int
   */
  public function getITipoDocAso(): int
  {
    return $this->iTipoDocAso;
  }

  /**
   * Get the value of dDTipoDocAso
   * 
   * @return string
   */
  public function getDDTipoDocAso(): string
  {
    return $this->dDTipoDocAso;
  }

  /**
   * Get the value of dFecEmiDI
   *
   * @return DateTime
   */
  public function getDFecEmiDI(): DateTime
  {
    return $this->dFecEmiDI;
  }

  /**
   * Get the value of dNumComRet
   *
   * @return string
   */
  public function getDNumComRet(): string
  {
    return $this->dNumComRet;
  }

  /**
   * Get the value of dNumResCF
   *
   * @return string
   */
  public function getDNumResCF(): string
  {
    return $this->dNumResCF;
  }

  /**
   * Get the value of iTipCons
   *
   * @return int
   */
  public function getITipCons(): int
  {
    return $this->iTipCons;
  }

  /**
   * Get the value of dDesTipCons
   *
   * @return string
   */
  public function getDDesTipCons(): string
  {
    return $this->dDesTipCons;
  }

  /**
   * Get the value of dNumCons
   *
   * @return int
   */
  public function getDNumCons(): int
  {
    return $this->dNumCons;
  }

  /**
   * Get the value of dNumControl
   *
   * @return string
   */
  public function getDNumControl(): string
  {
    return $this->dNumControl;
  }

  ///////////////////////////////////////////////////////////////////////
  // XML Element
  ///////////////////////////////////////////////////////////////////////

  /**
   * Instancia un objeto GCamDEAsoc a partir de un SimpleXMLElement
   * 
   * @param SimpleXMLElement $nodo
   * 
   * @return GCamDEAsoc
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $nodo): GCamDEAsoc
  {
    if(strcmp($nodo->getName(), 'gCamDEAsoc') != 0)
    {
      throw new \Exception("El nombre del nodo no es gCamDEAsoc");
    }
    $res = new GCamDEAsoc();
    $res->setITipDocAso(intval($nodo->iTipDocAso));
    $res->setDDesTipDocAso(strval($nodo->dDesTipDocAso));
    if(isset($nodo->dCdCDERef))
    {
      $res->setDCdCDERef(strval($nodo->dCdCDERef));
    }
    if(isset($nodo->dNTimDI))
    {
      $res->setDNTimDI(intval($nodo->dNTimDI));
    }
    if(isset($nodo->dEstDocAso))
    {
      $res->setDEstDocAso(strval($nodo->dEstDocAso));
    }
    if(isset($nodo->dPExpDocAso))
    {
      $res->setDPExpDocAso(strval($nodo->dPExpDocAso));
    }
    if(isset($nodo->dNumDocAso))
    {
      $res->setDNumDocAso(strval($nodo->dNumDocAso));
    }
    if(isset($nodo->iTipoDocAso))
    {
      $res->setITipoDocAso(intval($nodo->iTipoDocAso));
    }
    if(isset($nodo->dDTipoDocAso))
    {
      $res->setDDTipoDocAso(strval($nodo->dDTipoDocAso));
    }
    if(isset($nodo->dFecEmiDI))
    {
      $res->setDFecEmiDI(DateTime::createFromFormat('Y-m-d', strval($nodo->dFecEmiDI)));
    }
    if(isset($nodo->dNumComRet))
    {
      $res->setDNumComRet(strval($nodo->dNumComRet));
    }
    if(isset($nodo->dNumResCF))
    {
      $res->setDNumResCF(strval($nodo->dNumResCF));
    }
    if(isset($nodo->iTipCons))
    {
      $res->setITipCons(intval($nodo->iTipCons));
    }
    if(isset($nodo->dDesTipCons))
    {
      $res->setDDesTipCons(strval($nodo->dDesTipCons));
    }
    if(isset($nodo->dNumCons))
    {
      $res->setDNumCons(intval($nodo->dNumCons));
    }
    if(isset($nodo->dNumControl))
    {
      $res->setDNumControl(strval($nodo->dNumControl));
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
    $res = new DOMElement('gCamDEAsoc');
    $res->appendChild(new DOMElement('iTipDocAso', $this->getITipDocAso()));
    $res->appendChild(new DOMElement('dDesTipDocAso', $this->getDDesTipDocAso()));
    if ($this->iTipDocAso == 1) {
      $res->appendChild(new DOMElement('dCdCDERef', $this->getDCdCDERef()));
    }

    if ($this->iTipDocAso == 2) {
      $res->appendChild(new DOMElement('dNTimDI', $this->getDNTimDI()));
      $res->appendChild(new DOMElement('dEstDocAso', str_pad($this->dEstDocAso, 3, '0', STR_PAD_LEFT)));
      $res->appendChild(new DOMElement('dPExpDocAso', str_pad($this->dPExpDocAso, 3, '0', STR_PAD_LEFT)));
      $res->appendChild(new DOMElement('dNumDocAso', str_pad($this->dNumDocAso, 7, '0', STR_PAD_LEFT)));
      $res->appendChild(new DOMElement('iTipoDocAso', $this->getITipDocAso()));
      $res->appendChild(new DOMElement('dDTipoDocAso', $this->getDDTipoDocAso()));
    }

    if (isset($this->dNTimDI)) {
      $res->appendChild(new DOMElement('dFecEmiDI', $this->getDFecEmiDI()->format('Y-m-d')));
    }

    $res->appendChild(new DOMElement('dNumComRet', $this->getDNumComRet()));
    $res->appendChild(new DOMElement('dNumResCF', $this->getDNumResCF()));

    if ($this->iTipDocAso == 3) {
      $res->appendChild(new DOMElement('iTipCons', $this->getITipCons()));
      $res->appendChild(new DOMElement('dDesTipCons', $this->getDDesTipCons()));
    }

    if ($this->iTipDocAso == 3 && $this->iTipCons == 2) {
      $res->appendChild(new DOMElement('dNumCons', $this->getDNumCons()));
      $res->appendChild(new DOMElement('dNumControl', $this->getDNumControl()));
    }

    return $res;
  }

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return GCamDEAsoc
  //  */
  // public static function fromDOMElement(DOMElement $xml): GCamDEAsoc
  // {
  //   if (strcmp($xml->tagName, 'gCamDEAsoc') == 0 && $xml->childElementCount >= 4) {
  //     $res = new GCamDEAsoc();
  //     $res->setITipDocAso(intval($xml->getElementsByTagName('iTipDocAso')->item(0)->nodeValue));
  //     $res->setDCdCDERef($xml->getElementsByTagName('dCdCDERef')->item(0)->nodeValue);
  //     $res->setDNTimDI(intval($xml->getElementsByTagName('dNTimDI')->item(0)->nodeValue));
  //     $res->setDEstDocAso($xml->getElementsByTagName('dStDocAso')->item(0)->nodeValue);
  //     $res->setDPExpDocAso($xml->getElementsByTagName('dPExpDocAso')->item(0)->nodeValue);
  //     $res->setDNumDocAso($xml->getElementsByTagName('dNumDocAso')->item(0)->nodeValue);
  //     $res->setITipDocAso(intval($xml->getElementsByTagName('iTipDocAso')->item(0)->nodeValue));
  //     $res->setDFecEmiDI(DateTime::createFromFormat('Y-m-d', $xml->getElementsByTagName('dFecEmDi')->item(0)->nodeValue));
  //     $res->setDNumComRet($xml->getElementsByTagName('dNumComRet')->item(0)->nodeValue);
  //     $res->setDNumResCF($xml->getElementsByTagName('dNumResCF')->item(0)->nodeValue);
  //     $res->setITipCons(intval($xml->getElementsByTagName('iTipCons')->item(0)->nodeValue));
  //     $res->setDNumCons(intval($xml->getElementsByTagName('dNumCons')->item(0)->nodeValue));
  //     $res->setDNumControl($xml->getElementsByTagName('dNumControl')->item(0)->nodeValue);

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
  public static function fromResponse($response): self
  {
    $res = new GCamDEAsoc();
    if(isset($response->iTipDocAso))
    {
      $res->setITipDocAso(intval($response->iTipDocAso));
    }
    if(isset($response->dCdCDERef))
    {
      $res->setDCdCDERef($response->dCdCDERef);
    }
    if(isset($response->dNTimDI))
    {
      $res->setDNTimDI(intval($response->dNTimDI));
    }
    if(isset($response->dEstDocAso))
    {
      $res->setDEstDocAso($response->dEstDocAso);
    }
    if(isset($response->dPExpDocAso))
    {
      $res->setDPExpDocAso($response->dPExpDocAso);
    }
    if(isset($response->dNumDocAso))
    {
      $res->setDNumDocAso(intval($response->dNumDocAso));
    }
    if(isset($response->iTipDocAso))
    {
      $res->setITipDocAso(intval($response->iTipDocAso));
    }
    if(isset($response->dFecEmiDI))
    {
      $res->setDFecEmiDI(DateTime::createFromFormat('Y-m-d', $response->dFecEmiDI));
    }
    if(isset($response->dNumComRet))
    {
      $res->setDNumComRet($response->dNumComRet);
    }
    if(isset($response->dNumResCF))
    {
      $res->setDNumResCF($response->dNumResCF);
    }
    if(isset($response->iTipCons))
    {
      $res->setITipCons(intval($response->iTipCons));
    }
    if(isset($response->dNumCons))
    {
      $res->setDNumCons(intval($response->dNumCons));
    }
    if(isset($response->dNumControl))
    {
      $res->setDNumControl($response->dNumControl);
    }
    
    return $res;
  }
}
