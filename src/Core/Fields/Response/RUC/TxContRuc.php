<?php

namespace Abiliomp\Pkuatia\Core\Fields\Response\Ruc;

use DOMElement;

/**
 * ContRUC01 Raíz
 */
class TxContRuc
{
  public ?string $dRUCCons = null;      // ContRUC02 - RUC Consultado
  public ?string $dRazCons = null;      // ContRUC03 - Razón social del RUC Consultado
  public ?string $dCodEstCons = null;   // ContRUC04 - Código del Estado del RUC Consultado
  public ?string $dDesEstCons = null;   //ContRUC05 - Descripción Código del Estado del RUC Consultado
  public ?string $dRUCFactElec = null;  // ContRUC06 - consultado es facturador electrónico

  //====================================================//
  ///SETTERS
  //====================================================//

  /**
   * Set the value of dRUCCons
   *
   * @param string $dRUCCons
   *
   * @return self
   */
  public function setDRUCCons(string $dRUCCons): self
  {
    $this->dRUCCons = $dRUCCons;

    return $this;
  }


  /**
   * Set the value of dRazCons
   *
   * @param string $dRazCons
   *
   * @return self
   */
  public function setDRazCons(string $dRazCons): self
  {
    $this->dRazCons = $dRazCons;

    return $this;
  }


  /**
   * Set the value of dCodEstCons
   *
   * @param string $dCodEstCons
   *
   * @return self
   */
  public function setDCodEstCons(string $dCodEstCons): self
  {
    $this->dCodEstCons = $dCodEstCons;

    return $this;
  }

  /**
   * Set the value of dDesEstCons
   *
   * @param string $dDesEstCons
   *
   * @return self
   */
  public function setDDesEstCons(string $dDesEstCons): self
  {
    $this->dDesEstCons = $dDesEstCons;

    return $this;
  }


  /**
   * Set the value of dRUCFactElec
   *
   * @param string $dRUCFactElec
   *
   * @return self
   */
  public function setDRUCFactElec(string $dRUCFactElec): self
  {
    $this->dRUCFactElec = $dRUCFactElec;

    return $this;
  }

  //====================================================//
  //GETTERS
  //====================================================//

  /**
   * Get the value of dRUCCons
   *
   * @return string
   */
  public function getDRUCCons(): string | null
  {
    return $this->dRUCCons;
  }

  /**
   * Get the value of dRazCons
   *
   * @return string
   */
  public function getDRazCons(): string | null
  {
    return $this->dRazCons;
  }

  /**
   * Get the value of dCodEstCons
   *
   * @return string
   */
  public function getDCodEstCons(): string | null
  {
    return $this->dCodEstCons;
  }

  /**
   * ContRUC05 - Descripción Código del Estado del RUC Consultado
   *
   * @return string
   */
  public function getDDesEstCons(): string | null
  {
    switch ($this->dCodEstCons) {
      case 'ACT':
        return "Activo";
        break;
      case 'SUS':
        return "Suspensión Temporal";
        break;
      case 'SAD':
        return "Suspensión Administrativa";
        break;
      case 'BLQ':
        return "Bloqueado";
        break;
      case 'CAN':
        return "Cancelado";
        break;
      case 'CDE':
        return "Cancelado  Definitivo";
        break;

      default:
        return null;
        break;
    }
  }


  /**
   * Get the value of dRUCFactElec
   *
   * @return string
   */
  public function getDRUCFactElec(): string | null
  { 
    return $this->dRUCFactElec;
  }

  //get the description of dRUCFactElec
  public function getDRUCFactElecDesc(): string | null
  {
    switch ($this->dRUCFactElec) {
      case 'S':
        return "Es facturador electrónico";
        break;
      case 'N':
        return "No es facturador electrónico";
        break;

      default:
        return null;
        break;
    }
  }

  //====================================================//
  ///XML ELEMENT
  //====================================================//    
  /**
   * toDOMElement
   *
   * @return void
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('TxContRuc');

    $res->appendChild(new DOMElement('dRUCCons', $this->dRUCCons));
    $res->appendChild(new DOMElement('dRazCons', $this->dRazCons));
    $res->appendChild(new DOMElement('dCodEstCons', $this->dCodEstCons));
    $res->appendChild(new DOMElement('dDesEstCons', $this->getDDesEstCons()));
    $res->appendChild(new DOMElement('dRUCFactElec', $this->dRUCFactElec));

    return $res;
  }

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return TxContRuc
  //  */
  // public static function fromDOMElement(DOMElement $xml): TxContRuc
  // {
  //   if (strcmp($xml->tagName, 'rContRUC ') == 0 && $xml->childElementCount == 5) {
  //     $res = new TxContRuc();
  //     $res->setDRUCCons($xml->getElementsByTagName('rContRUC ')->item(0)->nodeValue);
  //     $res->setDRazCons($xml->getElementsByTagName('dRazCons ')->item(0)->nodeValue);
  //     $res->setDCodEstCons($xml->getElementsByTagName('dCodEstCons ')->item(0)->nodeValue);
  //     $res->setDDesEstCons($xml->getElementsByTagName('dDesEstCons ')->item(0)->nodeValue);
  //     $res->setDRUCFactElec($xml->getElementsByTagName('dRUCFactElec ')->item(0)->nodeValue);
  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }

  ///create a objet from a objectClass  
  /**
   * fromResponse
   *
   * @param  mixed $object
   * @return TxContRuc
   */
  public static function fromResponse($object): TxContRuc
  {

    $res = new TxContRuc();
    if(isset($object->dRUCCons)){
      $res->setDRUCCons($object->dRUCCons);
    }
    if(isset($object->dRazCons)){
      $res->setDRazCons($object->dRazCons);
    }
    if(isset($object->dCodEstCons)){
      $res->setDCodEstCons($object->dCodEstCons);
    }
    if(isset($object->dRUCFactElec)){
      $res->setDRUCFactElec($object->dRUCFactElec);
    }

    return $res;
  }

  ///print the data of the object
  public function printData()
  {
    return "Datos de la Consulta: " . PHP_EOL .
      "RUC: " . $this->getDRUCCons() . PHP_EOL .
      "Razón Social: " . $this->getDRazCons() . PHP_EOL .
      "Descripción Estado: " . $this->getDDesEstCons() . PHP_EOL .
      "Facturador Electrónico?: " . $this->getDRUCFactElecDesc() . PHP_EOL;
  }
}
