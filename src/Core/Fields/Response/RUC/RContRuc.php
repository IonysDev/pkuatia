<?php

namespace Abiliomp\Pkuatia\Core\Fields\Response\Ruc;

use DOMElement;
use SimpleXMLElement;

/**
 * ContRUC01 Elemento raiz de la respuesta a la consulta de RUC
 */

class RContRUC
{
  public String $dRUCCons;      // ContRUC02 - RUC Consultado
  public String $dRazCons;      // ContRUC03 - Razón social del RUC Consultado
  public String $dCodEstCons;   // ContRUC04 - Código del Estado del RUC Consultado
  public String $dDesEstCons;   // ContRUC05 - Descripción Código del Estado del RUC Consultado
  public String $dRUCFactElec;  // ContRUC06 - consultado es facturador electrónico

  ///////////////////////////////////////////////////////////////////////
  ///SETTERS
  ///////////////////////////////////////////////////////////////////////

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

  ///////////////////////////////////////////////////////////////////////
  //GETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Get the value of dRUCCons
   *
   * @return String
   */
  public function getDRUCCons(): String
  {
    return $this->dRUCCons;
  }

  /**
   * Get the value of dRazCons
   *
   * @return String
   */
  public function getDRazCons(): String
  {
    return $this->dRazCons;
  }

  /**
   * Get the value of dCodEstCons
   *
   * @return String
   */
  public function getDCodEstCons(): String
  {
    return $this->dCodEstCons;
  }

  /**
   * ContRUC05 - Descripción Código del Estado del RUC Consultado
   *
   * @return String
   */
  public function getDDesEstCons(): String
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
   * @return String
   */
  public function getDRUCFactElec(): String
  { 
    return $this->dRUCFactElec;
  }

  //get the description of dRUCFactElec
  public function getDRUCFactElecDesc(): String
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

  ///////////////////////////////////////////////////////////////////////
  ///XML ELEMENT
  ///////////////////////////////////////////////////////////////////////    
  /**
   * toDOMElement
   *
   * @return void
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('rContRuc');

    $res->appendChild(new DOMElement('dRUCCons', $this->dRUCCons));
    $res->appendChild(new DOMElement('dRazCons', $this->dRazCons));
    $res->appendChild(new DOMElement('dCodEstCons', $this->dCodEstCons));
    $res->appendChild(new DOMElement('dDesEstCons', $this->getDDesEstCons()));
    $res->appendChild(new DOMElement('dRUCFactElec', $this->dRUCFactElec));

    return $res;
  }

  ///create a objet from a objectClass  
  /**
   * fromResponse
   *
   * @param  mixed $object
   * @return RContRuc
   */
  public static function fromStdClassObject($object): RContRuc
  {
    $res = new RContRuc();
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

  /**
   * Instantiates a RContRuc from a SimpleXMLElement.
   * 
   * @param  SimpleXMLElement $xml
   * 
   * @return RContRuc
   */
  public static function fromSimpleXMLElement(SimpleXMLElement $xml): RContRuc
  {
    if(strcmp($xml->getName(),'rContRUC') != 0) {
      throw new \Exception("Invalid XML Element: $xml->getName()");
      return null;
    }
    $res = new RContRuc();
    if(isset($xml->dRUCCons)){
      $res->setDRUCCons((string)$xml->dRUCCons);
    }
    if(isset($xml->dRazCons)){
      $res->setDRazCons((string)$xml->dRazCons);
    }
    if(isset($xml->dCodEstCons)){
      $res->setDCodEstCons((string)$xml->dCodEstCons);
    }
    if(isset($xml->dDesEstCons)){
      $res->setDRUCFactElec((string)$xml->dDesEstCons);
    }
    if(isset($xml->dRUCFactElec)){
      $res->setDRUCFactElec((string)$xml->dRUCFactElec);
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
