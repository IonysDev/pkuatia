<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\F;

use Abiliomp\Pkuatia\Utils\StringNumberFormatter;
use Abiliomp\Pkuatia\Utils\ValueValidations;
use DOMDocument;
use DOMElement;
use Exception;
use SimpleXMLElement;

/**
 * Nodo Id:     F001
 * Nombre:      gTotSub
 * Descripción: Campos de subtotales y totales 
 * Nodo Padre:  A001 - DE - Campos firmados del DE 
 */

class GTotSub
{
                                 // ID - Longitud - Ocurrencia - Descripción
  public String $dSubExe;        // F002 - 1-15p(0-8) - 0-1 - Subtotal de la operación exenta
  public String $dSubExo;        // F003 - 1-15p(0-8) - 0-1 - Subtotal de la operación exonerada
  public String $dSub5;          // F004 - 1-15p(0-8) - 0-1 - Subtotal de la operación con IVA incluido a la tasa 5%
  public String $dSub10;         // F005 - 1-15p(0-8) - 0-1 - Subtotal de la  operación con IVA  incluido a la tasa 10%
  public String $dTotOpe;        // F008 - 1-15p(0-8) - 1-1 - Total Bruto de la operación 
  public String $dTotDesc;       // F009 - 1-15p(0-8) - 1-1 - Total descuento particular por ítem
  public String $dTotDescGlotem; // F033 - 1-15p(0-8) - 1-1 - Total descuento global  por ítem
  public String $dTotAntItem;    // F034 - 1-15p(0-8) - 1-1 - Total Anticipo por ítem
  public String $dTotAnt;        // F035 - 1-15p(0-8) - 1-1 - Total Anticipo global por ítem
  public String $dPorcDescTotal; // F010 - 1-3p(0-8)  - 1-1 - Porcentaje de descuento global sobre total de la operación
  public String $dDescTotal;     // F011 - 1-15p(0-8) - 1-1 - Total Descuentos de la operación 
  public String $dAnticipo;      // F012 - 1-15p(0-8) - 1-1 - Total Anticipos de la operación 
  public String $dRedon;         // F013 - 1-3p(0-4)  - 1-1 - Redondeo de la operación 
  public String $dComi;          // F025 - 1-15p(0-8) - 0-1 - Comisión de la operación
  public String $dTotGralOpe;    // F014 - 1-15p(0-8) - 1-1 - Total Neto de la operación
  public String $dIVA5;          // F015 - 1-15p(0-8) - 0-1 - Liquidación del IVA a la tasa del 5%
  public String $dIVA10;         // F016 - 1-15p(0-8) - 0-1 - Liquidación del IVA a la tasa del 10%
  public String $dLiqTotIVA5;    // F036 - 1-15p(0-8) - 0-1 - Liquidación total del IVA por redondeo a la tasa del 5%
  public String $dLiqTotIVA10;   // F037 - 1-15p(0-8) - 0-1 - Liquidación total del IVA por redondeo a la tasa del 10%
  public String $dIVAComi;       // F026 - 1-15p(0-8) - 0-1 - Liquidación total del IVA de la comisión
  public String $dTotIVA;        // F017 - 1-15p(0-8) - 0-1 - Liquidación total del IVA 
  public String $dBaseGrav5;     // F018 - 1-15p(0-8) - 0-1 - Total base gravada al 5%
  public String $dBaseGrav10;    // F019 - 1-15p(0-8) - 0-1 - Total base gravada al 10%
  public String $dTBasGraIVA;    // F020 - 1-15p(0-8) - 0-1 - Total de la base gravada de IVA F018+F019 
  public String $dTotalGs;       // F023 - 1-15p(0-8) - 0-1 - Total general de la operación en Guaraníes
  // Representación de números como cadenas para trabajar con BCMath para evitar errores de redondeo o truncamiento

  /**
   * Constructor de la clase con valores por defecto:
   * - dTotOpe = 0
   * - dTotDesc = 0
   * - dTotDescGlotem = 0
   * - dTotAntItem = 0
   * - dTotAnt = 0
   * - dPorcDescTotal = 0
   * - dDescTotal = 0
   * - dAnticipo = 0
   * - dRedon = 0
   * - dTotGralOpe = 0
   */
  public function __construct()
  {
    // Solo incializar a 0 los campos que no son opcionales
    $this->dTotOpe = '0';
    $this->dTotDesc = '0';
    $this->dTotDescGlotem = '0';
    $this->dTotAntItem = '0';
    $this->dTotAnt = '0';
    $this->dPorcDescTotal = '0';
    $this->dDescTotal = '0';
    $this->dAnticipo = '0';
    $this->dRedon = '0';
    $this->dTotGralOpe = '0';
  }
  
  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de dSubExe que representa el subtotal de la operación exenta.
   *
   * @param String $dSubExe El valor del subtotal de la operación exenta expresado en cadena numérica de caracteres.
   *
   * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
   */
  public function setDSubExe(String $dSubExe): self
  {
    $newVal = trim($dSubExe);
    if(!ValueValidations::isValidStringDecimal($newVal, 15, 0, 8))
      throw new \Exception("Valor no válido para el campo dSubExe: $newVal");
    $this->dSubExe = $newVal;
    return $this;
  }


  /**
   * Establece el valor de dSubExo que representa el subtotal de la operación exonerada.
   *
   * @param String $dSubExo El valor del subtotal de la operación exonerada expresado en cadena numérica de caracteres.
   *
   * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
   */
  public function setDSubExo(String $dSubExo): self
  {
    $newVal = trim($dSubExo);
    if(!ValueValidations::isValidStringDecimal($newVal, 15, 0, 8))
      throw new \Exception("Valor no válido para el campo dSubExo: $newVal");
    $this->dSubExo = $newVal;
    return $this;
  }


  /**
   * Establece el valor de dSub5 que representa el subtotal de la operación con IVA incluido a la tasa 5%.
   *
   * @param String $dSub5 El valor del subtotal de la operación con IVA incluido a la tasa 5% expresado en cadena numérica de caracteres.
   *
   * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
   */
  public function setDSub5(String $dSub5): self
  {
    $newVal = trim($dSub5);
    if(!ValueValidations::isValidStringDecimal($newVal, 15, 0, 8))
      throw new \Exception("Valor no válido para el campo dSub5: $newVal");
    $this->dSub5 = $newVal;
    return $this;
  }


  /**
   * Establece el valor de dSub10 que representa el subtotal de la operación con IVA incluido a la tasa 10%.
   *
   * @param String $dSub10 El valor del subtotal de la operación con IVA incluido a la tasa 10% expresado en cadena numérica de caracteres.
   *
   * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
   */
  public function setDSub10(String $dSub10): self
  {
    $newVal = trim($dSub10);
    if(!ValueValidations::isValidStringDecimal($newVal, 15, 0, 8))
      throw new \Exception("Valor no válido para el campo dSub10: $newVal");
    $this->dSub10 = $newVal;
    return $this;
  }


  /**
   * Establece el valor de dTotOpe que representa el total bruto de la operación.
   *
   * @param String $dTotOpe El valor del total bruto de la operación expresado en cadena numérica de caracteres.
   *
   * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
   */
  public function setDTotOpe(String $dTotOpe): self
  {
    $newVal = trim($dTotOpe);
    if(!ValueValidations::isValidStringDecimal($newVal, 15, 0, 8))
      throw new \Exception("Valor no válido para el campo dTotOpe: $newVal");
    $this->dTotOpe = $newVal;
    return $this;
  }


  /**
   * Establece el valor de dTotDesc que representa el total descuento particular por ítem.
   *
   * @param String $dTotDesc El valor del total descuento particular por ítem expresado en cadena numérica de caracteres.
   *
   * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
   */
  public function setDTotDesc(String $dTotDesc): self
  {
    $newVal = trim($dTotDesc);
    if(!ValueValidations::isValidStringDecimal($newVal, 15, 0, 8))
      throw new \Exception("Valor no válido para el campo dTotDesc: $newVal");
    $this->dTotDesc = $newVal;
    return $this;
  }


  /**
   * Establece el valor de dTotDescGlotem que representa el total descuento global por ítem.
   * 
   * @param String $dTotDescGlotem El valor del total descuento global por ítem expresado en cadena numérica de caracteres.
   *
   * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
   */
  public function setDTotDescGlotem(String $dTotDescGlotem): self
  {
    $newVal = trim($dTotDescGlotem);
    if(!ValueValidations::isValidStringDecimal($newVal, 15, 0, 8))
      throw new \Exception("Valor no válido para el campo dTotDescGlotem: $newVal");
    $this->dTotDescGlotem = $newVal;
    return $this;
  }


  /**
   * Establece el valor de dTotAntItem que representa el total anticipo por ítem.
   *
   * @param String $dTotAntItem El valor del total anticipo por ítem expresado en cadena numérica de caracteres.
   *
   * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
   */
  public function setDTotAntItem(String $dTotAntItem): self
  {
    $newVal = trim($dTotAntItem);
    if(!ValueValidations::isValidStringDecimal($newVal, 15, 0, 8))
      throw new \Exception("Valor no válido para el campo dTotAntItem: $newVal");
    $this->dTotAntItem = $newVal;
    return $this;
  }


  /**
   * Establece el valor de dTotAnt que representa el total anticipo global por ítem.
   *
   * @param String $dTotAnt El valor del total anticipo global por ítem expresado en cadena numérica de caracteres.
   *
   * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
   */
  public function setDTotAnt(String $dTotAnt): self
  {
    $newVal = trim($dTotAnt);
    if(!ValueValidations::isValidStringDecimal($newVal, 15, 0, 8))
      throw new \Exception("Valor no válido para el campo dTotAnt: $newVal");
    $this->dTotAnt = $newVal;
    return $this;
  }


  /**
   * Establece el valor de dPorcDescTotal que representa el porcentaje de descuento global sobre total de la operación.
   *
   * @param String $dPorcDescTotal El valor del porcentaje de descuento global sobre total de la operación expresado en cadena numérica de caracteres.
   *
   * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
   */
  public function setDPorcDescTotal(String $dPorcDescTotal): self
  {
    $newVal = trim($dPorcDescTotal);
    if(!ValueValidations::isValidStringDecimal($newVal, 3, 0, 8))
      throw new \Exception("Valor no válido para el campo dPorcDescTotal: $newVal");
    $this->dPorcDescTotal = $newVal;
    return $this;
  }


  /**
   * Establece el valor de dDescTotal que representa el total descuentos de la operación.
   *
   * @param String $dDescTotal El valor del total descuentos de la operación expresado en cadena numérica de caracteres.
   *
   * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
   */
  public function setDDescTotal(String $dDescTotal): self
  {
    $newVal = trim($dDescTotal);
    if(!ValueValidations::isValidStringDecimal($newVal, 15, 0, 8))
      throw new \Exception("Valor no válido para el campo dDescTotal: $newVal");
    $this->dDescTotal = $newVal;
    return $this;
  }


  /**
   * Establece el valor de dAnticipo que representa el total anticipos de la operación.
   *
   * @param String $dAnticipo El valor del total anticipos de la operación expresado en cadena numérica de caracteres.
   *
   * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
   */
  public function setDAnticipo(String $dAnticipo): self
  {
    $newVal = trim($dAnticipo);
    if(!ValueValidations::isValidStringDecimal($newVal, 15, 0, 8))
      throw new \Exception("Valor no válido para el campo dAnticipo: $newVal");
    $this->dAnticipo = $newVal;
    return $this;
  }


  /**
   * Establece el valor de dRedon que representa el redondeo de la operación.
   *
   * @param String $dRedon El valor del redondeo de la operación expresado en cadena numérica de caracteres.
   *
   * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
   */
  public function setDRedon(String $dRedon): self
  {
    $newVal = trim($dRedon);
    if(!ValueValidations::isValidStringDecimal($newVal, 3, 0))
      throw new \Exception("[GTotSub] Valor no válido para el campo dRedon: $newVal");
    $this->dRedon = $newVal;
    return $this;
  }


  /**
   * Establece el valor de dComi que representa la comisión de la operación.
   *
   * @param String $dComi El valor de la comisión de la operación expresado en cadena numérica de caracteres.
   *
   * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
   */
  public function setDComi(String $dComi): self
  {
    $newVal = trim($dComi);
    if(!ValueValidations::isValidStringDecimal($newVal, 15, 0, 8))
      throw new \Exception("Valor no válido para el campo dComi: $newVal");
    $this->dComi = $newVal;
    return $this;
  }


  /**
   * Establece el valor de dTotGralOpe que representa el total neto de la operación.
   *
   * @param String $dTotGralOpe El valor del total neto de la operación expresado en cadena numérica de caracteres.
   *
   * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
   */
  public function setDTotGralOpe(String $dTotGralOpe): self
  {
    $newVal = trim($dTotGralOpe);
    if(!ValueValidations::isValidStringDecimal($newVal, 15, 0, 8))
      throw new \Exception("Valor no válido para el campo dTotGralOpe: $newVal");
    $this->dTotGralOpe = $newVal;
    return $this;
  }


  /**
   * Establece el valor de dIVA5 que representa la liquidación del IVA a la tasa del 5%.
   *
   * @param String $dIVA5 El valor de la liquidación del IVA a la tasa del 5% expresado en cadena numérica de caracteres.
   *
   * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
   */
  public function setDIVA5(String $dIVA5): self
  {
    $newVal = trim($dIVA5);
    if(!ValueValidations::isValidStringDecimal($newVal, 15, 0, 8))
      throw new \Exception("Valor no válido para el campo dIVA5: $newVal");
    $this->dIVA5 = $newVal;
    return $this;
  }


  /**
   * Establece el valor de dIVA10 que representa la liquidación del IVA a la tasa del 10%.
   *
   * @param String $dIVA10
   *
   * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
   */
  public function setDIVA10(String $dIVA10): self
  {
    $newVal = trim($dIVA10);
    if(!ValueValidations::isValidStringDecimal($newVal, 15, 0, 8))
      throw new \Exception("Valor no válido para el campo dIVA10: $newVal");
    $this->dIVA10 = $newVal;
    return $this;
  }


  /**
   * Establece el valor de dLiqTotIVA5 que representa la liquidación total del IVA por redondeo a la tasa del 5%.
   *
   * @param String $dLiqTotIVA5 El valor de la liquidación total del IVA por redondeo a la tasa del 5% expresado en cadena numérica de caracteres.
   *
   * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
   */
  public function setDLiqTotIVA5(String $dLiqTotIVA5): self
  {
    $newVal = trim($dLiqTotIVA5);
    if(!ValueValidations::isValidStringDecimal($newVal, 15, 0, 8))
      throw new \Exception("Valor no válido para el campo dLiqTotIVA5: $newVal");
    $this->dLiqTotIVA5 = $newVal;
    return $this;
  }


  /**
   * Establece el valor de dLiqTotIVA10 que representa la liquidación total del IVA por redondeo a la tasa del 10%.
   *
   * @param String $dLiqTotIVA10 El valor de la liquidación total del IVA por redondeo a la tasa del 10% expresado en cadena numérica de caracteres.
   *
   * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
   */
  public function setDLiqTotIVA10(String $dLiqTotIVA10): self
  {
    $newVal = trim($dLiqTotIVA10);
    if(!ValueValidations::isValidStringDecimal($newVal, 15, 0, 8))
      throw new \Exception("Valor no válido para el campo dLiqTotIVA10: $newVal");
    $this->dLiqTotIVA10 = $newVal;
    return $this;
  }


  /**
   * Establece el valor de dIVAComi que representa la liquidación total del IVA de la comisión.
   *
   * @param String $dIVAComi El valor de la liquidación total del IVA de la comisión expresado en cadena numérica de caracteres.
   *  
   * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
   */
  public function setDIVAComi(String $dIVAComi): self
  {
    $newVal = trim($dIVAComi);
    if(!ValueValidations::isValidStringDecimal($newVal, 15, 0, 8))
      throw new \Exception("Valor no válido para el campo dIVAComi: $newVal");
    $this->dIVAComi = $newVal;
    return $this;
  }


  /**
   * Establece el valor de dTotIVA que representa la liquidación total del IVA.
   *
   * @param String $dTotIVA El valor de la liquidación total del IVA expresado en cadena numérica de caracteres.
   *
   * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
   */
  public function setDTotIVA(String $dTotIVA): self
  {
    $newVal = trim($dTotIVA);
    if(!ValueValidations::isValidStringDecimal($newVal, 15, 0, 8))
      throw new \Exception("Valor no válido para el campo dTotIVA: $newVal");
    $this->dTotIVA = $newVal;
    return $this;
  }


  /**
   * Establece el valor de dBaseGrav5 que representa el total de la base gravada de IVA al 5%.
   *
   * @param String $dBaseGrav5 El valor de la base gravada de IVA al 5% expresado en cadena numérica de caracteres.
   *
   * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
   */
  public function setDBaseGrav5(String $dBaseGrav5): self
  {
    $newVal = trim($dBaseGrav5);
    if(!ValueValidations::isValidStringDecimal($newVal, 15, 0, 8))
      throw new \Exception("Valor no válido para el campo dBaseGrav5: $newVal");
    $this->dBaseGrav5 = $newVal;
    return $this;
  }

  /**
   * Establece el valor de dBaseGrav10 que representa el total de la base gravada de IVA al 10%.
   *
   * @param String $dBaseGrav10 El valor de la base gravada de IVA al 10% expresado en cadena numérica de caracteres.
   *
   * @return self Retorna la instancia de esta clase.
   */
  public function setDBaseGrav10(String $dBaseGrav10): self
  {
    $newVal = trim($dBaseGrav10);
    if(!ValueValidations::isValidStringDecimal($newVal, 15, 0, 8))
      throw new \Exception("[GTotSub] Valor no válido para el campo dBaseGrav10: $newVal");
    $this->dBaseGrav10 = $dBaseGrav10;
    return $this;
  }


  /**
   * Establece el valor de dTBasGraIV que representa el total de la base gravada de IVA F018+F019
   *
   * @param String $dTBasGraIVA El valor de la base gravada de IVA F018+F019 expresado en cadena numérica de caracteres.
   *
   * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
   */
  public function setDTBasGraIVA(String $dTBasGraIVA): self
  {
    $newVal = trim($dTBasGraIVA);
    if(!ValueValidations::isValidStringDecimal($newVal, 15, 0, 8))
      throw new \Exception("[GTotSub] Valor no válido para el campo dTBasGraIVA: $newVal");
    $this->dTBasGraIVA = $newVal;
    return $this;
  }


  /**
   * Establece el valor de dTotalGs que representa el total general de la operación en Guaraníes.
   *
   * @param String $dTotalGs El valor del total general de la operación en Guaraníes expresado en cadena numérica de caracteres.
   *
   * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
   */
  public function setDTotalGs(String $dTotalGs): self
  {
    $newVal = trim($dTotalGs);
    if(!ValueValidations::isValidStringDecimal($newVal, 15, 0, 8))
      throw new \Exception("Valor no válido para el campo dTotalGs: $newVal");
    $this->dTotalGs = $newVal;
    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////


  /**
   * Obtiene el valor de dSubExe que representa el subtotal de la operación exenta.
   *
   * @return String  El valor del subtotal de la operación exenta expresado en cadena numérica de caracteres.
   */
  public function getDSubExe(): String | null
  {
    if(isset($this->dSubExe))
      return $this->dSubExe;
    else
      return null;
  }

  /**
   * Obtiene el valor de dSubExo que representa el subtotal de la operación exonerada en formato de cadena formateada con separador de miles.
   * 
   * @return String El valor del subtotal de la operación exonerada expresado en cadena numérica formateada de caracteres.
   * 
   */
  public function getFormattedDSubExe(): String | null
  {
    if(isset($this->dSubExe))
      return StringNumberFormatter::FormatBCMAthNumber($this->dSubExe, ',', '.');
    else
      return null;
  }

  /**
   * Obtiene el valor de dSubExo que representa el subtotal de la operación exonerada.
   *
   * @return String El valor del subtotal de la operación exonerada expresado en cadena numérica de caracteres.
   */
  public function getDSubExo(): String | null
  {
    if(isset($this->dSubExo))
      return $this->dSubExo;
    else
      return null;
  }

  /**
   * Obtiene el valor de dSubExo que representa el subtotal de la operación exonerada en formato de cadena formateada con separador de miles.
   * 
   * @return String El valor del subtotal de la operación exonerada expresado en cadena numérica formateada de caracteres.
   */
  public function getFormattedDSubExo(): String | null
  {
    if(isset($this->dSubExo))
      return StringNumberFormatter::FormatBCMAthNumber($this->dSubExo, ',', '.');
    else
      return null;
  }

  /**
   * Obtiene el valor de dSub5 que representa el subtotal de la operación con IVA incluido a la tasa 5%.
   *
   * @return String El valor del subtotal de la operación con IVA incluido a la tasa 5% expresado en cadena numérica de caracteres.
   */
  public function getDSub5(): String | null
  {
    if(isset($this->dSub5))
      return $this->dSub5;
    else
      return null;
  }

  /**
   * Obtiene el valor de dSub5 que representa el subtotal de la operación con IVA incluido a la tasa 5% en formato de cadena formateada con separador de miles.
   * 
   * @return String El valor del subtotal de la operación con IVA incluido a la tasa 5% expresado en cadena numérica formateada de caracteres.
   */
  public function getFormattedDSub5(): String | null
  {
    if(isset($this->dSub5))
      return StringNumberFormatter::FormatBCMAthNumber($this->dSub5, ',', '.');
    else
      return null;
  }
 

  /**
   * Obtiene el valor de dSub10 que representa el subtotal de la operación con IVA incluido a la tasa 10%.
   *
   * @return String El valor del subtotal de la operación con IVA incluido a la tasa 10% expresado en cadena numérica de caracteres.
   */
  public function getDSub10(): String | null
  {
   if(isset($this->dSub10))
      return $this->dSub10;
    else
      return null;
  }

  /**
   * Obtiene el valor de dSub10 que representa el subtotal de la operación con IVA incluido a la tasa 10% en formato de cadena formateada con separador de miles.
   * 
   * @return String El valor del subtotal de la operación con IVA incluido a la tasa 10% expresado en cadena numérica formateada de caracteres.
   */
  public function getFormattedDSub10(): String | null
  {
    if(isset($this->dSub10))
      return StringNumberFormatter::FormatBCMAthNumber($this->dSub10, ',', '.');
    else
      return null;
  }

  /**
   * Obtiene el valor de dTotOpe que representa el total bruto de la operación.
   *
   * @return String El valor del total bruto de la operación expresado en cadena numérica de caracteres.
   */
  public function getDTotOpe(): String
  {
    return $this->dTotOpe;
  }



  /**
   * Obtiene el valor de dTotDesc que representa el total descuento particular por ítem.
   *
   * @return String El valor del total descuento particular por ítem expresado en cadena numérica de caracteres.
   */
  public function getDTotDesc(): String
  {
    return $this->dTotDesc;
  }

  /**
   * Obtiene el valor de dTotDescGlotem que representa el total descuento global por ítem.
   *
   * @return String El valor del total descuento global por ítem expresado en cadena numérica de caracteres.
   */
  public function getDTotDescGlotem(): String
  {
    return $this->dTotDescGlotem;
  }

  /**
   * Obtiene el valor de dTotAntItem que representa el total anticipo por ítem.
   *
   * @return String El valor del total anticipo por ítem expresado en cadena numérica de caracteres.
   */
  public function getDTotAntItem(): String
  {
    return $this->dTotAntItem;
  }

  /**
   * Obtiene el valor de dTotAnt que representa el total anticipo global por ítem.
   *
   * @return String El valor del total anticipo global por ítem expresado en cadena numérica de caracteres.
   */
  public function getDTotAnt(): String
  {
    return $this->dTotAnt;
  }

  /**
   * Obtiene el valor de dPorcDescTotal que representa el porcentaje de descuento global sobre total de la operación.
   *
   * @return String El valor del porcentaje de descuento global sobre total de la operación expresado en cadena numérica de caracteres.
   */
  public function getDPorcDescTotal(): String
  {
    return $this->dPorcDescTotal;
  }

  /**
   * Obtiene el valor de dDescTotal que representa el total descuentos de la operación.
   *
   * @return String El valor del total descuentos de la operación expresado en cadena numérica de caracteres.
   */
  public function getDDescTotal(): String
  {
    return $this->dDescTotal;
  }

  /**
   * Obtiene el valor de dAnticipo que representa el total anticipos de la operación.
   *
   * @return String
   */
  public function getDAnticipo(): String
  {
    return $this->dAnticipo;
  }

  /**
   * Obtiene el valor de dRedon que representa el redondeo de la operación.
   *
   * @return String El valor del redondeo de la operación expresado en cadena numérica de caracteres.
   */
  public function getDRedon(): String
  {
    return $this->dRedon;
  }

  /**
   * Obtiene el valor de dComi que representa la comisión de la operación.
   *
   * @return String El valor de la comisión de la operación expresado en cadena numérica de caracteres.
   */
  public function getDComi(): String | null
  {
   if(isset($this->dComi))
      return $this->dComi;
    else
      return null;
  }

  /**
   * Obtiene el valor de dTotGralOpe que representa el total neto de la operación.
   *
   * @return String El valor del total neto de la operación expresado en cadena numérica de caracteres.
   */
  public function getDTotGralOpe(): String
  {
    return $this->dTotGralOpe;
  }

  public function getFormattedDTotGralOpe(): String
  {
    return StringNumberFormatter::FormatBCMAthNumber($this->dTotGralOpe, ',', '.');
  }

  /**
   * Obtiene el valor de dIVA5 que representa la liquidación del IVA a la tasa del 5%.
   *
   * @return String El valor de la liquidación del IVA a la tasa del 5% expresado en cadena numérica de caracteres.
   */
  public function getDIVA5(): String | null
  {
    if(isset($this->dIVA5))
      return $this->dIVA5;
    else
      return null;
  }

  /**
   * Obtiene el valor de dIVA5 que representa la liquidación del IVA a la tasa del 5% en formato de cadena formateada con separador de miles.
   * 
   * @return String El valor de la liquidación del IVA a la tasa del 5% expresado en cadena numérica formateada de caracteres.
   */
  public function getFormattedDIVA5(): String | null
  {
    if(isset($this->dIVA5))
      return StringNumberFormatter::FormatBCMAthNumber($this->dIVA5, ',', '.');
    else
      return null;
  }
  

  /**
   * Obtiene el valor de dIVA10 que representa la liquidación del IVA a la tasa del 10%.
   *
   * @return String El valor de la liquidación del IVA a la tasa del 10% expresado en cadena numérica de caracteres.
   */
  public function getDIVA10(): String | null  
  {
    if(isset($this->dIVA10))
      return $this->dIVA10;
    else
      return null;
  }

  /**
   * Obtiene el valor de dIVA10 que representa la liquidación del IVA a la tasa del 10% en formato de cadena formateada con separador de miles.
   * 
   * @return String El valor de la liquidación del IVA a la tasa del 10% expresado en cadena numérica formateada de caracteres.
   */
  public function getFormattedDIVA10(): String | null  
  {
    if(isset($this->dIVA10))
      return StringNumberFormatter::FormatBCMAthNumber($this->dIVA10, ',', '.');
    else
      return null;
  }

  /**
   * Obtiene el valor de dLiqTotIVA5 que representa la liquidación total del IVA por redondeo a la tasa del 5%.
   *
   * @return String El valor de la liquidación total del IVA por redondeo a la tasa del 5% expresado en cadena numérica de caracteres.
   */
  public function getDLiqTotIVA5(): String | null
  {
    if(isset($this->dLiqTotIVA5))
      return $this->dLiqTotIVA5;
    else
      return null;
  }

  /**
   * Obtiene el valor de dLiqTotIVA10 que representa la liquidación total del IVA por redondeo a la tasa del 10%.
   *
   * @return String El valor de la liquidación total del IVA por redondeo a la tasa del 10% expresado en cadena numérica de caracteres.
   */
  public function getDLiqTotIVA10(): String | null
  {
    if(isset($this->dLiqTotIVA10))
      return $this->dLiqTotIVA10;
    else
      return null;
  }

  /**
   * Obtiene el valor de dIVAComi que representa la liquidación total del IVA de la comisión.
   *
   * @return String El valor de la liquidación total del IVA de la comisión expresado en cadena numérica de caracteres.
   */
  public function getDIVAComi(): String | null
  {
    if(isset($this->dIVAComi))
      return $this->dIVAComi;
    else
      return null;
  }

  /**
   * Devuelve el valor dTotIVA (F017 - Liquidación total del IVA) en formato de cadena formateada con separador de miles.
   *
   * @return String El valor de la liquidación total del IVA expresado en cadena numérica formateada de caracteres.
   */
  public function getDTotIVA(): String | null
  {
    if(isset($this->dTotIVA))
      return $this->dTotIVA;
    else
      return null;
  }

  /**
   * Devuelve el valor dTotIVA (F017 - Liquidación total del IVA) en formato de cadena formateada con separador de miles.
   * 
   * @return String El valor de la liquidación total del IVA expresado en cadena numérica formateada de caracteres.
   */
  public function getFormattedDTotIVA(): String | null
  {
    if(isset($this->dTotIVA))
      return StringNumberFormatter::FormatBCMAthNumber($this->dTotIVA, ',', '.');
    else
      return null;
  }

  /**
   * Obtiene el valor de dBaseGrav5 que representa el total de la base gravada de IVA al 5%.
   *
   * @return String El valor de la base gravada de IVA al 5% expresado en cadena numérica de caracteres.
   */
  public function getDBaseGrav5(): String | null
  {
    if(isset($this->dBaseGrav5))
      return $this->dBaseGrav5;
    else
      return null;
  }

  /**
   * Obtiene el valor de dBaseGrav10 que representa el total de la base gravada de IVA al 10%.
   *
   * @return String El valor de la base gravada de IVA al 10% expresado en cadena numérica de caracteres.
   */
  public function getDBaseGrav10(): String
  {
    return $this->dBaseGrav10;
  }

  /**
   * Obtiene el valor de dTBasGraIVA que representa el total de la base gravada de IVA F018+F019
   *
   * @return String
   */
  public function getDTBasGraIVA(): String
  {
    return $this->dTBasGraIVA;
  }

  /** 
   * Obtiene el valor de dTotalGs que representa el total general de la operación en Guaraníes.
   *
   * @return String El valor del total general de la operación en Guaraníes expresado en cadena numérica de caracteres.
   */
  public function getDTotalGs(): String
  {
    return $this->dTotalGs;
  }

  /**
   * Obtiene el valor de dTotalGs que representa el total general de la operación en Guaraníes en formato de cadena formateada con separador de miles.
   * 
   * @return String El valor del total general de la operación en Guaraníes expresado en cadena numérica formateada de caracteres.
   */
  public function getFormattedDTotalGs(): String
  {
    return StringNumberFormatter::FormatBCMAthNumber($this->dTotalGs, ',', '.');
  }

  ///////////////////////////////////////////////////////////////////////
  // Instanciadores
  ///////////////////////////////////////////////////////////////////////
  
  /**
   * Instancia un objeto GTotSub a partir de un DOMElement que lo representa.
   * 
   * @param DOMElement $node El DOMElement que contiene la representación XML de un GTotSub.
   * 
   * @return self
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    if(strcmp($node->nodeName, 'gTotSub') != 0)
      throw new \Exception('[GTotSub] Nodo con nombre inválido: ' . $node->nodeName);
    $res = new GTotSub();
    if($node->getElementsByTagName('dSubExe')->length > 0)
      $res->setDSubExe($node->getElementsByTagName('dSubExe')->item(0)->nodeValue);
    if($node->getElementsByTagName('dSubExo')->length > 0)
      $res->setDSubExo($node->getElementsByTagName('dSubExo')->item(0)->nodeValue);
    if($node->getElementsByTagName('dSub5')->length > 0)
      $res->setDSub5($node->getElementsByTagName('dSub5')->item(0)->nodeValue);
    if($node->getElementsByTagName('dSub10')->length > 0)
      $res->setDSub10($node->getElementsByTagName('dSub10')->item(0)->nodeValue);
    $res->setDTotOpe($node->getElementsByTagName('dTotOpe')->item(0)->nodeValue);
    $res->setDTotDesc($node->getElementsByTagName('dTotDesc')->item(0)->nodeValue);
    $res->setDTotDescGlotem($node->getElementsByTagName('dTotDescGlotem')->item(0)->nodeValue);
    $res->setDTotAntItem($node->getElementsByTagName('dTotAntItem')->item(0)->nodeValue);
    $res->setDTotAnt($node->getElementsByTagName('dTotAnt')->item(0)->nodeValue);
    $res->setDPorcDescTotal($node->getElementsByTagName('dPorcDescTotal')->item(0)->nodeValue);
    $res->setDDescTotal($node->getElementsByTagName('dDescTotal')->item(0)->nodeValue);
    $res->setDAnticipo($node->getElementsByTagName('dAnticipo')->item(0)->nodeValue);
    $res->setDRedon($node->getElementsByTagName('dRedon')->item(0)->nodeValue);
    if($node->getElementsByTagName('dComi')->length > 0)
      $res->setDComi($node->getElementsByTagName('dComi')->item(0)->nodeValue);
    $res->setDTotGralOpe($node->getElementsByTagName('dTotGralOpe')->item(0)->nodeValue);
    if($node->getElementsByTagName('dIVA5')->length > 0)
      $res->setDIVA5($node->getElementsByTagName('dIVA5')->item(0)->nodeValue);
    if($node->getElementsByTagName('dIVA10')->length > 0)
      $res->setDIVA10($node->getElementsByTagName('dIVA10')->item(0)->nodeValue);
    if($node->getElementsByTagName('dLiqTotIVA5')->length > 0)
      $res->setDLiqTotIVA5($node->getElementsByTagName('dLiqTotIVA5')->item(0)->nodeValue);
    if($node->getElementsByTagName('dLiqTotIVA10')->length > 0)
      $res->setDLiqTotIVA10($node->getElementsByTagName('dLiqTotIVA10')->item(0)->nodeValue);
    if($node->getElementsByTagName('dIVAComi')->length > 0)
      $res->setDIVAComi($node->getElementsByTagName('dIVAComi')->item(0)->nodeValue);
    if($node->getElementsByTagName('dTotIVA')->length > 0)
      $res->setDTotIVA($node->getElementsByTagName('dTotIVA')->item(0)->nodeValue);
    if($node->getElementsByTagName('dBaseGrav5')->length > 0)
      $res->setDBaseGrav5($node->getElementsByTagName('dBaseGrav5')->item(0)->nodeValue);
    if($node->getElementsByTagName('dBaseGrav10')->length > 0)
      $res->setDBaseGrav10($node->getElementsByTagName('dBaseGrav10')->item(0)->nodeValue);
    if($node->getElementsByTagName('dTBasGraIVA')->length > 0)
      $res->setDTBasGraIVA($node->getElementsByTagName('dTBasGraIVA')->item(0)->nodeValue);
    if($node->getElementsByTagName('dTotalGs')->length > 0)
      $res->setDTotalGs($node->getElementsByTagName('dTotalGs')->item(0)->nodeValue);
    return $res;
  }

  /**
   * Instancia un objeto de la clase a partir de un SimpleXMLElement
   * 
   * @param SimpleXMLElement $xml
   * 
   * @return self
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $xml): self
  {
    if(strcmp($xml->getName(), 'gTotSub') != 0)
      throw new \Exception("El nombre del elemento no es del tipo gTotSub");
    $res = new GTotSub();
    if (isset($xml->dSubExe)) {
      $res->setDSubExe($xml->dSubExe);
    }
    if (isset($xml->dSubExo)) {
      $res->setDSubExo($xml->dSubExo);
    }
    if (isset($xml->dSub5)) {
      $res->setDSub5($xml->dSub5);
    }
    if (isset($xml->dSub10)) {
      $res->setDSub10($xml->dSub10);
    }
    $res->setDTotOpe($xml->dTotOpe);
    $res->setDTotDesc($xml->dTotDesc);
    $res->setDTotDescGlotem($xml->dTotDescGlotem);
    $res->setDTotAntItem($xml->dTotAntItem);
    $res->setDTotAnt($xml->dTotAnt);
    $res->setDPorcDescTotal($xml->dPorcDescTotal);
    $res->setDDescTotal($xml->dDescTotal);
    $res->setDAnticipo($xml->dAnticipo);
    $res->setDRedon($xml->dRedon);
    if(isset($xml->dComi)) {
      $res->setDComi($xml->dComi);
    }
    $res->setDTotGralOpe($xml->dTotGralOpe);
    if (isset($xml->dIVA5)) {
      $res->setDIVA5($xml->dIVA5);
    }
    if (isset($xml->dIVA10)) {
      $res->setDIVA10($xml->dIVA10);
    }
    if (isset($xml->dLiqTotIVA5)) {
      $res->setDLiqTotIVA5($xml->dLiqTotIVA5);
    }
    if (isset($xml->dLiqTotIVA10)) {
      $res->setDLiqTotIVA10($xml->dLiqTotIVA10);
    }
    if (isset($xml->dIVAComi)) {
      $res->setDIVAComi($xml->dIVAComi);
    }
    if (isset($xml->dTotIVA)) {
      $res->setDTotIVA($xml->dTotIVA);
    }
    if (isset($xml->dBaseGrav5)) {
      $res->setDBaseGrav5($xml->dBaseGrav5);
    }
    if (isset($xml->dBaseGrav10)) {
      $res->setDBaseGrav10($xml->dBaseGrav10);
    }
    if (isset($xml->dTBasGraIVA)) {
      $res->setDTBasGraIVA($xml->dTBasGraIVA);
    }
    if (isset($xml->dTotalGs)) {
      $res->setDTotalGs($xml->dTotalGs);
    }
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
    $res = new GTotSub();
    if (isset($object->dSubExe)) {
      $res->setDSubExe($object->dSubExe);
    }
    if (isset($object->dSubEx)) {
      $res->setDSubExo($object->dSubEx);
    }
    if (isset($object->dSub5)) {
      $res->setDSub5($object->dSub5);
    }
    if (isset($object->dSub10)) {
      $res->setDSub10($object->dSub10);
    }
    if (isset($object->dTotOpe)) {
      $res->setDTotOpe($object->dTotOpe);
    }
    if (isset($object->dTotDesc)) {
      $res->setDTotDesc($object->dTotDesc);
    }
    if (isset($object->dTotDescGlotem)) {
      $res->setDTotDescGlotem($object->dTotDescGlotem);
    }
    if (isset($object->dTotAntItem)) {
      $res->setDTotAntItem($object->dTotAntItem);
    }
    if (isset($object->dTotAnt)) {
      $res->setDTotAnt($object->dTotAnt);
    }
    if (isset($object->dPorcDescTotal)) {
      $res->setDPorcDescTotal($object->dPorcDescTotal);
    }
    if (isset($object->dPorcDesc)) {
      $res->setDPorcDescTotal($object->dPorcDesc);
    }
    if (isset($object->dDesc)) {
      $res->setDDescTotal($object->dDesc);
    }
    if (isset($object->dAnticipo)) {
      $res->setDAnticipo($object->dAnticipo);
    }
    if (isset($object->dRedon)) {
      $res->setDRedon($object->dRedon);
    }
    if (isset($object->dComi)) {
      $res->setDComi($object->dComi);
    }
    if (isset($object->dTotGralOpe)) {
      $res->setDTotGralOpe($object->dTotGralOpe);
    }
    if (isset($object->dIVA5)) {
      $res->setDIVA5($object->dIVA5);
    }
    if (isset($object->dIVA10)) {
      $res->setDIVA10($object->dIVA10);
    }
    if (isset($object->dLiqTotIVA5)) {
      $res->setDLiqTotIVA5($object->dLiqTotIVA5);
    }
    if (isset($object->dLiqTotIVA10)) {
      $res->setDLiqTotIVA10($object->dLiqTotIVA10);
    }
    if (isset($object->dIVAComi)) {
      $res->setDIVAComi($object->dIVAComi);
    }
    if (isset($object->dTotIVA)) {
      $res->setDTotIVA($object->dTotIVA);
    }
    if (isset($object->dBaseGrav5)) {
      $res->setDBaseGrav5($object->dBaseGrav5);
    }
    if (isset($object->dBaseGrav10)) {
      $res->setDBaseGrav10($object->dBaseGrav10);
    }
    if (isset($object->dTBaseGraIVA)) {
      $res->setDTbasGraIVA($object->dTBaseGraIVA);
    }
    if (isset($object->dTotalGs)) {
      $res->setDTotalGs($object->dTotalGs);
    }    
    return $res;
  }

  ///////////////////////////////////////////////////////////////////////
  // Conversores
  ///////////////////////////////////////////////////////////////////////

  /**
   * Convierte este GTotSub en un DOMElement perteneciente a un DOMDocument
   * 
   * @param DOMDocument $doc El DOMDocument que generará el DOMElement sin insertarlo.
   *
   * @return DOMElement El DOMElement que representa a este GTotSub.
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gTotSub');
    if(isset($this->dSubExe))
      $res->appendChild(new DOMElement('dSubExe', $this->getDSubExe()));
    if(isset($this->dSubExo))
      $res->appendChild(new DOMElement('dSubExo', $this->getDSubExo()));
    if(isset($this->dSub5))
      $res->appendChild(new DOMElement('dSub5', $this->getDSub5()));
    if(isset($this->dSub10))
      $res->appendChild(new DOMElement('dSub10', $this->getDSub10()));
    $res->appendChild(new DOMElement('dTotOpe', $this->getDTotOpe()));
    $res->appendChild(new DOMElement('dTotDesc', $this->getDTotDesc()));
    $res->appendChild(new DOMElement('dTotDescGlotem', $this->getDTotDescGlotem()));
    $res->appendChild(new DOMElement('dTotAntItem', $this->getDTotAntItem()));
    $res->appendChild(new DOMElement('dTotAnt', $this->getDTotAnt()));
    $res->appendChild(new DOMElement('dPorcDescTotal', $this->getDPorcDescTotal()));
    $res->appendChild(new DOMElement('dDescTotal', $this->getDDescTotal()));
    $res->appendChild(new DOMElement('dAnticipo', $this->getDAnticipo()));
    $res->appendChild(new DOMElement('dRedon', $this->getDRedon()));
    if(isset($this->dComi))
      $res->appendChild(new DOMElement('dComi', $this->getDComi()));
    $res->appendChild(new DOMElement('dTotGralOpe', $this->getDTotGralOpe()));
    if(isset($this->dIVA5))
      $res->appendChild(new DOMElement('dIVA5', $this->getDIVA5()));
    if(isset($this->dIVA10))
      $res->appendChild(new DOMElement('dIVA10', $this->getDIVA10()));
    if(isset($this->dLiqTotIVA5))
      $res->appendChild(new DOMElement('dLiqTotIVA5', $this->getDLiqTotIVA5()));
    if(isset($this->dLiqTotIVA10))
      $res->appendChild(new DOMElement('dLiqTotIVA10', $this->getDLiqTotIVA10()));
    if(isset($this->dIVAComi))
      $res->appendChild(new DOMElement('dIVAComi', $this->getDIVAComi()));
    if(isset($this->dTotIVA))
      $res->appendChild(new DOMElement('dTotIVA', $this->getDTotIVA()));
    if(isset($this->dBaseGrav5))
      $res->appendChild(new DOMElement('dBaseGrav5', $this->dBaseGrav5));
    if(isset($this->dBaseGrav10))
      $res->appendChild(new DOMElement('dBaseGrav10', $this->getDBaseGrav10()));
    if(isset($this->dTBasGraIVA))
      $res->appendChild(new DOMElement('dTBasGraIVA', $this->getDTBasGraIVA()));
    if(isset($this->dTotalGs))
      $res->appendChild(new DOMElement('dTotalGs', $this->getDTotalGs()));
    return $res;
  }

  ///////////////////////////////////////////////////////////////////////
  // Funciones de Cálculo
  ///////////////////////////////////////////////////////////////////////

  /**
   * Calcula el parámetro dTotOpe (total BRUTO de la operación) a partir de la suma de los parámetros dSubExe, dSubExo, dSub5 y dSub10.
   * 
   * @return String dTotOpe calculado
   */
  public function calcDTotOpe(): String
  {
    $this->dTotOpe = bcadd($this->dSubExe ?? '0', $this->dSubExo ?? '0', 8);
    $this->dTotOpe = bcadd($this->dTotOpe ?? '0', $this->dSub5 ?? '0', 8);
    $this->dTotOpe = bcadd($this->dTotOpe ?? '0', $this->dSub10 ?? '0', 8);
    return $this->dTotOpe;
  }

  /**
   * Calcula el parámetro dTotGralOpe (total NETO de la operación) a partir de dTotOpe - dRedon + dComi.
   * 
   * @return String dTotGralOpe calculado
   */
  public function calcDTotGralOpe(): String
  {
    $this->dTotGralOpe = bcadd($this->dTotOpe ?? '0', $this->dComi ?? '0', 8);
    $this->dTotGralOpe = bcsub($this->dTotGralOpe ?? '0', $this->dRedon ?? '0', 8);
    return $this->dTotGralOpe;
  }

  /**
   * Calcula el parámetro dTBasGraIVA (total de la base gravada de IVA) a partir de la suma de los parámetros dBaseGrav5 y dBaseGrav10.
   * 
   * @return String dTBasGraIVA calculado
   */
  public function calcDTBasGraIVA(): String
  {
    $this->dTBasGraIVA = bcadd($this->dBaseGrav5 ?? '0', $this->dBaseGrav10 ?? '0', 8);
    return $this->dTBasGraIVA;
  }
}
