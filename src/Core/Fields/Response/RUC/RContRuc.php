<?php

namespace Abiliomp\Pkuatia\Core\Fields\Response\Ruc;

use DOMElement;
use SimpleXMLElement;

/**
 * ContRUC01 Elemento raiz de la respuesta a la consulta de RUC
 */

class RContRUC
{
                                // ID - DESCRIPCION- LONGITUD - OCURRENCIA
  public String $dRUCCons;      // ContRUC02 - RUC Consultado - 5-8 - 1-1
  public String $dRazCons;      // ContRUC03 - Razón social del RUC Consultado - 1-250 - 1-1
  public String $dCodEstCons;   // ContRUC04 - Código del Estado del RUC Consultado - 3 - 1-1
  public String $dDesEstCons;   // ContRUC05 - Descripción Código del Estado del RUC Consultado - 6-25 - 1-1
  public String $dRUCFactElec;  // ContRUC06 - consultado es facturador electrónico - 1 - 1-1

  ///////////////////////////////////////////////////////////////////////
  ///SETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de dRUCCons
   *
   * @param String $dRUCCons
   *
   * @return self
   */
  public function setDRUCCons(String $dRUCCons): self
  {
    $this->dRUCCons = $dRUCCons;

    return $this;
  }


  /**
   * Establece el valor de dRazCons
   *
   * @param String $dRazCons
   *
   * @return self
   */
  public function setDRazCons(String $dRazCons): self
  {
    $this->dRazCons = $dRazCons;

    return $this;
  }


  /**
   * Establece el valor de dCodEstCons
   *
   * @param String $dCodEstCons
   *
   * @return self
   */
  public function setDCodEstCons(String $dCodEstCons): self
  {
    $this->dCodEstCons = $dCodEstCons;

    return $this;
  }

  /**
   * Establece el valor de dDesEstCons
   *
   * @param String $dDesEstCons
   *
   * @return self
   */
  public function setDDesEstCons(String $dDesEstCons): self
  {
    $this->dDesEstCons = $dDesEstCons;

    return $this;
  }


  /**
   * Establece el valor de dRUCFactElec
   *
   * @param String $dRUCFactElec
   *
   * @return self
   */
  public function setDRUCFactElec(String $dRUCFactElec): self
  {
    $this->dRUCFactElec = $dRUCFactElec;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  //GETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de dRUCCons
   *
   * @return String
   */
  public function getDRUCCons(): String
  {
    return $this->dRUCCons;
  }

  /**
   * Obtiene el valor de dRazCons
   *
   * @return String
   */
  public function getDRazCons(): String
  {
    return $this->dRazCons;
  }

  /**
   * Obtiene el valor de dCodEstCons
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
   * Obtiene el valor de dRUCFactElec
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
   * FromSifenResponseObject
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
      $res->setDRUCCons((String)$xml->dRUCCons);
    }
    if(isset($xml->dRazCons)){
      $res->setDRazCons((String)$xml->dRazCons);
    }
    if(isset($xml->dCodEstCons)){
      $res->setDCodEstCons((String)$xml->dCodEstCons);
    }
    if(isset($xml->dDesEstCons)){
      $res->setDRUCFactElec((String)$xml->dDesEstCons);
    }
    if(isset($xml->dRUCFactElec)){
      $res->setDRUCFactElec((String)$xml->dRUCFactElec);
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
