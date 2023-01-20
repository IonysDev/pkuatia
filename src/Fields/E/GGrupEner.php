<?php

namespace Abiliomp\Pkuatia\Fields\E;

use DOMElement;

/**
 *ID:E791 
 *Grupo del sector de energía eléctrica 
 *PADRE:E790
 */
class GGrupEner
{
  public string $dNroMed; //E792 Número de medidor
  public int $dActiv; ///E793 Código de actividad
  public string $dCateg; ///E794 Código de categoría
  public int $dLecAnt; ///E795 Lectura anterior
  public int $dLecAct;///E796 Lectura actual
  public int $dConKwh;/// 797 dConKwh Consumo
  ///SETTETS
  
  /**
   * Set the value of dNroMed
   *
   * @param string $dNroMed
   *
   * @return self
   */
  public function setDNroMed(string $dNroMed): self
  {
    $this->dNroMed = $dNroMed;

    return $this;
  }


  /**
   * Set the value of dActiv
   *
   * @param int $dActiv
   *
   * @return self
   */
  public function setDActiv(int $dActiv): self
  {
    $this->dActiv = $dActiv;

    return $this;
  }


  /**
   * Set the value of dCateg
   *
   * @param string $dCateg
   *
   * @return self
   */
  public function setDCateg(string $dCateg): self
  {
    $this->dCateg = $dCateg;

    return $this;
  }


  /**
   * Set the value of dLecAnt
   *
   * @param int $dLecAnt
   *
   * @return self
   */
  public function setDLecAnt(int $dLecAnt): self
  {
    $this->dLecAnt = $dLecAnt;

    return $this;
  }


  /**
   * Set the value of dLecAct
   *
   * @param int $dLecAct
   *
   * @return self
   */
  public function setDLecAct(int $dLecAct): self
  {
    $this->dLecAct = $dLecAct;

    return $this;
  }

    /**
   * Set the value of dConKwh
   *
   * @param int $dConKwh
   *
   * @return self
   */
  public function setDConKwh(int $dConKwh): self
  {
    $this->dConKwh = $dConKwh;

    return $this;
  }

  ///Getter





  /**
   * Get the value of dNroMed
   *
   * @return string
   */
  public function getDNroMed(): string
  {
    return $this->dNroMed;
  }

  /**
   * Get the value of dActiv
   *
   * @return int
   */
  public function getDActiv(): int
  {
    return $this->dActiv;
  }

  /**
   * Get the value of dCateg
   *
   * @return string
   */
  public function getDCateg(): string
  {
    return $this->dCateg;
  }

  /**
   * Get the value of dLecAnt
   *
   * @return int
   */
  public function getDLecAnt(): int
  {
    return $this->dLecAnt;
  }

  /**
   * Get the value of dLecAct
   *
   * @return int
   */
  public function getDLecAct(): int
  {
    return $this->dLecAct;
  }

  /**
   * Get the value of dConKwh
   *
   * @return int
   */
  public function getDConKwh(): int
  {
    return $this->dLecAct - $this->dLecAct;
  }


  ///XML Element
  
  /**
   * toDomElement
   *
   * @return DOMElement
   */
  public function toDomElement(): DOMElement
  {
    $res = new DOMElement('gGrupEner');

    $res->appendChild(new DOMElement('dNroMed', $this->getDNroMed()));
    $res->appendChild(new DOMElement('dActiv', $this->getDActiv()));
    $res->appendChild(new DOMElement('dCateg', $this->getDCateg()));
    $res->appendChild(new DOMElement('dLecAnt', $this->getDLecAnt()));
    $res->appendChild(new DOMElement('dLecAct', $this->getDLecAct()));
    $res->appendChild(new DOMElement('dConKwh', $this->getDConKwh()));

    return $res;
  }
}
