<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\E;

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

  //====================================================//
  ///Setters
  //====================================================//

  /**
   * Set the value of iMotEmiNR
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
   * Set the value of iRespEmiNR
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
   * Set the value of dKmR
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
   * Set the value of dFecEm
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

  //====================================================//
  ///Getters
  //====================================================//

  /**
   * Get the value of iMotEmiNR
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
   * @return string
   */
  public function getDDesMotEmiNR(): string
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
   * Get the value of iRespEmiNR
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
   * @return string
   */
  public function getDDesRespEmiNR(): string
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
   * Get the value of dKmR
   *
   * @return int
   */
  public function getDKmR(): int
  {
    return $this->dKmR;
  }

  /**
   * Get the value of dFecEm
   *
   * @return DateTime
   */
  public function getDFecEm(): DateTime
  {
    return $this->dFecEm;
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
    $res = new DOMElement("gCamNRE");

    $res->appendChild(new DOMElement('iMotEmiNR', $this->getIMotEmiNR()));
    $res->appendChild(new DOMElement('dDesMotEmiNR', $this->getDDesMotEmiNR()));
    $res->appendChild(new DOMElement('iRespEmiNR', $this->getIRespEmiNR()));
    $res->appendChild(new DOMElement('dDesRespEmiNR', $this->getDDesRespEmiNR()));
    $res->appendChild(new DOMElement('dKmR', $this->getDKmR()));
    $res->appendChild(new DOMElement('dFecEm', $this->getDFecEm()->format('Y-m-d')));

    return $res;
  }
  
  /**
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return GCamNRE
   */
  public static function fromDOMElement(DOMElement $xml): GCamNRE
  {
    if (strcmp($xml->tagName, "gCamNRE") == 0 && $xml->childElementCount == 6) {
      $res = new GCamNRE();

      $res->setIMotEmiNR(intval($xml->getElementsByTagName('iMotEmiNR')->item(0)->nodeValue));
      $res->setIRespEmiNR(intval($xml->getElementsByTagName('iRespEmiNR')->item(0)->nodeValue));
      $res->setdkmR(intval($xml->getElementsByTagName('dkmR')->item(0)->nodeValue));
      $res->setDFecEm(DateTime::createFromFormat('Y-m-d', $xml->getElementsByTagName('dFecEm')->item(0)->nodeValue));
      return $res;
    } else {
      throw new \Exception("Invalid XML Element: $xml->tagName");
      return null;
    }
  }
}
