<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\events\GER;

use DateTime;
use DOMElement;

/**
 * Nodo: GCO001 - rGeVeConf - Raiz Gestión de Eventos Conformidad
 * Padre: GDE007 - gGroupTiEvt - Grupo de campos del tipo de evento
 */
class TrGeVeConf
{
  public string   $Id;        // GCO002 CDC del DTE 
  public int      $iTipConf;  // GCO003 Tipo de Conformidad: 1 - Total | 2 - Parcial
  public DateTime $dFecRecep; // GCO004 Fecha Estimada de Recepción


  //====================================================//
  // Setters
  //====================================================//

  /**
   * Establece el valor de Id - CDC del DTE 
   *
   * @param string $Id
   *
   * @return self
   */
  public function setId(string $Id): self
  {
    $this->Id = $Id;
    return $this;
  }

  /**
   * Establece el valor de iTipConf - Tipo de Conformidad
   *
   * @param int $iTipConf
   *
   * @return self
   */
  public function setITipConf(int $iTipConf): self
  {
    $this->iTipConf = $iTipConf;
    return $this;
  }

  /**
   * Establece el valor de dFecRecep - Fecha Estimada de Recepción
   *
   * @param DateTime $dFecRecep
   *
   * @return self
   */
  public function setDFecRecep(DateTime $dFecRecep): self
  {
    $this->dFecRecep = $dFecRecep;
    return $this;
  }


  //====================================================//
  // Getters
  //====================================================//  

  /**
   * Obtiene el valor de Id - CDC del DTE 
   *
   * @return string
   */
  public function getId(): string
  {
    return $this->Id;
  }

  /**
   * Obtiene el valor de iTipConf - Tipo de Conformidad
   *
   * @return int
   */
  public function getITipConf(): int
  {
    return $this->iTipConf;
  }

  /**
   * Obtiene el valor de dFecRecep - Fecha Estimada de Recepción
   *
   * @return DateTime
   */
  public function getDFecRecep(): DateTime
  {
    return $this->dFecRecep;
  }

  //====================================================//
  // Conversiones XML  
  //====================================================//

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('trGeVeConf');
    $res->appendChild(new DOMElement('Id', $this->getId()));
    $res->appendChild(new DOMElement('iTipConf', $this->getITipConf()));
    if ($this->iTipConf == 2) {
      $res->appendChild(new DOMElement('dFecRecep', $this->dFecRecep->format('Y-m-d')));
    }
    return $res;
  }

  /**
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return TrGeVeConf
   */
  public static function fromDOMElement(DOMElement $xml): TrGeVeConf
  {
    if (strcmp($xml->tagName, 'trGeVeConf') == 0 && $xml->childElementCount == 3) {
      $res = new TrGeVeConf();
      $res->setId($xml->getElementsByTagName('Id')->item(0)->nodeValue);
      $res->setITipConf(intval($xml->getElementsByTagName('iTipConf')->item(0)->nodeValue));
      $res->setDFecRecep(DateTime::createFromFormat('Y-m-d' ,$xml->getElementsByTagName('dFecRecep')->item(0)->nodeValue));
      return $res;
    } else {
      throw new \Exception("Invalid XML Element: $xml->tagName");
      return null;
    }
  }
}
