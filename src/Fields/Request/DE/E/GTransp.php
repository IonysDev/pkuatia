<?php

namespace Abiliomp\Pkuatia\Fields\E;

use DateTime;
use DOMElement;

/**
 * ID:E900 
 *Campos que describen  el transporte de mercaderías
 * PADRE:E001
 */
class GTransp
{
  public int $iTipTrans; //E901 Tipo de transporte
  public int $iModTrans; ///E903 Modalidad de transporte
  public int $iRespFlete; //E905 Responsable del costo del flete
  public string $cCondNeg; //E906 Condición de la negociación 
  public string $dNuManif; //E907 Número de manifiesto o conocimiento de carga/declaración de tránsito aduanero/ Carta de porte internacional 
  public string $dNuDespImp; ///E908 Número de despacho de importación
  public DateTime $dIniTras; ///E909 Fecha estimada de inicio de traslado
  public DateTime $dFinTras; ///E910 Fecha estimada de fin  de traslado
  public string $cPaisDest; ///E911 Código del país de destino
  public GCamSal $gCamSal;
  public GCamEnt $gCamEnt;
  public GVehTras $gVehTras;
  public GCamTrans $gCamTrans;
  ///SETTERS

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
   * Set the value of iRespFlete
   *
   * @param int $iRespFlete
   *
   * @return self
   */
  public function setIRespFlete(int $iRespFlete): self
  {
    $this->iRespFlete = $iRespFlete;

    return $this;
  }


  /**
   * Set the value of cCondNeg
   *
   * @param string $cCondNeg
   *
   * @return self
   */
  public function setCCondNeg(string $cCondNeg): self
  {
    $this->cCondNeg = $cCondNeg;

    return $this;
  }


  /**
   * Set the value of dNuManif
   *
   * @param string $dNuManif
   *
   * @return self
   */
  public function setDNuManif(string $dNuManif): self
  {
    $this->dNuManif = $dNuManif;

    return $this;
  }


  /**
   * Set the value of dNuDespImp
   *
   * @param string $dNuDespImp
   *
   * @return self
   */
  public function setDNuDespImp(string $dNuDespImp): self
  {
    $this->dNuDespImp = $dNuDespImp;

    return $this;
  }


  /**
   * Set the value of dIniTras
   *
   * @param DateTime $dIniTras
   *
   * @return self
   */
  public function setDIniTras(DateTime $dIniTras): self
  {
    $this->dIniTras = $dIniTras;

    return $this;
  }


  /**
   * Set the value of dFinTras
   *
   * @param DateTime $dFinTras
   *
   * @return self
   */
  public function setDFinTras(DateTime $dFinTras): self
  {
    $this->dFinTras = $dFinTras;

    return $this;
  }


  /**
   * Set the value of cPaisDest
   *
   * @param string $cPaisDest
   *
   * @return self
   */
  public function setCPaisDest(string $cPaisDest): self
  {
    $this->cPaisDest = $cPaisDest;

    return $this;
  }


  ///Getters


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
   * E902 Descripción del tipo de transporte 
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
   * E904 Descripción de la modalidad del transporte
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
   * Get the value of iRespFlete
   *
   * @return int
   */
  public function getIRespFlete(): int
  {
    return $this->iRespFlete;
  }

  /**
   * Get the value of cCondNeg
   *
   * @return string
   */
  public function getCCondNeg(): string
  {
    switch ($this->cCondNeg) {
      case 'CFR':
        return "Costo y flete";
        break;
      case 'CIF':
        return "Costo, seguro y flete";
        break;
      case 'CIP':
        return "Transporte y seguro pagados hasta";
        break;
      case 'CPT':
        return "Transporte pagado hasta";
        break;
      case 'DAP':
        return "Entregada en lugar convenido";
        break;
      case 'DAT':
        return "Entregada en terminaL";
        break;
      case 'DDP':
        return "Entregada derechos pagados";
        break;
      case 'EXW':
        return "En fabrica";
        break;
      case 'FAS':
        return "Franco al costado del buque";
        break;
      case 'FCA':
        return "Franco transportista";
        break;
      case 'FOB':
        return "Franco a bordo";
        break;

      default:
        return null;
        break;
    }
  }

  /**
   * Get the value of dNuManif
   *
   * @return string
   */
  public function getDNuManif(): string
  {
    return $this->dNuManif;
  }

  /**
   * Get the value of dNuDespImp
   *
   * @return string
   */
  public function getDNuDespImp(): string
  {
    return $this->dNuDespImp;
  }

  /**
   * Get the value of dIniTras
   *
   * @return DateTime
   */
  public function getDIniTras(): DateTime
  {
    return $this->dIniTras;
  }

  /**
   * Get the value of dFinTras
   *
   * @return DateTime
   */
  public function getDFinTras(): DateTime
  {
    return $this->dFinTras;
  }

  /**
   * Get the value of cPaisDest
   *
   * @return string
   */
  public function getCPaisDest(): string
  {
    return $this->cPaisDest;
  }

  /**
   * E912 Descripción del país de destino
   *
   * @return string
   */
  public function getDDesPaisDest(): string
  {
    return "Mordor"; ///test
  }


  ///xml Element

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('gTransp');

    $res->appendChild(new DOMElement('iTipTrans', $this->getITipTrans()));
    if (isset($this->iTipTrans)) {
      $res->appendChild(new DOMElement('dDesTipTrans', $this->getDDesTipTrans()));
    }
    $res->appendChild(new DOMElement('iModTrans', $this->getIModTrans()));
    $res->appendChild(new DOMElement('dDesModTrans', $this->getDDesModTrans()));
    $res->appendChild(new DOMElement('iRespFlete', $this->getIRespFlete()));
    $res->appendChild(new DOMElement('cCondNeg', $this->getCCondNeg()));
    $res->appendChild(new DOMElement('dNuManif', $this->getDNuManif()));
    $res->appendChild(new DOMElement('dNuDespImp', $this->getDNuDespImp()));
    $res->appendChild(new DOMElement('dIniTras', $this->getDFinTras()->format('Y-m-d')));
    $res->appendChild(new DOMElement('dFinTras', $this->getDFinTras()->format('Y-m-d')));
    $res->appendChild(new DOMElement('cPaisDest', $this->getCPaisDest()));
    $res->appendChild(new DOMElement('dDesPaisDest', $this->getDDesPaisDest()));
    return $res;
  }

  /**
   * Get the value of gCamSal
   *
   * @return GCamSal
   */
  public function getGCamSal(): GCamSal
  {
    return $this->gCamSal;
  }

  /**
   * Set the value of gCamSal
   *
   * @param GCamSal $gCamSal
   *
   * @return self
   */
  public function setGCamSal(GCamSal $gCamSal): self
  {
    $this->gCamSal = $gCamSal;

    return $this;
  }

  /**
   * Get the value of gVehTras
   *
   * @return GVehTras
   */
  public function getGVehTras(): GVehTras
  {
    return $this->gVehTras;
  }

  /**
   * Set the value of gVehTras
   *
   * @param GVehTras $gVehTras
   *
   * @return self
   */
  public function setGVehTras(GVehTras $gVehTras): self
  {
    $this->gVehTras = $gVehTras;

    return $this;
  }

  /**
   * Get the value of gCamTrans
   *
   * @return GCamTrans
   */
  public function getGCamTrans(): GCamTrans
  {
    return $this->gCamTrans;
  }

  /**
   * Set the value of gCamTrans
   *
   * @param GCamTrans $gCamTrans
   *
   * @return self
   */
  public function setGCamTrans(GCamTrans $gCamTrans): self
  {
    $this->gCamTrans = $gCamTrans;

    return $this;
  }
}
