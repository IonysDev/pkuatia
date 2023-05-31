<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\H;

use DateTime;
use DOMElement;

/**
 * ID:H001 Campos que identifican al DE asociado PADRE:A001
 */
class GCamDEAsoc
{
  public ?int $iTipDocAso = null; ///H002 Tipo de documento asociado
  public ?string $dCdCDERef = null; ///H004 CDC del DTE referenciado
  public ?int $dNTimDI = null; ///H005 Nro. timbrado documento impreso de referencia
  public ?string $dEstDocAso = null; ///H006 Establecimiento
  public ?string $dPExpDocAso = null; ///H007 Punto de expedición
  public ?string $dNumDocAso = null; ///H008 Número del documento
  public ?int $iTipoDocAso = null; ///H009 Tipo de documento  impreso
  public ?DateTime $dFecEmiDI = null; ///H011 Fecha de emisión del documento impreso de referencia
  public ?string $dNumComRet = null; /// H012  Número de comprobante de retención
  public ?string $dNumResCF = null; /// H013 Número de resolución de crédito fiscal
  public ?int $iTipCons = null; //H014 Tipo de constancia
  public ?int $dNumCons = null; //H016 Número de constancia 
  public ?string $dNumControl = null; ///H017 Número de control de la constancia 

  //====================================================//
  ///SETTERS
  //====================================================//

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

  //====================================================//
  ///GETTERS
  //====================================================//

  /**
   * Get the value of iTipDocAso
   *
   * @return int
   */
  public function getITipDocAso(): int | null
  {
    return $this->iTipDocAso;
  }

  /**
   * Get the value of dNTimDI
   *
   * @return int
   */
  public function getDNTimDI(): int | null
  {
    return $this->dNTimDI;
  }


  /**
   * H003  Descripción del tipo de documento asociado 
   *
   * @return string
   */
  public function getDDesTipDocAso(): string | null
  {
    switch ($this->iTipDocAso) {
      case 1:
        return "Electrónico";
        break;
      case 2:
        return "Impreso";
        break;
      case 3:
        return "Constancia Electrónica";
        break;

      default:
        return null;
        break;
    }
  }



  /**
   * Get the value of dCdCDERef
   *
   * @return string
   */
  public function getDCdCDERef(): string | null
  {
    return $this->dCdCDERef;
  }

  /**
   * Get the value of dEstDocAso
   *
   * @return string
   */
  public function getDEstDocAso(): string | null
  {
    return $this->dEstDocAso;
  }

  /**
   * Get the value of dPExpDocAso
   *
   * @return string
   */
  public function getDPExpDocAso(): string | null
  {
    return $this->dPExpDocAso;
  }

  /**
   * Get the value of dNumDocAso
   *
   * @return string
   */
  public function getDNumDocAso(): string | null
  {
    return $this->dNumDocAso;
  }

  /**
   * Get the value of iTipoDocAso
   *
   * @return int
   */
  public function getITipoDocAso(): int | null
  {
    return $this->iTipoDocAso;
  }

  /**
   *  H010 Descripción del tipo de documento impreso
   *
   * @return string
   */
  public function getDDTipoDocAso(): string | null
  {
    switch ($this->iTipDocAso) {
      case 1:
        return "Factura";
        break;
      case 2:
        return "Nota de crédito";
        break;
      case 3:
        return "Nota de débito";
        break;
      case 4:
        return "Nota de remisión";
        break;
      case 5:
        return "Comprobante de retención";
        break;

      default:
        return null;
        break;
    }
  }



  /**
   * Get the value of dFecEmiDI
   *
   * @return DateTime
   */
  public function getDFecEmiDI(): DateTime | null
  {
    return $this->dFecEmiDI;
  }

  /**
   * Get the value of dNumComRet
   *
   * @return string
   */
  public function getDNumComRet(): string | null
  {
    return $this->dNumComRet;
  }

  /**
   * Get the value of dNumResCF
   *
   * @return string
   */
  public function getDNumResCF(): string | null
  {
    return $this->dNumResCF;
  }

  /**
   * Get the value of iTipCons
   *
   * @return int
   */
  public function getITipCons(): int | null
  {
    return $this->iTipCons;
  }

  /**
   * H015 Descripción del tipo de constancia
   *
   * @return string
   */
  public function getDDesTipCons(): string | null
  {
    switch ($this->iTipCons) {
      case 1:
        return "Constancia de no ser contribuyente";
        break;
      case 2:
        return "Constancia de microproductores";
        break;

      default:
        return null;
        break;
    }
  }



  /**
   * Get the value of dNumCons
   *
   * @return int
   */
  public function getDNumCons(): int | null
  {
    return $this->dNumCons;
  }

  /**
   * Get the value of dNumControl
   *
   * @return string
   */
  public function getDNumControl(): string | null
  {
    return $this->dNumControl;
  }

  //====================================================//
  ///XML Element
  //====================================================//

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
    $res->setITipDocAso(intval($response->iTipDocAso));
    $res->setDCdCDERef($response->dCdCDERef);
    $res->setDNTimDI(intval($response->dNTimDI));
    $res->setDEstDocAso($response->dStDocAso);
    $res->setDPExpDocAso($response->dPExpDocAso);
    $res->setDNumDocAso($response->dNumDocAso);
    $res->setITipDocAso(intval($response->iTipDocAso));
    $res->setDFecEmiDI(DateTime::createFromFormat('Y-m-d', $response->dFecEmDi));
    $res->setDNumComRet($response->dNumComRet);
    $res->setDNumResCF($response->dNumResCF);
    $res->setITipCons(intval($response->iTipCons));
    $res->setDNumCons(intval($response->dNumCons));
    $res->setDNumControl($response->dNumControl);
    return $res;
  }
}
