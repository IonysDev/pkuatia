<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\Event\GDE;

use Abiliomp\Pkuatia\DataMappings\CountryMapping;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo: GET001 - rGeVeTr - Grupos de Campos Generales del Evento 
 * Padre: GDE007 - gGroupTiEvt - Grupo de campos del tipo de evento
 */
class RGeVeTr
{
  public String $Id;          // GET002 - CDC del DTE 1-1
  public int    $dMotEv;      // GET003 - Motivo del evento 1-1
  public int    $cDepEnt;     // GET004 - Código del departamento del local de la entrega 0-1
  public int    $cDisEnt;     // GET006 - Código del distrito del  local de la entrega  0-1
  public int    $cCiuEnt;     // GET008 - Código de la ciudad del local de la entrega 0-1
  public String $dDirEnt;     // GET010 - Dirección del local de la entrega 0-1
  public int    $dNumCas;     // GET011 - Número de casa del local de la entrega 0-1
  public String $dCompDir1;   // GET012 - Complemento de dirección del local de  la entrega 0-1
  public String $dNomChof;    // GET013 - Nombre y apellido del chofer 1-1
  public String $dNumIDChof;  // GET014 - Número de documento  de identidad del chofer 0-1
  public int    $iNatTrans;   // GET015 - Naturaleza del transportista 0-1
  public String $dRucTrans;   // GET016 - RUC del transportista 0-1
  public int    $dDVTrans;    // GET017 - Dígito verificador del RUC del transportista 0-1
  public String $dNomTrans;   // GET018 - Nombre o razón social del transportista 0-1
  public int    $iTipIDTrans; // GET019 - Tipo de documento de  identidad del  transportista 0-1
  public String $dNumIDTrans; // GET021 - Número de documento de identidad del transportista 0-1
  public int    $iTipTrans;   // GET022 - Tipo de transporte 0-1
  public int    $iModTrans;   // GET024 - Modalidad del transporte 0-1
  public String $dTiVehTras;  // GET026 - Tipo de vehículo 0-1
  public String $dMarVeh;     // GET027 - Marca del vehículo 0-1
  public int    $dTipIdenVeh; // GET028 - Tipo de identificación del vehículo 0-1
  public String $dNroIDVeh;   // GET029 - Número de identificación del vehículo 0-1
  public String $dNroMatVeh;  // GET030 - Número de matrícula  del vehículo 0-1


  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of Id
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
   * Set the value of dNomChof
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
   * Set the value of dNumIDChof
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
   * Set the value of dNroMatVeh
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
   * Set the value of dTiVehTras
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
   * Get the value of Id
   *
   * @return String
   */
  public function getId(): String
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
   * @return String
   */
  public function getDDesDepEnt(): String
  {
    return CountryMapping::getCountryDesc(strval($this->cDepEnt));
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
   * @return String
   */
  public function getDDesDisEnt(): String
  {
    return CountryMapping::getCountryDesc(strval($this->cDisEnt));
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
   * @return String
   */
  public function getDDesCiuEnt(): String
  {
    return CountryMapping::getCountryDesc(strval($this->cCiuEnt));
  }



  /**
   * Get the value of dDirEnt
   *
   * @return String
   */
  public function getDDirEnt(): String
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
   * @return String
   */
  public function getDCompDir1(): String
  {
    return $this->dCompDir1;
  }

  /**
   * Get the value of dNomChof
   *
   * @return String
   */
  public function getDNomChof(): String
  {
    return $this->dNomChof;
  }

  /**
   * Get the value of dNumIDChof
   *
   * @return String
   */
  public function getDNumIDChof(): String
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
   * @return String
   */
  public function getDRucTrans(): String
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
   * @return String
   */
  public function getDNomTrans(): String
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
        # code...
        break;
    }
  }

  /**
   * Get the value of dNumIDTrans
   *
   * @return String
   */
  public function getDNumIDTrans(): String
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
   * Get the value of dTiVehTras
   *
   * @return String
   */
  public function getDTiVehTras(): String
  {
    return $this->dTiVehTras;
  }

  /**
   * Get the value of dMarVeh
   *
   * @return String
   */
  public function getDMarVeh(): String
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
   * @return String
   */
  public function getDNroIDVeh(): String
  {
    return $this->dNroIDVeh;
  }

  /**
   * Get the value of dNroMatVeh
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
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('rGeVeTr');
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

  public static function FromSimpleXMLElement(SimpleXMLElement $node):self
  {
    if(strcmp($node->getName(),'rGeVeTr') != 0) {
      throw new \Exception("Invalid XML Element: $node->getName()");
      return null;
    }

    $res = new self();
    $res->setId(strval($node->Id));
    $res->setDMotEv(intval($node->dMotEv));

    if(isset($node->cDepEnt)) {
      $res->setCDepEnt(intval($node->cDepEnt));
    }

    if(isset($node->cDisEnt)) {
      $res->cDisEnt = intval($node->cDisEnt);
    }

    if(isset($node->cCiuEnt)) {
      $res->cCiuEnt = intval($node->cCiuEnt);
    }

    if(isset($node->dDirEnt)) {
      $res->dDirEnt = strval($node->dDirEnt);
    }

    if(isset($node->dNumCas)) {
      $res->dNumCas = intval($node->dNumCas);
    }

    if(isset($node->dCompDir1)) {
      $res->dCompDir1 = strval($node->dCompDir1);
    }

    if(isset($node->dNomChof)) {
      $res->dNomChof = strval($node->dNomChof);
    }

    if(isset($node->dNumIDChof)) {
      $res->dNumIDChof = strval($node->dNumIDChof);
    }

    if(isset($node->iNatTrans)) {
      $res->iNatTrans = intval($node->iNatTrans);
    }

    if(isset($node->dRucTrans)) {
      $res->dRucTrans = strval($node->dRucTrans);
    }

    if(isset($node->dDVTrans)) {
      $res->dDVTrans = intval($node->dDVTrans);
    }

    if(isset($node->dNomTrans)) {
      $res->dNomTrans = strval($node->dNomTrans);
    }

    if(isset($node->iTipIDTrans)) {
      $res->iTipIDTrans = intval($node->iTipIDTrans);
    }

    if(isset($node->dNumIDTrans)) {
      $res->dNumIDTrans = strval($node->dNumIDTrans);
    }

    if(isset($node->iTipTrans)) {
      $res->iTipTrans = intval($node->iTipTrans);
    }

    if(isset($node->iModTrans)) {
      $res->iModTrans = intval($node->iModTrans);
    }

    if(isset($node->dTiVehTras)) {
      $res->dTiVehTras = strval($node->dTiVehTras);
    }

    if(isset($node->dMarVeh)) {
      $res->dMarVeh = strval($node->dMarVeh);
    }

    if(isset($node->dTipIdenVeh)) {
      $res->dTipIdenVeh = intval($node->dTipIdenVeh);
    }

    if(isset($node->dNroIDVeh)) {
      $res->dNroIDVeh = strval($node->dNroIDVeh);
    }

    if(isset($node->dNroMatVeh)) {
      $res->dNroMatVeh = strval($node->dNroMatVeh);
    }

    return $res;


  }
}
