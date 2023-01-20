<?php

namespace Abiliomp\Pkuatia\Fields\E;

use DateTime;
use DOMElement;

/**
 * //Campos que componen la FE
 * ID:E010
 * PADRE:E001
 */
class GCamFE
{
  public int $iIndPres; //indicador de presencia ID:E011 PADRE:E010
  public DateTime $dFecEmNR; //Fecha en el formato: AAAA-MM-DD Fecha estimada para el traslado de la mercadería y emisión de la nota de remisión electrónica cuando corresponda. RG 41/14 ID:E013 PADRE:E010
  public GCompPub $gComPub;

  ////Setters
  
  /**
   * Set the value of iIndPres
   *
   * @param int $iIndPres
   *
   * @return self
   */
  public function setIIndPres(int $iIndPres): self
  {
    $this->iIndPres = $iIndPres;

    return $this;
  }


  /**
   * Set the value of dFecEmNR
   *
   * @param DateTime $dFecEmNR
   *
   * @return self
   */
  public function setDFecEmNR(DateTime $dFecEmNR): self
  {
    $this->dFecEmNR = $dFecEmNR;

    return $this;
  }


  /**
   * Set the value of gComPub
   *
   * @param GCompPub $gComPub
   *
   * @return self
   */
  public function setGComPub(GCompPub $gComPub): self
  {
    $this->gComPub = $gComPub;

    return $this;
  }

  ////Getters

  /**
   * Get the value of iIndPres
   */
  public function getIIndPres(): int
  {
    return $this->iIndPres;
  }

  /**
   * Get the value of dFecEmNR
   */
  public function getDFecEmNR(): DateTime
  {
    return $this->dFecEmNR;
  }

  /**
   * E012 dDesIndPres Descripción del indicador de presencia
   *
   * @return string
   */
  public function getDDesIndPres(): string
  {
    switch ($this->iIndPres) {
      case 1:
        return "Operación presencial";
        break;

      case 2:
        return "Operación electrónica";
        break;

      case 3:
        return "Operación telemarketing";
        break;

      case 4:
        return "Venta a domicilio";
        break;

      case 5:
        return "Operación bancaria";
        break;

      case 6:
        return "Operación cíclica";
        break;

      case 9:
        return "Otro";
        break;

      default:
        return null;
        break;
    }
  }


  ///XML Element

  /**
   * XML Element
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('gCamFE');
    $res->appendChild(new DOMElement('iIndPres', $this->iIndPres));
    $res->appendChild(new DOMElement('dDesIndPres', $this->getDDesIndPres()));
    $res->appendChild(new DOMElement('dFecEmNR', $this->dFecEmNR->format('Y-m-d')));
    return $res;
  }
}
?> 