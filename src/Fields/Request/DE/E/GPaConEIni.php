<?php

namespace Abiliomp\Pkuatia\Fields\E;

use DOMElement;

/**
 * ID:E605 iCampos que describen la forma de pago al contado o del monto de la entrega inicial PADRE:E600
 */
class GPaConEIni
{
  public int $iTiPago; //E606 Tipo de pago
  public int $dMonTiPag; // E608 Monto por tipo de pago
  public string $cMoneTiPag; //E609 Moneda por tipo de pago
  public int $dTiCamTiPag; //E611 Tipo de cambio por tipo de pago
  public GPagTarCD $gPagTarCD;
  public GPagCheq $gPagCheq;

  //Setters

  /**
   * Set the value of iTiPago
   *
   * @param int $iTiPago
   *
   * @return self
   */
  public function setITiPago(int $iTiPago): self
  {
    $this->iTiPago = $iTiPago;

    return $this;
  }



  /**
   * Set the value of dMonTiPag
   *
   * @param int $dMonTiPag
   *
   * @return self
   */
  public function setDMonTiPag(int $dMonTiPag): self
  {
    $this->dMonTiPag = $dMonTiPag;

    return $this;
  }


  /**
   * Set the value of cMoneTiPag
   *
   * @param string $cMoneTiPag
   *
   * @return self
   */
  public function setCMoneTiPag(string $cMoneTiPag): self
  {
    $this->cMoneTiPag = $cMoneTiPag;

    return $this;
  }


  /**
   * Set the value of dTiCamTiPag
   *
   * @param int $dTiCamTiPag
   *
   * @return self
   */
  public function setDTiCamTiPag(int $dTiCamTiPag): self
  {
    $this->dTiCamTiPag = $dTiCamTiPag;

    return $this;
  }

  ///Getters


  /**
   * Get the value of iTiPago
   *
   * @return int
   */
  public function getITiPago(): int
  {
    return $this->iTiPago;
  }

  /**
   * E607 Descripción del tipo de pago
   *
   * @return string
   */
  public function getDDesTiPag(): string
  {
    switch ($this->iTiPago) {
      case 1:
        return "Efectivo";
        break;
      case 2:
        return "Cheque";
        break;
      case 3:
        return "Tarjeta de crédito";
        break;
      case 4:
        return "Tarjeta de débito";
        break;
      case 5:
        return "Transferencia";
        break;
      case 6:
        return "Giro";
        break;
      case 7:
        return "Billetera electrónica";
        break;
      case 8:
        return "Tarjeta empresarial";
        break;
      case 9:
        return "Vale";
        break;
      case 10:
        return "Retención";
        break;
      case 11:
        return "Pago por anticipo";
        break;
      case 12:
        return "Valor fiscal";
        break;
      case 13:
        return "Valor comercial";
        break;
      case 14:
        return "Compensación";
        break;
      case 15:
        return "Permuta";
        break;
      case 16:
        return "Pago bancario";
        break;
      case 17:
        return "Pago Móvil";
        break;
      case 18:
        return "Donación";
        break;
      case 19:
        return "Promoción";
        break;
      case 20:
        return "Consumo Interno";
        break;
      case 21:
        return "Pago Electrónico";
        break;
      case 99:
        return "Otro (Especificar)";
        break;

      default:
        return null;
        break;
    }
  }

  
  /**
   * Get the value of dMonTiPag
   *
   * @return int
   */
  public function getDMonTiPag(): int
  {
    return $this->dMonTiPag;
  }

  /**
   * Get the value of cMoneTiPag
   *
   * @return string
   */
  public function getCMoneTiPag(): string
  {
    return $this->cMoneTiPag;///VER EL TEMA DE LAS MONEDAS
  }
  
  /**
   *  E610 Descripción de la moneda por tipo de pago
   *
   * @return string
   */
  public function getDDMoneTiPag(): string
  {
    return "Moneda de Mordor";///ver el tema de la tabla
  }


  /**
   * Get the value of dTiCamTiPag
   *
   * @return int
   */
  public function getDTiCamTiPag(): int
  {
    return $this->dTiCamTiPag;
  }

  ///XML Element
  
  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('gPaConEIni');

    $res->appendChild(new DOMElement('iTiPago', $this->getITiPago()));
    $res->appendChild(new DOMElement('dDesTiPag', $this->getDDesTiPag()));
    $res->appendChild(new DOMElement('dMonTiPag', $this->getDMonTiPag()));
    $res->appendChild(new DOMElement('cMoneTiPag', $this->getCMoneTiPag()));
    $res->appendChild(new DOMElement('dDMoneTiPag', $this->getDMonTiPag()));
    if($this->cMoneTiPag != 'PYG')
    {
      $res->appendChild(new DOMElement('dTiCamTiPag', $this->getDTiCamTiPag()));
    }

    return $res;
  }
}
?> 