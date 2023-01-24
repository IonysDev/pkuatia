<?php

namespace Abiliomp\Pkuatia\Fields\Request\events\GEA;

use DateTime;
use DOMElement;

/**
 * ID:GEDF001 rGeDevCCFFCue Raíz Gestión de Eventos de devolución de créditos fiscales - Cuestionado PADRE:GDE007
 */
class rGeDevCCFFCue
{
  public string $Id; //GEDF002 CDC del DE/DTE
  public string $dNumDevSol; //GEDF003 Número DIR
  public string $dNumDevInf; //GEDF004 Número de informe 
  public string $dNumDevRes; //GEDF005 Número de resolución de la devolución
  public DateTime $dFeEmiSol; //GEDF006 Fecha de emisión de DIR
  public DateTime $dFeEmiInf; //GEDF007 Fecha de emisión del informe
  public DateTime $dFeEmiRes; //GEDF008 Fecha de emisión de la resolución

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
   * Set the value of dNumDevSol
   *
   * @param string $dNumDevSol
   *
   * @return self
   */
  public function setDNumDevSol(string $dNumDevSol): self
  {
    $this->dNumDevSol = $dNumDevSol;

    return $this;
  }


  /**
   * Set the value of dNumDevInf
   *
   * @param string $dNumDevInf
   *
   * @return self
   */
  public function setDNumDevInf(string $dNumDevInf): self
  {
    $this->dNumDevInf = $dNumDevInf;

    return $this;
  }


  /**
   * Set the value of dNumDevRes
   *
   * @param string $dNumDevRes
   *
   * @return self
   */
  public function setDNumDevRes(string $dNumDevRes): self
  {
    $this->dNumDevRes = $dNumDevRes;

    return $this;
  }


  /**
   * Set the value of dFeEmiSol
   *
   * @param DateTime $dFeEmiSol
   *
   * @return self
   */
  public function setDFeEmiSol(DateTime $dFeEmiSol): self
  {
    $this->dFeEmiSol = $dFeEmiSol;

    return $this;
  }


  /**
   * Set the value of dFeEmiInf
   *
   * @param DateTime $dFeEmiInf
   *
   * @return self
   */
  public function setDFeEmiInf(DateTime $dFeEmiInf): self
  {
    $this->dFeEmiInf = $dFeEmiInf;

    return $this;
  }


  /**
   * Set the value of dFeEmiRes
   *
   * @param DateTime $dFeEmiRes
   *
   * @return self
   */
  public function setDFeEmiRes(DateTime $dFeEmiRes): self
  {
    $this->dFeEmiRes = $dFeEmiRes;

    return $this;
  }

  //GETTERS
  

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
   * Get the value of dNumDevSol
   *
   * @return string
   */
  public function getDNumDevSol(): string
  {
    return $this->dNumDevSol;
  }

  /**
   * Get the value of dNumDevInf
   *
   * @return string
   */
  public function getDNumDevInf(): string
  {
    return $this->dNumDevInf;
  }

  /**
   * Get the value of dNumDevRes
   *
   * @return string
   */
  public function getDNumDevRes(): string
  {
    return $this->dNumDevRes;
  }

  /**
   * Get the value of dFeEmiSol
   *
   * @return DateTime
   */
  public function getDFeEmiSol(): DateTime
  {
    return $this->dFeEmiSol;
  }

  /**
   * Get the value of dFeEmiInf
   *
   * @return DateTime
   */
  public function getDFeEmiInf(): DateTime
  {
    return $this->dFeEmiInf;
  }

  /**
   * Get the value of dFeEmiRes
   *
   * @return DateTime
   */
  public function getDFeEmiRes(): DateTime
  {
    return $this->dFeEmiRes;
  }

  ///XML ELEMENT
  
  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('rGeDevCCFFCue');
    $res->appendChild(new DOMElement('Id', $this->getId()));
    $res->appendChild(new DOMElement('dNumDevSol', $this->getDNumDevSol()));
    $res->appendChild(new DOMElement('dNumDevInf', $this->getDNumDevInf()));
    $res->appendChild(new DOMElement('dNumDevRes', $this->getDNumDevRes()));
    $res->appendChild(new DOMElement('dFeEmiSol', $this->getDFeEmiSol()->format('Y-m-d')));
    $res->appendChild(new DOMElement('dFeEmiInf', $this->getDFeEmiInf()->format('Y-m-d')));
    $res->appendChild(new DOMElement('dFeEmiRes', $this->getDFeEmiRes()->format('Y-m-d')));

    return $res;
  }
}
