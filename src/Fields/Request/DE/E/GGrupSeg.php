<?php

namespace Abiliomp\Pkuatia\Fields\E;

use DOMElement;
use DOMException;

/**
 * ID:E800  Grupo del sector de seguros
 * PADRE:E790
 */
class GGrupSeg
{
  public string $dCodEmpSeg; //E801 Código de la empresa de seguros en la Superintendencia de Seguros
  public GGrupPolSeg $gGrupoPolSeg;

  //====================================================//
  ///Setter
  //====================================================//

  /**
   * Set the value of dCodEmpSeg
   *
   * @param string $dCodEmpSeg
   *
   * @return self
   */
  public function setDCodEmpSeg(string $dCodEmpSeg): self
  {
    $this->dCodEmpSeg = $dCodEmpSeg;

    return $this;
  }

  //====================================================//
  ///Getter
  //====================================================//

  /**
   * Get the value of dCodEmpSeg
   *
   * @return string
   */
  public function getDCodEmpSeg(): string
  {
    return $this->dCodEmpSeg;
  }

  //====================================================//
  ///XML Element  
  //====================================================//

  /**
   * toDomElement
   *
   * @return DOMElement
   */
  public function toDomElement(): DOMElement
  {
    $res = new DOMElement('gGrupSeg');
    $res->appendChild(new DOMElement('dCodEmpSeg', $this->getDCodEmpSeg()));
    return $res;
  }

  //====================================================//
  //Others
  //====================================================//

  /**
   * Get the value of gGrupoPolSeg
   *
   * @return GGrupPolSeg
   */
  public function getGGrupoPolSeg(): GGrupPolSeg
  {
    return $this->gGrupoPolSeg;
  }

  /**
   * Set the value of gGrupoPolSeg
   *
   * @param GGrupPolSeg $gGrupoPolSeg
   *
   * @return self
   */
  public function setGGrupoPolSeg(GGrupPolSeg $gGrupoPolSeg): self
  {
    $this->gGrupoPolSeg = $gGrupoPolSeg;

    return $this;
  }
}
