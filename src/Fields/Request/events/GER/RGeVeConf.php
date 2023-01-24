<?php

namespace Abiliomp\Pkuatia\Fields\Request\events\GER;

use DateTime;
use DOMElement;

/**
 * ID:GCO001 rGeVeConf Raiz Gestión de Eventos Conformidad PADRE:GDE007
 */
class RGeVeConf
{
  public string $Id;///GCO002 CDC del DTE 
  public int $iTipConf;//GCO003 Tipo de Conformidad 
  public DateTime $dFecRecep;//// GCO004 Fecha Estimada de Recepción


  ///SETTERS
  /**
   * Set the value of Id
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
   * Set the value of iTipConf
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
   * Set the value of dFecRecep
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

  ///GETTERS
  

  /**
   * Get the value of Id
   *
   * @return string
   */
  public function getId(): string
  {
    return $this->Id;
  }

  /**
   * Get the value of iTipConf
   *
   * @return int
   */
  public function getITipConf(): int
  {
    return $this->iTipConf;
  }

  /**
   * Get the value of dFecRecep
   *
   * @return DateTime
   */
  public function getDFecRecep(): DateTime
  {
    return $this->dFecRecep;
  }


  ///XML Element  
  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('rGeVeConf');
    $res->appendChild(new DOMElement('Id', $this->getId()));
    $res->appendChild(new DOMElement('iTipConf', $this->getITipConf()));

    if($this->iTipConf == 2)
    {
      $res->appendChild(new DOMElement('dFecRecep', $this->dFecRecep->format('Y-m-d')));
    }
    return $res;
  }
}
