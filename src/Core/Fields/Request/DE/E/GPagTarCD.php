<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\E;

use DOMElement;

/**
 *ID:E620 
 *Campos que describen el pago o entrega inicial de la operación con tarjeta de crédito/débito
 *PADRE:E605 
 */
class GPagTarCD
{
  public int $iDenTarj; //E621 Denominación de la tarjeta
  public string $dRSProTar; //E623  Razón social de la procesadora de tarjeta
  public string $dRUCProTar; //E624 RUC de la procesadora de tarjeta
  public int $dDVProTar; //E625 Dígito verificador del  RUC de la procesadora  de tarjeta
  public int $iForProPa; //E626  Forma de procesamiento de pago
  public int $dCodAuOpe; //E627 Código de autorización de la operación
  public string $dNomTit; //dNomTit Nombre del titular de la tarjeta 
  public int $dNumTarj; //E629 dNumTarj Número de la tarjeta;

  //====================================================//
  ///Setters
  //====================================================//

  /**
   * Set the value of iDenTarj
   *
   * @param int $iDenTarj
   *
   * @return self
   */
  public function setIDenTarj(int $iDenTarj): self
  {
    $this->iDenTarj = $iDenTarj;

    return $this;
  }


  /**
   * Set the value of dRSProTar
   *
   * @param string $dRSProTar
   *
   * @return self
   */
  public function setDRSProTar(string $dRSProTar): self
  {
    $this->dRSProTar = $dRSProTar;

    return $this;
  }


  /**
   * Set the value of dRUCProTar
   *
   * @param string $dRUCProTar
   *
   * @return self
   */
  public function setDRUCProTar(string $dRUCProTar): self
  {
    $this->dRUCProTar = $dRUCProTar;

    return $this;
  }


  /**
   * Set the value of dDVProTar
   *
   * @param int $dDVProTar
   *
   * @return self
   */
  public function setDDVProTar(int $dDVProTar): self
  {
    $this->dDVProTar = $dDVProTar;

    return $this;
  }


  /**
   * Set the value of iForProPa
   *
   * @param int $iForProPa
   *
   * @return self
   */
  public function setIForProPa(int $iForProPa): self
  {
    $this->iForProPa = $iForProPa;

    return $this;
  }


  /**
   * Set the value of dCodAuOpe
   *
   * @param int $dCodAuOpe
   *
   * @return self
   */
  public function setDCodAuOpe(int $dCodAuOpe): self
  {
    $this->dCodAuOpe = $dCodAuOpe;

    return $this;
  }


  /**
   * Set the value of dNomTit
   *
   * @param string $dNomTit
   *
   * @return self
   */
  public function setDNomTit(string $dNomTit): self
  {
    $this->dNomTit = $dNomTit;

    return $this;
  }


  /**
   * Set the value of dNumTarj
   *
   * @param int $dNumTarj
   *
   * @return self
   */
  public function setDNumTarj(int $dNumTarj): self
  {
    $this->dNumTarj = $dNumTarj;

    return $this;
  }

  //====================================================//
  ///Getters
  //====================================================//

  /**
   * Get the value of iDenTarj
   *
   * @return int
   */
  public function getIDenTarj(): int
  {
    return $this->iDenTarj;
  }


  /**
   *  E622 Descripción de denominación de la tarjeta
   *
   * @return string
   */
  public function getDDesDenTarj(): string
  {
    switch ($this->iDenTarj) {
      case  1:
        return "Visa";
        break;
      case  2:
        return "Mastercard";
        break;
      case  3:
        return "American Express";
        break;
      case  4:
        return "Maestro";
        break;
      case  5:
        return "Panal";
        break;
      case  6:
        return "Cabal";
        break;
      case  99:
        return "Otro (especificar)";
        break;

      default:
        return null;
        break;
    }
  }

  /**
   * Get the value of dRSProTar
   *
   * @return string
   */
  public function getDRSProTar(): string
  {
    return $this->dRSProTar;
  }

  /**
   * Get the value of dRUCProTar
   *
   * @return string
   */
  public function getDRUCProTar(): string
  {
    return $this->dRUCProTar;
  }

  /**
   * Get the value of dDVProTar
   *
   * @return int
   */
  public function getDDVProTar(): int
  {
    return $this->dDVProTar;
  }

  /**
   * Get the value of iForProPa
   *
   * @return int
   */
  public function getIForProPa(): int
  {
    return $this->iForProPa;
  }

  /**
   * Get the value of dCodAuOpe
   *
   * @return int
   */
  public function getDCodAuOpe(): int
  {
    return $this->dCodAuOpe;
  }

  /**
   * Get the value of dNomTit
   *
   * @return string
   */
  public function getDNomTit(): string
  {
    return $this->dNomTit;
  }

  /**
   * Get the value of dNumTarj
   *
   * @return int
   */
  public function getDNumTarj(): int
  {
    return $this->dNumTarj;
  }

  //====================================================//
  //XML Element
  //====================================================//

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('gPagTarCD');

    $res->appendChild(new DOMElement('iDenTarj', $this->getIDenTarj()));
    $res->appendChild(new DOMElement('dDesDenTarj', $this->getDDesDenTarj()));
    $res->appendChild(new DOMElement('dRSProTar', $this->getDRSProTar()));
    $res->appendChild(new DOMElement('dRUCProTar', $this->getDRUCProTar()));
    $res->appendChild(new DOMElement('dDVProTar', $this->getDDVProTar()));
    $res->appendChild(new DOMElement('iForProPa', $this->getIForProPa()));
    $res->appendChild(new DOMElement('dCodAuOpe', $this->getDCodAuOpe()));
    $res->appendChild(new DOMElement('dNomTit', $this->getDNomTit()));
    $res->appendChild(new DOMElement('dNumTarj', $this->getDNumTarj()));

    return $res;
  }

  /**
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return GPagTarCD
   */
  public static function fromDOMElement(DOMElement $xml): GPagTarCD
  {
    if (strcmp($xml->tagName, 'gPagTarCD') == 0 && $xml->childElementCount == 9) {
      $res = new GPagTarCD();
      $res->setIDenTarj(intval($xml->getElementsByTagName('iDenTarj')->item(0)->nodeValue));
      $res->setDRSProTar($xml->getElementsByTagName('dRSProTar')->item(0)->nodeValue);
      $res->setDRUCProTar($xml->getElementsByTagName('dRUCProTar')->item(0)->nodeValue);
      $res->setDDVProTar($xml->getElementsByTagName('dDDVProTar')->item(0)->nodeValue);
      $res->setIForProPa(intval($xml->getElementsByTagName('iForProPa')->item(0)->nodeValue));
      $res->setDCodAuOpe(intval($xml->getElementsByTagName('dCodAuOpe')->item(0)->nodeValue));
      $res->setDNomTit($xml->getElementsByTagName('dNomTit')->item(0)->nodeValue);
      $res->setDNumTarj(intval($xml->getElementsByTagName('dNumTarj')->item(0)->nodeValue));

      return $res;
    } else {
      throw new \Exception("Invalid XML Elemement: $xml->tagName");
    }
  }
}
