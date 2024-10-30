<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use Abiliomp\Pkuatia\Core\Fields\BaseSifenField;
use DOMDocument;
use DOMElement;
use Exception;
use stdClass;

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
  public ?int $dPNet; ///E777 Peso Neto 
  public ?int $dPBruto; ///E778 Peso Bruto
  public ?int $iTipCom; ///E779 Tipo de combustible
  public ?String $dDesTipCom; ///E780 Descripción del tipo de combustible
  public String $dNroMotor; ///E781 Numero de Motor
  public ?int $dCapTracc; ///E782 Capacidad máxima de  tracción 
  public ?int $dAnoFab; ///E783 Año de fabricación
  public String $cTipVeh; ///E784 Tipo de vehículo
  public ?int $dCapac; ///E785 Capacidad máxima de pasajeros 
  public String $dCilin; ///E786  Cilindradas del motor

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
   * Establece el valor de dPNet
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
   * Establece el valor de dPBruto
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
   * Establece el valor de dCapTracc
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
   * Obtiene el valor de dChasis
   *
   * @return String
   */
  public function getDChasis(): String
  {
    return $this->dChasis;
  }

  /**
   * Obtiene el valor de dColor
   *
   * @return String
   */
  public function getDColor(): String
  {
    return $this->dColor;
  }

  /**
   * Obtiene el valor de dPotencia
   *
   * @return int
   */
  public function getDPotencia(): int
  {
    return $this->dPotencia;
  }

  /**
   * Obtiene el valor de dCapMot
   *
   * @return int
   */
  public function getDCapMot(): int
  {
    return $this->dCapMot;
  }

  /**
   * Obtiene el valor de dPNet
   *
   * @return int
   */
  public function getDPNet(): int
  {
    return $this->dPNet;
  }

  /**
   * Obtiene el valor de dPBruto
   *
   * @return int
   */
  public function getDPBruto(): int
  {
    return $this->dPBruto;
  }

  /**
   * Obtiene el valor de iTipCom
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
   */
  public function getDCapTracc(): int
  {
    return $this->dCapTracc;
  }

  /**
   * Obtiene el valor de dAnoFab
   *
   * @return int
   */
  public function getDAnoFab(): int
  {
    return $this->dAnoFab;
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
  public function getDCapac(): int
  {
    return $this->dCapac;
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
      $res->appendChild(new DOMElement('iTipOpVN', $this->getDDesTipOpVN()));
      $res->appendChild(new DOMElement('dDesTipOpVN', $this->getDDesTipOpVN()));
    }
    if(isset($this->dChasis))
      $res->appendChild(new DOMElement('dChasis', $this->getDChasis()));
    if(isset($this->dColor))
      $res->appendChild(new DOMElement('dColor', $this->getDColor()));
    if(isset($this->dPotencia))
      $res->appendChild(new DOMElement('dPotencia', $this->getDPotencia()));
    if(isset($this->dCapMot))
      $res->appendChild(new DOMElement('dCapMot', $this->getDCapMot()));
    if(isset($this->dPNet))
      $res->appendChild(new DOMElement('dPNet', $this->getDPNet()));
    if(isset($this->dPBruto))
      $res->appendChild(new DOMElement('dPBruto', $this->getDPBruto()));
    if(isset($this->iTipCom)) {
      $res->appendChild(new DOMElement('iTipCom', $this->getITipCom()));
      $res->appendChild(new DOMElement('dDesTipCom', $this->getDDesTipCom()));
    }
    if(isset($this->dNroMotor))
      $res->appendChild(new DOMElement('dNroMotor', $this->getDNroMotor()));
    if(isset($this->dCapTracc))
      $res->appendChild(new DOMElement('dCapTracc', $this->getDCapTracc()));
    if(isset($this->dAnoFab))
      $res->appendChild(new DOMElement('dAnoFab', $this->getDAnoFab()));
    if(isset($this->cTipVeh))
      $res->appendChild(new DOMElement('cTipVeh', $this->getCTipVeh()));
    if(isset($this->dCapac))
      $res->appendChild(new DOMElement('dCapac', $this->getDCapac()));
    if(isset($this->dCilin))
      $res->appendChild(new DOMElement('dCilin', $this->getDCilin()));
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
          $res->setDPNet(intval(trim($node->getElementsByTagName('dPNet')->item(0)->nodeValue)));
        if($node->getElementsByTagName('dPBruto')->length > 0)
          $res->setDPBruto(intval(trim($node->getElementsByTagName('dPBruto')->item(0)->nodeValue)));
        if($node->getElementsByTagName('iTipCom')->length > 0)
          $res->setITipCom(intval(trim($node->getElementsByTagName('iTipCom')->item(0)->nodeValue)));
        if($node->getElementsByTagName('dDesTipCom')->length > 0)
          $res->setDDesTipCom(trim($node->getElementsByTagName('dDesTipCom')->item(0)->nodeValue));
        if($node->getElementsByTagName('dNroMotor')->length > 0)
          $res->setDNroMotor(trim($node->getElementsByTagName('dNroMotor')->item(0)->nodeValue));
        if($node->getElementsByTagName('dCapTracc')->length > 0)
          $res->setDCapTracc(intval(trim($node->getElementsByTagName('dCapTracc')->item(0)->nodeValue)));
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

  public static function FromSifenResponseObject(stdClass $object): self
  {
    throw new \Exception("Not implemented");
    $res = new self();
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
      $res->setDPNet(intval($node->dPNet));
    }
    if (isset($node->dPBruto)) {
      $res->setDPBruto(intval($node->dPBruto));
    }
    if (isset($node->iTipCom)) {
      $res->setITipCom(intval($node->iTipCom));
    }
    if (isset($node->dNroMotor)) {
      $res->setDNroMotor($node->dNroMotor);
    }
    if (isset($node->dCapTracc)) {
      $res->setDCapTracc(intval($node->dCapTracc));
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
}
