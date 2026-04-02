<?php

namespace IonysDev\Pkuatia\Core\Fields\DE\E;

use IonysDev\Pkuatia\DataMappings\DepartamentoMapping;
use IonysDev\Pkuatia\DataMappings\PyGeoCodesMapping;
use IonysDev\Pkuatia\Core\Constants\CamAENatVen;
use IonysDev\Pkuatia\Core\Constants\CamAETipIDVen;
use DOMDocument;
use DOMElement;

/**
 * Nodo Id:     E300
 * Nombre:      gCamAE
 * Descripción: Campos de la Autofactura Electrónica (datos del vendedor no contribuyente o extranjero y lugar de la operación).
 * Nodo Padre:  E001 - gDtipDE - Campos específicos por tipo de Documento Electrónico
 *
 * Los códigos E3xx corresponden al manual de campos SIFEN. Preferir los setters que reciben códigos numéricos:
 * suelen rellenar automáticamente la descripción homóloga vía {@see DepartamentoMapping} o {@see PyGeoCodesMapping}.
 */

class GCamAE
{
                                   // Id - Longitud - Ocurrencia - Descripción (manual SIFEN)
  public int    $iNatVen;     // E301 - 1     - 1-1 - Naturaleza del vendedor
  public String $dDesNatVen;  // E302 - 10-16 - 1-1 - Descripción de la naturaleza del vendedor
  public int    $iTipIDVen;   // E304 - 1     - 1-1 - Tipo de documento de identidad del vendedor
  public String $dDTipIDVen;  // E305 - 9-20  - 1-1 - Descripción del tipo de documento de identidad del vendedor
  public String $dNumIDVen;   // E306 - 1-20  - 1-1 - Número de documento de identidad del vendedor
  public String $dNomVen;     // E307 - 4-60  - 1-1 - Nombre y apellido del vendedor
  public String $dDirVen;     // E308 - 1-255 - 1-1 - Dirección del vendedor (calle principal)
  public int    $dNumCasVen;  // E309 - 1-6   - 1-1 - Número de casa del vendedor
  public int    $cDepVen;     // E310 - 1-2   - 1-1 - Código de departamento del vendedor
  public String $dDesDepVen;  // E311 - 6-16  - 1-1 - Descripción del departamento del vendedor
  public int    $cDisVen;    // E312 - 1-4   - 0-1 - Código de distrito del vendedor
  public String $dDesDisVen;  // E313 - 1-30  - 0-1 - Descripción del distrito del vendedor
  public int    $cCiuVen;     // E314 - 1-5   - 1-1 - Código de ciudad del vendedor
  public String $dDesCiuVen;  // E315 - 1-30  - 1-1 - Descripción de la ciudad del vendedor
  public String $dDirProv;    // E316 - 1-255 - 1-1 - Lugar donde se realiza la transacción (dirección en el lugar de la operación)
  public int    $cDepProv;    // E317 - 1-2   - 1-1 - Código de departamento del lugar de la transacción
  public String $dDesDepProv; // E318 - 6-16  - 1-1 - Descripción del departamento del lugar de la transacción
  public int    $cDisProv;    // E319 - 1-4   - 0-1 - Código de distrito del lugar de la transacción
  public String $dDesDisProv; // E320 - 1-30  - 0-1 - Descripción del distrito del lugar de la transacción
  public int    $cCiuProv;    // E321 - 1-5   - 1-1 - Código de ciudad del lugar de la transacción
  public String $dDesCiuProv; // E322 - 1-30  - 1-1 - Descripción de la ciudad del lugar de la transacción

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor iNatVen (E301) que representa el código de la naturaleza del vendedor.
   * Actualiza dDesNatVen (E302) según la descripción definida en {@see CamAENatVen}.
   *
   * @param int|CamAENatVen $iNatVen Código o caso del enum de la naturaleza del vendedor.
   *
   * @return self Encadenamiento fluido.
   */
  public function setINatVen(int|CamAENatVen $iNatVen): self
  {
    $nat = $iNatVen instanceof CamAENatVen
      ? $iNatVen
      : CamAENatVen::tryFrom($iNatVen);

    if ($nat === null) {
      unset($this->iNatVen, $this->dDesNatVen);
      $dado = $iNatVen instanceof CamAENatVen ? $iNatVen->value : $iNatVen;
      throw new \Exception("[GCamAE] iNatVen debe ser 1 o 2, valor dado: $dado");
    }

    $this->iNatVen = $nat->value;
    $this->dDesNatVen = $nat->getDescription();

    return $this;
  }

  /**
   * Establece dDesNatVen (E302). Preferir {@see setINatVen()}; este setter sirve sobre todo para
   * {@see FromDOMElement()} o valores ya validados contra el manual.
   *
   * @param String $dDesNatVen Literal admitido por el esquema: «No contribuyente» o «Extranjero».
   *
   * @return self Encadenamiento fluido.
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
   * Actualiza dDTipIDVen (E305) según la descripción definida en {@see CamAETipIDVen}.
   *
   * @param int|CamAETipIDVen $iTipIDVen Código o caso del enum del tipo de documento de identidad del vendedor.
   *
   * @return self Encadenamiento fluido.
   */
  public function setITipIDVen(int|CamAETipIDVen $iTipIDVen): self
  {
    $tipo = $iTipIDVen instanceof CamAETipIDVen
      ? $iTipIDVen
      : CamAETipIDVen::tryFrom($iTipIDVen);

    if ($tipo === null) {
      unset($this->iTipIDVen, $this->dDTipIDVen);
      $dado = $iTipIDVen instanceof CamAETipIDVen ? $iTipIDVen->value : $iTipIDVen;
      throw new \Exception("[GCamAE] iTipIDVen debe ser 1, 2, 3 o 4, valor dado: $dado");
    }

    $this->iTipIDVen = $tipo->value;
    $this->dDTipIDVen = $tipo->getDescription();

    return $this;
  }

  /**
   * Establece dDTipIDVen (E305). Preferir {@see setITipIDVen()}; este setter complementa
   * {@see FromDOMElement()} cuando el XML ya trae código y descripción coherentes.
   *
   * @param String $dDTipIDVen Texto según manual (p. ej. «Cédula paraguaya», «Pasaporte»).
   *
   * @return self Encadenamiento fluido.
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
   * @return self Encadenamiento fluido.
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
   * @return self Encadenamiento fluido.
   */
  public function setDNomVen(String $dNomVen): self
  {
    if(strlen($dNomVen) < 4 || strlen($dNomVen) > 60)
      throw new \Exception("[GCamAE] dNomVen debe tener entre 4 y 60 caracteres, valor dado: $dNomVen");
    $this->dNomVen = $dNomVen;
    return $this;
  }


  /**
   * Establece dDirVen (E308): calle principal del vendedor.
   * Para vendedor extranjero, suele indicarse la dirección donde se realizó la operación (criterio manual SIFEN).
   *
   * @param String $dDirVen Entre 1 y 255 caracteres.
   *
   * @return self Encadenamiento fluido.
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
   * @return self Encadenamiento fluido.
   */
  public function setDNumCasVen(int $dNumCasVen): self
  {
    if($dNumCasVen < 0 || $dNumCasVen > 999999)
      throw new \Exception("[GCamAE] dNumCasVen debe tener entre 0 y 999999, valor dado: $dNumCasVen");
    $this->dNumCasVen = $dNumCasVen;
    return $this;
  }


  /**
   * Establece cDepVen (E310) y valida contra catálogo; rellena dDesDepVen (E311) vía {@see DepartamentoMapping}.
   * Para vendedor extranjero, usar el departamento donde se realizó la operación (manual SIFEN).
   * 
   * @param int $cDepVen Código del departamento del vendedor.
   *
   * @return self Encadenamiento fluido.
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
   * Asigna dDesDepVen (E311) sin validar contra catálogo. {@see setCDepVen()} calcula la descripción a partir del código;
   * use este método solo si necesita fijar el texto manualmente (p. ej. deserialización).
   *
   * @param String $dDesDepVen Nombre del departamento.
   *
   * @return self Encadenamiento fluido.
   */
  public function setDDesDepVen(String $dDesDepVen): self
  {
    $this->dDesDepVen = $dDesDepVen;
    return $this;
  }

  /**
   * Establece cDisVen (E312) y rellena dDesDisVen (E313) vía {@see PyGeoCodesMapping::getDistName()}.
   * Para vendedor extranjero, distrito donde se realizó la transacción.
   * 
   * @param int $cDisVen Código del distrito del vendedor.
   *
   * @return self Encadenamiento fluido.
   */
  public function setCDisVen(int|null $cDisVen): self
  {
    if($cDisVen !== null) {
      $this->cDisVen = $cDisVen;
      $this->dDesDisVen = PyGeoCodesMapping::getDistName(strval($cDisVen));
    }
    else {
      unset($this->cDisVen, $this->dDesDisVen);
    }
    return $this;
  }


  /**
   * Establece cCiuVen (E314) y rellena dDesCiuVen (E315) con {@see PyGeoCodesMapping::getCiudName()}.
   *
   * @param int $cCiuVen Código de ciudad según tablas geográficas SIFEN.
   *
   * @return self Encadenamiento fluido.
   */
  public function setCCiuVen(int $cCiuVen): self
  {
    $this->cCiuVen = $cCiuVen;
    $this->dDesCiuVen = PyGeoCodesMapping::getCiudName(strval($cCiuVen));
    return $this;
  }


  /**
   * Establece dDirProv (E316): dirección o referencia del lugar donde se realiza la transacción (lugar de la operación).
   *
   * @param String $dDirProv Texto libre según longitudes del manual.
   *
   * @return self Encadenamiento fluido.
   */
  public function setDDirProv(String $dDirProv): self
  {
    $this->dDirProv = $dDirProv;

    return $this;
  }


  /**
   * Establece cDepProv (E317) y rellena dDesDepProv (E318) con {@see DepartamentoMapping::getDepName()}.
   *
   * @param int $cDepProv Código de departamento del lugar de la transacción.
   *
   * @return self Encadenamiento fluido.
   */
  public function setCDepProv(int $cDepProv): self
  {
    $this->cDepProv = $cDepProv;
    $this->dDesDepProv = DepartamentoMapping::getDepName(strval($cDepProv));
    return $this;
  }


  /**
   * Establece cDisProv (E319) y rellena dDesDisProv (E320) con {@see PyGeoCodesMapping::getDistName()}.
   *
   * @param int $cDisProv Código de distrito del lugar de la transacción.
   *
   * @return self Encadenamiento fluido.
   */
  public function setCDisProv(int $cDisProv): self
  {
    $this->cDisProv = $cDisProv;
    $this->dDesDisProv = PyGeoCodesMapping::getDistName(strval($cDisProv));
    return $this;
  }


  /**
   * Establece cCiuProv (E321) y rellena dDesCiuProv (E322) con {@see PyGeoCodesMapping::getCiudName()}.
   *
   * @param int $cCiuProv Código de ciudad del lugar de la transacción.
   *
   * @return self Encadenamiento fluido.
   */
  public function setCCiuProv(int $cCiuProv): self
  {
    $this->cCiuProv = $cCiuProv;
    $this->dDesCiuProv = PyGeoCodesMapping::getCiudName(strval($cCiuProv));
    return $this;
  }

  /**
   * Asigna dDesDisVen (E313) sin pasar por {@see setCDisVen()}. Uso típico: XML o datos ya validados.
   *
   * @return self Encadenamiento fluido.
   */
  public function setDDesDisVen(String $dDesDisVen): self
  {
    $this->dDesDisVen = $dDesDisVen;
    return $this;
  }

  /**
   * Asigna dDesCiuVen (E315) sin pasar por {@see setCCiuVen()}. Uso típico: XML o datos ya validados.
   *
   * @return self Encadenamiento fluido.
   */
  public function setDDesCiuVen(String $dDesCiuVen): self
  {
    $this->dDesCiuVen = $dDesCiuVen;
    return $this;
  }

  /**
   * Asigna dDesDepProv (E318) sin pasar por {@see setCDepProv()}.
   *
   * @return self Encadenamiento fluido.
   */
  public function setDDesDepProv(String $dDesDepProv): self
  {
    $this->dDesDepProv = $dDesDepProv;
    return $this;
  }

  /**
   * Asigna dDesDisProv (E320) sin pasar por {@see setCDisProv()}.
   *
   * @return self Encadenamiento fluido.
   */
  public function setDDesDisProv(String $dDesDisProv): self
  {
    $this->dDesDisProv = $dDesDisProv;
    return $this;
  }

  /**
   * Asigna dDesCiuProv (E322) sin pasar por {@see setCCiuProv()}.
   *
   * @return self Encadenamiento fluido.
   */
  public function setDDesCiuProv(String $dDesCiuProv): self
  {
    $this->dDesCiuProv = $dDesCiuProv;
    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * iNatVen (E301): código de naturaleza del vendedor ({@see CamAENatVen}).
   */
  public function getINatVen(): int
  {
    return $this->iNatVen;
  }

  /**
   * dDesNatVen (E302): descripción de la naturaleza del vendedor.
   *
   * @return String
   */
  public function getDDesNatVen(): String
  {
    return $this->dDesNatVen;
  }


  /**
   * iTipIDVen (E304): tipo de documento del vendedor ({@see CamAETipIDVen}).
   */
  public function getITipIDVen(): int
  {
    return $this->iTipIDVen;
  }


  /**
   * dDTipIDVen (E305): descripción del tipo de documento del vendedor.
   *
   * @return String
   */
  public function getDDTipIDVen(): String
  {
    return $this->dDTipIDVen;
  }


  /**
   * dNumIDVen (E306): número de documento de identidad del vendedor.
   */
  public function getDNumIDVen(): String
  {
    return $this->dNumIDVen;
  }

  /**
   * dNomVen (E307): nombre y apellido del vendedor.
   */
  public function getDNomVen(): String
  {
    return $this->dNomVen;
  }



  /**
   * dDirVen (E308): dirección (calle) del vendedor.
   */
  public function getDDirVen(): String
  {
    return $this->dDirVen;
  }

  /**
   * dNumCasVen (E309): número de casa; sin numeración usar 0.
   */
  public function getDNumCasVen(): int
  {
    return $this->dNumCasVen;
  }

  /**
   * cDepVen (E310): código de departamento del vendedor.
   */
  public function getCDepVen(): int
  {
    return $this->cDepVen;
  }

  /**
   * dDesDepVen (E311): nombre del departamento del vendedor, obtenido del código `cDepVen` vía {@see DepartamentoMapping}.
   *
   * @return String
   */
  public function getDDesDepVen(): String
  {
    return DepartamentoMapping::getDepName(strval($this->cDepVen));
  }


  /**
   * cDisVen (E312): código de distrito del vendedor (opcional en esquema).
   *
   * @return int
   */
  public function getCDisVen(): int
  {
    return $this->cDisVen;
  }

  /**
   * dDesDisVen (E313): nombre del distrito, obtenido del código `cDisVen` vía {@see PyGeoCodesMapping}.
   *
   * @return String
   */
  public function getDDesDisVen(): String
  {
    return PyGeoCodesMapping::getDistName(strval($this->cDisVen));
  }

  /**
   * cCiuVen (E314): código de ciudad del vendedor.
   *
   * @return int
   */
  public function getCCiuVen(): int
  {
    return $this->cCiuVen;
  }

  /**
   * dDesCiuVen (E315): nombre de la ciudad, obtenido del código `cCiuVen` vía {@see PyGeoCodesMapping}.
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
   * cDepProv (E317): código de departamento del lugar de la transacción.
   *
   * @return int
   */
  public function getCDepProv(): int
  {
    return $this->cDepProv;
  }

  /**
   * dDesDepProv (E318): departamento del lugar de la transacción, obtenido del código `cDepProv` vía {@see DepartamentoMapping}.
   *
   * @return String
   */
  public function getDDesDepProv(): String
  {
    return DepartamentoMapping::getDepName(strval($this->cDepProv));
  }


  /**
   * cDisProv (E319): código de distrito del lugar de la transacción (opcional en esquema).
   *
   * @return int
   */
  public function getCDisProv(): int
  {
    return $this->cDisProv;
  }

  /**
   * dDesDisProv (E320): distrito del lugar de la transacción, obtenido del código `cDisProv` vía {@see PyGeoCodesMapping}.
   *
   * @return String
   */
  public function getDDesDisProv(): String
  {
    return PyGeoCodesMapping::getDistName(strval($this->cDisProv));
  }

  /**
   * cCiuProv (E321): código de ciudad del lugar de la transacción.
   *
   * @return int
   */
  public function getCCiuProv(): int
  {
    return $this->cCiuProv;
  }

  /**
   * dDesCiuProv (E322): ciudad del lugar de la transacción, obtenido del código `cCiuProv` vía {@see PyGeoCodesMapping}.
   *
   * @return String
   */
  public function getDDesCiuProv(): String
  {
    return PyGeoCodesMapping::getCiudName(strval($this->cCiuProv));
  }

  ///////////////////////////////////////////////////////////////////////
  // Serialización XML
  ///////////////////////////////////////////////////////////////////////

  /**
   * Genera el nodo XML `gCamAE` con hijos en el orden exigido por el esquema SIFEN.
   * Los campos de descripción geográfica se obtienen con los getters (mapeo desde códigos cuando aplica).
   *
   * @param DOMDocument $doc Documento propietario de los nodos creados.
   *
   * @return DOMElement Nodo raíz `gCamAE`.
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

    // Manual SIFEN: sin numeración enviar 0
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
   * Construye una instancia desde un nodo `gCamAE` (p. ej. DE recibido o persistido).
   * Exige que el nombre local del nodo sea `gCamAE`; usa setters con validación donde existe.
   *
   * @param DOMElement $node Nodo cuyo `nodeName` debe ser `gCamAE`.
   *
   * @return self Instancia poblada desde el XML.
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
   * Hidratación parcial desde un objeto devuelto por la API SIFEN (p. ej. `stdClass` decodificado).
   * Solo asigna propiedades presentes; no replica la validación completa de {@see FromDOMElement()}.
   *
   * @param object $object Objeto con propiedades homónimas a los campos XML (iNatVen, dNomVen, …).
   *
   * @return self Instancia con los campos disponibles en la respuesta.
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
