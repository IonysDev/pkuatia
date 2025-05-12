<?php

namespace IonysDev\Pkuatia\Core\Fields\DE\E;

use DateTime;
use DOMDocument;
use DOMElement;
use IonysDev\Pkuatia\Core\Constants\MotEmiNR;
use IonysDev\Pkuatia\Core\Constants\RespEmiNR;
use IonysDev\Pkuatia\Core\Fields\BaseSifenField;

/**
 * Nodo Id:     E500
 * Nombre:      GCamNRE
 * Descripción: Campos que componen la Nota de Remisión Electrónica (E500-E599)
 * Nodo Padre:  E001 - gDtipDE - Campos específicos por tipo de Documento Electrónico 
 */
class GCamNRE extends BaseSifenField
{
                                // Id - Longitud - Ocurrencia - Descripción
  public int $iMotEmiNR;        // E501 - 1-2   - 1-1 - Motivo de emisión
  public String $dDesMotEmiNR;  // E502 - 5-60  - 1-1 - Descripción del motivo de emisión
  public int $iRespEmiNR;       // E503 - 1-1   - 1-1 - Responsable de la emisión de la Nota Remisión Electrónica
  public String $dDesRespEmiNR; // E504 - 20-36 - 1-1 - Descripción del responsable de la emisión de la Nota Remisión Electrónica
  public int $dKmR;             // E505 - 1-5   - 0-1 - Kilómetros estimados de recorrido
  public DateTime $dFecEm;      // E506 - 10    - 0-1 - Fecha futura de emisión de la factura
  
  ///////////////////////////////////////////////////////////////////////
  ///Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de iMotEmiNR (Motivo de emisión) y a la vez establece el valor de dDesMotEmiNR (Descripción del motivo de emisión).
   *
   * @param int $iMotEmiNR - Motivo de emisión
   *
   * @return self
   */
  public function setIMotEmiNR(int|MotEmiNR $iMotEmiNR): self
  {
    if(is_int($iMotEmiNR)){
      $this->dDesMotEmiNR = MotEmiNR::getDescripcionFromInt($iMotEmiNR);
      $this->iMotEmiNR = $iMotEmiNR;
    } else {
      $this->iMotEmiNR = $iMotEmiNR->value;
      $this->dDesMotEmiNR = $iMotEmiNR->getDescripcion();
    }
    return $this;
  }

  /**
   * Establece el valor de dDesMotEmiNR (Descripción del motivo de emisión).
   * Solo usarlo para iMotEmiNR = 99 - Otro (Describir motivo).
   * No se recomienda usar este método, ya que se puede establecer el valor de iMotEmiNR, que a la vez establece el valor de dDesMotEmiNR.
   * 
   * @param String $dDesMotEmiNR - Descripción del motivo de emisión
   * 
   * @return self 
   */
  public function setDDesMotEmiNR(String $dDesMotEmiNR): self
  {
    $this->dDesMotEmiNR = $dDesMotEmiNR;
    return $this;
  }

  /**
   * Establece el valor de iRespEmiNR (Responsable de la emisión de la Nota Remisión Electrónica)
   *
   * @param int $iRespEmiNR - Responsable de la emisión de la Nota Remisión Electrónica
   *
   * @return self
   */
  public function setIRespEmiNR(int|RespEmiNR $iRespEmiNR): self
  {
    if(is_int($iRespEmiNR)){
      $this->dDesRespEmiNR = RespEmiNR::getDescripcionFromInt($iRespEmiNR);
      $this->iRespEmiNR = $iRespEmiNR;
    } else {
      $this->iRespEmiNR = $iRespEmiNR->value;
      $this->dDesRespEmiNR = $iRespEmiNR->getDescripcion();
    }

    return $this;
  }

  /**
   * Establece el valor de dDesRespEmiNR (Descripción del responsable de la emisión de la Nota Remisión Electrónica).
   * No se recomienda usar este método, ya que se puede establecer el valor de iRespEmiNR, que a la vez establece el valor de dDesRespEmiNR.
   * 
   * @param String $dDesRespEmiNR - Descripción del responsable de la emisión de la Nota Remisión Electrónica
   * 
   * @return self 
   */
  public function setDDesRespEmiNR(String $dDesRespEmiNR): self
  {
    $this->dDesRespEmiNR = $dDesRespEmiNR;
    return $this;
  }


  /**
   * Establece el valor de dKmR (Kilómetros estimados de recorrido)
   *
   * @param int $dKmR - Kilómetros estimados de recorrido
   *
   * @return self
   */
  public function setDKmR(int $dKmR): self
  {
    $this->dKmR = $dKmR;

    return $this;
  }


  /**
   * Establece el valor de dFecEm (Fecha futura de emisión de la factura)
   *
   * @param DateTime $dFecEm - Fecha futura de emisión de la factura
   *
   * @return self
   */
  public function setDFecEm(DateTime $dFecEm): self
  {
    $this->dFecEm = $dFecEm;

    return $this;
  }


  ///////////////////////////////////////////////////////////////////////
  ///Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de iMotEmiNR (Motivo de emisión)
   *
   * @return int
   */
  public function getIMotEmiNR(): int
  {
    return $this->iMotEmiNR;
  }

  /**
   * Obtiene el valor de dDesMotEmiNR (Descripción del motivo de emisión)
   *
   * @return String
   */
  public function getDDesMotEmiNR(): String
  {
    return $this->dDesMotEmiNR;
  }

  /**
   * Obtiene el valor de iRespEmiNR (Responsable de la emisión de la Nota Remisión Electrónica)
   *
   * @return int
   */
  public function getIRespEmiNR(): int
  {
    return $this->iRespEmiNR;
  } 

  /**
   * Obtiene el valor de dDesRespEmiNR (Descripción del responsable de la emisión de la Nota Remisión Electrónica)
   *
   * @return String
   */
  public function getDDesRespEmiNR(): String
  {
    return $this->dDesRespEmiNR;
  } 

  /**
   * Obtiene el valor de dKmR (Kilómetros estimados de recorrido)
   *
   * @return int
   */
  public function getDKmR(): int
  {
    return $this->dKmR;
  } 

  /**
   * Obtiene el valor de dFecEm (Fecha futura de emisión de la factura)
   *
   * @return DateTime
   */
  public function getDFecEm(): DateTime
  {
    return $this->dFecEm;
  }   

  ///////////////////////////////////////////////////////////////////////
  ///XML Element
  ///////////////////////////////////////////////////////////////////////

  /**
   * Convierte este objeto GCamNRE a un DOMElement mediante el DOMDocument proporcionado.
   * 
   * @param DOMDocument $doc - Documento DOM donde se creará el elemento.
   *
   * @return DOMElement El elemento DOM que representa este objeto GCamNRE.
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gCamNRE');
    $res->appendChild(new DOMElement('iMotEmiNR', $this->getIMotEmiNR()));
    $res->appendChild(new DOMElement('dDesMotEmiNR', $this->getDDesMotEmiNR()));
    $res->appendChild(new DOMElement('iRespEmiNR', $this->getIRespEmiNR()));
    $res->appendChild(new DOMElement('dDesRespEmiNR', $this->getDDesRespEmiNR()));
    $res->appendChild(new DOMElement('dKmR', $this->getDKmR()));
    $res->appendChild(new DOMElement('dFecEm', $this->getDFecEm()->format('Y-m-d')));
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
    if($node->getElementsByTagName('dDesMotEmiNR')->length > 0){
      $res->setDDesMotEmiNR($node->getElementsByTagName('dDesMotEmiNR')->item(0)->nodeValue);
    }
    if($node->getElementsByTagName('iRespEmiNR')->length > 0){
      $res->setIRespEmiNR(intval($node->getElementsByTagName('iRespEmiNR')->item(0)->nodeValue));
    }
    if($node->getElementsByTagName('dDesRespEmiNR')->length > 0){
      $res->setDDesRespEmiNR($node->getElementsByTagName('dDesRespEmiNR')->item(0)->nodeValue);
    }
    if($node->getElementsByTagName('dKmR')->length > 0){
      $res->setDKmR(intval($node->getElementsByTagName('dKmR')->item(0)->nodeValue));
    }
    if($node->getElementsByTagName('dFecEm')->length > 0){
      $res->setDFecEm(DateTime::createFromFormat('Y-m-d', $node->getElementsByTagName('dFecEm')->item(0)->nodeValue));
    }
    return $res;
  }
}
