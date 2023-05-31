<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\E;

use DateTime;
use DOMElement;

/**
 *  ID:E650 
 *  Campos que describen las cuotas
 * PADRE: E640
 */
class GCuotas
{
  public ?string $cMoneCuo = null; //E653 Moneda de las cuotas
  public ?int $dMonCuota = null; //E651 Monto de cada cuota
  public ?DateTime $dVencCuo = null; //E652  Fecha de vencimiento de cada cuota;

  //====================================================//
  ///Setters
  //====================================================//


  /**
   * Set the value of cMoneCuo
   *
   * @param string $cMoneCuo
   *
   * @return self
   */
  public function setCMoneCuo(string $cMoneCuo): self
  {
    $this->cMoneCuo = $cMoneCuo;

    return $this;
  }


  /**
   * Set the value of dMonCuota
   *
   * @param int $dMonCuota
   *
   * @return self
   */
  public function setDMonCuota(int $dMonCuota): self
  {
    $this->dMonCuota = $dMonCuota;

    return $this;
  }


  /**
   * Set the value of dVencCuo
   *
   * @param DateTime $dVencCuo
   *
   * @return self
   */
  public function setDVencCuo(DateTime $dVencCuo): self
  {
    $this->dVencCuo = $dVencCuo;

    return $this;
  }

  //====================================================//
  ///Getters
  //====================================================//

  /**
   * Get the value of cMoneCuo
   *
   * @return string
   */
  public function getCMoneCuo(): string | null
  {
    return $this->cMoneCuo;
  }

  /**
   * E654  Descripción de la moneda de las cuotas
   *
   * @return string
   */
  public function getDDMoneCuo(): string | null
  {
    return "Moneda de Mordor";
  }

  /**
   * Get the value of dMonCuota
   *
   * @return int
   */
  public function getDMonCuota(): int | null
  {
    return $this->dMonCuota;
  }

  /**
   * Get the value of dVencCuo
   *
   * @return DateTime
   */
  public function getDVencCuo(): DateTime | null
  {
    return $this->dVencCuo;
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
    $res = new DOMElement('gCuotas');

    $res->appendChild(new DOMElement('cMoneCuo', $this->getCMoneCuo()));
    $res->appendChild(new DOMElement('dDMoneCuo', $this->getDDMoneCuo()));
    $res->appendChild(new DOMElement('dMonCuota', $this->getDMonCuota()));
    $res->appendChild(new DOMElement('dVencCuo', $this->getDVencCuo()->format("Y-m-d")));

    return $res;
  }

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return GCuotas
  //  */
  // public static function fromDOMElement(DOMElement $xml): GCuotas
  // {
  //   if (strcmp($xml->tagName, 'gCuotas') == 0 && $xml->childElementCount == 4) {
  //     $res = new GCuotas();
  //     $res->setCMoneCuo($xml->getElementsByTagName('cMoneCuo')->item(0)->nodeValue);
  //     $res->setDMonCuota($xml->getElementsByTagName('dDMoneCuo')->item(0)->nodeValue);
  //     $res->setDVencCuo(DateTime::createFromFormat('Y-m-d', $xml->getElementsByTagName('dVencCuo')->item(0)->nodeValue));
  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }
  
  /**
   * fromResponse
   *
   * @param  mixed $response
   * @return self
   */
  public static function fromResponse($response):self
  {
    $res = new GCuotas();
    if(isset($response->cMoneCuo))
    {
      $res->setCMoneCuo($response->cMoneCuo);
    }
    if(isset($response->dMonCuota))
    {
      $res->setDMonCuota($response->dMonCuota);
    }
    if(isset($response->dVencCuo))
    {
      $res->setDVencCuo(DateTime::createFromFormat('Y-m-d', $response->dVencCuo));
    }

    return $res;

  }
}
