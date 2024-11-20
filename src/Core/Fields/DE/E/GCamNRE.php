<?php

namespace IonysDev\Pkuatia\Core\Fields\DE\E;

use DateTime;
use DOMElement;

/**
 * E500 Campos que componen la Nota de Remisión Electrónica PADRE:E001 
 */
class GCamNRE
{
  public int $iMotEmiNR; ///ID:E501 Motivo de emisión PADRE:E500 
  public int $iRespEmiNR; ///ID:E503 Responsable de la emisión de la Nota Remisión Electrónica Padre:E500 
  public int $dKmR; ///E505 Kilómetros estimados de recorrido E500 
  public DateTime $dFecEm; //ID:E506 Fecha futura de emisión de la factura PADRE:E500
  public String $cPreFle; //Costo del Flete 

  ///////////////////////////////////////////////////////////////////////
  ///Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de iMotEmiNR
   *
   * @param int $iMotEmiNR
   *
   * @return self
   */
  public function setIMotEmiNR(int $iMotEmiNR): self
  {
    $this->iMotEmiNR = $iMotEmiNR;

    return $this;
  }

  /**
   * Establece el valor de iRespEmiNR
   *
   * @param int $iRespEmiNR
   *
   * @return self
   */
  public function setIRespEmiNR(int $iRespEmiNR): self
  {
    $this->iRespEmiNR = $iRespEmiNR;

    return $this;
  }


  /**
   * Establece el valor de dKmR
   *
   * @param int $dKmR
   *
   * @return self
   */
  public function setDKmR(int $dKmR): self
  {
    $this->dKmR = $dKmR;

    return $this;
  }


  /**
   * Establece el valor de dFecEm
   *
   * @param DateTime $dFecEm
   *
   * @return self
   */
  public function setDFecEm(DateTime $dFecEm): self
  {
    $this->dFecEm = $dFecEm;

    return $this;
  }

  public function setCPrefle(String $cPreFle): self
  {
    $this->cPreFle = $cPreFle;

    return $this;
  }


  ///////////////////////////////////////////////////////////////////////
  ///Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de iMotEmiNR
   *
   * @return int
   */
  public function getIMotEmiNR(): int 
  {
    return $this->iMotEmiNR;
  }

  /**
   * E502 Descripción del motivo de emisión E500
   *
   * @return String
   */
  public function getDDesMotEmiNR(): String 
  {
    switch ($this->iMotEmiNR) {
      case 1:
        return "Traslado por venta";
        break;
      case 2:
        return "Traslado por consignación";
        break;
      case 3:
        return "Exportación";
        break;
      case 4:
        return "Traslado por compra";
        break;
      case 5:
        return "Importación";
        break;
      case 6:
        return "Traslado por devolución";
        break;
      case 7:
        return "Traslado entre locales de la empresa";
        break;
      case 8:
        return "Traslado de bienes por  transformación";
        break;
      case 9:
        return "Traslado de bienes por reparación";
        break;
      case 10:
        return "Traslado por emisor móvil";
        break;
      case 11:
        return "Exhibición o demostración";
        break;
      case 12:
        return "Participación en ferias";
        break;
      case 13:
        return "Traslado de encomienda";
        break;
      case 14:
        return "Decomiso";
        break;
      case 99:
        return "Otro (Describir motivo)";
        break;

      default:
        return null;
        break;
    }
  }

  /**
   * Obtiene el valor de iRespEmiNR
   *
   * @return int
   */
  public function getIRespEmiNR(): int 
  {
    return $this->iRespEmiNR;
  }

  /**
   * E504 Descripción del responsable de la emisión de la Nota de Remisión Electrónica  
   *
   * @return String
   */
  public function getDDesRespEmiNR(): String 
  {
    switch ($this->iRespEmiNR) {
      case 1:
        return "Emisor de la factura";
        break;
      case 2:
        return "Poseedor de la factura y bienes";
        break;
      case 3:
        return "Empresa transportista";
        break;
      case 4:
        return "Despachante de Aduanas";
        break;
      case 5:
        return "Agente de transporte o intermediario";
        break;

      default:
        return null;
        break;
    }
  }

  /**
   * Obtiene el valor de dKmR
   *
   * @return int
   */
  public function getDKmR(): int 
  {
    return $this->dKmR;
  }

  /**
   * Obtiene el valor de dFecEm
   *
   * @return DateTime
   */
  public function getDFecEm(): DateTime 
  {
    return $this->dFecEm;
  }

  public function getCPrefle(): String 
  {
    return $this->cPreFle;
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
    $res = new DOMElement("gCamNRE");

    $res->appendChild(new DOMElement('iMotEmiNR', $this->getIMotEmiNR()));
    $res->appendChild(new DOMElement('dDesMotEmiNR', $this->getDDesMotEmiNR()));
    $res->appendChild(new DOMElement('iRespEmiNR', $this->getIRespEmiNR()));
    $res->appendChild(new DOMElement('dDesRespEmiNR', $this->getDDesRespEmiNR()));
    $res->appendChild(new DOMElement('dKmR', $this->getDKmR()));
    $res->appendChild(new DOMElement('dFecEm', $this->getDFecEm()->format('Y-m-d')));
    $res->appendChild(new DOMElement('cPreFle', $this->getCPrefle()));

    return $res;
  }

  /**
   * Instancia un objeto del tipo GCamNRE a partir de un DOMElement que representa el nodo XML del objeto GCamNRE.
   * 
   * @param DOMElement $node Nodo XML que representa el objeto GCamNRE
   * 
   * @return self Objeto GCamNRE instanciado
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    $res = new GCamNRE();

    if($node->getElementsByTagName('iMotEmiNR')->length > 0){
      $res->setIMotEmiNR(intval($node->getElementsByTagName('iMotEmiNR')->item(0)->nodeValue));
    }
    if($node->getElementsByTagName('iRespEmiNR')->length > 0){
      $res->setIRespEmiNR(intval($node->getElementsByTagName('iRespEmiNR')->item(0)->nodeValue));
    }
    if($node->getElementsByTagName('dKmR')->length > 0){
      $res->setDKmR(intval($node->getElementsByTagName('dKmR')->item(0)->nodeValue));
    }
    if($node->getElementsByTagName('dFecEm')->length > 0){
      $res->setDFecEm(DateTime::createFromFormat('Y-m-d', $node->getElementsByTagName('dFecEm')->item(0)->nodeValue));
    }
    
    if($node->getElementsByTagName('cPreFle')->length > 0){
      $res->setCPrefle($node->getElementsByTagName('cPreFle')->item(0)->nodeValue);
    }

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
    $res = new GCamNRE();

    if(isset($object->iMotEmiNR)){
      $res->setIMotEmiNR(intval($object->iMotEmiNR));
    }
    if(isset($object->iRespEmiNR)){
      $res->setIRespEmiNR(intval($object->iRespEmiNR));
    }
    if(isset($object->dKmR)){
      $res->setDKmR(intval($object->dKmR));
    }
    if(isset($object->dFecEm)){
      $res->setDFecEm(DateTime::createFromFormat('Y-m-d', $object->dFecEm));
    }

    if(isset($object->cPreFle)){
      $res->setCPrefle($object->cPreFle);
    }
    
    return $res;
  }
}
