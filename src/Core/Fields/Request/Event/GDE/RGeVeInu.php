<?php

namespace IonysDev\Pkuatia\Core\Fields\Request\Event\GDE;

use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo: GEI001 - rGeVeInu - Campos generales del DE
 * Padre: GDE007 - gGroupTiEvt - Grupo de campos del tipo de evento
 */
class RGeVeInu
{
                            //RAIZ - DESCRIPCION- LONGITUD - OCURRENCIA
  public int    $dNumTim;   // GEI002 - Número del Timbrado - 8 - 1-1
  public String $dEst;      // GEI003 - Establecimiento - 3 - 1-1
  public String $dPunExp;   // GEI004 - Punto de expedición 3 -1-1
  public String $dNumIn;    // GEI005 - Número Inicio del rango del documento - 7 - 1-1
  public String $dNumFin;   // GEI006 - Número Final del rango del documento - 7 - 1-1
  public int    $iTiDE;     // GEI007 - Tipo de Documento Electrónico  -1-2 - 1-1
  public String $mOtEve;    // GEI008 - Motivo del Evento 5-500 - 1-1
  public String $dSerieNum; // GEI009 - Serie del número del documento: OCURRENCIA - 2 - 0-1

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de dNumTim - Número del Timbrado
   *
   * @param int $dNumTim
   *
   * @return self
   */
  public function setDNumTim(int $dNumTim): self
  {
    $this->dNumTim = $dNumTim;
    return $this;
  }

  /**
   * Establece el valor de dEst - Establecimiento
   *
   * @param String $dEst
   *
   * @return self
   */
  public function setDEst(String $dEst): self
  {
    $this->dEst = $dEst;
    return $this;
  }

  /**
   * Establece el valor de dPunExp - Punto de expedición
   *
   * @param String $dPunExp
   *
   * @return self
   */
  public function setDPunExp(String $dPunExp): self
  {
    $this->dPunExp = $dPunExp;
    return $this;
  }

  /**
   * Establece el valor de dNumIn - Número Inicio del rango del documento
   *
   * @param String $dNumIn
   *
   * @return self
   */
  public function setDNumIn(String $dNumIn): self
  {
    $this->dNumIn = $dNumIn;
    return $this;
  }

  /**
   * Establece el valor de dNumFin - Número Final del rango del documento
   *
   * @param String $dNumFin
   *
   * @return self
   */
  public function setDNumFin(String $dNumFin): self
  {
    $this->dNumFin = $dNumFin;
    return $this;
  }

  /**
   * Establece el valor de iTiDE - Tipo de Documento Electrónico
   *
   * @param int $iTiDE
   *
   * @return self
   */
  public function setITiDE(int $iTiDE): self
  {
    $this->iTiDE = $iTiDE;
    return $this;
  }

  /**
   * Establece el valor de mOtEve - Motivo del Evento
   *
   * @param String $mOtEve
   *
   * @return self
   */
  public function setMOtEve(String $mOtEve): self
  {
    $this->mOtEve = $mOtEve;
    return $this;
  }


  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de dNumTim - Número del Timbrado
   *
   * @return int
   */
  public function getDNumTim(): int
  {
    return $this->dNumTim;
  }

  /**
   * Obtiene el valor de dEst - Establecimiento
   *
   * @return String
   */
  public function getDEst(): String
  {
    return $this->dEst;
  }

  /**
   * Obtiene el valor de dPunExp - Punto de expedición
   *
   * @return String
   */
  public function getDPunExp(): String
  {
    return $this->dPunExp;
  }

  /**
   * Obtiene el valor de dNumIn - Número Inicio del rango del documento
   *
   * @return String
   */
  public function getDNumIn(): String
  {
    return $this->dNumIn;
  }

  /**
   * Obtiene el valor de dNumFin - Número Final del rango del documento
   *
   * @return String
   */
  public function getDNumFin(): String
  {
    return $this->dNumFin;
  }

  /**
   * Obtiene el valor de iTiDE - Tipo de Documento Electrónico
   *
   * @return int
   */
  public function getITiDE(): int
  {
    return $this->iTiDE;
  }

  /**
   * Obtiene el valor de mOtEve - Motivo del Evento
   *
   * @return String
   */
  public function getMOtEve(): String
  {
    return $this->mOtEve;
  }


  ///////////////////////////////////////////////////////////////////////
  // Conversiones XML
  ///////////////////////////////////////////////////////////////////////

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
      $res = $doc->createElement('rGeVeInu');
      $res->appendChild($doc->createElement('dNumTim', $this->dNumTim));
      $res->appendChild($doc->createElement('dEst', $this->dEst));
      $res->appendChild($doc->createElement('dPunExp', $this->dPunExp));
      $res->appendChild($doc->createElement('dNumIn', $this->dNumIn));
      $res->appendChild($doc->createElement('dNumFin', $this->dNumFin));
      $res->appendChild($doc->createElement('iTiDE', $this->iTiDE));
      $res->appendChild($doc->createElement('mOtEve', $this->mOtEve));
      if (isset($this->dSerieNum)) {
        $res->appendChild($doc->createElement('dSerieNum', $this->dSerieNum));
      }
      return $res;
  }

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return RGeVeInu
  //  */
  // public static function fromDOMElement(DOMElement $xml): RGeVeInu
  // {
  //   if (strcmp($xml->tagName, 'rGeVeInu') == 0 && $xml->childElementCount == 8) {
  //     $res = new RGeVeInu();
  //     $res->setDNumTim(intval($xml->getElementsByTagName('dNumTim')->item(0)->nodeValue));
  //     $res->setDEst($xml->getElementsByTagName('dEst')->item(0)->nodeValue);
  //     $res->setDPunExp($xml->getElementsByTagName('dPunExp')->item(0)->nodeValue);
  //     $res->setDNumIn($xml->getElementsByTagName('dNumIn')->item(0)->nodeValue);
  //     $res->setDNumFin($xml->getElementsByTagName('dNumFin')->item(0)->nodeValue);
  //     $res->setITiDE(intval($xml->getElementsByTagName('iTiDE')->item(0)->nodeValue));
  //     $res->setMOtEve($xml->getElementsByTagName('mOtEve')->item(0)->nodeValue);

  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }

  ///////////////////////////////////////////////////////////////////////
  ////AGREGADO EN NOTA TECNICA
  ///////////////////////////////////////////////////////////////////////
  /**
   * Obtiene el valor de dSerieNum
   *
   * @return String
   */
  public function getDSerieNum(): String
  {
    return $this->dSerieNum;
  }

  /**
   * Establece el valor de dSerieNum
   *
   * @param String $dSerieNum
   *
   * @return self
   */
  public function setDSerieNum(String $dSerieNum): self
  {
    $this->dSerieNum = $dSerieNum;

    return $this;
  }
  
  /**
   * FromSimpleXMLElement
   *
   * @param  mixed $node
   * @return self
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node):self
  {
     if(strcmp($node->getName(),'rGeVeInu') != 0) {
       throw new \Exception("Invalid XML Element: ". $node->getName());
       return null;
     }

      $res = new self();
      $res->setDNumTim(intval($node->dNumTim));
      $res->setDEst($node->dEst);
      $res->setDPunExp($node->dPunExp);
      $res->setDNumIn($node->dNumIn);
      $res->setDNumFin($node->dNumFin);
      $res->setITiDE(intval($node->iTiDE));
      $res->setMOtEve($node->mOtEve);
      if(isset($node->dSerieNum)) {
        $res->setDSerieNum($node->dSerieNum);
      }

      return $res;
  }
}
