<?php

namespace Abiliomp\Pkuatia\Fields\H;

use DateTime;
use DOMElement;

/**
 * ID:H001 Campos que identifican al DE asociado PADRE:A001
 */
class GCamDEAsoc
{
  public int $iTipDocAso; ///H002 Tipo de documento asociado
  public string $dCdCDERef; ///H004 CDC del DTE referenciado
  public int $dNTimDI; ///H005 Nro. timbrado documento impreso de referencia
  public string $dEstDocAso; ///H006 Establecimiento
  public string $dPExpDocAso; ///H007 Punto de expedición
  public string $dNumDocAso; ///H008 Número del documento
  public int $iTipoDocAso; ///H009 Tipo de documento  impreso
  public DateTime $dFecEmiDI; ///H011 Fecha de emisión del documento impreso de referencia
  public string $dNumComRet; /// H012  Número de comprobante de retención
  public string $dNumResCF; /// H013 Número de resolución de crédito fiscal
  public int $iTipCons; //H014 Tipo de constancia
  public int $dNumCons; //H016 Número de constancia 
  public string $dNumControl; ///H017 Número de control de la constancia 

  ///SETTERS
  /**
   * Set the value of iTipDocAso
   *
   * @param int $iTipDocAso
   *
   * @return self
   */
  public function setITipDocAso(int $iTipDocAso): self
  {
    $this->iTipDocAso = $iTipDocAso;

    return $this;
  }


  /**
   * Set the value of dCdCDERef
   *
   * @param string $dCdCDERef
   *
   * @return self
   */
  public function setDCdCDERef(string $dCdCDERef): self
  {
    $this->dCdCDERef = $dCdCDERef;

    return $this;
  }


  /**
   * Set the value of dNTimDI
   *
   * @param int $dNTimDI
   *
   * @return self
   */
  public function setDNTimDI(int $dNTimDI): self
  {
    $this->dNTimDI = $dNTimDI;

    return $this;
  }


  /**
   * Set the value of dEstDocAso
   *
   * @param string $dEstDocAso
   *
   * @return self
   */
  public function setDEstDocAso(string $dEstDocAso): self
  {
    $this->dEstDocAso = $dEstDocAso;

    return $this;
  }


  /**
   * Set the value of dPExpDocAso
   *
   * @param string $dPExpDocAso
   *
   * @return self
   */
  public function setDPExpDocAso(string $dPExpDocAso): self
  {
    $this->dPExpDocAso = $dPExpDocAso;

    return $this;
  }


  /**
   * Set the value of dNumDocAso
   *
   * @param string $dNumDocAso
   *
   * @return self
   */
  public function setDNumDocAso(string $dNumDocAso): self
  {
    $this->dNumDocAso = $dNumDocAso;

    return $this;
  }


  /**
   * Set the value of iTipoDocAso
   *
   * @param int $iTipoDocAso
   *
   * @return self
   */
  public function setITipoDocAso(int $iTipoDocAso): self
  {
    $this->iTipoDocAso = $iTipoDocAso;

    return $this;
  }


  /**
   * Set the value of dFecEmiDI
   *
   * @param DateTime $dFecEmiDI
   *
   * @return self
   */
  public function setDFecEmiDI(DateTime $dFecEmiDI): self
  {
    $this->dFecEmiDI = $dFecEmiDI;

    return $this;
  }


  /**
   * Set the value of dNumComRet
   *
   * @param string $dNumComRet
   *
   * @return self
   */
  public function setDNumComRet(string $dNumComRet): self
  {
    $this->dNumComRet = $dNumComRet;

    return $this;
  }


  /**
   * Set the value of dNumResCF
   *
   * @param string $dNumResCF
   *
   * @return self
   */
  public function setDNumResCF(string $dNumResCF): self
  {
    $this->dNumResCF = $dNumResCF;

    return $this;
  }


  /**
   * Set the value of iTipCons
   *
   * @param int $iTipCons
   *
   * @return self
   */
  public function setITipCons(int $iTipCons): self
  {
    $this->iTipCons = $iTipCons;

    return $this;
  }


  /**
   * Set the value of dNumCons
   *
   * @param int $dNumCons
   *
   * @return self
   */
  public function setDNumCons(int $dNumCons): self
  {
    $this->dNumCons = $dNumCons;

    return $this;
  }


  /**
   * Set the value of dNumControl
   *
   * @param string $dNumControl
   *
   * @return self
   */
  public function setDNumControl(string $dNumControl): self
  {
    $this->dNumControl = $dNumControl;

    return $this;
  }

  ///GETTERS


  /**
   * Get the value of iTipDocAso
   *
   * @return int
   */
  public function getITipDocAso(): int
  {
    return $this->iTipDocAso;
  }

  /**
   * Get the value of dNTimDI
   *
   * @return int
   */
  public function getDNTimDI(): int
  {
    return $this->dNTimDI;
  }


  /**
   * H003  Descripción del tipo de documento asociado 
   *
   * @return string
   */
  public function getDDesTipDocAso(): string
  {
    switch ($this->iTipDocAso) {
      case 1:
        return "Electrónico";
        break;
      case 2:
        return "Impreso";
        break;
      case 3:
        return "Constancia Electrónica";
        break;

      default:
        return null;
        break;
    }
  }



  /**
   * Get the value of dCdCDERef
   *
   * @return string
   */
  public function getDCdCDERef(): string
  {
    return $this->dCdCDERef;
  }

  /**
   * Get the value of dEstDocAso
   *
   * @return string
   */
  public function getDEstDocAso(): string
  {
    return $this->dEstDocAso;
  }

  /**
   * Get the value of dPExpDocAso
   *
   * @return string
   */
  public function getDPExpDocAso(): string
  {
    return $this->dPExpDocAso;
  }

  /**
   * Get the value of dNumDocAso
   *
   * @return string
   */
  public function getDNumDocAso(): string
  {
    return $this->dNumDocAso;
  }

  /**
   * Get the value of iTipoDocAso
   *
   * @return int
   */
  public function getITipoDocAso(): int
  {
    return $this->iTipoDocAso;
  }

  /**
   *  H010 Descripción del tipo de documento impreso
   *
   * @return string
   */
  public function getDDTipoDocAso(): string
  {
    switch ($this->iTipDocAso) {
      case 1:
        return "Factura";
        break;
      case 2:
        return "Nota de crédito";
        break;
      case 3:
        return "Nota de débito";
        break;
      case 4:
        return "Nota de remisión";
        break;
      case 5:
        return "Comprobante de retención";
        break;

      default:
        return null;
        break;
    }
  }



  /**
   * Get the value of dFecEmiDI
   *
   * @return DateTime
   */
  public function getDFecEmiDI(): DateTime
  {
    return $this->dFecEmiDI;
  }

  /**
   * Get the value of dNumComRet
   *
   * @return string
   */
  public function getDNumComRet(): string
  {
    return $this->dNumComRet;
  }

  /**
   * Get the value of dNumResCF
   *
   * @return string
   */
  public function getDNumResCF(): string
  {
    return $this->dNumResCF;
  }

  /**
   * Get the value of iTipCons
   *
   * @return int
   */
  public function getITipCons(): int
  {
    return $this->iTipCons;
  }

  /**
   * H015 Descripción del tipo de constancia
   *
   * @return string
   */
  public function getDDesTipCons(): string
  {
    switch ($this->iTipCons) {
      case 1:
        return "Constancia de no ser contribuyente";
        break;
      case 2:
        return "Constancia de microproductores";
        break;

      default:
        return null;
        break;
    }
  }



  /**
   * Get the value of dNumCons
   *
   * @return int
   */
  public function getDNumCons(): int
  {
    return $this->dNumCons;
  }

  /**
   * Get the value of dNumControl
   *
   * @return string
   */
  public function getDNumControl(): string
  {
    return $this->dNumControl;
  }

  ///XML Element

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('gCamDEAsoc');
    $res->appendChild(new DOMElement('iTipDocAso', $this->getITipDocAso()));
    $res->appendChild(new DOMElement('dDesTipDocAso', $this->getDDesTipDocAso()));
    if ($this->iTipDocAso == 1) {
      $res->appendChild(new DOMElement('dCdCDERef', $this->getDCdCDERef()));
    }

    if ($this->iTipDocAso == 2) {
      $res->appendChild(new DOMElement('dNTimDI', $this->getDNTimDI()));
      $res->appendChild(new DOMElement('dEstDocAso', str_pad($this->dEstDocAso, 1, '0', STR_PAD_LEFT)));
      $res->appendChild(new DOMElement('dPExpDocAso', str_pad($this->dPExpDocAso, 1, '0', STR_PAD_LEFT)));
      $res->appendChild(new DOMElement('dNumDocAso', str_pad($this->dNumDocAso, 7, '0', STR_PAD_LEFT)));
      $res->appendChild(new DOMElement('iTipoDocAso', $this->getITipDocAso()));
      $res->appendChild(new DOMElement('dDTipoDocAso', $this->getDDTipoDocAso()));
    }

    if (isset($this->dNTimDI)) {
      $res->appendChild(new DOMElement('dFecEmiDI', $this->getDFecEmiDI()->format('Y-m-d')));
    }

    $res->appendChild(new DOMElement('dNumComRet', $this->getDNumComRet()));
    $res->appendChild(new DOMElement('dNumResCF', $this->getDNumResCF()));

    if ($this->iTipDocAso == 3) {
      $res->appendChild(new DOMElement('iTipCons', $this->getITipCons()));
      $res->appendChild(new DOMElement('dDesTipCons', $this->getDDesTipCons()));
    }

    if ($this->iTipDocAso == 3 && $this->iTipCons == 2) {
      $res->appendChild(new DOMElement('dNumCons', $this->getDNumCons()));
      $res->appendChild(new DOMElement('dNumControl', $this->getDNumControl()));
    }

    return $res;
  }
}
