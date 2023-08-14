<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\F;

use DOMElement;

/**
 * ID:F001 Campos de subtotales y totales PADRE:A001 
 */
class GTotSub
{

  // TODO cambiar todo a Decimal
  
  public ?float $dSubExe = null; //F002 Subtotal de la operación exenta
  public ?float $dSubExo = null; //F003 Subtotal de la operación exonerada
  public ?float $dSub5 = null; ///F004 Subtotal de la operación con IVA incluido a la tasa 5%
  public ?float $dSub10 = null; ///F005 Subtotal de la  operación con IVA  incluido a la tasa 10%
  public ?float $dTotOpe = null; ///F008 dTotOpe Total Bruto de la operación 
  public ?float $dTotDesc = null; //F009 dTotDesc Total descuento particular por ítem
  public ?float $dTotDescGlotem = null; //F033 Total descuento global  por ítem
  public ?float $dTotAntItem = null; ///F034 Total Anticipo por ítem
  public ?float $dTotAnt = null; //F035 Total Anticipo global por ítem
  public ?float $dPorcDescTotal = null; ///F010 Porcentaje de descuento global sobre total de la operación
  public ?float $dDescTotal = null; ///F011 Total Descuentos de la operación 
  public ?float $dAnticipo = null; ///F012 Total Anticipos de la operación 
  public ?float $dRedon = null; ///F013 Redondeo de la  operación 
  public ?float $dComi = null; ///F025 Comisión de la operación
  public ?float $dTotGralOpe = null; ///F014 Total Neto de la operación
  public ?float $dIVA5 = null; ///F015 Liquidación del IVA a la tasa del 5%
  public ?float $dIVA10 = null; ///F016 Liquidación del IVA a la tasa del 10%
  public ?float $dLiqTotIVA5; ///F036 Liquidación total del IVA por redondeo a la tasa del 5%
  public ?float $dLiqTotIVA10 = null; /// F037Liquidación total del IVA por redondeo a la tasa del 10%
  public ?float $dIVAComi = null; ///F026 Liquidación total del IVA de la comisión
  public ?float $dTotIVA = null; //F017 Liquidación total del IVA 
  public ?float $dBaseGrav5 = null; //F018  Total base gravada al  5%
  public ?float $dBaseGrav10 = null; ///F019  Total base gravada 
  public ?float $dTBasGraIVA = null; //F020 Total de la base gravada de IVA
  public ?float $dTotalGs = null; /// F023 Total general de la operación en Guaraníes

  ///////////////////////////////////////////////////////////////////////
  ///SETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of dSubExe
   *
   * @param float $dSubExe
   *
   * @return self
   */
  public function setDSubExe(float $dSubExe): self
  {
    $this->dSubExe = $dSubExe;

    return $this;
  }


  /**
   * Set the value of dSubExo
   *
   * @param float $dSubExo
   *
   * @return self
   */
  public function setDSubExo(float $dSubExo): self
  {
    $this->dSubExo = $dSubExo;

    return $this;
  }


  /**
   * Set the value of dSub5
   *
   * @param float $dSub5
   *
   * @return self
   */
  public function setDSub5(float $dSub5): self
  {
    $this->dSub5 = $dSub5;

    return $this;
  }


  /**
   * Set the value of dSub10
   *
   * @param float $dSub10
   *
   * @return self
   */
  public function setDSub10(float $dSub10): self
  {
    $this->dSub10 = $dSub10;

    return $this;
  }


  /**
   * Set the value of dTotOpe
   *
   * @param float $dTotOpe
   *
   * @return self
   */
  public function setDTotOpe(float $dTotOpe): self
  {
    $this->dTotOpe = $dTotOpe;

    return $this;
  }


  /**
   * Set the value of dTotDesc
   *
   * @param float $dTotDesc
   *
   * @return self
   */
  public function setDTotDesc(float $dTotDesc): self
  {
    $this->dTotDesc = $dTotDesc;

    return $this;
  }


  /**
   * Set the value of dTotDescGlotem
   *
   * @param float $dTotDescGlotem
   *
   * @return self
   */
  public function setDTotDescGlotem(float $dTotDescGlotem): self
  {
    $this->dTotDescGlotem = $dTotDescGlotem;

    return $this;
  }


  /**
   * Set the value of dTotAntItem
   *
   * @param float $dTotAntItem
   *
   * @return self
   */
  public function setDTotAntItem(float $dTotAntItem): self
  {
    $this->dTotAntItem = $dTotAntItem;

    return $this;
  }


  /**
   * Set the value of dTotAnt
   *
   * @param float $dTotAnt
   *
   * @return self
   */
  public function setDTotAnt(float $dTotAnt): self
  {
    $this->dTotAnt = $dTotAnt;

    return $this;
  }


  /**
   * Set the value of dPorcDescTotal
   *
   * @param float $dPorcDescTotal
   *
   * @return self
   */
  public function setDPorcDescTotal(float $dPorcDescTotal): self
  {
    $this->dPorcDescTotal = $dPorcDescTotal;

    return $this;
  }


  /**
   * Set the value of dDescTotal
   *
   * @param float $dDescTotal
   *
   * @return self
   */
  public function setDDescTotal(float $dDescTotal): self
  {
    $this->dDescTotal = $dDescTotal;

    return $this;
  }


  /**
   * Set the value of dAnticipo
   *
   * @param float $dAnticipo
   *
   * @return self
   */
  public function setDAnticipo(float $dAnticipo): self
  {
    $this->dAnticipo = $dAnticipo;

    return $this;
  }


  /**
   * Set the value of dRedon
   *
   * @param float $dRedon
   *
   * @return self
   */
  public function setDRedon(float $dRedon): self
  {
    $this->dRedon = $dRedon;

    return $this;
  }


  /**
   * Set the value of dComi
   *
   * @param float $dComi
   *
   * @return self
   */
  public function setDComi(float $dComi): self
  {
    $this->dComi = $dComi;

    return $this;
  }


  /**
   * Set the value of dTotGralOpe
   *
   * @param float $dTotGralOpe
   *
   * @return self
   */
  public function setDTotGralOpe(float $dTotGralOpe): self
  {
    $this->dTotGralOpe = $dTotGralOpe;

    return $this;
  }


  /**
   * Set the value of dIVA5
   *
   * @param float $dIVA5
   *
   * @return self
   */
  public function setDIVA5(float $dIVA5): self
  {
    $this->dIVA5 = $dIVA5;

    return $this;
  }


  /**
   * Set the value of dIVA10
   *
   * @param float $dIVA10
   *
   * @return self
   */
  public function setDIVA10(float $dIVA10): self
  {
    $this->dIVA10 = $dIVA10;

    return $this;
  }


  /**
   * Set the value of dLiqTotIVA5
   *
   * @param float $dLiqTotIVA5
   *
   * @return self
   */
  public function setDLiqTotIVA5(float $dLiqTotIVA5): self
  {
    $this->dLiqTotIVA5 = $dLiqTotIVA5;

    return $this;
  }


  /**
   * Set the value of dLiqTotIVA10
   *
   * @param float $dLiqTotIVA10
   *
   * @return self
   */
  public function setDLiqTotIVA10(float $dLiqTotIVA10): self
  {
    $this->dLiqTotIVA10 = $dLiqTotIVA10;

    return $this;
  }


  /**
   * Set the value of dIVAComi
   *
   * @param float $dIVAComi
   *
   * @return self
   */
  public function setDIVAComi(float $dIVAComi): self
  {
    $this->dIVAComi = $dIVAComi;

    return $this;
  }


  /**
   * Set the value of dTotIVA
   *
   * @param float $dTotIVA
   *
   * @return self
   */
  public function setDTotIVA(float $dTotIVA): self
  {
    $this->dTotIVA = $dTotIVA;

    return $this;
  }


  /**
   * Set the value of dBaseGrav5
   *
   * @param float $dBaseGrav5
   *
   * @return self
   */
  public function setDBaseGrav5(float $dBaseGrav5): self
  {
    $this->dBaseGrav5 = $dBaseGrav5;

    return $this;
  }


  /**
   * Set the value of dTBasGraIVA
   *
   * @param float $dTBasGraIVA
   *
   * @return self
   */
  public function setDTBasGraIVA(float $dTBasGraIVA): self
  {
    $this->dTBasGraIVA = $dTBasGraIVA;

    return $this;
  }


  /**
   * Set the value of dTotalGs
   *
   * @param float $dTotalGs
   *
   * @return self
   */
  public function setDTotalGs(float $dTotalGs): self
  {
    $this->dTotalGs = $dTotalGs;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  ///GETTERS
  ///////////////////////////////////////////////////////////////////////


  /**
   * Get the value of dSubExe
   *
   * @return float
   */
  public function getDSubExe(): float | null
  {
    return $this->dSubExe;
  }

  /**
   * Get the value of dSubExo
   *
   * @return float
   */
  public function getDSubExo(): float | null
  {
    return $this->dSubExo;
  }

  /**
   * Get the value of dSub5
   *
   * @return float
   */
  public function getDSub5(): float | null
  {
    return $this->dSub5;
  }

  /**
   * Get the value of dSub10
   *
   * @return float
   */
  public function getDSub10(): float | null
  {
    return $this->dSub10;
  }

  /**
   * Get the value of dTotOpe
   *
   * @return float
   */
  public function getDTotOpe(): float | null
  {
    return $this->dSubExe + $this->dSubExo + $this->dSub5 + $this->dSub10;
  }

  /**
   * Get the value of dTotDesc
   *
   * @return float
   */
  public function getDTotDesc(): float | null
  {
    return $this->dTotDesc;
  }

  /**
   * Get the value of dTotDescGlotem
   *
   * @return float
   */
  public function getDTotDescGlotem(): float | null
  {
    return $this->dTotDescGlotem;
  }

  /**
   * Get the value of dTotAntItem
   *
   * @return float
   */
  public function getDTotAntItem(): float | null
  {
    return $this->dTotAntItem;
  }

  /**
   * Get the value of dTotAnt
   *
   * @return float
   */
  public function getDTotAnt(): float | null
  {
    return $this->dTotAnt;
  }

  /**
   * Get the value of dPorcDescTotal
   *
   * @return float
   */
  public function getDPorcDescTotal(): float | null
  {
    return $this->dPorcDescTotal;
  }

  /**
   * Get the value of dDescTotal
   *
   * @return float
   */
  public function getDDescTotal(): float | null
  {
    return $this->dDescTotal;
  }

  /**
   * Get the value of dAnticipo
   *
   * @return float
   */
  public function getDAnticipo(): float | null
  {
    return $this->dAnticipo;
  }

  /**
   * Get the value of dRedon
   *
   * @return float
   */
  public function getDRedon(): float | null
  {
    return $this->dRedon;
  }

  /**
   * Get the value of dComi
   *
   * @return float
   */
  public function getDComi(): float | null
  {
    return $this->dComi;
  }

  /**
   * Get the value of dTotGralOpe
   *
   * @return float
   */
  public function getDTotGralOpe(): float | null
  {
    return $this->dTotOpe - $this->dRedon + $this->dComi;
  }

  /**
   * Get the value of dIVA5
   *
   * @return float
   */
  public function getDIVA5(): float | null
  {
    return $this->dIVA5;
  }

  /**
   * Get the value of dIVA10
   *
   * @return float
   */
  public function getDIVA10(): float | null
  {
    return $this->dIVA10;
  }

  /**
   * Get the value of dLiqTotIVA5
   *
   * @return float
   */
  public function getDLiqTotIVA5(): float | null
  {
    return $this->dLiqTotIVA5;
  }

  /**
   * Get the value of dLiqTotIVA10
   *
   * @return float
   */
  public function getDLiqTotIVA10(): float | null
  {
    return $this->dLiqTotIVA10;
  }

  /**
   * Get the value of dIVAComi
   *
   * @return float
   */
  public function getDIVAComi(): float | null
  {
    return $this->dIVAComi;
  }

  /**
   * Get the value of dTotIVA
   *
   * @return float
   */
  public function getDTotIVA(): float | null
  {
    return $this->dTotIVA;
  }

  /**
   * Get the value of dBaseGrav5
   *
   * @return float
   */
  public function getDBaseGrav5(): float | null
  {
    return $this->dBaseGrav5;
  }

  /**
   * Get the value of dBaseGrav10
   *
   * @return float
   */
  public function getDBaseGrav10(): float | null
  {
    return $this->dBaseGrav10;
  }

  /**
   * Get the value of dTBasGraIVA
   *
   * @return float
   */
  public function getDTBasGraIVA(): float | null
  {
    return $this->dBaseGrav5 + $this->dBaseGrav10;
  }

  /**
   * Get the value of dTotalGs
   *
   * @return float
   */
  public function getDTotalGs(): float | null
  {
    return $this->dTotalGs;
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML Element  
  ///////////////////////////////////////////////////////////////////////

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('gTotSub');
    $res->appendChild(new DOMElement('dSubExe', $this->getDSubExe()));
    $res->appendChild(new DOMElement('dSubExo', $this->getDSubExo()));
    $res->appendChild(new DOMElement('dSub5', $this->getDSub5()));
    $res->appendChild(new DOMElement('dSub10', $this->getDSub10()));
    $res->appendChild(new DOMElement('dTotOpe', $this->getDTotOpe()));
    $res->appendChild(new DOMElement('dTotDesc', $this->getDTotDesc()));
    $res->appendChild(new DOMElement('dTotDescGlotem', $this->getDTotDescGlotem()));
    $res->appendChild(new DOMElement('dTotAntItem', $this->getDTotAntItem()));
    $res->appendChild(new DOMElement('dTotAnt', $this->getDTotAnt()));
    if (isset($this->dPorcDescTotal)) {
      $res->appendChild(new DOMElement('dPorcDescTotal', $this->getDPorcDescTotal()));
    } else {
      $res->appendChild(new DOMElement('dPorcDescTotal', 0));
    }
    $res->appendChild(new DOMElement('dDescTotal', $this->getDDescTotal()));
    $res->appendChild(new DOMElement('dAnticipo', $this->getDAnticipo()));
    $res->appendChild(new DOMElement('dRedon', $this->getDRedon())); ///SE Debe redondear dTotOpe con la logica que pide pdf
    $res->appendChild(new DOMElement('dComi', $this->getDComi()));
    $res->appendChild(new DOMElement('dTotGralOpe', $this->getDTotGralOpe()));
    $res->appendChild(new DOMElement('dIVA5', $this->getDIVA5()));
    $res->appendChild(new DOMElement('dIVA10', $this->getDIVA10()));
    $res->appendChild(new DOMElement('dLiqTotIVA5', $this->getDLiqTotIVA5()));
    $res->appendChild(new DOMElement('dLiqTotIVA10', $this->getDLiqTotIVA10()));
    $res->appendChild(new DOMElement('dIVAComi', $this->getDIVAComi()));
    $res->appendChild(new DOMElement('dTotIVA', $this->getDTotIVA()));
    $res->appendChild(new DOMElement('dBaseGrav5', $this->dBaseGrav5));
    $res->appendChild(new DOMElement('dBaseGrav10', $this->getDBaseGrav10()));
    $res->appendChild(new DOMElement('dTBasGraIVA', $this->getDTBasGraIVA()));
    $res->appendChild(new DOMElement('dTotalGs', $this->getDTotalGs())); //////leer la logica del pdf de Mordor
    return $res;
  }

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return GTotSub
  //  */
  // public static function fromDOMElement(DOMElement $xml): GTotSub
  // {
  //   if (strcmp($xml->tagName, 'gTotSub') == 0 && $xml->childElementCount == 25) {
  //     $res = new GTotSub();
  //     $res->setDSubExe(floatval($xml->getElementsByTagName('dSubExe')->item(0)->nodeValue));
  //     $res->setDSubExo(floatval($xml->getElementsByTagName('dSubEx')->item(0)->nodeValue));
  //     $res->setDSub5(floatval($xml->getElementsByTagName('dSub5')->item(0)->nodeValue));
  //     $res->setDSub10(floatval($xml->getElementsByTagName('dSub10')->item(0)->nodeValue));
  //     $res->setDTotOpe(floatval($xml->getElementsByTagName('dTotOpe')->item(0)->nodeValue));
  //     $res->setDTotDesc(floatval($xml->getElementsByTagName('dTotDesc')->item(0)->nodeValue));
  //     $res->setDTotDescGlotem(floatval($xml->getElementsByTagName('dTotDescGlotem')->item(0)->nodeValue));
  //     $res->setDTotAntItem(floatval($xml->getElementsByTagName('dTotAntItem')->item(0)->nodeValue));
  //     $res->setDTotAnt(floatval($xml->getElementsByTagName('dTotAnt')->item(0)->nodeValue));
  //     $res->setDPorcDescTotal(floatval($xml->getElementsByTagName('dPorcDescTotal')->item(0)->nodeValue));
  //     $res->setDPorcDescTotal(floatval($xml->getElementsByTagName('dPorcDesc')->item(0)->nodeValue));
  //     $res->setDDescTotal(floatval($xml->getElementsByTagName('dDesc')->item(0)->nodeValue));
  //     $res->setDAnticipo(floatval($xml->getElementsByTagName('dAnticipo')->item(0)->nodeValue));
  //     $res->setDRedon(floatval($xml->getElementsByTagName('dRedon')->item(0)->nodeValue));
  //     $res->setDComi(floatval($xml->getElementsByTagName('dComi')->item(0)->nodeValue));
  //     $res->setDTotGralOpe(floatval($xml->getElementsByTagName('dTotGralOpe')->item(0)->nodeValue));
  //     $res->setDIVA5(floatval($xml->getElementsByTagName('dIVA5')->item(0)->nodeValue));
  //     $res->setDIVA10(floatval($xml->getElementsByTagName('dIVA10')->item(0)->nodeValue));
  //     $res->setDLiqTotIVA5(floatval($xml->getElementsByTagName('dLiqTotIVA5')->item(0)->nodeValue));
  //     $res->setDLiqTotIVA10(floatval($xml->getElementsByTagName('dLiqTotIVA10')->item(0)->nodeValue));
  //     $res->setDIVAComi(floatval($xml->getElementsByTagName('dIVAComi')->item(0)->nodeValue));
  //     $res->setDTotIVA(floatval($xml->getElementsByTagName('dTotIVA')->item(0)->nodeValue));
  //     $res->setDBaseGrav5(floatval($xml->getElementsByTagName('dBaseGrav5')->item(0)->nodeValue));
  //     $res->setDBaseGrav10(floatval($xml->getElementsByTagName('dBaseGrav10')->item(0)->nodeValue));
  //     $res->setDTbasGraIVA(floatval($xml->getElementsByTagName('dTBaseGraIVA')->item(0)->nodeValue));
  //     $res->setDTotalGs(floatval($xml->getElementsByTagName('dTotalGs')->item(0)->nodeValue));
  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }


  /**
   * Set the value of dBaseGrav10
   *
   * @param float $dBaseGrav10
   *
   * @return self
   */
  public function setDBaseGrav10(float $dBaseGrav10): self
  {
    $this->dBaseGrav10 = $dBaseGrav10;

    return $this;
  }

  /**
   * fromResponse
   *
   * @param  mixed $response
   * @return self
   */
  public static function fromResponse($response): self
  {


    $res = new GTotSub();
    if (isset($response->dSubExe)) {
      $res->setDSubExe(floatval($response->dSubExe));
    }
    if (isset($response->dSubEx)) {
      $res->setDSubExo(floatval($response->dSubEx));
    }
    if (isset($response->dSub5)) {
      $res->setDSub5(floatval($response->dSub5));
    }
    if (isset($response->dSub10)) {
      $res->setDSub10(floatval($response->dSub10));
    }
    if (isset($response->dTotOpe)) {
      $res->setDTotOpe(floatval($response->dTotOpe));
    }
    if (isset($response->dTotDesc)) {
      $res->setDTotDesc(floatval($response->dTotDesc));
    }
    if (isset($response->dTotDescGlotem)) {
      $res->setDTotDescGlotem(floatval($response->dTotDescGlotem));
    }
    if (isset($response->dTotAntItem)) {
      $res->setDTotAntItem(floatval($response->dTotAntItem));
    }
    if (isset($response->dTotAnt)) {
      $res->setDTotAnt(floatval($response->dTotAnt));
    }
    if (isset($response->dPorcDescTotal)) {
      $res->setDPorcDescTotal(floatval($response->dPorcDescTotal));
    }
    if (isset($response->dPorcDesc)) {
      $res->setDPorcDescTotal(floatval($response->dPorcDesc));
    }
    if (isset($response->dDesc)) {
      $res->setDDescTotal(floatval($response->dDesc));
    }
    if (isset($response->dAnticipo)) {
      $res->setDAnticipo(floatval($response->dAnticipo));
    }
    if (isset($response->dRedon)) {
      $res->setDRedon(floatval($response->dRedon));
    }
    if (isset($response->dComi)) {
      $res->setDComi(floatval($response->dComi));
    }
    if (isset($response->dTotGralOpe)) {
      $res->setDTotGralOpe(floatval($response->dTotGralOpe));
    }
    if (isset($response->dIVA5)) {
      $res->setDIVA5(floatval($response->dIVA5));
    }
    if (isset($response->dIVA10)) {
      $res->setDIVA10(floatval($response->dIVA10));
    }
    if (isset($response->dLiqTotIVA5)) {
      $res->setDLiqTotIVA5(floatval($response->dLiqTotIVA5));
    }
    if (isset($response->dLiqTotIVA10)) {
      $res->setDLiqTotIVA10(floatval($response->dLiqTotIVA10));
    }
    if (isset($response->dIVAComi)) {
      $res->setDIVAComi(floatval($response->dIVAComi));
    }
    if (isset($response->dTotIVA)) {
      $res->setDTotIVA(floatval($response->dTotIVA));
    }
    if (isset($response->dBaseGrav5)) {
      $res->setDBaseGrav5(floatval($response->dBaseGrav5));
    }
    if (isset($response->dBaseGrav10)) {
      $res->setDBaseGrav10(floatval($response->dBaseGrav10));
    }
    if (isset($response->dTBaseGraIVA)) {
      $res->setDTbasGraIVA(floatval($response->dTBaseGraIVA));
    }
    if (isset($response->dTotalGs)) {
      $res->setDTotalGs(floatval($response->dTotalGs));
    }
    
    return $res;
  }
}
