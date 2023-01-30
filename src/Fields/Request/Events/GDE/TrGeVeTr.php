<?php

namespace Abiliomp\Pkuatia\Fields\Request\Events\GDE;

use DOMElement;

/**
 * Nodo: GET001 - rGeVeTr - Grupos de Campos Generales del Evento 
 * Padre: GDE007 - gGroupTiEvt - Grupo de campos del tipo de evento
 */
class TrGeVeTr
{
  public string $Id;          // GET002 - CDC del DTE 
  public int    $dMotEv;      // GET003 - Motivo del evento
  public int    $cDepEnt;     // GET004 - Código del departamento del local de la entrega
  public int    $cDisEnt;     // GET006 - Código del distrito del  local de la entrega  
  public int    $cCiuEnt;     // GET008 - Código de la ciudad del local de la entrega
  public string $dDirEnt;     // GET010 - Dirección del local de la entrega
  public int    $dNumCas;     // GET011 - Número de casa del local de la entrega
  public string $dCompDir1;   // GET012 - Complemento de dirección del local de  la entrega
  public string $dNomChof;    // GET013 - Nombre y apellido del chofer
  public string $dNumIDChof;  // GET014 - Número de documento  de identidad del chofer
  public int    $iNatTrans;   // GET015 - Naturaleza del transportista
  public string $dRucTrans;   // GET016 - RUC del transportista
  public int    $dDVTrans;    // GET017 - Dígito verificador del RUC del transportista
  public string $dNomTrans;   // GET018 - Nombre o razón social del transportista
  public int    $iTipIDTrans; // GET019 - Tipo de documento de  identidad del  transportista
  public string $dNumIDTrans; // GET021 - Número de documento de identidad del transportista
  public int    $iTipTrans;   // GET022 - Tipo de transporte
  public int    $iModTrans;   // GET024 - Modalidad del transporte
  public string $dTiVehTras;  // GET026 - Tipo de vehículo
  public string $dMarVeh;     // GET027 - Marca del vehículo GET001
  public int    $dTipIdenVeh; // GET028 - Tipo de identificación del vehículo
  public string $dNroIDVeh;   // GET029 - Número de identificación del vehículo
  public string $dNroMatVeh;  // GET030 - Número de matrícula  del vehículo


  //====================================================//
  // Setters
  //====================================================//

  /**
   * Set the value of Id
   *
   * @param string $Id
   *
   * @return self
   */
  public function setId(string $Id): self
  {
    $this->Id = $Id;

    return $this;
  }


  /**
   * Set the value of dMotEv
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
   * Set the value of cDepEnt
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
   * Set the value of cDisEnt
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
   * Set the value of cCiuEnt
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
   * Set the value of dDirEnt
   *
   * @param string $dDirEnt
   *
   * @return self
   */
  public function setDDirEnt(string $dDirEnt): self
  {
    $this->dDirEnt = $dDirEnt;

    return $this;
  }


  /**
   * Set the value of dNumCas
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
   * Set the value of dCompDir1
   *
   * @param string $dCompDir1
   *
   * @return self
   */
  public function setDCompDir1(string $dCompDir1): self
  {
    $this->dCompDir1 = $dCompDir1;

    return $this;
  }

  /**
   * Set the value of dNomChof
   *
   * @param string $dNomChof
   *
   * @return self
   */
  public function setDNomChof(string $dNomChof): self
  {
    $this->dNomChof = $dNomChof;

    return $this;
  }

  /**
   * Set the value of dNumIDChof
   *
   * @param string $dNumIDChof
   *
   * @return self
   */
  public function setDNumIDChof(string $dNumIDChof): self
  {
    $this->dNumIDChof = $dNumIDChof;

    return $this;
  }


  /**
   * Set the value of iNatTrans
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
   * Set the value of dRucTrans
   *
   * @param string $dRucTrans
   *
   * @return self
   */
  public function setDRucTrans(string $dRucTrans): self
  {
    $this->dRucTrans = $dRucTrans;

    return $this;
  }


  /**
   * Set the value of dDVTrans
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
   * Set the value of dNomTrans
   *
   * @param string $dNomTrans
   *
   * @return self
   */
  public function setDNomTrans(string $dNomTrans): self
  {
    $this->dNomTrans = $dNomTrans;

    return $this;
  }


  /**
   * Set the value of iTipIDTrans
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
   * Set the value of dNumIDTrans
   *
   * @param string $dNumIDTrans
   *
   * @return self
   */
  public function setDNumIDTrans(string $dNumIDTrans): self
  {
    $this->dNumIDTrans = $dNumIDTrans;

    return $this;
  }


  /**
   * Set the value of iTipTrans
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
   * Set the value of iModTrans
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
   * Set the value of dMarVeh
   *
   * @param string $dMarVeh
   *
   * @return self
   */
  public function setDMarVeh(string $dMarVeh): self
  {
    $this->dMarVeh = $dMarVeh;

    return $this;
  }


  /**
   * Set the value of dTipIdenVeh
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
   * Set the value of dNroIDVeh
   *
   * @param string $dNroIDVeh
   *
   * @return self
   */
  public function setDNroIDVeh(string $dNroIDVeh): self
  {
    $this->dNroIDVeh = $dNroIDVeh;

    return $this;
  }


  /**
   * Set the value of dNroMatVeh
   *
   * @param string $dNroMatVeh
   *
   * @return self
   */
  public function setDNroMatVeh(string $dNroMatVeh): self
  {
    $this->dNroMatVeh = $dNroMatVeh;

    return $this;
  }


  //====================================================//
  // Getters
  //====================================================//

  /**
   * Get the value of Id
   *
   * @return string
   */
  public function getId(): string
  {
    return $this->Id;
  }

  /**
   * Get the value of dMotEv
   *
   * @return int
   */
  public function getDMotEv(): int
  {
    return $this->dMotEv;
  }

  /**
   * Get the value of cDepEnt
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
   * @return string
   */
  public function getDDesDepEnt(): string
  {
    return "Mordor";
  }


  /**
   * Get the value of cDisEnt
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
   * @return string
   */
  public function getDDesDisEnt(): string
  {
    return "Mordor";
  }



  /**
   * Get the value of cCiuEnt
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
   * @return string
   */
  public function getDDesCiuEnt(): string
  {
    return "Mordor";
  }



  /**
   * Get the value of dDirEnt
   *
   * @return string
   */
  public function getDDirEnt(): string
  {
    return $this->dDirEnt;
  }

  /**
   * Get the value of dNumCas
   *
   * @return int
   */
  public function getDNumCas(): int
  {
    return $this->dNumCas;
  }

  /**
   * Get the value of dCompDir1
   *
   * @return string
   */
  public function getDCompDir1(): string
  {
    return $this->dCompDir1;
  }

  /**
   * Get the value of dNomChof
   *
   * @return string
   */
  public function getDNomChof(): string
  {
    return $this->dNomChof;
  }

  /**
   * Get the value of dNumIDChof
   *
   * @return string
   */
  public function getDNumIDChof(): string
  {
    return $this->dNumIDChof;
  }

  /**
   * Get the value of iNatTrans
   *
   * @return int
   */
  public function getINatTrans(): int
  {
    return $this->iNatTrans;
  }

  /**
   * Get the value of dRucTrans
   *
   * @return string
   */
  public function getDRucTrans(): string
  {
    return $this->dRucTrans;
  }

  /**
   * Get the value of dDVTrans
   *
   * @return int
   */
  public function getDDVTrans(): int
  {
    return $this->dDVTrans;
  }

  /**
   * Get the value of dNomTrans
   *
   * @return string
   */
  public function getDNomTrans(): string
  {
    return $this->dNomTrans;
  }

  /**
   * Get the value of iTipIDTrans
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
   * @return string
   */
  public function getdDTipIDTrans(): string
  {
    return "Mordor";
  }

  /**
   * Get the value of dNumIDTrans
   *
   * @return string
   */
  public function getDNumIDTrans(): string
  {
    return $this->dNumIDTrans;
  }

  /**
   * Get the value of iTipTrans
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
   * @return string
   */
  public function getDDesTipTrans(): string
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
   * Get the value of iModTrans
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
   * @return string
   */
  public function getDDesModTrans(): string
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
   * Get the value of dTiVehTras
   *
   * @return string
   */
  public function getDTiVehTras(): string
  {
    return $this->dTiVehTras;
  }

  /**
   * Get the value of dMarVeh
   *
   * @return string
   */
  public function getDMarVeh(): string
  {
    return $this->dMarVeh;
  }

  /**
   * Get the value of dTipIdenVeh
   *
   * @return int
   */
  public function getDTipIdenVeh(): int
  {
    return $this->dTipIdenVeh;
  }

  /**
   * Get the value of dNroIDVeh
   *
   * @return string
   */
  public function getDNroIDVeh(): string
  {
    return $this->dNroIDVeh;
  }

  /**
   * Get the value of dNroMatVeh
   *
   * @return string
   */
  public function getDNroMatVeh(): string
  {
    return $this->dNroMatVeh;
  }

  //====================================================//
  // Conversiones XML
  //====================================================//

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('trGeVeTr');
    $res->appendChild(new DOMElement('Id', $this->getId()));
    $res->appendChild(new DOMElement('dMotEv', $this->getDMotEv()));

    if ($this->dMotEv == 1) {
      $res->appendChild(new DOMElement('cDepEnt', $this->getCDepEnt()));
      $res->appendChild(new DOMElement('dDesDepEnt', $this->getDDesDepEnt()));
    }

    $res->appendChild(new DOMElement('cDisEnt', $this->getCDisEnt()));

    if (isset($this->cDisEnt)) {
      $res->appendChild(new DOMElement('dDesDisEnt', $this->getDDesDisEnt()));
    }

    if ($this->dMotEv == 1) {
      $res->appendChild(new DOMElement('cCiuEnt', $this->getCCiuEnt()));
      $res->appendChild(new DOMElement('dDesCiuEnt', $this->getDDesCiuEnt()));
      $res->appendChild(new DOMElement('dDirEnt', $this->getDDirEnt()));
      $res->appendChild(new DOMElement('dNumCas', $this->getDNumCas()));
      if (isset($this->dCompDir1)) {
        $res->appendChild(new DOMElement('dCompDir1', $this->getDCompDir1()));
      }
    }

    if ($this->dMotEv == 2) {
      $res->appendChild(new DOMElement('dNomChof', $this->getDNomChof()));
      $res->appendChild(new DOMElement('dNumIDChof', $this->getDNumIDChof()));
    }

    if ($this->dMotEv == 3) {
      $res->appendChild(new DOMElement('iNatTrans', $this->getINatTrans()));
    }

    if ($this->iNatTrans == 1) {
      $res->appendChild(new DOMElement('dRucTrans', $this->getDRucTrans()));
      $res->appendChild(new DOMElement('dDVTrans', $this->getDDVTrans()));
    }

    if ($this->dMotEv == 3) {
      $res->appendChild(new DOMElement('dNomTrans', $this->getDNomTrans()));
    }

    if ($this->iNatTrans == 2) {
      $res->appendChild(new DOMElement('iTipIDTrans', $this->getITipIDTrans()));
      $res->appendChild(new DOMElement('dDTipIDTrans', $this->getdDTipIDTrans()));
      $res->appendChild(new DOMElement('dNumIDTrans', $this->getDNumIDTrans()));
    }

    if ($this->dMotEv == 4) {
      $res->appendChild(new DOMElement('iTipTrans', $this->getITipTrans()));
      $res->appendChild(new DOMElement('dDesTipTrans', $this->getDDesTipTrans()));
      $res->appendChild(new DOMElement('iModTrans', $this->getIModTrans()));
      $res->appendChild(new DOMElement('dDesModTrans', $this->getDDesModTrans()));
      $res->appendChild(new DOMElement('dTiVehTras', $this->getDTiVehTras()));
      $res->appendChild(new DOMElement('dMarVeh', $this->getDMarVeh()));
      $res->appendChild(new DOMElement('dTipIdenVeh', $this->getDTipIdenVeh()));
    }

    if ($this->dTipIdenVeh == 1) {
      $res->appendChild(new DOMElement('dNroIDVeh', $this->getDNroIDVeh()));
    }

    if ($this->dTipIdenVeh == 2) {
      $res->appendChild(new DOMElement('dNroMatVeh', $this->getDNroMatVeh()));
    }

    return $res;
  }
}
