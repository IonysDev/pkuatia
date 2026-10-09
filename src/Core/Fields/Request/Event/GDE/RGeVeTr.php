<?php

namespace IonysDev\Pkuatia\Core\Fields\Request\Event\GDE;

use IonysDev\Pkuatia\DataMappings\CountryMapping;
use IonysDev\Pkuatia\DataMappings\DepartamentoMapping;
use IonysDev\Pkuatia\DataMappings\PyGeoCodesMapping;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;
use IonysDev\Pkuatia\Helpers\XmlHelper;

/**
 * Nodo: GET001 - rGeVeTr - Grupos de Campos Generales del Evento 
 * Padre: GDE007 - gGroupTiEvt - Grupo de campos del tipo de evento
 */
class RGeVeTr
{
                               // ID - DESCRIPCION- LONGITUD - OCURRENCIA
  public String $Id;           // GET002 - CDC del DTE - 44 - 1 - 1-1
  public int    $dMotEv;       // GET003 - Motivo del evento 1-1
  public int    $cDepEnt;      // GET004 - Código del departamento del local de la entrega - 1-2 - 0-1
  public String $dDesDepEnt;   // GET005 - Descripción del departamento del local de la entrega - 6-16 - 0-1
  public int    $cDisEnt;      // GET006 - Código del distrito del  local de la entrega - 1-4 - 0-1
  public String $dDesDisEnt;   // GET007 - Descripción de distrito del local de la entrega -  1-30 - 0-1
  public int    $cCiuEnt;      // GET008 - Código de la ciudad del local de la entrega - 1-5 - 0-1
  public String $dDesCiuEnt;   // GET009 - Descripción de ciudad del local de la entrega - 1-30 - 0-1
  public String $dDirEnt;      // GET010 - Dirección del local de la entrega - 1-255 - 0-1
  public int    $dNumCas;      // GET011 - Número de casa del local de la entrega - 1-6 - 0-1
  public String $dCompDir1;    // GET012 - Complemento de dirección del local de la entrega - 1-255 - 0-1
  public String $dNomChof;     // GET013 - Nombre y apellido del chofer - 4-69 - 1-1
  public String $dNumIDChof;   // GET014 - Número de documento  de identidad del chofer -  1-20 - 0-1
  public int    $iNatTrans;    // GET015 - Naturaleza del transportista - 1- 0-1
  public String $dRucTrans;    // GET016 - RUC del transportista 3-8 - 0-1
  public int    $dDVTrans;     // GET017 - Dígito verificador del RUC del transportista - 1 - 0-1
  public String $dNomTrans;    // GET018 - Nombre o razón social del transportista - 4-60 - 0-1
  public int    $iTipIDTrans;  // GET019 - Tipo de documento de  identidad del  transportista - 1- 0-1
  public String $dDTipIDTrans; // GET020 - Descripción del tipo de documento de identidad del transportista - 9-20 - 0-1
  public String $dNumIDTrans;  // GET021 - Número de documento de identidad del transportista - 1-20 - 0-1
  public int    $iTipTrans;    // GET022 - Tipo de transporte - 1 - 0-1
  public String $dDesTipTrans; // GET023 - Descripción del tipo de transporte - 6-7 - 0-1
  public int    $iModTrans;    // GET024 - Modalidad del transporte - 1 - 0-1
  public String $dDesModTrans; // GET025 - Descripción de la modalidad del transporte - 5-10 - 0-1
  public String $dTiVehTras;   // GET026 - Tipo de vehículo - 4-10 - 0-1
  public String $dMarVeh;      // GET027 - Marca del vehículo - 1-10  - 0-1
  public int    $dTipIdenVeh;  // GET028 - Tipo de identificación del vehículo - 1 - 0-1
  public String $dNroIDVeh;    // GET029 - Número de identificación del vehículo 1-20 - 0-1
  public String $dNroMatVeh;   // GET030 - Número de matrícula del vehículo - 6 (longitud exacta, tdNroMatVeh) - 0-1


  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de Id
   *
   * @param String $Id
   *
   * @return self
   */
  public function setId(String $Id): self
  {
    $this->Id = $Id;

    return $this;
  }


  /**
   * Establece el valor de dMotEv
   *
   * @param int $dMotEv
   *
   * @return self
   */
  public function setDMotEv(int $dMotEv): self
  {
    $this->dMotEv = $dMotEv;

    return $this;
  }


  /**
   * Establece el valor de cDepEnt
   *
   * @param int $cDepEnt
   *
   * @return self
   */
  public function setCDepEnt(int $cDepEnt): self
  {
    $this->cDepEnt = $cDepEnt;

    return $this;
  }


  /**
   * Establece el valor de cDisEnt
   *
   * @param int $cDisEnt
   *
   * @return self
   */
  public function setCDisEnt(int $cDisEnt): self
  {
    $this->cDisEnt = $cDisEnt;

    return $this;
  }


  /**
   * Establece el valor de cCiuEnt
   *
   * @param int $cCiuEnt
   *
   * @return self
   */
  public function setCCiuEnt(int $cCiuEnt): self
  {
    $this->cCiuEnt = $cCiuEnt;

    return $this;
  }


  /**
   * Establece el valor de dDirEnt
   *
   * @param String $dDirEnt
   *
   * @return self
   */
  public function setDDirEnt(String $dDirEnt): self
  {
    $this->dDirEnt = $dDirEnt;

    return $this;
  }


  /**
   * Establece el valor de dNumCas
   *
   * @param int $dNumCas
   *
   * @return self
   */
  public function setDNumCas(int $dNumCas): self
  {
    $this->dNumCas = $dNumCas;

    return $this;
  }


  /**
   * Establece el valor de dCompDir1
   *
   * @param String $dCompDir1
   *
   * @return self
   */
  public function setDCompDir1(String $dCompDir1): self
  {
    $this->dCompDir1 = $dCompDir1;

    return $this;
  }

  /**
   * Establece el valor de dNomChof
   *
   * @param String $dNomChof
   *
   * @return self
   */
  public function setDNomChof(String $dNomChof): self
  {
    $this->dNomChof = $dNomChof;

    return $this;
  }

  /**
   * Establece el valor de dNumIDChof
   *
   * @param String $dNumIDChof
   *
   * @return self
   */
  public function setDNumIDChof(String $dNumIDChof): self
  {
    $this->dNumIDChof = $dNumIDChof;

    return $this;
  }


  /**
   * Establece el valor de iNatTrans
   *
   * @param int $iNatTrans
   *
   * @return self
   */
  public function setINatTrans(int $iNatTrans): self
  {
    $this->iNatTrans = $iNatTrans;

    return $this;
  }


  /**
   * Establece el valor de dRucTrans
   *
   * @param String $dRucTrans
   *
   * @return self
   */
  public function setDRucTrans(String $dRucTrans): self
  {
    $this->dRucTrans = $dRucTrans;

    return $this;
  }


  /**
   * Establece el valor de dDVTrans
   *
   * @param int $dDVTrans
   *
   * @return self
   */
  public function setDDVTrans(int $dDVTrans): self
  {
    $this->dDVTrans = $dDVTrans;

    return $this;
  }


  /**
   * Establece el valor de dNomTrans
   *
   * @param String $dNomTrans
   *
   * @return self
   */
  public function setDNomTrans(String $dNomTrans): self
  {
    $this->dNomTrans = $dNomTrans;

    return $this;
  }


  /**
   * Establece el valor de iTipIDTrans
   *
   * @param int $iTipIDTrans
   *
   * @return self
   */
  public function setITipIDTrans(int $iTipIDTrans): self
  {
    $this->iTipIDTrans = $iTipIDTrans;

    return $this;
  }


  /**
   * Establece el valor de dNumIDTrans
   *
   * @param String $dNumIDTrans
   *
   * @return self
   */
  public function setDNumIDTrans(String $dNumIDTrans): self
  {
    $this->dNumIDTrans = $dNumIDTrans;

    return $this;
  }


  /**
   * Establece el valor de iTipTrans
   *
   * @param int $iTipTrans
   *
   * @return self
   */
  public function setITipTrans(int $iTipTrans): self
  {
    $this->iTipTrans = $iTipTrans;

    return $this;
  }


  /**
   * Establece el valor de iModTrans
   *
   * @param int $iModTrans
   *
   * @return self
   */
  public function setIModTrans(int $iModTrans): self
  {
    $this->iModTrans = $iModTrans;

    return $this;
  }


  /**
   * Establece el valor de dMarVeh
   *
   * @param String $dMarVeh
   *
   * @return self
   */
  public function setDMarVeh(String $dMarVeh): self
  {
    $this->dMarVeh = $dMarVeh;

    return $this;
  }


  /**
   * Establece el valor de dTipIdenVeh
   *
   * @param int $dTipIdenVeh
   *
   * @return self
   */
  public function setDTipIdenVeh(int $dTipIdenVeh): self
  {
    $this->dTipIdenVeh = $dTipIdenVeh;

    return $this;
  }


  /**
   * Establece el valor de dNroIDVeh
   *
   * @param String $dNroIDVeh
   *
   * @return self
   */
  public function setDNroIDVeh(String $dNroIDVeh): self
  {
    $this->dNroIDVeh = $dNroIDVeh;

    return $this;
  }


  /**
   * Establece el valor de dNroMatVeh
   *
   * @param String $dNroMatVeh
   *
   * @return self
   */
  public function setDNroMatVeh(String $dNroMatVeh): self
  {
    $this->dNroMatVeh = $dNroMatVeh;

    return $this;
  }


  /**
   * Establece el valor de dTiVehTras
   *
   * @param String $dTiVehTras
   *
   * @return self
   */
  public function setDTiVehTras(String $dTiVehTras): self
  {
    $this->dTiVehTras = $dTiVehTras;

    return $this;
  }


  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de Id
   *
   * @return String
   */
  public function getId(): String
  {
    return $this->Id;
  }

  /**
   * Obtiene el valor de dMotEv
   *
   * @return int
   */
  public function getDMotEv(): int
  {
    return $this->dMotEv;
  }

  /**
   * Obtiene el valor de cDepEnt
   *
   * @return int
   */
  public function getCDepEnt(): int
  {
    return $this->cDepEnt;
  }

  /**
   *  GET005 Descripción del departamento del local de la entrega
   *
   * @return String
   */
  public function getDDesDepEnt(): String
  {
    // GET005 es la descripción del departamento (tdDesDepEnt), no de un país: mismo mapeo que GCamEnt.
    return DepartamentoMapping::getDepName(strval($this->cDepEnt));
  }


  /**
   * Obtiene el valor de cDisEnt
   *
   * @return int
   */
  public function getCDisEnt(): int
  {
    return $this->cDisEnt;
  }

  /**
   * GET007  Descripción de distrito del local de la entrega

   *
   * @return String
   */
  public function getDDesDisEnt(): String
  {
    return PyGeoCodesMapping::getDistName(strval($this->cDisEnt)); // GET007 descripción del distrito
  }



  /**
   * Obtiene el valor de cCiuEnt
   *
   * @return int
   */
  public function getCCiuEnt(): int
  {
    return $this->cCiuEnt;
  }

  /**
   *  GET009  Descripción de ciudad del local de la entrega
   *
   * @return String
   */
  public function getDDesCiuEnt(): String
  {
    return PyGeoCodesMapping::getCiudName(strval($this->cCiuEnt)); // GET009 descripción de la ciudad
  }



  /**
   * Obtiene el valor de dDirEnt
   *
   * @return String
   */
  public function getDDirEnt(): String
  {
    return $this->dDirEnt;
  }

  /**
   * Obtiene el valor de dNumCas
   *
   * @return int
   */
  public function getDNumCas(): int
  {
    return $this->dNumCas;
  }

  /**
   * Obtiene el valor de dCompDir1
   *
   * @return String
   */
  public function getDCompDir1(): String
  {
    return $this->dCompDir1;
  }

  /**
   * Obtiene el valor de dNomChof
   *
   * @return String
   */
  public function getDNomChof(): String
  {
    return $this->dNomChof;
  }

  /**
   * Obtiene el valor de dNumIDChof
   *
   * @return String
   */
  public function getDNumIDChof(): String
  {
    return $this->dNumIDChof;
  }

  /**
   * Obtiene el valor de iNatTrans
   *
   * @return int
   */
  public function getINatTrans(): int
  {
    return $this->iNatTrans;
  }

  /**
   * Obtiene el valor de dRucTrans
   *
   * @return String
   */
  public function getDRucTrans(): String
  {
    return $this->dRucTrans;
  }

  /**
   * Obtiene el valor de dDVTrans
   *
   * @return int
   */
  public function getDDVTrans(): int
  {
    return $this->dDVTrans;
  }

  /**
   * Obtiene el valor de dNomTrans
   *
   * @return String
   */
  public function getDNomTrans(): String
  {
    return $this->dNomTrans;
  }

  /**
   * Obtiene el valor de iTipIDTrans
   *
   * @return int
   */
  public function getITipIDTrans(): int
  {
    return $this->iTipIDTrans;
  }

  /**
   *  GET020 Descripción del tipo de documento de identidad del transportista
   *
   * @return String
   */
  public function getdDTipIDTrans(): String
  {
    switch ($this->iTipIDTrans) {
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
        throw new \InvalidArgumentException('[RGeVeTr] iTipIDTrans no válido: ' . $this->iTipIDTrans);
    }
  }

  /**
   * Obtiene el valor de dNumIDTrans
   *
   * @return String
   */
  public function getDNumIDTrans(): String
  {
    return $this->dNumIDTrans;
  }

  /**
   * Obtiene el valor de iTipTrans
   *
   * @return int
   */
  public function getITipTrans(): int
  {
    return $this->iTipTrans;
  }

  /**
   * GET023 Descripción del tipo de transporte
   *
   * @return String
   */
  public function getDDesTipTrans(): String
  {
    switch ($this->iTipTrans) {
      case 1:
        return "Propio";
        break;
      case 2:
        return "Tercero";
        break;

      default:
        return null;
        break;
    }
  }

  /**
   * Obtiene el valor de iModTrans
   *
   * @return int
   */
  public function getIModTrans(): int
  {
    return $this->iModTrans;
  }

  /**
   * GET025 Descripción de la modalidad del transporte
   *
   * @return String
   */
  public function getDDesModTrans(): String
  {
    switch ($this->iModTrans) {
      case 1:
        return "Terrestre";
        break;
      case 2:
        return "Fluvial";
        break;
      case 3:
        return "Aéreo";
        break;
      case 4:
        return "Multimodal";
        break;

      default:
        return null;
        break;
    }
  }



  /**
   * Obtiene el valor de dTiVehTras
   *
   * @return String
   */
  public function getDTiVehTras(): String
  {
    return $this->dTiVehTras;
  }

  /**
   * Obtiene el valor de dMarVeh
   *
   * @return String
   */
  public function getDMarVeh(): String
  {
    return $this->dMarVeh;
  }

  /**
   * Obtiene el valor de dTipIdenVeh
   *
   * @return int
   */
  public function getDTipIdenVeh(): int
  {
    return $this->dTipIdenVeh;
  }

  /**
   * Obtiene el valor de dNroIDVeh
   *
   * @return String
   */
  public function getDNroIDVeh(): String
  {
    return $this->dNroIDVeh;
  }

  /**
   * Obtiene el valor de dNroMatVeh
   *
   * @return String
   */
  public function getDNroMatVeh(): String
  {
    return $this->dNroMatVeh;
  }

  ///////////////////////////////////////////////////////////////////////
  // Conversiones XML
  ///////////////////////////////////////////////////////////////////////

  /**
   * Verifica que estén informados los campos que exige cada motivo (GET003) antes de serializar. Fuente: MT v150
   * (validaciones 4300-4310) y docs/sifen-ai/05-api-sifen/eventos.md.
   *
   * @throws \InvalidArgumentException Si el motivo no es 1-4 o faltan campos del motivo.
   */
  public function validar(): void
  {
    if (!isset($this->Id) || !isset($this->dMotEv))
      throw new \InvalidArgumentException('[RGeVeTr] Id (GET002, CDC de la Nota de Remisión) y dMotEv (GET003, motivo) son obligatorios.');
    $faltan = [];
    $req = function (string $prop, string $desc) use (&$faltan): void {
      if (!isset($this->$prop)) $faltan[] = "$prop ($desc)";
    };
    switch ($this->dMotEv) {
      case 1: // Cambio del local de entrega
        $req('cDepEnt', 'GET004 departamento');
        $req('cCiuEnt', 'GET008 ciudad');
        $req('dDirEnt', 'GET010 dirección');
        $req('dNumCas', 'GET011 número de casa');
        break;
      case 2: // Cambio del chofer
        $req('dNomChof', 'GET013 nombre del chofer');
        $req('dNumIDChof', 'GET014 documento del chofer');
        break;
      case 3: // Cambio del transportista
        $req('iNatTrans', 'GET015 naturaleza del transportista');
        $req('dNomTrans', 'GET018 nombre del transportista');
        if (isset($this->iNatTrans) && $this->iNatTrans == 1) {
          $req('dRucTrans', 'GET016 RUC del transportista');
          $req('dDVTrans', 'GET017 dígito verificador');
        }
        if (isset($this->iNatTrans) && $this->iNatTrans == 2) {
          $req('iTipIDTrans', 'GET019 tipo de documento del transportista');
          $req('dNumIDTrans', 'GET021 número de documento del transportista');
        }
        break;
      case 4: // Cambio de vehículo
        $req('iTipTrans', 'GET022 tipo de transporte');
        $req('iModTrans', 'GET024 modalidad del transporte');
        $req('dTiVehTras', 'GET026 tipo de vehículo');
        $req('dMarVeh', 'GET027 marca');
        $req('dTipIdenVeh', 'GET028 tipo de identificación del vehículo');
        if (isset($this->dTipIdenVeh) && $this->dTipIdenVeh == 1) $req('dNroIDVeh', 'GET029 número de identificación del vehículo');
        if (isset($this->dTipIdenVeh) && $this->dTipIdenVeh == 2) $req('dNroMatVeh', 'GET030 matrícula');
        break;
      default:
        throw new \InvalidArgumentException("[RGeVeTr] dMotEv (GET003) debe ser 1 cambio del local de entrega, 2 cambio del chofer, 3 cambio del transportista o 4 cambio de vehículo; se recibió {$this->dMotEv}.");
    }
    if (count($faltan) > 0)
      throw new \InvalidArgumentException('[RGeVeTr] Para dMotEv = ' . $this->dMotEv . ' faltan: ' . implode(', ', $faltan) . '.');
    // tdNroMatVeh exige longitud exacta 6 (Evento_Types_v150.xsd:524-533), a diferencia del DE (hasta 7).
    if (isset($this->dNroMatVeh) && mb_strlen($this->dNroMatVeh) !== 6)
      throw new \InvalidArgumentException("[RGeVeTr] dNroMatVeh (GET030) debe tener exactamente 6 caracteres en el evento (tdNroMatVeh, Evento_Types_v150.xsd:524-533); se recibió '{$this->dNroMatVeh}'.");
  }

  /**
   * Convierte el objeto a un DOMElement.
   *
   * @param DOMDocument $doc Documento DOM donde se creará el nodo, pero NO será insertado.
   *
   * @return DOMElement Nodo DOM creado pero no insertado.
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $this->validar();
    $res = $doc->createElement('rGeVeTr');
    // Secuencia de trGeVeTr (Evento_v150.xsd:271-299): Id y dMotEv obligatorios; el resto es minOccurs="0" y se emite
    // solo si fue informado. Antes se accedían propiedades sin inicializar (cDisEnt, iNatTrans, dTipIdenVeh) según el
    // motivo, y las descripciones geográficas se buscaban en el catálogo de países.
    $res->appendChild(XmlHelper::elemento($doc, 'Id', $this->getId()));
    $res->appendChild(XmlHelper::elemento($doc, 'dMotEv', $this->getDMotEv()));
    if (isset($this->cDepEnt)) {
      $res->appendChild(XmlHelper::elemento($doc, 'cDepEnt', $this->getCDepEnt()));
      $res->appendChild(XmlHelper::elemento($doc, 'dDesDepEnt', $this->getDDesDepEnt()));
    }
    if (isset($this->cDisEnt)) {
      $res->appendChild(XmlHelper::elemento($doc, 'cDisEnt', $this->getCDisEnt()));
      $res->appendChild(XmlHelper::elemento($doc, 'dDesDisEnt', $this->getDDesDisEnt()));
    }
    if (isset($this->cCiuEnt)) {
      $res->appendChild(XmlHelper::elemento($doc, 'cCiuEnt', $this->getCCiuEnt()));
      $res->appendChild(XmlHelper::elemento($doc, 'dDesCiuEnt', $this->getDDesCiuEnt()));
    }
    if (isset($this->dDirEnt))
      $res->appendChild(XmlHelper::elemento($doc, 'dDirEnt', $this->getDDirEnt()));
    if (isset($this->dNumCas))
      $res->appendChild(XmlHelper::elemento($doc, 'dNumCas', $this->getDNumCas()));
    if (isset($this->dCompDir1))
      $res->appendChild(XmlHelper::elemento($doc, 'dCompDir1', $this->getDCompDir1()));
    if (isset($this->dNomChof))
      $res->appendChild(XmlHelper::elemento($doc, 'dNomChof', $this->getDNomChof()));
    if (isset($this->dNumIDChof))
      $res->appendChild(XmlHelper::elemento($doc, 'dNumIDChof', $this->getDNumIDChof()));
    if (isset($this->iNatTrans))
      $res->appendChild(XmlHelper::elemento($doc, 'iNatTrans', $this->getINatTrans()));
    if (isset($this->dRucTrans))
      $res->appendChild(XmlHelper::elemento($doc, 'dRucTrans', $this->getDRucTrans()));
    if (isset($this->dDVTrans))
      $res->appendChild(XmlHelper::elemento($doc, 'dDVTrans', $this->getDDVTrans()));
    if (isset($this->dNomTrans))
      $res->appendChild(XmlHelper::elemento($doc, 'dNomTrans', $this->getDNomTrans()));
    if (isset($this->iTipIDTrans)) {
      $res->appendChild(XmlHelper::elemento($doc, 'iTipIDTrans', $this->getITipIDTrans()));
      $res->appendChild(XmlHelper::elemento($doc, 'dDTipIDTrans', $this->getdDTipIDTrans()));
    }
    if (isset($this->dNumIDTrans))
      $res->appendChild(XmlHelper::elemento($doc, 'dNumIDTrans', $this->getDNumIDTrans()));
    if (isset($this->iTipTrans)) {
      $res->appendChild(XmlHelper::elemento($doc, 'iTipTrans', $this->getITipTrans()));
      $res->appendChild(XmlHelper::elemento($doc, 'dDesTipTrans', $this->getDDesTipTrans()));
    }
    if (isset($this->iModTrans)) {
      $res->appendChild(XmlHelper::elemento($doc, 'iModTrans', $this->getIModTrans()));
      $res->appendChild(XmlHelper::elemento($doc, 'dDesModTrans', $this->getDDesModTrans()));
    }
    if (isset($this->dTiVehTras))
      $res->appendChild(XmlHelper::elemento($doc, 'dTiVehTras', $this->getDTiVehTras()));
    if (isset($this->dMarVeh))
      $res->appendChild(XmlHelper::elemento($doc, 'dMarVeh', $this->getDMarVeh()));
    if (isset($this->dTipIdenVeh))
      $res->appendChild(XmlHelper::elemento($doc, 'dTipIdenVeh', $this->getDTipIdenVeh()));
    if (isset($this->dNroIDVeh))
      $res->appendChild(XmlHelper::elemento($doc, 'dNroIDVeh', $this->getDNroIDVeh()));
    if (isset($this->dNroMatVeh))
      $res->appendChild(XmlHelper::elemento($doc, 'dNroMatVeh', $this->getDNroMatVeh()));
    return $res;
  }

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return RGeVeTr
  //  */
  // public static function fromDOMElement(DOMElement $xml): RGeVeTr
  // {
  //   if (strcmp($xml->tagName, 'rGeDeVTr') == 0 && $xml->childElementCount == 23) {
  //     $res = new RGeVeTr();
  //     $res->setId($xml->getElementsByTagName('Id')->item(0)->nodeValue);
  //     $res->setDMotEv(intval($xml->getElementsByTagName('dMotEv')->item(0)->nodeValue));
  //     $res->setCDepEnt(intval($xml->getElementsByTagName('cDepEnt')->item(0)->nodeValue));
  //     $res->setCDisEnt(intval($xml->getElementsByTagName('cDisEnt')->item(0)->nodeValue));
  //     $res->setCCiuEnt(intval($xml->getElementsByTagName('cCiuEnt')->item(0)->nodeValue));
  //     $res->setDDirEnt($xml->getElementsByTagName('dDirEnt')->item(0)->nodeValue);
  //     $res->setDNumCas(intval($xml->getElementsByTagName('dNumCas')->item(0)->nodeValue));
  //     $res->setDCompDir1($xml->getElementsByTagName('dCompDir1')->item(0)->nodeValue);
  //     $res->setDNomChof($xml->getElementsByTagName('dNomChof')->item(0)->nodeValue);
  //     $res->setDNumIDChof($xml->getElementsByTagName('dNumIDChof')->item(0)->nodeValue);
  //     $res->setINatTrans(intval($xml->getElementsByTagName('iNatTrans')->item(0)->nodeValue));
  //     $res->setDRucTrans($xml->getElementsByTagName('dRucTrans')->item(0)->nodeValue);
  //     $res->setDDVTrans(intval($xml->getElementsByTagName('dDVTrans')->item(0)->nodeValue));
  //     $res->setDNomTrans($xml->getElementsByTagName('dNomTrans')->item(0)->nodeValue);
  //     $res->setITipIDTrans(intval($xml->getElementsByTagName('iTipIDTrans')->item(0)->nodeValue));
  //     $res->setDNumIDTrans($xml->getElementsByTagName('dNumIDTrans')->item(0)->nodeValue);
  //     $res->setITipTrans(intval($xml->getElementsByTagName('iTipTrans')->item(0)->nodeValue));
  //     $res->setIModTrans(intval($xml->getElementsByTagName('iModTrans')->item(0)->nodeValue));
  //     $res->setDTiVehTras($xml->getElementsByTagName('dTiVehTras')->item(0)->nodeValue);
  //     $res->setDMarVeh($xml->getElementsByTagName('dMarVeh')->item(0)->nodeValue);
  //     $res->setDTipIdenVeh(intval($xml->getElementsByTagName('dTipIdenVeh')->item(0)->nodeValue));
  //     $res->setDNroIDVeh($xml->getElementsByTagName('dNroIDVeh')->item(0)->nodeValue);
  //     $res->setDNroMatVeh($xml->getElementsByTagName('dNroMatVeh')->item(0)->nodeValue);

  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }

  /**
   * FromSimpleXMLElement
   *
   * @param  SimpleXMLElement $node
   * @return RGeVeTr
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node): self
  {
    if (strcmp($node->getName(), 'rGeVeTr') != 0) {
      throw new \Exception("Invalid XML Element: $node->getName()");
      return null;
    }

    $res = new self();
    $res->setId(strval($node->Id));
    $res->setDMotEv(intval($node->dMotEv));

    if (isset($node->cDepEnt)) {
      $res->setCDepEnt(intval($node->cDepEnt));
      $res->dDesDepEnt = $node->dDesDepEnt;
    }

    if (isset($node->cDisEnt)) {
      $res->cDisEnt = intval($node->cDisEnt);
      $res->dDesDisEnt = $node->dDesDisEnt;
    }

    if (isset($node->cCiuEnt)) {
      $res->cCiuEnt = intval($node->cCiuEnt);
      $res->dDesCiuEnt = $node->dDesCiuEnt;
    }

    if (isset($node->dDirEnt)) {
      $res->dDirEnt = strval($node->dDirEnt);
    }

    if (isset($node->dNumCas)) {
      $res->dNumCas = intval($node->dNumCas);
    }

    if (isset($node->dCompDir1)) {
      $res->dCompDir1 = strval($node->dCompDir1);
    }

    if (isset($node->dNomChof)) {
      $res->dNomChof = strval($node->dNomChof);
    }

    if (isset($node->dNumIDChof)) {
      $res->dNumIDChof = strval($node->dNumIDChof);
    }

    if (isset($node->iNatTrans)) {
      $res->iNatTrans = intval($node->iNatTrans);
    }

    if (isset($node->dRucTrans)) {
      $res->dRucTrans = strval($node->dRucTrans);
    }

    if (isset($node->dDVTrans)) {
      $res->dDVTrans = intval($node->dDVTrans);
    }

    if (isset($node->dNomTrans)) {
      $res->dNomTrans = strval($node->dNomTrans);
    }

    if (isset($node->iTipIDTrans)) {
      $res->iTipIDTrans = intval($node->iTipIDTrans);
      $res->dDTipIDTrans = strval($node->dDTipIDTrans);
    }

    if (isset($node->dNumIDTrans)) {
      $res->dNumIDTrans = strval($node->dNumIDTrans);
    }

    if (isset($node->iTipTrans)) {
      $res->iTipTrans = intval($node->iTipTrans);
      $res->dDesTipTrans = strval($node->dDesTipTrans);
    }

    if (isset($node->iModTrans)) {
      $res->iModTrans = intval($node->iModTrans);
      $res->dDesModTrans = strval($node->dDesModTrans);
    }

    if (isset($node->dTiVehTras)) {
      $res->dTiVehTras = strval($node->dTiVehTras);
    }

    if (isset($node->dMarVeh)) {
      $res->dMarVeh = strval($node->dMarVeh);
    }

    if (isset($node->dTipIdenVeh)) {
      $res->dTipIdenVeh = intval($node->dTipIdenVeh);
    }

    if (isset($node->dNroIDVeh)) {
      $res->dNroIDVeh = strval($node->dNroIDVeh);
    }

    if (isset($node->dNroMatVeh)) {
      $res->dNroMatVeh = strval($node->dNroMatVeh);
    }

    return $res;
  }
}
