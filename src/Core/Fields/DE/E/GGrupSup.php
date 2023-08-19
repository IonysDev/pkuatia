<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use DOMElement;

/**
 * ID:E810 gGrupSup Grupo del sector supermercados
 * PAFRE:E790
 */
class GGrupSup
{
  public ?string $dNomCaj = null; ///E811 Nombre del cajero
  public ?int $dEfectivo = null; /// E812 Efectivo
  public ?int $dVuelto = null; //E813 Vuelto
  public ?int $dDonac = null; ///E814 Monto de la donación
  public ?string $dDesDonac = null; ///E815 Descripción de la donación

  ///////////////////////////////////////////////////////////////////////
  ////Setters
  ///////////////////////////////////////////////////////////////////////

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

  ///////////////////////////////////////////////////////////////////////
  //Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Get the value of dNomCaj
   *
   * @return string
   */
  public function getDNomCaj(): string | null
  {
    return $this->dNomCaj;
  }

  /**
   * Get the value of dEfectivo
   *
   * @return int
   */
  public function getDEfectivo(): int | null
  {
    return $this->dEfectivo;
  }

  /**
   * Get the value of dVuelto
   *
   * @return int
   */
  public function getDVuelto(): int | null
  {
    return $this->dVuelto;
  }

  /**
   * Get the value of dDonac
   *
   * @return int
   */
  public function getDDonac(): int | null
  {
    return $this->dDonac;
  }

  /**
   * Get the value of dDesDonac
   *
   * @return string
   */
  public function getDDesDonac(): string | null
  {
    return $this->dDesDonac;
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML Element
  ///////////////////////////////////////////////////////////////////////

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

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return GGrupSup
  //  */
  // public static function fromDOMElement(DOMElement $xml): GGrupSup
  // {
  //   if (strcmp($xml->tagName, 'gGrupSup') === 0 && $xml->childElementCount == 5) {
  //     $res = new GGrupSup();
  //     $res->setDNomCaj($xml->getElementsByTagName('dNomCaj')->item(0)->nodeValue);
  //     $res->setDEfectivo(intval($xml->getElementsByTagName('dEfectivo')->item(0)->nodeValue));
  //     $res->setDVuelto(intval($xml->getElementsByTagName('dVuelto')->item(0)->nodeValue));
  //     $res->setDDonac(intval($xml->getElementsByTagName('dDonac')->item(0)->nodeValue));
  //     $res->setDDesDonac(strval($xml->getElementsByTagName('dDesDonac')->item(0)->nodeValue));

  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }

  /**
   * FromSifenResponseObject
   *
   * @param  mixed $object
   * @return self
   */
  public static function FromSifenResponseObject($object): self
  {
    $res = new GGrupSup();
    if (isset($object->dNomCaj)) {
      $res->setDNomCaj($object->dNomCaj);
    }
    if (isset($object->dEfectivo)) {
      $res->setDEfectivo($object->dEfectivo);
    }
    if (isset($object->dVuelto)) {
      $res->setDVuelto($object->dVuelto);
    }
    if (isset($object->dDonac)) {
      $res->setDDonac($object->dDonac);
    }
    if (isset($object->dDesDonac)) {
      $res->setDDesDonac($object->dDesDonac);
    }
    return $res;
  }
}
