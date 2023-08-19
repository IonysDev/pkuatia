<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use DOMElement;

/**
 * ID:E770 Grupo de detalle de vehículos nuevos
 */
class GVehNuevo
{
  public ?int $iTipOpVN; // E771 iTipOpVN Tipo de operación de venta de vehículos
  public String $dChasis; /// E773 Chasis del vehículo;
  public String $dColor; // E774 Color del vehículo
  public ?int $dPotencia; ///E775 Potencia del motor (CV)
  public ?int $dCapMot; ///E776 Capacidad del motor
  public ?int $dPNet; ///E777 Peso Neto 
  public ?int $dPBruto; ///E778 Peso Bruto
  public ?int $iTipCom; ///E779 Tipo de combustible
  public String $dNroMotor; ///E780 Descripción del tipo de combustible
  public ?int $dCapTracc; ///E782 Capacidad máxima de  tracción 
  public ?int $dAnoFab; ///E783 Año de fabricación
  public String $cTipVeh; ///E784 Tipo de vehículo
  public ?int $dCapac; ///E785 Capacidad máxima de pasajeros 
  public String $dCilin; ///E786  Cilindradas del motor

  ///////////////////////////////////////////////////////////////////////
  ///Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of iTipOpVN
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
   * Set the value of dChasis
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
   * Set the value of dColor
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
   * Set the value of dPotencia
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
   * Set the value of dCapMot
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
   * Set the value of dPNet
   *
   * @param int $dPNet
   *
   * @return self
   */
  public function setDPNet(int $dPNet): self
  {
    $this->dPNet = $dPNet;

    return $this;
  }


  /**
   * Set the value of dPBruto
   *
   * @param int $dPBruto
   *
   * @return self
   */
  public function setDPBruto(int $dPBruto): self
  {
    $this->dPBruto = $dPBruto;

    return $this;
  }


  /**
   * Set the value of iTipCom
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
   * Set the value of dNroMotor
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
   * Set the value of dCapTracc
   *
   * @param int $dCapTracc
   *
   * @return self
   */
  public function setDCapTracc(int $dCapTracc): self
  {
    $this->dCapTracc = $dCapTracc;

    return $this;
  }


  /**
   * Set the value of dAnoFab
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
   * Set the value of cTipVeh
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
   * Set the value of dCapac
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
   * Set the value of dCilin
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
   * Get the value of iTipOpVN
   *
   * @return int
   */
  public function getITipOpVN(): int
  {
    return $this->iTipOpVN;
  }

  /**
   * E772 
   *Descripción del tipo de operación de venta de vehículos
   *
   * @return String
   */
  public function getDDesTipOpVN(): String
  {
    switch ($this->iTipOpVN) {
      case 1:
        return "Venta a representante";
        break;
      case 2:
        return "Venta al consumidor final";
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
   * Get the value of dChasis
   *
   * @return String
   */
  public function getDChasis(): String
  {
    return $this->dChasis;
  }

  /**
   * Get the value of dColor
   *
   * @return String
   */
  public function getDColor(): String
  {
    return $this->dColor;
  }

  /**
   * Get the value of dPotencia
   *
   * @return int
   */
  public function getDPotencia(): int
  {
    return $this->dPotencia;
  }

  /**
   * Get the value of dCapMot
   *
   * @return int
   */
  public function getDCapMot(): int
  {
    return $this->dCapMot;
  }

  /**
   * Get the value of dPNet
   *
   * @return int
   */
  public function getDPNet(): int
  {
    return $this->dPNet;
  }

  /**
   * Get the value of dPBruto
   *
   * @return int
   */
  public function getDPBruto(): int
  {
    return $this->dPBruto;
  }

  /**
   * Get the value of iTipCom
   *
   * @return int
   */
  public function getITipCom(): int
  {
    return $this->iTipCom;
  }

  /**
   * E780 Descripción del tipo de combustible
   *
   * @return String
   */
  public function getDDesTipCom(): String
  {
    switch ($this->iTipCom) {
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
   * Get the value of dNroMotor
   *
   * @return String
   */
  public function getDNroMotor(): String
  {
    return $this->dNroMotor;
  }

  /**
   * Get the value of dCapTracc
   *
   * @return int
   */
  public function getDCapTracc(): int
  {
    return $this->dCapTracc;
  }

  /**
   * Get the value of dAnoFab
   *
   * @return int
   */
  public function getDAnoFab(): int
  {
    return $this->dAnoFab;
  }

  /**
   * Get the value of cTipVeh
   *
   * @return String
   */
  public function getCTipVeh(): String
  {
    return $this->cTipVeh;
  }

  /**
   * Get the value of dCapac
   *
   * @return int
   */
  public function getDCapac(): int
  {
    return $this->dCapac;
  }

  /**
   * Get the value of dCilin
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
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('gVehNuevo');

    $res->appendChild(new DOMElement('iTipOpVN', $this->getDDesTipOpVN()));
    $res->appendChild(new DOMElement('dDesTipOpVN', $this->getDDesTipOpVN()));
    $res->appendChild(new DOMElement('dChasis', $this->getDChasis()));
    $res->appendChild(new DOMElement('dColor', $this->getDColor()));
    $res->appendChild(new DOMElement('dPotencia', $this->getDPotencia()));
    $res->appendChild(new DOMElement('dCapMot', $this->getDCapMot()));
    $res->appendChild(new DOMElement('dPNet', $this->getDPNet()));
    $res->appendChild(new DOMElement('dPBruto', $this->getDPBruto()));
    $res->appendChild(new DOMElement('iTipCom', $this->getITipCom()));
    $res->appendChild(new DOMElement('dDesTipCom', $this->getDDesTipCom()));
    $res->appendChild(new DOMElement('dNroMotor', $this->getDNroMotor()));
    $res->appendChild(new DOMElement('dCapTracc', $this->getDCapTracc()));
    $res->appendChild(new DOMElement('dAnoFab', $this->getDAnoFab()));
    $res->appendChild(new DOMElement('cTipVeh', $this->getCTipVeh()));
    $res->appendChild(new DOMElement('dCapac', $this->getDCapac()));
    $res->appendChild(new DOMElement('dCilin', $this->getDCilin()));

    return $res;
  }

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return GVehNuevo
  //  */
  // public static function fromDOMElement(DOMElement $xml): GVehNuevo
  // {
  //   if (strcmp($xml->tagName, 'gVehNuevo') === 0 && $xml->childElementCount == 14) {
  //     $res = new GVehNuevo();
  //     $res->setITipOpVN(intval($xml->getElementsByTagName('iTipOpVN')->item(0)->nodeValue));
  //     $res->setDChasis($xml->getElementsByTagName('dChasis')->item(0)->nodeValue);
  //     $res->setDColor($xml->getElementsByTagName('dColor')->item(0)->nodeValue);
  //     $res->setDPotencia(intval($xml->getElementsByTagName('dPotencia')->item(0)->nodeValue));
  //     $res->setDCapMot(intval($xml->getElementsByTagName('dCapMot')->item(0)->nodeValue));
  //     $res->setDPNet(intval($xml->getElementsByTagName('dPnet')->item(0)->nodeValue));
  //     $res->setDPBruto(intval($xml->getElementsByTagName('dPBruto')->item(0)->nodeValue));
  //     $res->setITipCom(intval($xml->getElementsByTagName('iTipCom')->item(0)->nodeValue));
  //     $res->setDNroMotor($xml->getElementsByTagName('dNroMotor')->item(0)->nodeValue);
  //     $res->setDCapTracc(intval($xml->getElementsByTagName('dCapTracc')->item(0)->nodeValue));
  //     $res->setDAnoFab(intval($xml->getElementsByTagName('dAnoFab')->item(0)->nodeValue));
  //     $res->setCTipVeh($xml->getElementsByTagName('ctipVeh')->item(0)->nodeValue);
  //     $res->setDCapac(intval($xml->getElementsByTagName('dCapac')->item(0)->nodeValue));
  //     $res->setDCilin($xml->getElementsByTagName('dCilin')->item(0)->nodeValue);
  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }

  /**
   * FromSifenResponseObject
   *
   * @param  mixed $object
   * @return self
   */
  public static function FromSifenResponseObject($object): self
  {
    $res = new self();
    if (isset($object->iTipOpVN)) {
      $res->setITipOpVN(intval($object->iTipOpVN));
    }
    if (isset($object->dChasis)) {
      $res->setDChasis($object->dChasis);
    }
    if (isset($object->dColor)) {
      $res->setDColor($object->dColor);
    }
    if (isset($object->dPotencia)) {
      $res->setDPotencia(intval($object->dPotencia));
    }
    if (isset($object->dCapMot)) {
      $res->setDCapMot(intval($object->dCapMot));
    }
    if (isset($object->dPNet)) {
      $res->setDPNet(intval($object->dPNet));
    }
    if (isset($object->dPBruto)) {
      $res->setDPBruto(intval($object->dPBruto));
    }
    if (isset($object->iTipCom)) {
      $res->setITipCom(intval($object->iTipCom));
    }
    if (isset($object->dNroMotor)) {
      $res->setDNroMotor($object->dNroMotor);
    }
    if (isset($object->dCapTracc)) {
      $res->setDCapTracc(intval($object->dCapTracc));
    }
    if (isset($object->dAnoFab)) {
      $res->setDAnoFab(intval($object->dAnoFab));
    }
    if (isset($object->cTipVeh)) {
      $res->setCTipVeh($object->cTipVeh);
    }
    if (isset($object->dCapac)) {
      $res->setDCapac(intval($object->dCapac));
    }
    if (isset($object->dCilin)) {
      $res->setDCilin($object->dCilin);
    }
    return $res;
  }
}
