<?php

namespace IonysDev\Pkuatia\Core\Fields\DE\E;

use DOMDocument;
use DOMElement;

/**
 * ID:E810 gGrupSup Grupo del sector supermercados
 * PAFRE:E790
 */
class GGrupSup
{
  public String $dNomCaj; ///E811 Nombre del cajero
  public int $dEfectivo; /// E812 Efectivo
  public int $dVuelto; //E813 Vuelto
  public int $dDonac; ///E814 Monto de la donación
  public String $dDesDonac; ///E815 Descripción de la donación

  ///////////////////////////////////////////////////////////////////////
  ////Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de dNomCaj
   *
   * @param String $dNomCaj
   *
   * @return self
   */
  public function setDNomCaj(String $dNomCaj): self
  {
    $this->dNomCaj = $dNomCaj;

    return $this;
  }


  /**
   * Establece el valor de dEfectivo
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
   * Establece el valor de dVuelto
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
   * Establece el valor de dDonac
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
   * Establece el valor de dDesDonac
   *
   * @param String $dDesDonac
   *
   * @return self
   */
  public function setDDesDonac(String $dDesDonac): self
  {
    $this->dDesDonac = $dDesDonac;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  //Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de dNomCaj
   *
   * @return String
   */
  public function getDNomCaj(): String
  {
    return $this->dNomCaj;
  }

  /**
   * Obtiene el valor de dEfectivo
   *
   * @return int
   */
  public function getDEfectivo(): int
  {
    return $this->dEfectivo;
  }

  /**
   * Obtiene el valor de dVuelto
   *
   * @return int
   */
  public function getDVuelto(): int
  {
    return $this->dVuelto;
  }

  /**
   * Obtiene el valor de dDonac
   *
   * @return int
   */
  public function getDDonac(): int
  {
    return $this->dDonac;
  }

  /**
   * Obtiene el valor de dDesDonac
   *
   * @return String
   */
  public function getDDesDonac(): String
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
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gGrupSup');
    $res->appendChild(new DOMElement('dNomCaj', $this->getDNomCaj()));
    $res->appendChild(new DOMElement('dEfectivo', $this->getDEfectivo()));
    $res->appendChild(new DOMElement('dVuelto', $this->getDVuelto()));
    $res->appendChild(new DOMElement('dDonac', $this->getDDonac()));
    $res->appendChild(new DOMElement('dDesDonac', $this->getDDesDonac()));
    return $res;
  }

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
