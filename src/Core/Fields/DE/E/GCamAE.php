<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use Abiliomp\Pkuatia\Helpers\DepartamentoHelper;
use Abiliomp\Pkuatia\Helpers\GeoRefCodesHelper;
use DOMElement;

/**
 * Nodo Id:     E300
 * Nombre:      gCamAE
 * Descripción: Campos que componen la Autofactura Electrónica
 * Nodo Padre:  E001 - gDtipDE - Campos específicos por tipo de Documento Electrónico
 */

class GCamAE
{
  public int    $iNatVen;    // E301 - 1     - 1-1 - Naturaleza del vendedor PADRE:E300
  public String $dDesNatVen; // E305 - 10-16 - 1-1 - Descripción de la naturaleza del vendedor
  public int    $iTipIDVen;  // E304 - 1     - 1-1 - Tipo de documento de identidad del vendedor
  public String $dDTipIDVen; // E305 - 9-20  - 1-1 - Descripción del tipo de documento de identidad del vendedor
  public String $dNumIDVen;  // E306 - 1-20  - 1-1 - Número de documento de identidad del vendedor PADRE:E300
  public String $dNomVen;    // E307 - 4-60  - 1-1 - Nombre y apellido delvendedor PADRE:E300
  public String $dDirVen;    // E308 - 1-255 - 1-1 - Dirección del vendedor PADRE:E300
  public int    $dNumCasVen; // E309 - 1-6   - 1-1 - Número de casa del vendedor PADRE:E300
  public int    $cDepVen;    // E310 Código del departamento del vendedor PADRE:E300
  public int    $cDisVen;    // E312 Código del distrito del vendedor PADRE:E300
  public int    $cCiuVen;    // E314 Código de la ciudad del vendedor PADRE:E300
  public String $dDirProv;   // E316 dDirProv Lugar de la transacción PADRE:E300
  public int    $cDepProv;   // E317 Código del departamento  donde se realiza la  transacción
  public int    $cDisProv;   // E319 cDisProv Código del distrito donde se realiza la transacción
  public int    $cCiuProv;   // E321 cCiuProv Código de la ciudad  donde se realiza la transacción

  ///////////////////////////////////////////////////////////////////////
  ///Setters
  ///////////////////////////////////////////////////////////////////////

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

  ///////////////////////////////////////////////////////////////////////
  ///Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Get the value of iNatVen
   */
  public function getINatVen(): int | null
  {
    return $this->iNatVen;
  }

  /**
   * E302 dDesNatVen Descripción de la naturaleza del vendedor
   *
   * @return string
   */
  public function getDDesNatVen(): string | null
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
  public function getITipIDVen(): int | null
  {
    return $this->iTipIDVen;
  }


  /**
   * E305 Descripción del tipo de documento de identidad del vendedor
   *
   * @return string
   */
  public function getDDTipIDVen(): string | null
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
  public function getDNumIDVen(): string | null
  {
    return $this->dNumIDVen;
  }

  /**
   * Get the value of dNomVen
   */
  public function getDNomVen(): string | null
  {
    return $this->dNomVen;
  }



  /**
   * Get the value of dDirVen
   */
  public function getDDirVen(): string | null
  {
    return $this->dDirVen;
  }

  /**
   * Get the value of dNumCasVen
   */
  public function getDNumCasVen(): int | null
  {
    return $this->dNumCasVen;
  }

  /**
   * Get the value of cDepVen
   */
  public function getCDepVen(): int | null
  {
    return $this->cDepVen;
  }

  /**
   * E311 Descripción del departamento del vendedor
   *
   * @return string
   */
  public function getDDesDepVen(): string | null
  {
    return DepartamentoHelper::getDepName(strval($this->cDepVen));
  }


  /**
   * Get the value of cDisVen
   *
   * @return int
   */
  public function getCDisVen(): int | null
  {
    return $this->cDisVen;
  }

  /**
   * E313 Descripción del distrito del vendedor
   *
   * @return string
   */
  public function getDDesDisVen(): string | null
  {
    return GeoRefCodesHelper::getDistName(strval($this->cDisVen));
  }

  /**
   * Get the value of cCiuVen
   *
   * @return int
   */
  public function getCCiuVen(): int | null
  {
    return $this->cCiuVen;
  }

  /**
   * E315  Descripción de la ciudad del vendedor 
   *
   * @return string
   */
  public function getDDesCiuVen(): string | null
  {
    return GeoRefCodesHelper::getCiudName(strval($this->cCiuVen));
  }


  /**
   * Get the value of dDirProv
   *
   * @return string
   */
  public function getDDirProv(): string | null
  {
    return $this->dDirProv;
  }

  /**
   * Get the value of cDepProv
   *
   * @return int
   */
  public function getCDepProv(): int | null
  {
    return $this->cDepProv;
  }

  /**
   * E318 Descripción del departamento donde se realiza la transacción
   *
   * @return string
   */
  public function getDDesDepProv(): string | null
  {
    return DepartamentoHelper::getDepName(strval($this->cDepProv));
  }


  /**
   * Get the value of cDisProv
   *
   * @return int
   */
  public function getCDisProv(): int | null
  {
    return $this->cDisProv;
  }

  /**
   * E320 Descripción del distrito donde se realiza la transacción
   *
   * @return string
   */
  public function getDDesDisProv(): string | null
  {
    return GeoRefCodesHelper::getDistName(strval($this->cDisProv));
  }

  /**
   * Get the value of cCiuProv
   *
   * @return int
   */
  public function getCCiuProv(): int | null
  {
    return $this->cCiuProv;
  }

  /**
   * E322 Descripción de la ciudad donde se realiza la transacción
   *
   * @return string
   */
  public function getDDesCiuProv(): string | null
  {
    return GeoRefCodesHelper::getCiudName(strval($this->cCiuProv));
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

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return GCamAE
  //  */
  // public static function fromDOMElement(DOMElement $xml): GCamAE
  // {
  //   if (strcmp($xml->tagName, 'gcamAE') == 0 && $xml->childElementCount >= 14) {
  //     $res = new GCamAE();
  //     $res->setINatVen(intval($xml->getElementsByTagName('iNatVen')->item(0)->nodeValue));
  //     $res->setITipIDVen(intval($xml->getElementsByTagName('iTipIDVen')->item(0)->nodeValue));
  //     $res->setDNumIDVen($xml->getElementsByTagName('dNumIDVen')->item(0)->nodeValue);
  //     $res->setDNomVen($xml->getElementsByTagName('dNomVen')->item(0)->nodeValue);
  //     $res->setDDirVen($xml->getElementsByTagName('dDirVen')->item(0)->nodeValue);
  //     $res->setDNumCasVen(intval($xml->getElementsByTagName('dNumCasVen')->item(0)->nodeValue));
  //     $res->setCDepVen(intval($xml->getElementsByTagName('cDepVen')->item(0)->nodeValue));
  //     $res->setCDisVen(intval($xml->getElementsByTagName('cDisVen')->item(0)->nodeValue));
  //     $res->setCCiuVen(intval($xml->getElementsByTagName('cCiuVen')->item(0)->nodeValue));
  //     $res->setDDirProv($xml->getElementsByTagName('dDirProv')->item(0)->nodeValue);
  //     $res->setCDepProv(intval($xml->getElementsByTagName('cDepProv')->item(0)->nodeValue));
  //     $res->setCDisProv(intval($xml->getElementsByTagName('cDisProv')->item(0)->nodeValue));
  //     $res->setCCiuProv(intval($xml->getElementsByTagName('cCiuProv')->item(0)->nodeValue));

  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }

  /**
   * FromSimpleXMLElement
   *
   * @param  mixed $object
   * @return self
   */
  public static function FromSifenResponseObject($object): self
  {
    $res = new GCamAE();
    if (isset($object->iNatVen)) {
      $res->setINatVen(intval($object->iNatVen));
    }

    if (isset($object->iTipIDVen)) {
      $res->setITipIDVen(intval($object->iTipIDVen));
    }

    if (isset($object->dNumIDVen)) {
      $res->setDNumIDVen($object->dNumIDVen);
    }
    if (isset($object->dNomVen)) {
      $res->setDNomVen($object->dNomVen);
    }
    if (isset($object->dDirVen)) {
      $res->setDDirVen($object->dDirVen);
    }
    if (isset($object->dNumCasVen)) {
      $res->setDNumCasVen(intval($object->dNumCasVen));
    }
    if (isset($object->cDepVen)) {
      $res->setCDepVen(intval($object->cDepVen));
    }

    if (isset($object->cDisVen)) {
      $res->setCDisVen(intval($object->cDisVen));
    }

    if (isset($object->cCiuVen)) {
      $res->setCCiuVen(intval($object->cCiuVen));
    }

    if (isset($object->dDirProv)) {
      $res->setDDirProv($object->dDirProv);
    }
    if (isset($object->cDepProv)) {
      $res->setCDepProv(intval($object->cDepProv));
    }

    if (isset($object->cDisProv)) {
      $res->setCDisProv(intval($object->cDisProv));
    }

    if (isset($object->cCiuProv)) {
      $res->setCCiuProv(intval($object->cCiuProv));
    }
    return $res;
  }
}
