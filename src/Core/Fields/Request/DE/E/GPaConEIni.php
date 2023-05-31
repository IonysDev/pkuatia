<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\E;

use DOMElement;

/**
 * ID:E605 iCampos que describen la forma de pago al contado o del monto de la entrega inicial PADRE:E600
 */
class GPaConEIni
{
  public ?int $iTiPago = null; //E606 Tipo de pago
  public ?int $dMonTiPag = null; // E608 Monto por tipo de pago
  public ?string $cMoneTiPag = null; //E609 Moneda por tipo de pago
  public ?int $dTiCamTiPag = null; //E611 Tipo de cambio por tipo de pago
  public ?GPagTarCD $gPagTarCD = null;
  public ?GPagCheq $gPagCheq = null;


  //====================================================//
  //Setters
  //====================================================//

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

  //====================================================//
  ///Getters
  //====================================================//

  /**
   * Get the value of iTiPago
   *
   * @return int
   */
  public function getITiPago(): int | null
  {
    return $this->iTiPago;
  }

  /**
   * E607 Descripción del tipo de pago
   *
   * @return string
   */
  public function getDDesTiPag(): string | null
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
  public function getDMonTiPag(): int | null
  {
    return $this->dMonTiPag;
  }

  /**
   * Get the value of cMoneTiPag
   *
   * @return string
   */
  public function getCMoneTiPag(): string | null
  {
    return $this->cMoneTiPag; ///VER EL TEMA DE LAS MONEDAS
  }

  /**
   *  E610 Descripción de la moneda por tipo de pago
   *
   * @return string
   */
  public function getDDMoneTiPag(): string | null
  {
    return "Moneda de Mordor"; ///ver el tema de la tabla
  }


  /**
   * Get the value of dTiCamTiPag
   *
   * @return int
   */
  public function getDTiCamTiPag(): int | null
  {
    return $this->dTiCamTiPag;
  }

  //====================================================//
  ///XML Element
  //====================================================//

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
    if ($this->cMoneTiPag != 'PYG') {
      $res->appendChild(new DOMElement('dTiCamTiPag', $this->getDTiCamTiPag()));
    }
    ///children
    $res->appendChild($this->gPagTarCD->toDOMElement());
    $res->appendChild($this->gPagCheq->toDOMElement());

    return $res;
  }

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return GPaConEIni
  //  */
  // public function fromDOMElement(DOMElement $xml): GPaConEIni
  // {
  //   if (strcmp($xml->tagName, 'gPaConEIni') == 0 && $xml->childElementCount >= 5) {
  //     $res = new GPaConEIni();
  //     $res->setITiPago(intval($xml->getElementsByTagName('iTiPago')->item(0)->nodeValue));
  //     $res->setDMonTiPag(intval($xml->getElementsByTagName('dMonTiPag')->item(0)->nodeValue));
  //     $res->setCMoneTiPag($xml->getElementsByTagName('cmoneTiPag')->item(0)->nodeValue);
  //     $res->setDTiCamTiPag($xml->getElementsByTagName('dTiCamTiPag')->item(0)->nodeValue);

  //     //Children
  //     $res->setGPagTarCD($res->gPagTarCD->fromDOMElement($xml->getElementsByTagName('gPagTarCD')->item(0)->nodeValue));
  //     $res->setGPagCheq($res->gPagCheq->fromDOMElement($xml->getElementsByTagName('gPagCheq')->item(0)->nodeValue));
  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }


  ////

  /**
   * Get the value of gPagTarCD
   *
   * @return GPagTarCD
   */
  public function getGPagTarCD(): GPagTarCD | null
  {
    return $this->gPagTarCD;
  }

  /**
   * Set the value of gPagTarCD
   *
   * @param GPagTarCD $gPagTarCD
   *
   * @return self
   */
  public function setGPagTarCD(GPagTarCD $gPagTarCD): self
  {
    $this->gPagTarCD = $gPagTarCD;

    return $this;
  }

  /**
   * Get the value of gPagCheq
   *
   * @return GPagCheq
   */
  public function getGPagCheq(): GPagCheq | null
  {
    return $this->gPagCheq;
  }

  /**
   * Set the value of gPagCheq
   *
   * @param GPagCheq $gPagCheq
   *
   * @return self
   */
  public function setGPagCheq(GPagCheq $gPagCheq): self
  {
    $this->gPagCheq = $gPagCheq;

    return $this;
  }
  
  /**
   * fromResponse
   *
   * @param  mixed $response
   * @return self
   */
  public static function fromResponse($response):self
  {
    $res = new GPaConEIni();
    $res->setITiPago(intval($response->iTiPago));
    $res->setDMonTiPag(intval($response->dMonTiPag));
    $res->setCMoneTiPag($response->cMoneTiPag);
    if(isset($response->dTiCamTiPag))
    {
      $res->setDTiCamTiPag($response->dTiCamTiPag);
    }
    //Children
    if(isset($response->gPagTarCD))
    {
      $res->setGPagTarCD(GPagTarCD::fromResponse($response->gPagTarCD));
    }
    if(isset($response->gPagCheq))
    {
      $res->setGPagCheq(GPagCheq::fromResponse($response->gPagCheq));
    } 

    return $res;
  }
  
}
