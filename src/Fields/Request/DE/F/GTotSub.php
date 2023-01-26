<?php

namespace Abiliomp\Pkuatia\Fields\F;

use DOMElement;

/**
 * ID:F001 Campos de subtotales y totales PADRE:A001 
 */
class GTotSub
{
  public int $dSubExe; //F002 Subtotal de la operación exenta
  public int $dSubExo; //F003 Subtotal de la operación exonerada
  public int $dSub5; ///F004 Subtotal de la operación con IVA incluido a la tasa 5%
  public int $dSub10; ///F005 Subtotal de la  operación con IVA  incluido a la tasa 10%
  public int $dTotOpe; ///F008 dTotOpe Total Bruto de la operación 
  public int $dTotDesc; //F009 dTotDesc Total descuento particular por ítem
  public int $dTotDescGlotem; //F033 Total descuento global  por ítem
  public int $dTotAntItem; ///F034 Total Anticipo por ítem
  public int $dTotAnt; //F035 Total Anticipo global por ítem
  public int $dPorcDescTotal; ///F010 Porcentaje de descuento global sobre total de la operación
  public int $dDescTotal; ///F011 Total Descuentos de la operación 
  public int $dAnticipo; ///F012 Total Anticipos de la operación 
  public int $dRedon; ///F013 Redondeo de la  operación 
  public int $dComi; ///F025 Comisión de la operación
  public int $dTotGralOpe; ///F014 Total Neto de la operación
  public int $dIVA5; ///F015 Liquidación del IVA a la tasa del 5%
  public int $dIVA10; ///F016 Liquidación del IVA a la tasa del 10%
  public int $dLiqTotIVA5; ///F036 Liquidación total del IVA por redondeo a la tasa del 5%
  public int $dLiqTotIVA10; /// F037Liquidación total del IVA por redondeo a la tasa del 10%
  public int $dIVAComi; ///F026 Liquidación total del IVA de la comisión
  public int $dTotIVA; //F017 Liquidación total del IVA 
  public int $dBaseGrav5; //F018  Total base gravada al  5%
  public int $dBaseGrav10; ///F019  Total base gravada 
  public int $dTBasGraIVA; //F020 Total de la base gravada de IVA
  public int $dTotalGs; /// F023 Total general de la operación en Guaraníes

   //====================================================//
  ///SETTERS
   //====================================================//

  /**
   * Set the value of dSubExe
   *
   * @param int $dSubExe
   *
   * @return self
   */
  public function setDSubExe(int $dSubExe): self
  {
    $this->dSubExe = $dSubExe;

    return $this;
  }


  /**
   * Set the value of dSubExo
   *
   * @param int $dSubExo
   *
   * @return self
   */
  public function setDSubExo(int $dSubExo): self
  {
    $this->dSubExo = $dSubExo;

    return $this;
  }


  /**
   * Set the value of dSub5
   *
   * @param int $dSub5
   *
   * @return self
   */
  public function setDSub5(int $dSub5): self
  {
    $this->dSub5 = $dSub5;

    return $this;
  }


  /**
   * Set the value of dSub10
   *
   * @param int $dSub10
   *
   * @return self
   */
  public function setDSub10(int $dSub10): self
  {
    $this->dSub10 = $dSub10;

    return $this;
  }


  /**
   * Set the value of dTotOpe
   *
   * @param int $dTotOpe
   *
   * @return self
   */
  public function setDTotOpe(int $dTotOpe): self
  {
    $this->dTotOpe = $dTotOpe;

    return $this;
  }


  /**
   * Set the value of dTotDesc
   *
   * @param int $dTotDesc
   *
   * @return self
   */
  public function setDTotDesc(int $dTotDesc): self
  {
    $this->dTotDesc = $dTotDesc;

    return $this;
  }


  /**
   * Set the value of dTotDescGlotem
   *
   * @param int $dTotDescGlotem
   *
   * @return self
   */
  public function setDTotDescGlotem(int $dTotDescGlotem): self
  {
    $this->dTotDescGlotem = $dTotDescGlotem;

    return $this;
  }


  /**
   * Set the value of dTotAntItem
   *
   * @param int $dTotAntItem
   *
   * @return self
   */
  public function setDTotAntItem(int $dTotAntItem): self
  {
    $this->dTotAntItem = $dTotAntItem;

    return $this;
  }


  /**
   * Set the value of dTotAnt
   *
   * @param int $dTotAnt
   *
   * @return self
   */
  public function setDTotAnt(int $dTotAnt): self
  {
    $this->dTotAnt = $dTotAnt;

    return $this;
  }


  /**
   * Set the value of dPorcDescTotal
   *
   * @param int $dPorcDescTotal
   *
   * @return self
   */
  public function setDPorcDescTotal(int $dPorcDescTotal): self
  {
    $this->dPorcDescTotal = $dPorcDescTotal;

    return $this;
  }


  /**
   * Set the value of dDescTotal
   *
   * @param int $dDescTotal
   *
   * @return self
   */
  public function setDDescTotal(int $dDescTotal): self
  {
    $this->dDescTotal = $dDescTotal;

    return $this;
  }


  /**
   * Set the value of dAnticipo
   *
   * @param int $dAnticipo
   *
   * @return self
   */
  public function setDAnticipo(int $dAnticipo): self
  {
    $this->dAnticipo = $dAnticipo;

    return $this;
  }


  /**
   * Set the value of dRedon
   *
   * @param int $dRedon
   *
   * @return self
   */
  public function setDRedon(int $dRedon): self
  {
    $this->dRedon = $dRedon;

    return $this;
  }


  /**
   * Set the value of dComi
   *
   * @param int $dComi
   *
   * @return self
   */
  public function setDComi(int $dComi): self
  {
    $this->dComi = $dComi;

    return $this;
  }


  /**
   * Set the value of dTotGralOpe
   *
   * @param int $dTotGralOpe
   *
   * @return self
   */
  public function setDTotGralOpe(int $dTotGralOpe): self
  {
    $this->dTotGralOpe = $dTotGralOpe;

    return $this;
  }


  /**
   * Set the value of dIVA5
   *
   * @param int $dIVA5
   *
   * @return self
   */
  public function setDIVA5(int $dIVA5): self
  {
    $this->dIVA5 = $dIVA5;

    return $this;
  }


  /**
   * Set the value of dIVA10
   *
   * @param int $dIVA10
   *
   * @return self
   */
  public function setDIVA10(int $dIVA10): self
  {
    $this->dIVA10 = $dIVA10;

    return $this;
  }


  /**
   * Set the value of dLiqTotIVA5
   *
   * @param int $dLiqTotIVA5
   *
   * @return self
   */
  public function setDLiqTotIVA5(int $dLiqTotIVA5): self
  {
    $this->dLiqTotIVA5 = $dLiqTotIVA5;

    return $this;
  }


  /**
   * Set the value of dLiqTotIVA10
   *
   * @param int $dLiqTotIVA10
   *
   * @return self
   */
  public function setDLiqTotIVA10(int $dLiqTotIVA10): self
  {
    $this->dLiqTotIVA10 = $dLiqTotIVA10;

    return $this;
  }


  /**
   * Set the value of dIVAComi
   *
   * @param int $dIVAComi
   *
   * @return self
   */
  public function setDIVAComi(int $dIVAComi): self
  {
    $this->dIVAComi = $dIVAComi;

    return $this;
  }


  /**
   * Set the value of dTotIVA
   *
   * @param int $dTotIVA
   *
   * @return self
   */
  public function setDTotIVA(int $dTotIVA): self
  {
    $this->dTotIVA = $dTotIVA;

    return $this;
  }


  /**
   * Set the value of dBaseGrav5
   *
   * @param int $dBaseGrav5
   *
   * @return self
   */
  public function setDBaseGrav5(int $dBaseGrav5): self
  {
    $this->dBaseGrav5 = $dBaseGrav5;

    return $this;
  }


  /**
   * Set the value of dTBasGraIVA
   *
   * @param int $dTBasGraIVA
   *
   * @return self
   */
  public function setDTBasGraIVA(int $dTBasGraIVA): self
  {
    $this->dTBasGraIVA = $dTBasGraIVA;

    return $this;
  }


  /**
   * Set the value of dTotalGs
   *
   * @param int $dTotalGs
   *
   * @return self
   */
  public function setDTotalGs(int $dTotalGs): self
  {
    $this->dTotalGs = $dTotalGs;

    return $this;
  }

   //====================================================//
  ///GETTERS
   //====================================================//


  /**
   * Get the value of dSubExe
   *
   * @return int
   */
  public function getDSubExe(): int
  {
    return $this->dSubExe;
  }

  /**
   * Get the value of dSubExo
   *
   * @return int
   */
  public function getDSubExo(): int
  {
    return $this->dSubExo;
  }

  /**
   * Get the value of dSub5
   *
   * @return int
   */
  public function getDSub5(): int
  {
    return $this->dSub5;
  }

  /**
   * Get the value of dSub10
   *
   * @return int
   */
  public function getDSub10(): int
  {
    return $this->dSub10;
  }

  /**
   * Get the value of dTotOpe
   *
   * @return int
   */
  public function getDTotOpe(): int
  {
    return $this->dSubExe + $this->dSubExo + $this->dSub5 + $this->dSub10;
  }

  /**
   * Get the value of dTotDesc
   *
   * @return int
   */
  public function getDTotDesc(): int
  {
    return $this->dTotDesc;
  }

  /**
   * Get the value of dTotDescGlotem
   *
   * @return int
   */
  public function getDTotDescGlotem(): int
  {
    return $this->dTotDescGlotem;
  }

  /**
   * Get the value of dTotAntItem
   *
   * @return int
   */
  public function getDTotAntItem(): int
  {
    return $this->dTotAntItem;
  }

  /**
   * Get the value of dTotAnt
   *
   * @return int
   */
  public function getDTotAnt(): int
  {
    return $this->dTotAnt;
  }

  /**
   * Get the value of dPorcDescTotal
   *
   * @return int
   */
  public function getDPorcDescTotal(): int
  {
    return $this->dPorcDescTotal;
  }

  /**
   * Get the value of dDescTotal
   *
   * @return int
   */
  public function getDDescTotal(): int
  {
    return $this->dDescTotal;
  }

  /**
   * Get the value of dAnticipo
   *
   * @return int
   */
  public function getDAnticipo(): int
  {
    return $this->dAnticipo;
  }

  /**
   * Get the value of dRedon
   *
   * @return int
   */
  public function getDRedon(): int
  {
    return $this->dRedon;
  }

  /**
   * Get the value of dComi
   *
   * @return int
   */
  public function getDComi(): int
  {
    return $this->dComi;
  }

  /**
   * Get the value of dTotGralOpe
   *
   * @return int
   */
  public function getDTotGralOpe(): int
  {
    return $this->dTotOpe - $this->dRedon + $this->dComi;
  }

  /**
   * Get the value of dIVA5
   *
   * @return int
   */
  public function getDIVA5(): int
  {
    return $this->dIVA5;
  }

  /**
   * Get the value of dIVA10
   *
   * @return int
   */
  public function getDIVA10(): int
  {
    return $this->dIVA10;
  }

  /**
   * Get the value of dLiqTotIVA5
   *
   * @return int
   */
  public function getDLiqTotIVA5(): int
  {
    return $this->dLiqTotIVA5;
  }

  /**
   * Get the value of dLiqTotIVA10
   *
   * @return int
   */
  public function getDLiqTotIVA10(): int
  {
    return $this->dLiqTotIVA10;
  }

  /**
   * Get the value of dIVAComi
   *
   * @return int
   */
  public function getDIVAComi(): int
  {
    return $this->dIVAComi;
  }

  /**
   * Get the value of dTotIVA
   *
   * @return int
   */
  public function getDTotIVA(): int
  {
    return $this->dTotIVA;
  }

  /**
   * Get the value of dBaseGrav5
   *
   * @return int
   */
  public function getDBaseGrav5(): int
  {
    return $this->dBaseGrav5;
  }

  /**
   * Get the value of dBaseGrav10
   *
   * @return int
   */
  public function getDBaseGrav10(): int
  {
    return $this->dBaseGrav10;
  }

  /**
   * Get the value of dTBasGraIVA
   *
   * @return int
   */
  public function getDTBasGraIVA(): int
  {
    return $this->dBaseGrav5 + $this->dBaseGrav10;
  }

  /**
   * Get the value of dTotalGs
   *
   * @return int
   */
  public function getDTotalGs(): int
  {
    return $this->dTotalGs;
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
    $res->appendChild(new DOMElement('dRedon', $this->getDRedon()));///SE Debe redondear dTotOpe con la logica que pide pdf
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
    $res->appendChild(new DOMElement('dTotalGs', $this->getDTotalGs()));//////leer la logica del pdf de Mordor
    return $res;
  }
}
