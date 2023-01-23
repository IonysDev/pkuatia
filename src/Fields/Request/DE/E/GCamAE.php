<?php

namespace Abiliomp\Pkuatia\Fields\E;

use DOMElement;

/**
 * Campos que componen la Autofactura Electrónica
 * ID:E300
 * PADRE:E001
 */
class GCamAE
{
  public int $iNatVen; //ID:E301 Naturaleza del vendedor PADRE:E300
  public int $iTipIDVen; //ID:E304 Tipo de documento de identidad del vendedor PADRE:E300
  public string $dNumIDVen; //ID:E306 Número de documento de identidad del vendedor PADRE:E300
  public string $dNomVen; //ID:E307 Nombre y apellido delvendedor PADRE:E300
  public string $dDirVen; //ID:E308 Dirección del vendedor PADRE:E300
  public int $dNumCasVen; //ID:E309 dNumCasVen Número de casa del vendedor PADRE:E300
  public int $cDepVen; //ID:E310 Código del departamento del vendedor PADRE:E300
  public int $cDisVen; //ID:E312 Código del distrito del vendedor PADRE:E300
  public int $cCiuVen; //ID:E314 Código de la ciudad del vendedor PADRE:E300
  public string $dDirProv; //ID:E316 dDirProv Lugar de la transacción PADRE:E300
  public int $cDepProv; //ID:E317 Código del departamento  donde se realiza la  transacción
  public int $cDisProv; //ID:E319 cDisProv Código del distrito donde se realiza la transacción
  public int $cCiuProv; //ID:E321 cCiuProv Código de la ciudad  donde se realiza la transacción

  ///Setters

  /**
   * Set the value of iNatVen
   *
   * @param int $iNatVen
   *
   * @return self
   */
  public function setINatVen(int $iNatVen): self
  {
    $this->iNatVen = $iNatVen;

    return $this;
  }


  /**
   * Set the value of iTipIDVen
   *
   * @param int $iTipIDVen
   *
   * @return self
   */
  public function setITipIDVen(int $iTipIDVen): self
  {
    $this->iTipIDVen = $iTipIDVen;

    return $this;
  }


  /**
   * Set the value of dNumIDVen
   *
   * @param string $dNumIDVen
   *
   * @return self
   */
  public function setDNumIDVen(string $dNumIDVen): self
  {
    $this->dNumIDVen = $dNumIDVen;

    return $this;
  }


  /**
   * Set the value of dNomVen
   *
   * @param string $dNomVen
   *
   * @return self
   */
  public function setDNomVen(string $dNomVen): self
  {
    $this->dNomVen = $dNomVen;

    return $this;
  }


  /**
   * Set the value of dDirVen
   *
   * @param string $dDirVen
   *
   * @return self
   */
  public function setDDirVen(string $dDirVen): self
  {
    $this->dDirVen = $dDirVen;

    return $this;
  }


  /**
   * Set the value of dNumCasVen
   *
   * @param int $dNumCasVen
   *
   * @return self
   */
  public function setDNumCasVen(int $dNumCasVen): self
  {
    $this->dNumCasVen = $dNumCasVen;

    return $this;
  }


  /**
   * Set the value of cDepVen
   *
   * @param int $cDepVen
   *
   * @return self
   */
  public function setCDepVen(int $cDepVen): self
  {
    $this->cDepVen = $cDepVen;

    return $this;
  }

  /**
   * Set the value of cDisVen
   *
   * @param int $cDisVen
   *
   * @return self
   */
  public function setCDisVen(int $cDisVen): self
  {
    $this->cDisVen = $cDisVen;

    return $this;
  }


  /**
   * Set the value of cCiuVen
   *
   * @param int $cCiuVen
   *
   * @return self
   */
  public function setCCiuVen(int $cCiuVen): self
  {
    $this->cCiuVen = $cCiuVen;

    return $this;
  }


  /**
   * Set the value of dDirProv
   *
   * @param string $dDirProv
   *
   * @return self
   */
  public function setDDirProv(string $dDirProv): self
  {
    $this->dDirProv = $dDirProv;

    return $this;
  }


  /**
   * Set the value of cDepProv
   *
   * @param int $cDepProv
   *
   * @return self
   */
  public function setCDepProv(int $cDepProv): self
  {
    $this->cDepProv = $cDepProv;

    return $this;
  }


  /**
   * Set the value of cDisProv
   *
   * @param int $cDisProv
   *
   * @return self
   */
  public function setCDisProv(int $cDisProv): self
  {
    $this->cDisProv = $cDisProv;

    return $this;
  }


  /**
   * Set the value of cCiuProv
   *
   * @param int $cCiuProv
   *
   * @return self
   */
  public function setCCiuProv(int $cCiuProv): self
  {
    $this->cCiuProv = $cCiuProv;

    return $this;
  }


  ///Getters

  /**
   * Get the value of iNatVen
   */
  public function getINatVen()
  {
    return $this->iNatVen;
  }

  /**
   * E302 dDesNatVen Descripción de la naturaleza del vendedor
   *
   * @return string
   */
  public function getDDesNatVen(): string
  {
    switch ($this->iNatVen) {
      case 1:
        return "No contribuyente";
        break;

      case 2:
        return "Extranjero";
        break;

      default:
        return null;
        break;
    }
  }


  /**
   * Get the value of iTipIDVen
   */
  public function getITipIDVen()
  {
    return $this->iTipIDVen;
  }


  /**
   * E305 Descripción del tipo de documento de identidad del vendedor
   *
   * @return string
   */
  public function getDDTipIDVen(): string
  {
    switch ($this->iTipIDVen) {
      case 1:
        return "Cédula paraguaya";
        break;

      case 2:
        return "Pasaporte";
        break;

      case 3:
        return "Cédula extranjera";
        break;

      case 4:
        return "Carnet de residencia";
        break;

      default:
        return null;
        break;
    }
  }


  /**
   * Get the value of dNumIDVen
   */
  public function getDNumIDVen()
  {
    return $this->dNumIDVen;
  }

  /**
   * Get the value of dNomVen
   */
  public function getDNomVen()
  {
    return $this->dNomVen;
  }



  /**
   * Get the value of dDirVen
   */
  public function getDDirVen()
  {
    return $this->dDirVen;
  }

  /**
   * Get the value of dNumCasVen
   */
  public function getDNumCasVen()
  {
    return $this->dNumCasVen;
  }

  /**
   * Get the value of cDepVen
   */
  public function getCDepVen()
  {
    return $this->cDepVen;
  }

  /**
   * E311 Descripción del departamento del vendedor
   *
   * @return string
   */
  public function getDDesDepVen(): string
  {
    return "Mordor";
  }


  /**
   * Get the value of cDisVen
   *
   * @return int
   */
  public function getCDisVen(): int
  {
    return $this->cDisVen;
  }

  /**
   * E313 Descripción del distrito del vendedor
   *
   * @return string
   */
  public function getDDesDisVen(): string
  {
    return "Mordor";
  }

  /**
   * Get the value of cCiuVen
   *
   * @return int
   */
  public function getCCiuVen(): int
  {
    return $this->cCiuVen;
  }

  /**
   * E315  Descripción de la ciudad del vendedor 
   *
   * @return string
   */
  public function getDDesCiuVen(): string
  {
    return "Mordor";
  }


  /**
   * Get the value of dDirProv
   *
   * @return string
   */
  public function getDDirProv(): string
  {
    return $this->dDirProv;
  }

  /**
   * Get the value of cDepProv
   *
   * @return int
   */
  public function getCDepProv(): int
  {
    return $this->cDepProv;
  }

  /**
   * E318 Descripción del departamento donde se realiza la transacción
   *
   * @return string
   */
  public function getDDesDepProv(): string
  {
    return "Mordor";
  }


  /**
   * Get the value of cDisProv
   *
   * @return int
   */
  public function getCDisProv(): int
  {
    return $this->cDisProv;
  }

  /**
   * E320 Descripción del distrito donde se realiza la transacción
   *
   * @return string
   */
  public function getDDesDisProv(): string
  {
    return "Mordor";
  }

  /**
   * Get the value of cCiuProv
   *
   * @return int
   */
  public function getCCiuProv(): int
  {
    return $this->cCiuProv;
  }

  /**
   * E322 Descripción de la ciudad donde se realiza la transacción
   *
   * @return string
   */
  public function getDDesCiuProv(): string
  {
    return "Mordor";
  }


  ///XML Element

  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement("gCamAE");

    $res->appendChild(new DOMElement('iNatVen', $this->getINatVen()));
    $res->appendChild(new DOMElement('dDesNatVen', $this->getDDesNatVen()));
    $res->appendChild(new DOMElement('iTipIDVen', $this->getITipIDVen()));
    $res->appendChild(new DOMElement('dDTipIDVen', $this->getDDTipIDVen()));
    $res->appendChild(new DOMElement('dNumIDVen', $this->getDNumIDVen()));
    $res->appendChild(new DOMElement('dNomVen', $this->getDNomVen()));
    $res->appendChild(new DOMElement('dDirVen', $this->getDDirVen()));

    ///Si no tiene numeración colocar 0 (cero)
    if (isset($this->dNumCasVen)) {
      $res->appendChild(new DOMElement('dNumCasVen', $this->getDNumCasVen()));
    } else {
      $res->appendChild(new DOMElement('dNumCasVen', 0));
    }

    $res->appendChild(new DOMElement('cDepVen', $this->getCDepVen()));
    $res->appendChild(new DOMElement('dDesDepVen', $this->getDDesDepVen()));
    $res->appendChild(new DOMElement('cDisVen', $this->getCDisVen()));
    $res->appendChild(new DOMElement('dDesDisVen', $this->getDDesDisVen()));
    $res->appendChild(new DOMElement('cCiuVen', $this->getCCiuVen()));
    $res->appendChild(new DOMElement('dDesCiuVen', $this->getDDesCiuVen()));
    $res->appendChild(new DOMElement('dDirProv', $this->getDDirProv()));
    $res->appendChild(new DOMElement('cDepProv', $this->getCDepProv()));
    $res->appendChild(new DOMElement('dDesDepProv', $this->getDDesDepProv()));
    $res->appendChild(new DOMElement('cDisProv', $this->getCDisProv()));
    $res->appendChild(new DOMElement('dDesDisProv', $this->getDDesDisProv()));
    $res->appendChild(new DOMElement('cCiuProv', $this->getCCiuProv()));
    $res->appendChild(new DOMElement('dDesCiuProv', $this->getDDesCiuProv()));

    return $res;
  }
}
?> 