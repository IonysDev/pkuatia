<?php

namespace Abiliomp\Pkuatia\Fields\E;

use DOMElement;

/**
 * ID:E810 gGrupSup Grupo del sector supermercados
 * PAFRE:E790
 */
class GGrupSup
{
  public string $dNomCaj; ///E811 Nombre del cajero
  public int $dEfectivo; /// E812 Efectivo
  public int $dVuelto; //E813 Vuelto
  public int $dDonac; ///E814 Monto de la donación
  public string $dDesDonac; ///E815 Descripción de la donación

  //====================================================//
  ////Setters
  //====================================================//

  /**
   * Set the value of dNomCaj
   *
   * @param string $dNomCaj
   *
   * @return self
   */
  public function setDNomCaj(string $dNomCaj): self
  {
    $this->dNomCaj = $dNomCaj;

    return $this;
  }


  /**
   * Set the value of dEfectivo
   *
   * @param int $dEfectivo
   *
   * @return self
   */
  public function setDEfectivo(int $dEfectivo): self
  {
    $this->dEfectivo = $dEfectivo;

    return $this;
  }


  /**
   * Set the value of dVuelto
   *
   * @param int $dVuelto
   *
   * @return self
   */
  public function setDVuelto(int $dVuelto): self
  {
    $this->dVuelto = $dVuelto;

    return $this;
  }


  /**
   * Set the value of dDonac
   *
   * @param int $dDonac
   *
   * @return self
   */
  public function setDDonac(int $dDonac): self
  {
    $this->dDonac = $dDonac;

    return $this;
  }


  /**
   * Set the value of dDesDonac
   *
   * @param string $dDesDonac
   *
   * @return self
   */
  public function setDDesDonac(string $dDesDonac): self
  {
    $this->dDesDonac = $dDesDonac;

    return $this;
  }

  //====================================================//
  //Getters
  //====================================================//

  /**
   * Get the value of dNomCaj
   *
   * @return string
   */
  public function getDNomCaj(): string
  {
    return $this->dNomCaj;
  }

  /**
   * Get the value of dEfectivo
   *
   * @return int
   */
  public function getDEfectivo(): int
  {
    return $this->dEfectivo;
  }

  /**
   * Get the value of dVuelto
   *
   * @return int
   */
  public function getDVuelto(): int
  {
    return $this->dVuelto;
  }

  /**
   * Get the value of dDonac
   *
   * @return int
   */
  public function getDDonac(): int
  {
    return $this->dDonac;
  }

  /**
   * Get the value of dDesDonac
   *
   * @return string
   */
  public function getDDesDonac(): string
  {
    return $this->dDesDonac;
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
    $res = new DOMElement('gGrupSup');

    $res->appendChild(new DOMElement('dNomCaj', $this->getDNomCaj()));
    $res->appendChild(new DOMElement('dEfectivo', $this->getDEfectivo()));
    $res->appendChild(new DOMElement('dVuelto', $this->getDVuelto()));
    $res->appendChild(new DOMElement('dDonac', $this->getDDonac()));
    $res->appendChild(new DOMElement('dDesDonac', $this->getDDesDonac()));

    return $res;
  }

  /**
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return GGrupSup
   */
  public static function fromDOMElement(DOMElement $xml): GGrupSup
  {
    if (strcmp($xml->tagName, 'gGrupSup') === 0 && $xml->childElementCount == 5) {
      $res = new GGrupSup();
      $res->setDNomCaj($xml->getElementsByTagName('dNomCaj')->item(0)->nodeValue);
      $res->setDEfectivo(intval($xml->getElementsByTagName('dEfectivo')->item(0)->nodeValue));
      $res->setDVuelto(intval($xml->getElementsByTagName('dVuelto')->item(0)->nodeValue));
      $res->setDDonac(intval($xml->getElementsByTagName('dDonac')->item(0)->nodeValue));
      $res->setDDesDonac(strval($xml->getElementsByTagName('dDesDonac')->item(0)->nodeValue));

      return $res;
    } else {
      throw new \Exception("Invalid XML Element: $xml->tagName");
      return null;
    }
  }
}
