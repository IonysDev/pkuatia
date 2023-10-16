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
   * Establece el valor de cCiuVen
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
   * Establece el valor de dDirProv
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
   * Establece el valor de cDepProv
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
   * Establece el valor de cDisProv
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
   * Establece el valor de cCiuProv
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

  public function setDDesDisVen(String $dDesDisVen): self
  {
    $this->dDesDisVen = $dDesDisVen;
    return $this;
  }

  public function setDDesCiuVen(String $dDesCiuVen): self
  {
    $this->dDesCiuVen = $dDesCiuVen;
    return $this;
  }

  public function setDDesDepProv(String $dDesDepProv): self
  {
    $this->dDesDepProv = $dDesDepProv;
    return $this;
  }

  public function setDDesDisProv(String $dDesDisProv): self
  {
    $this->dDesDisProv = $dDesDisProv;
    return $this;
  }

  public function setDDesCiuProv(String $dDesCiuProv): self
  {
    $this->dDesCiuProv = $dDesCiuProv;
    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  ///Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de iNatVen
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
   * Obtiene el valor de iTipIDVen
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
   * Obtiene el valor de dNumIDVen
   */
  public function getDNumIDVen(): String
  {
    return $this->dNumIDVen;
  }

  /**
   * Obtiene el valor de dNomVen
   */
  public function getDNomVen(): String
  {
    return $this->dNomVen;
  }



  /**
   * Obtiene el valor de dDirVen
   */
  public function getDDirVen(): String
  {
    return $this->dDirVen;
  }

  /**
   * Obtiene el valor de dNumCasVen
   */
  public function getDNumCasVen(): int
  {
    return $this->dNumCasVen;
  }

  /**
   * Obtiene el valor de cDepVen
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
   * Obtiene el valor de cDisVen
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
   * Obtiene el valor de cCiuVen
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
   * Obtiene el valor de dDirProv
   *
   * @return String
   */
  public function getDDirProv(): String
  {
    return $this->dDirProv;
  }

  /**
   * Obtiene el valor de cDepProv
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
   * Obtiene el valor de cDisProv
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
   * Obtiene el valor de cCiuProv
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
   * Instancia un objeto GCamAE a partir de un DOMElement que representa el nodo XML del objeto.
   * 
   * @param DOMElement $node Nodo XML que representa el objeto GCamAE
   * 
   * @return GCamAE Objeto GCamAE instanciado
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    if(strcmp($node->nodeName, 'gCamAE') != 0)
      throw new \Exception('[GCamAE] El nombre del nodo no corresponde a gCamAE: ' . $node->nodeName, 1);
    $res = new GCamAE();
    $res->setINatVen(intval($node->getElementsByTagName('iNatVen')->item(0)));
    $res->setDDesNatVen(strval($node->getElementsByTagName('dDesNatVen')->item(0)));
    $res->setITipIDVen(intval($node->getElementsByTagName('iTipIDVen')->item(0)));
    $res->setDDTipIDVen(strval($node->getElementsByTagName('dDTipIDVen')->item(0)));
    $res->setDNumIDVen(strval($node->getElementsByTagName('dNumIDVen')->item(0)));
    $res->setDNomVen(strval($node->getElementsByTagName('dNomVen')->item(0)));
    $res->setDDirVen(strval($node->getElementsByTagName('dDirVen')->item(0)));
    $res->setDNumCasVen(intval($node->getElementsByTagName('dNumCasVen')->item(0)));
    $res->setCDepVen(intval($node->getElementsByTagName('cDepVen')->item(0)));
    $res->setDDesDepVen(strval($node->getElementsByTagName('dDesDepVen')->item(0)));
    if($node->getElementsByTagName('cDisVen')->length > 0)
      $res->setCDisVen(intval($node->getElementsByTagName('cDisVen')->item(0)));
    if($node->getElementsByTagName('dDesDisVen')->length > 0)
      $res->setDDesDisVen(strval($node->getElementsByTagName('dDesDisVen')->item(0)));
    $res->setCCiuVen(intval($node->getElementsByTagName('cCiuVen')->item(0)));
    $res->setDDesCiuVen(strval($node->getElementsByTagName('dDesCiuVen')->item(0)));
    $res->setDDirProv(strval($node->getElementsByTagName('dDirProv')->item(0)));
    $res->setCDepProv(intval($node->getElementsByTagName('cDepProv')->item(0)));
    $res->setDDesDepProv(strval($node->getElementsByTagName('dDesDepProv')->item(0)));
    if($node->getElementsByTagName('cDisProv')->length > 0)
      $res->setCDisProv(intval($node->getElementsByTagName('cDisProv')->item(0)));
    if($node->getElementsByTagName('dDesDisProv')->length > 0)
      $res->setDDesDisProv(strval($node->getElementsByTagName('dDesDisProv')->item(0)));
    $res->setCCiuProv(intval($node->getElementsByTagName('cCiuProv')->item(0)));
    $res->setDDesCiuProv(strval($node->getElementsByTagName('dDesCiuProv')->item(0)));
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
