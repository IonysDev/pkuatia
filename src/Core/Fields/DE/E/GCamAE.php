<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use Abiliomp\Pkuatia\DataMappings\DepartamentoMapping;
use Abiliomp\Pkuatia\DataMappings\PyGeoCodesMapping;
use DOMDocument;
use DOMElement;

/**
 * Nodo Id:     E300
 * Nombre:      gCamAE
 * Descripción: Campos que componen la Autofactura Electrónica
 * Nodo Padre:  E001 - gDtipDE - Campos específicos por tipo de Documento Electrónico
 */

class GCamAE
{
  public int    $iNatVen;     // E301 - 1     - 1-1 - Naturaleza del vendedor
  public String $dDesNatVen;  // E302 - 10-16 - 1-1 - Descripción de la naturaleza del vendedor
  public int    $iTipIDVen;   // E304 - 1     - 1-1 - Tipo de documento de identidad del vendedor
  public String $dDTipIDVen;  // E305 - 9-20  - 1-1 - Descripción del tipo de documento de identidad del vendedor
  public String $dNumIDVen;   // E306 - 1-20  - 1-1 - Número de documento de identidad del vendedor
  public String $dNomVen;     // E307 - 4-60  - 1-1 - Nombre y apellido delvendedor
  public String $dDirVen;     // E308 - 1-255 - 1-1 - Dirección del vendedor
  public int    $dNumCasVen;  // E309 - 1-6   - 1-1 - Número de casa del vendedor
  public int    $cDepVen;     // E310 - 1-2   - 1-1 - Código del departamento del vendedor
  public String $dDesDepVen;  // E311 - 6-16  - 1-1 - Descripción del departamento del vendedor
  public int    $cDisVen;     // E312 - 1-4   - 0-1 - Código del distrito del vendedor
  public String $dDesDisVen;  // E313 - 1-30  - 0-1 - Descripción del distrito del vendedor
  public int    $cCiuVen;     // E314 - 1-5   - 1-1 - Código de la ciudad del vendedor
  public String $dDesCiuVen;  // E315 - 1-30  - 1-1 - Descripción de la ciudad del vendedor
  public String $dDirProv;    // E316 - 1-255 - 1-1 - Lugar de la transacción
  public int    $cDepProv;    // E317 - 1-2   - 1-1 - Código del departamento  donde se realiza la  transacción
  public String $dDesDepProv; // E318 - 6-16  - 1-1 - Descripción del departamento donde se realiza la transacción
  public int    $cDisProv;    // E319 - 1-4   - 0-1 - cDisProv Código del distrito donde se realiza la transacción
  public String $dDesDisProv; // E320 - 1-30  - 0-1 - Descripción del distrito donde se realiza la transacción
  public int    $cCiuProv;    // E321 - 1-5   - 1-1 - cCiuProv Código de la ciudad  donde se realiza la transacción
  public String $dDesCiuProv; // E322 - 1-30  - 1-1 - Descripción de la ciudad donde se realiza la transacción

  ///////////////////////////////////////////////////////////////////////
  ///Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor iNatVen (E301) que representa el código de la naturaleza del vendedor.
   *
   * @param int $iNatVen Código de la naturaleza del vendedor.
   *
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos.
   */
  public function setINatVen(int $iNatVen): self
  {
    $this->iNatVen = $iNatVen;
    switch ($iNatVen) {
      case 1:
        $this->dDesNatVen = "No contribuyente";
        break;
      case 2:
        $this->dDesNatVen = "Extranjero";
        break;
      default:  
        unset($this->dDesNatVen);
        throw new \Exception("[GCamAE] iNatVen debe ser 1 o 2, valor dado: $iNatVen");
        break;
    }
    return $this;
  }

  /**
   * Establece el valor de dDesNatVen (E302) que representa la descripción de la naturaleza del vendedor.
   * No se debería utilizar este método, ya que el valor de dDesNatVen se establece automáticamente.
   * 
   * @param String $dDesNatVen Descripción de la naturaleza del vendedor.
   * 
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos.
   */
  public function setDDesNatVen(String $dDesNatVen): self
  {
    if($dDesNatVen != "No contribuyente" && $dDesNatVen != "Extranjero")
      throw new \Exception("[GCamAE] dDesNatVen debe ser 'No contribuyente' o 'Extranjero', valor dado: $dDesNatVen");
    $this->dDesNatVen = $dDesNatVen;
    return $this;
  }

  /**
   * Establece el valor de iTipIDVen (E304) que representa el código del tipo de documento de identidad del vendedor.
   *
   * @param int $iTipIDVen Código del tipo de documento de identidad del vendedor.
   *
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos.
   */
  public function setITipIDVen(int $iTipIDVen): self
  {
    $this->iTipIDVen = $iTipIDVen;
    switch ($this->iTipIDVen) {
      case 1:
        $this->dDTipIDVen = "Cédula paraguaya";
        break;
      case 2:
        $this->dDTipIDVen = "Pasaporte";
        break;
      case 3:
        $this->dDTipIDVen = "Cédula extranjera";
        break;
      case 4:
        $this->dDTipIDVen = "Carnet de residencia";
        break;
      default:
        unset($this->iTipIDVen);
        unset($this->dDTipIDVen);
        throw new \Exception("[GCamAE] iTipIDVen debe ser 1, 2, 3 o 4, valor dado: $iTipIDVen");
        break;
    }
    return $this;
  }

  /**
   * Establece el valor de dDTipIDVen (E305) que representa la descripción del tipo de documento de identidad del vendedor.
   * Este método no debería ser utilizado, ya que el valor de dDTipIDVen se establece automáticamente a partir de setITipIDVen.
   * 
   * @param String $dDTipIDVen Descripción del tipo de documento de identidad del vendedor.
   * 
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos.
   */
  public function setDDTipIDVen(String $dDTipIDVen): self 
  {
    if($dDTipIDVen != "Cédula paraguaya" && $dDTipIDVen != "Pasaporte" && $dDTipIDVen != "Cédula extranjera" && $dDTipIDVen != "Carnet de residencia")
      throw new \Exception("[GCamAE] dDTipIDVen debe ser 'Cédula paraguaya', 'Pasaporte', 'Cédula extranjera' o 'Carnet de residencia', valor dado: $dDTipIDVen");
    $this->dDTipIDVen = $dDTipIDVen;
    return $this;
  }

  /**
   * Establece el valor de dNumIDVen (E306) que representa el número de documento de identidad del vendedor.
   * 
   * @param String $dNumIDVen Número de documento de identidad del vendedor.
   *
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos.
   */
  public function setDNumIDVen(String $dNumIDVen): self
  {
    if(strlen($dNumIDVen) < 1 || strlen($dNumIDVen) > 20)
      throw new \Exception("[GCamAE] dNumIDVen debe tener entre 1 y 20 caracteres, valor dado: $dNumIDVen");
    $this->dNumIDVen = $dNumIDVen;
    return $this;
  }


  /**
   * Establece el valor de dNomVen (E307) que representa el nombre y apellido del vendedor.
   * 
   * @param String $dNomVen Nombre y apellido del vendedor.
   *
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos.
   */
  public function setDNomVen(String $dNomVen): self
  {
    if(strlen($dNomVen) < 4 || strlen($dNomVen) > 60)
      throw new \Exception("[GCamAE] dNomVen debe tener entre 4 y 60 caracteres, valor dado: $dNomVen");
    $this->dNomVen = $dNomVen;
    return $this;
  }


  /**
   * Establece el valor de dDirVen (E308) que representa la dirección del vendedor.
   * Nombre de la calle principal.
   * En  caso  de  extranjeros,  colocar  la dirección  en  donde  se  realizó  la transacción.
   *
   * @param String $dDirVen
   *
   * @return self
   */
  public function setDDirVen(String $dDirVen): self
  {
    if(strlen($dDirVen) < 1 || strlen($dDirVen) > 255)
      throw new \Exception("[GCamAE] dDirVen debe tener entre 1 y 255 caracteres, valor dado: $dDirVen");
    $this->dDirVen = $dDirVen;
    return $this;
  }


  /**
   * Establece el valor de dNumCasVen (E309) que representa el número de casa del vendedor.
   * Si no tiene numeración colocar 0 (cero).
   *
   * @param int $dNumCasVen Número de casa del vendedor.
   *
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos.
   */
  public function setDNumCasVen(int $dNumCasVen): self
  {
    if($dNumCasVen < 0 || $dNumCasVen > 999999)
      throw new \Exception("[GCamAE] dNumCasVen debe tener entre 0 y 999999, valor dado: $dNumCasVen");
    $this->dNumCasVen = $dNumCasVen;
    return $this;
  }


  /**
   * Establece el valor de cDepVen (E310) que representa el código del departamento del vendedor.
   * En  caso  de  extranjeros,  colocar  el departamento  en  donde  se  realizó  la transacción.
   * 
   * @param int $cDepVen Código del departamento del vendedor.
   *
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos.
   */
  public function setCDepVen(int $cDepVen): self
  {
    $this->dDesDepVen = DepartamentoMapping::getDepName(strval($cDepVen));
    if(is_null($this->dDesDepVen)) {
      unset($this->dDesDepVen);
      throw new \Exception("[GCamAE] cDepVen debe ser un código de departamento válido, valor dado: $cDepVen");
    }
    $this->cDepVen = $cDepVen;
    return $this;
  }

  /**
   * Establece el valor de dDesDepVen (E311) que representa la descripción del departamento del vendedor.
   * Este método no debería ser utilizado, ya que el valor de dDesDepVen se establece automáticamente a partir de setCDepVen.
   * 
   * @param String $dDesDepVen Descripción del departamento del vendedor.
   * 
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos.
   */
  public function setDDesDepVen(String $dDesDepVen): self
  {
    $this->dDesDepVen = $dDesDepVen;
    return $this;
  }

  /**
   * Establece el valor de cDisVen (E312) que representa el código del distrito del vendedor.
   * En caso de extranjeros, colocar el distrito en donde se realizó la transacción.
   * 
   * @param int $cDisVen Código del distrito del vendedor.
   *
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos.
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
   * @param String $dDirProv
   *
   * @return self
   */
  public function setDDirProv(String $dDirProv): self
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
  public function getINatVen(): int
  {
    return $this->iNatVen;
  }

  /**
   * E302 dDesNatVen Descripción de la naturaleza del vendedor
   *
   * @return String
   */
  public function getDDesNatVen(): String
  {
    return $this->dDesNatVen;
  }


  /**
   * Get the value of iTipIDVen
   */
  public function getITipIDVen(): int
  {
    return $this->iTipIDVen;
  }


  /**
   * E305 Descripción del tipo de documento de identidad del vendedor
   *
   * @return String
   */
  public function getDDTipIDVen(): String
  {
    return $this->dDTipIDVen;
  }


  /**
   * Get the value of dNumIDVen
   */
  public function getDNumIDVen(): String
  {
    return $this->dNumIDVen;
  }

  /**
   * Get the value of dNomVen
   */
  public function getDNomVen(): String
  {
    return $this->dNomVen;
  }



  /**
   * Get the value of dDirVen
   */
  public function getDDirVen(): String
  {
    return $this->dDirVen;
  }

  /**
   * Get the value of dNumCasVen
   */
  public function getDNumCasVen(): int
  {
    return $this->dNumCasVen;
  }

  /**
   * Get the value of cDepVen
   */
  public function getCDepVen(): int
  {
    return $this->cDepVen;
  }

  /**
   * E311 Descripción del departamento del vendedor
   *
   * @return String
   */
  public function getDDesDepVen(): String
  {
    return DepartamentoMapping::getDepName(strval($this->cDepVen));
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
   * @return String
   */
  public function getDDesDisVen(): String
  {
    return PyGeoCodesMapping::getDistName(strval($this->cDisVen));
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
   * @return String
   */
  public function getDDesCiuVen(): String
  {
    return PyGeoCodesMapping::getCiudName(strval($this->cCiuVen));
  }


  /**
   * Get the value of dDirProv
   *
   * @return String
   */
  public function getDDirProv(): String
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
   * @return String
   */
  public function getDDesDepProv(): String
  {
    return DepartamentoMapping::getDepName(strval($this->cDepProv));
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
   * @return String
   */
  public function getDDesDisProv(): String
  {
    return PyGeoCodesMapping::getDistName(strval($this->cDisProv));
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
   * @return String
   */
  public function getDDesCiuProv(): String
  {
    return PyGeoCodesMapping::getCiudName(strval($this->cCiuProv));
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML Element
  ///////////////////////////////////////////////////////////////////////

  /**
   * Convierte este GCamAE a un DOMElement mediante un DOMDocument que lo generará.
   * 
   * @param  DOMDocument $doc Documento DOM que generará el DOMElement sin insertarlo.
   *
   * @return DOMElement El DOMElement que representa a este GCamAE en el DOMDocument proporcionado.
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement("gCamAE");

    $res->appendChild(new DOMElement('iNatVen',    $this->getINatVen()));
    $res->appendChild(new DOMElement('dDesNatVen', $this->getDDesNatVen()));
    $res->appendChild(new DOMElement('iTipIDVen',  $this->getITipIDVen()));
    $res->appendChild(new DOMElement('dDTipIDVen', $this->getDDTipIDVen()));
    $res->appendChild(new DOMElement('dNumIDVen',  $this->getDNumIDVen()));
    $res->appendChild(new DOMElement('dNomVen',    $this->getDNomVen()));
    $res->appendChild(new DOMElement('dDirVen',    $this->getDDirVen()));

    ///Si no tiene numeración colocar 0 (cero)
    if (isset($this->dNumCasVen)) {
      $res->appendChild(new DOMElement('dNumCasVen', $this->getDNumCasVen()));
    } else {
      $res->appendChild(new DOMElement('dNumCasVen', 0));
    }

    $res->appendChild(new DOMElement('cDepVen',     $this->getCDepVen()));
    $res->appendChild(new DOMElement('dDesDepVen',  $this->getDDesDepVen()));
    $res->appendChild(new DOMElement('cDisVen',     $this->getCDisVen()));
    $res->appendChild(new DOMElement('dDesDisVen',  $this->getDDesDisVen()));
    $res->appendChild(new DOMElement('cCiuVen',     $this->getCCiuVen()));
    $res->appendChild(new DOMElement('dDesCiuVen',  $this->getDDesCiuVen()));
    $res->appendChild(new DOMElement('dDirProv',    $this->getDDirProv()));
    $res->appendChild(new DOMElement('cDepProv',    $this->getCDepProv()));
    $res->appendChild(new DOMElement('dDesDepProv', $this->getDDesDepProv()));
    $res->appendChild(new DOMElement('cDisProv',    $this->getCDisProv()));
    $res->appendChild(new DOMElement('dDesDisProv', $this->getDDesDisProv()));
    $res->appendChild(new DOMElement('cCiuProv',    $this->getCCiuProv()));
    $res->appendChild(new DOMElement('dDesCiuProv', $this->getDDesCiuProv()));

    return $res;
  }

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
