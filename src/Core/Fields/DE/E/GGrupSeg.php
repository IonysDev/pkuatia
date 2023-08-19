<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use DOMElement;
use DOMException;

/**
 * ID:E800  Grupo del sector de seguros
 * PADRE:E790
 */
class GGrupSeg
{
  public ?String $dCodEmpSeg; //E801 Código de la empresa de seguros en la Superintendencia de Seguros
  public ?GGrupPolSeg $gGrupoPolSeg;


  /////////////////////////////////////////////////
  ///CONSTRUCTOR
  /////////////////////////////////////////////////
  public function __construct()
  {
    $this->gGrupoPolSeg = new GGrupPolSeg();
  }

  ///////////////////////////////////////////////////////////////////////
  ///Setter
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of dCodEmpSeg
   *
   * @param String $dCodEmpSeg
   *
   * @return self
   */
  public function setDCodEmpSeg(String $dCodEmpSeg): self
  {
    $this->dCodEmpSeg = $dCodEmpSeg;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  ///Getter
  ///////////////////////////////////////////////////////////////////////

  /**
   * Get the value of dCodEmpSeg
   *
   * @return String
   */
  public function getDCodEmpSeg(): String
  {
    return $this->dCodEmpSeg;
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML Element  
  ///////////////////////////////////////////////////////////////////////

  /**
   * toDomElement
   *
   * @return DOMElement
   */
  public function toDomElement(): DOMElement
  {
    $res = new DOMElement('gGrupSeg');
    $res->appendChild(new DOMElement('dCodEmpSeg', $this->getDCodEmpSeg()));
    //children
    $res->appendChild($this->gGrupoPolSeg->toDomElement());
    return $res;
  }

  ///////////////////////////////////////////////////////////////////////
  //Others
  ///////////////////////////////////////////////////////////////////////

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

  public static function FromSifenResponseObject($object):self
  {
    $res = new GGrupSeg();
    if(isset($object->dCodEmpSeg))
    {
      $res->setDCodEmpSeg($object->dCodEmpSeg);
    }
 
    if(isset($object->gGrupoPolSeg)){
      $res->setGGrupoPolSeg(GGrupPolSeg::FromSifenResponseObject($object->gGrupoPolSeg));
    }
    return $res;
  }
}
