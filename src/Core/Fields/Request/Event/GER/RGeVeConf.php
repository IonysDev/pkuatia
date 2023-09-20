<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\Event\GER;

use DateTime;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo: GCO001 - rGeVeConf - Raiz Gestión de Eventos Conformidad
 * Padre: GDE007 - gGroupTiEvt - Grupo de campos del tipo de evento
 */
class RGeVeConf
{
  // ID - DESCRIPCION- LONGITUD - OCURRENCIA
  public String   $Id;        // GCO002 CDC del DTE 44- 1-1
  public int      $iTipConf;  // GCO003 Tipo de Conformidad - 1 - 1-1
  public DateTime $dFecRecep; // GCO004 Fecha Estimada de Recepción - 19 -0-1


  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de Id - CDC del DTE 
   *
   * @param String $Id
   *
   * @return self
   */
  public function setId(String $Id): self
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


  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////  

  /**
   * Obtiene el valor de Id - CDC del DTE 
   *
   * @return String
   */
  public function getId(): String
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
    $res = $doc->createElement('rGeVeConf');
    $res->appendChild(new DOMElement('Id', $this->getId()));
    $res->appendChild(new DOMElement('iTipConf', $this->getITipConf()));
    if ($this->iTipConf == 2) {
      $res->appendChild(new DOMElement('dFecRecep', $this->dFecRecep->format('Y-m-d')));
    }
    return $res;
  }

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return RGeVeConf
  //  */
  // public static function fromDOMElement(DOMElement $xml): RGeVeConf
  // {
  //   if (strcmp($xml->tagName, 'rGeVeConf') == 0 && $xml->childElementCount == 3) {
  //     $res = new RGeVeConf();
  //     $res->setId($xml->getElementsByTagName('Id')->item(0)->nodeValue);
  //     $res->setITipConf(intval($xml->getElementsByTagName('iTipConf')->item(0)->nodeValue));
  //     $res->setDFecRecep(DateTime::createFromFormat('Y-m-d', $xml->getElementsByTagName('dFecRecep')->item(0)->nodeValue));
  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }

  public static function FromSimpleXMLElement(SimpleXMLElement $node): Self
  {
    if ($node->getName() != 'rGeVeConf')
      throw new \Exception("Invalid XML Element: $node->getName()");

    $res = new RGeVeConf();
    $res->setId($node->Id);
    $res->setITipConf($node->iTipConf);
    if (isset($node->dFecRecep))
      $res->setDFecRecep(DateTime::createFromFormat('Y-m-d', $node->dFecRecep));

    return $res;
  }
}
