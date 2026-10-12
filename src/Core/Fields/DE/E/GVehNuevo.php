<?php

namespace IonysDev\Pkuatia\Core\Fields\DE\E;

use IonysDev\Pkuatia\Core\Fields\BaseSifenField;
use DOMDocument;
use DOMElement;
use Exception;
use stdClass;
use IonysDev\Pkuatia\Helpers\XmlHelper;
use IonysDev\Pkuatia\Utils\DecimalXsd;

/**
 * ID:E770 Grupo de detalle de vehículos nuevos
 */
class GVehNuevo extends BaseSifenField
{
  public ?int $iTipOpVN; // E771 iTipOpVN Tipo de operación de venta de vehículos
  public ?String $dDesTipOpVN; // E772 Descripción del tipo de operación de venta de vehículos
  public ?String $dChasis; /// E773 Chasis del vehículo;
  public ?String $dColor; // E774 Color del vehículo
  public ?int $dPotencia; ///E775 Potencia del motor (CV)
  public ?int $dCapMot; ///E776 Capacidad del motor
  /** @deprecated 0.2.1 Parte entera del peso neto (E777 admite 4 decimales): usar getDPNetDecimal(). */
  public ?int $dPNet; ///E777 Peso Neto 
  /** @deprecated 0.2.1 Parte entera del peso bruto (E778 admite 4 decimales): usar getDPBrutoDecimal(). */
  public ?int $dPBruto; ///E778 Peso Bruto
  public ?int $iTipCom; ///E779 Tipo de combustible
  public ?String $dDesTipCom; ///E780 Descripción del tipo de combustible
  public String $dNroMotor; ///E781 Numero de Motor
  /** @deprecated 0.2.1 Parte entera de la capacidad de tracción (E782 admite 4 decimales): usar getDCapTraccDecimal(). */
  public ?int $dCapTracc; ///E782 Capacidad máxima de  tracción 
  public ?int $dAnoFab; ///E783 Año de fabricación
  public String $cTipVeh; ///E784 Tipo de vehículo
  public ?int $dCapac; ///E785 Capacidad máxima de pasajeros 
  public String $dCilin; ///E786  Cilindradas del motor

  // Q-B12 (0.2.1): valor exacto de las medidas tMontoBase6, con sus decimales. Las propiedades enteras de arriba guardan
  // la parte entera, como hasta 0.2.0.
  private ?String $dPNetDecimal = null;
  private ?String $dPBrutoDecimal = null;
  private ?String $dCapTraccDecimal = null;

  ///////////////////////////////////////////////////////////////////////
  ///Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de iTipOpVN
   *
   * @param int $iTipOpVN
   *
   * @return self
   */
  public function setITipOpVN(int $iTipOpVN): self
  {
    $this->iTipOpVN = $iTipOpVN;

    return $this;
  }

  /**
   * Establece el valor de dDesTipOpVN
   *
   * @param String $dDesTipOpVN
   *
   * @return self
   */
  public function setDDesTipOpVN(String $dDesTipOpVN): self
  {
    $this->dDesTipOpVN = $dDesTipOpVN;

    return $this;
  }


  /**
   * Establece el valor de dChasis
   *
   * @param String $dChasis
   *
   * @return self
   */
  public function setDChasis(String $dChasis): self
  {
    $this->dChasis = $dChasis;

    return $this;
  }




  /**
   * Establece el valor de dColor
   *
   * @param String $dColor
   *
   * @return self
   */
  public function setDColor(String $dColor): self
  {
    $this->dColor = $dColor;

    return $this;
  }


  /**
   * Establece el valor de dPotencia
   *
   * @param int $dPotencia
   *
   * @return self
   */
  public function setDPotencia(int $dPotencia): self
  {
    $this->dPotencia = $dPotencia;

    return $this;
  }


  /**
   * Establece el valor de dCapMot
   *
   * @param int $dCapMot
   *
   * @return self
   */
  public function setDCapMot(int $dCapMot): self
  {
    $this->dCapMot = $dCapMot;

    return $this;
  }


  /**
   * Establece el valor de dPNet (E777, peso neto; tMontoBase6: hasta 10 dígitos, 4 de ellos decimales).
   * Desde 0.2.1 acepta texto con decimales y lo emite exacto; hasta 0.2.0 solo admitía enteros (Q-B12).
   *
   * @param int|String $dPNet
   *
   * @throws \InvalidArgumentException Si no es un número válido para el XSD.
   *
   * @return self
   */
  public function setDPNet(int|String $dPNet): self
  {
    $this->dPNetDecimal = self::monto($dPNet, 'dPNet');
    $this->dPNet = intval($this->dPNetDecimal);

    return $this;
  }


  /**
   * Establece el valor de dPBruto (E778, peso bruto; tMontoBase6: hasta 10 dígitos, 4 de ellos decimales).
   * Desde 0.2.1 acepta texto con decimales y lo emite exacto; hasta 0.2.0 solo admitía enteros (Q-B12).
   *
   * @param int|String $dPBruto
   *
   * @throws \InvalidArgumentException Si no es un número válido para el XSD.
   *
   * @return self
   */
  public function setDPBruto(int|String $dPBruto): self
  {
    $this->dPBrutoDecimal = self::monto($dPBruto, 'dPBruto');
    $this->dPBruto = intval($this->dPBrutoDecimal);

    return $this;
  }


  /**
   * Establece el valor de iTipCom
   *
   * @param int $iTipCom
   *
   * @return self
   */
  public function setITipCom(int $iTipCom): self
  {
    $this->iTipCom = $iTipCom;

    return $this;
  }

  /** 
   * Establece el valor de dDesTipCom
   * 
   * @param String $dDesTipCom
   * 
   * @return self
   */
  public function setDDesTipCom(String $dDesTipCom): self
  {
    $this->dDesTipCom = $dDesTipCom;

    return $this;
  }


  /**
   * Establece el valor de dNroMotor
   *
   * @param String $dNroMotor
   *
   * @return self
   */
  public function setDNroMotor(String $dNroMotor): self
  {
    $this->dNroMotor = $dNroMotor;

    return $this;
  }


  /**
   * Establece el valor de dCapTracc (E782, capacidad máxima de tracción; tMontoBase6: hasta 10 dígitos, 4 de ellos
   * decimales). Desde 0.2.1 acepta texto con decimales y lo emite exacto; hasta 0.2.0 solo admitía enteros (Q-B12).
   *
   * @param int|String $dCapTracc
   *
   * @throws \InvalidArgumentException Si no es un número válido para el XSD.
   *
   * @return self
   */
  public function setDCapTracc(int|String $dCapTracc): self
  {
    $this->dCapTraccDecimal = self::monto($dCapTracc, 'dCapTracc');
    $this->dCapTracc = intval($this->dCapTraccDecimal);

    return $this;
  }


  /**
   * Establece el valor de dAnoFab
   *
   * @param int $dAnoFab
   *
   * @return self
   */
  public function setDAnoFab(int $dAnoFab): self
  {
    $this->dAnoFab = $dAnoFab;

    return $this;
  }


  /**
   * Establece el valor de cTipVeh
   *
   * @param String $cTipVeh
   *
   * @return self
   */
  public function setCTipVeh(String $cTipVeh): self
  {
    $this->cTipVeh = $cTipVeh;

    return $this;
  }


  /**
   * Establece el valor de dCapac
   *
   * @param int $dCapac
   *
   * @return self
   */
  public function setDCapac(int $dCapac): self
  {
    $this->dCapac = $dCapac;

    return $this;
  }


  /**
   * Establece el valor de dCilin
   *
   * @param String $dCilin
   *
   * @return self
   */
  public function setDCilin(String $dCilin): self
  {
    $this->dCilin = $dCilin;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  ///Getter
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de iTipOpVN
   *
   * @return int
   */
  public function getITipOpVN(): ?int
  {
    return $this->iTipOpVN ?? null;
  }

  /**
   * E772 
   *Descripción del tipo de operación de venta de vehículos
   *
   * @return String
   */
  public function getDDesTipOpVN(): ?String
  {
    switch ($this->iTipOpVN ?? null) {
      case 1:
        return "Venta a representante";
        break;
      case 2:
        // Literal del XSD con C mayúscula (tdDesTipOpVN, DE_Types_v150.xsd:1500); hasta 0.2.0 iba con minúscula (B12).
        return "Venta al Consumidor final";
        break;
      case 3:
        return "Venta a gobierno";
        break;
      case 4:
        return "Venta a flota de vehículos";
        break;

      default:
        return null;
        break;
    }
  }


  /**
   * Obtiene el valor de dChasis
   *
   * @return String
   */
  public function getDChasis(): ?String
  {
    return $this->dChasis ?? null;
  }

  /**
   * Obtiene el valor de dColor
   *
   * @return String
   */
  public function getDColor(): ?String
  {
    return $this->dColor ?? null;
  }

  /**
   * Obtiene el valor de dPotencia
   *
   * @return int
   */
  public function getDPotencia(): ?int
  {
    return $this->dPotencia ?? null;
  }

  /**
   * Obtiene el valor de dCapMot
   *
   * @return int
   */
  public function getDCapMot(): ?int
  {
    return $this->dCapMot ?? null;
  }

  /**
   * Obtiene el valor de dPNet
   *
   * @return int
   *
   * @deprecated 0.2.1 Trunca el peso neto (E777 admite 4 decimales): usar getDPNetDecimal().
   */
  public function getDPNet(): ?int
  {
    return $this->dPNet ?? null;
  }

  /**
   * Obtiene el peso neto (E777) exacto, con sus decimales, o null si no se informó (Q-B12, 0.2.1).
   *
   * @return String|null
   */
  public function getDPNetDecimal(): ?String
  {
    return isset($this->dPNet) ? self::exacto($this->dPNetDecimal, $this->dPNet) : null;
  }

  /**
   * Obtiene el valor de dPBruto
   *
   * @return int
   *
   * @deprecated 0.2.1 Trunca el peso bruto (E778 admite 4 decimales): usar getDPBrutoDecimal().
   */
  public function getDPBruto(): ?int
  {
    return $this->dPBruto ?? null;
  }

  /**
   * Obtiene el peso bruto (E778) exacto, con sus decimales, o null si no se informó (Q-B12, 0.2.1).
   *
   * @return String|null
   */
  public function getDPBrutoDecimal(): ?String
  {
    return isset($this->dPBruto) ? self::exacto($this->dPBrutoDecimal, $this->dPBruto) : null;
  }

  /**
   * Obtiene el valor de iTipCom
   *
   * @return int
   */
  public function getITipCom(): ?int
  {
    return $this->iTipCom ?? null;
  }

  /**
   * E780 Descripción del tipo de combustible
   *
   * @return String
   */
  public function getDDesTipCom(): ?String
  {
    switch ($this->iTipCom ?? null) {
      case 1:
        return "Gasolina";
        break;
      case 2:
        return "Diésel";
        break;
      case 3:
        return "Etanol";
        break;
      case 4:
        return "GNV";
        break;
      case 5:
        return "Flex";
        break;
      case 9:
        return "Otro (Especificar)";
        break;
      default:
        return null;
        break;
    }
  }


  /**
   * Obtiene el valor de dNroMotor
   *
   * @return String
   */
  public function getDNroMotor(): String
  {
    return $this->dNroMotor;
  }

  /**
   * Obtiene el valor de dCapTracc
   *
   * @return int
   *
   * @deprecated 0.2.1 Trunca la capacidad de tracción (E782 admite 4 decimales): usar getDCapTraccDecimal().
   */
  public function getDCapTracc(): ?int
  {
    return $this->dCapTracc ?? null;
  }

  /**
   * Obtiene la capacidad máxima de tracción (E782) exacta, con sus decimales, o null si no se informó (Q-B12, 0.2.1).
   *
   * @return String|null
   */
  public function getDCapTraccDecimal(): ?String
  {
    return isset($this->dCapTracc) ? self::exacto($this->dCapTraccDecimal, $this->dCapTracc) : null;
  }

  /**
   * Obtiene el valor de dAnoFab
   *
   * @return int
   */
  public function getDAnoFab(): ?int
  {
    return $this->dAnoFab ?? null;
  }

  /**
   * Obtiene el valor de cTipVeh
   *
   * @return String
   */
  public function getCTipVeh(): String
  {
    return $this->cTipVeh;
  }

  /**
   * Obtiene el valor de dCapac
   *
   * @return int
   */
  public function getDCapac(): ?int
  {
    return $this->dCapac ?? null;
  }

  /**
   * Obtiene el valor de dCilin
   *
   * @return String
   */
  public function getDCilin(): String
  {
    return $this->dCilin;
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML Element  
  ///////////////////////////////////////////////////////////////////////

  /**
   * Convierte este GVehNuevo en un DOMElement que puede insertarse en el DOMDocument especificado.
   * 
   * @param DOMDocument $doc Documento DOM que creará el DOMElement sin insertarlo.
   * 
   * @return DOMElement El DOMElement creado.
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gVehNuevo');
    if(isset($this->iTipOpVN)) {
      // E771 lleva el código (tiTipOpVN, DE_Types_v150.xsd:1470-1487); hasta 0.2.0 se emitía la descripción (B12).
      $res->appendChild(XmlHelper::elemento($doc, 'iTipOpVN', $this->getITipOpVN()));
      $res->appendChild(XmlHelper::elemento($doc, 'dDesTipOpVN', $this->getDDesTipOpVN()));
    }
    if(isset($this->dChasis))
      $res->appendChild(XmlHelper::elemento($doc, 'dChasis', $this->getDChasis()));
    if(isset($this->dColor))
      $res->appendChild(XmlHelper::elemento($doc, 'dColor', $this->getDColor()));
    if(isset($this->dPotencia))
      $res->appendChild(XmlHelper::elemento($doc, 'dPotencia', $this->getDPotencia()));
    if(isset($this->dCapMot))
      $res->appendChild(XmlHelper::elemento($doc, 'dCapMot', $this->getDCapMot()));
    if(isset($this->dPNet))
      $res->appendChild(XmlHelper::elemento($doc, 'dPNet', $this->getDPNetDecimal()));
    if(isset($this->dPBruto))
      $res->appendChild(XmlHelper::elemento($doc, 'dPBruto', $this->getDPBrutoDecimal()));
    if(isset($this->iTipCom)) {
      $res->appendChild(XmlHelper::elemento($doc, 'iTipCom', $this->getITipCom()));
      $res->appendChild(XmlHelper::elemento($doc, 'dDesTipCom', $this->getDDesTipCom()));
    }
    if(isset($this->dNroMotor))
      $res->appendChild(XmlHelper::elemento($doc, 'dNroMotor', $this->getDNroMotor()));
    if(isset($this->dCapTracc))
      $res->appendChild(XmlHelper::elemento($doc, 'dCapTracc', $this->getDCapTraccDecimal()));
    if(isset($this->dAnoFab))
      $res->appendChild(XmlHelper::elemento($doc, 'dAnoFab', $this->getDAnoFab()));
    if(isset($this->cTipVeh))
      $res->appendChild(XmlHelper::elemento($doc, 'cTipVeh', $this->getCTipVeh()));
    if(isset($this->dCapac))
      $res->appendChild(XmlHelper::elemento($doc, 'dCapac', $this->getDCapac()));
    if(isset($this->dCilin))
      $res->appendChild(XmlHelper::elemento($doc, 'dCilin', $this->getDCilin()));
    return $res;
  }

  /**
     * Instancia un objeto GVehNuevo a partir de un DOMElement que representa al objeto.
     * 
     * @param DOMElement $node Nodo XML que representa el objeto GVehNuevo
     * 
     * @return GVehNuevo Objeto GVehNuevo instanciado
     */
    public static function FromDOMElement(DOMElement $node): self
    {
        if(strcmp($node->nodeName, 'gVehNuevo') != 0)
            throw new Exception('[GVehNuevo] Nodo con nombre inválido: ' . $node->nodeName);
        $res = new self();
        if($node->getElementsByTagName('iTipOpVN')->length > 0)
          $res->setITipOpVN(intval(trim($node->getElementsByTagName('iTipOpVN')->item(0)->nodeValue)));
        if($node->getElementsByTagName('dDesTipOpVN')->length > 0)
          $res->setDDesTipOpVN(trim($node->getElementsByTagName('dDesTipOpVN')->item(0)->nodeValue));
        if($node->getElementsByTagName('dChasis')->length > 0)
          $res->setDChasis(trim($node->getElementsByTagName('dChasis')->item(0)->nodeValue));
        if($node->getElementsByTagName('dColor')->length > 0)
          $res->setDColor(trim($node->getElementsByTagName('dColor')->item(0)->nodeValue));
        if($node->getElementsByTagName('dPotencia')->length > 0)
          $res->setDPotencia(intval(trim($node->getElementsByTagName('dPotencia')->item(0)->nodeValue)));
        if($node->getElementsByTagName('dCapMot')->length > 0)
          $res->setDCapMot(intval(trim($node->getElementsByTagName('dCapMot')->item(0)->nodeValue)));
        if($node->getElementsByTagName('dPNet')->length > 0)
          $res->setDPNet(trim($node->getElementsByTagName('dPNet')->item(0)->nodeValue));
        if($node->getElementsByTagName('dPBruto')->length > 0)
          $res->setDPBruto(trim($node->getElementsByTagName('dPBruto')->item(0)->nodeValue));
        if($node->getElementsByTagName('iTipCom')->length > 0)
          $res->setITipCom(intval(trim($node->getElementsByTagName('iTipCom')->item(0)->nodeValue)));
        if($node->getElementsByTagName('dDesTipCom')->length > 0)
          $res->setDDesTipCom(trim($node->getElementsByTagName('dDesTipCom')->item(0)->nodeValue));
        if($node->getElementsByTagName('dNroMotor')->length > 0)
          $res->setDNroMotor(trim($node->getElementsByTagName('dNroMotor')->item(0)->nodeValue));
        if($node->getElementsByTagName('dCapTracc')->length > 0)
          $res->setDCapTracc(trim($node->getElementsByTagName('dCapTracc')->item(0)->nodeValue));
        if($node->getElementsByTagName('dAnoFab')->length > 0)
          $res->setDAnoFab(intval(trim($node->getElementsByTagName('dAnoFab')->item(0)->nodeValue)));
        if($node->getElementsByTagName('cTipVeh')->length > 0)
          $res->setCTipVeh(trim($node->getElementsByTagName('cTipVeh')->item(0)->nodeValue));
        if($node->getElementsByTagName('dCapac')->length > 0)
          $res->setDCapac(intval(trim($node->getElementsByTagName('dCapac')->item(0)->nodeValue)));
        if($node->getElementsByTagName('dCilin')->length > 0)
          $res->setDCilin(trim($node->getElementsByTagName('dCilin')->item(0)->nodeValue));
        return $res;
    }

  /**
   * Instancia un GVehNuevo a partir del objeto que entrega SoapClient. Hasta 0.2.0 lanzaba "Not implemented", y con él
   * fallaba la lectura SOAP de cualquier ítem con vehículo nuevo (B12).
   *
   * @param stdClass $object Objeto respuesta del SIFEN.
   *
   * @return self
   */
  public static function FromSifenResponseObject(stdClass $object): self
  {
    $res = new self();
    if(isset($object->iTipOpVN))
      $res->setITipOpVN(intval($object->iTipOpVN));
    if(isset($object->dDesTipOpVN))
      $res->setDDesTipOpVN(strval($object->dDesTipOpVN));
    if(isset($object->dChasis))
      $res->setDChasis(strval($object->dChasis));
    if(isset($object->dColor))
      $res->setDColor(strval($object->dColor));
    if(isset($object->dPotencia))
      $res->setDPotencia(intval($object->dPotencia));
    if(isset($object->dCapMot))
      $res->setDCapMot(intval($object->dCapMot));
    if(isset($object->dPNet))
      $res->setDPNet(trim(strval($object->dPNet)));
    if(isset($object->dPBruto))
      $res->setDPBruto(trim(strval($object->dPBruto)));
    if(isset($object->iTipCom))
      $res->setITipCom(intval($object->iTipCom));
    if(isset($object->dDesTipCom))
      $res->setDDesTipCom(strval($object->dDesTipCom));
    if(isset($object->dNroMotor))
      $res->setDNroMotor(strval($object->dNroMotor));
    if(isset($object->dCapTracc))
      $res->setDCapTracc(trim(strval($object->dCapTracc)));
    if(isset($object->dAnoFab))
      $res->setDAnoFab(intval($object->dAnoFab));
    if(isset($object->cTipVeh))
      $res->setCTipVeh(strval($object->cTipVeh));
    if(isset($object->dCapac))
      $res->setDCapac(intval($object->dCapac));
    if(isset($object->dCilin))
      $res->setDCilin(strval($object->dCilin));
    return $res;
  }

  /**
   * FromSifenResponseObject
   *
   * @param  mixed $node
   * @return self
   */
  public static function FromSimpleXMLElement($node): self
  {
    if ($node->getName() != 'gVehNuevo') {
      throw new \Exception("Invalid XML Element: $node->getName()");
    }

    $res = new self();
    if (isset($node->iTipOpVN)) {
      $res->setITipOpVN(intval($node->iTipOpVN));
    }
    if (isset($node->dChasis)) {
      $res->setDChasis($node->dChasis);
    }
    if (isset($node->dColor)) {
      $res->setDColor($node->dColor);
    }
    if (isset($node->dPotencia)) {
      $res->setDPotencia(intval($node->dPotencia));
    }
    if (isset($node->dCapMot)) {
      $res->setDCapMot(intval($node->dCapMot));
    }
    if (isset($node->dPNet)) {
      $res->setDPNet(trim((string) $node->dPNet));
    }
    if (isset($node->dPBruto)) {
      $res->setDPBruto(trim((string) $node->dPBruto));
    }
    if (isset($node->iTipCom)) {
      $res->setITipCom(intval($node->iTipCom));
    }
    if (isset($node->dNroMotor)) {
      $res->setDNroMotor($node->dNroMotor);
    }
    if (isset($node->dCapTracc)) {
      $res->setDCapTracc(trim((string) $node->dCapTracc));
    }
    if (isset($node->dAnoFab)) {
      $res->setDAnoFab(intval($node->dAnoFab));
    }
    if (isset($node->cTipVeh)) {
      $res->setCTipVeh($node->cTipVeh);
    }
    if (isset($node->dCapac)) {
      $res->setDCapac(intval($node->dCapac));
    }
    if (isset($node->dCilin)) {
      $res->setDCilin($node->dCilin);
    }
    return $res;
  }

  /**
   * Valida una medida contra tMontoBase6 (xs:decimal con fractionDigits 4 y totalDigits 10, DE_Types_v150.xsd:1308-1314)
   * y la devuelve como texto, sin redondear. Como en xs:decimal, los ceros a la izquierda y los decimales finales en
   * cero no cuentan. Mismo criterio que GGrupSup (Q-B10): también acepta, normalizados, los textos numéricos que hasta
   * 0.2.0 entraban por la conversión de PHP a int ("+5" y "5." como "5", ".5" como "0.5", "1e3" como "1000").
   * Desde 0.3.0 (Fase C, C1) delega en Utils\DecimalXsd, con el mismo criterio y los mismos mensajes.
   */
  private static function monto(int|String $valor, String $campo): String
  {
    return DecimalXsd::normalizar($valor, $campo, 10, 4, '[GVehNuevo]', 'tMontoBase6');
  }

  /** Valor exacto, salvo que la propiedad pública entera se haya asignado directamente con otro valor. */
  private static function exacto(?String $decimal, int $entero): String
  {
    return DecimalXsd::exacto($decimal, $entero);
  }
}
