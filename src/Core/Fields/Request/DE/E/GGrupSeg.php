<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\E;

use DOMElement;
use DOMException;

/**
 * ID:E800  Grupo del sector de seguros
 * PADRE:E790
 */
class GGrupSeg
{
  public ?string $dCodEmpSeg = null; //E801 Código de la empresa de seguros en la Superintendencia de Seguros
  public ?GGrupPolSeg $gGrupoPolSeg = null;

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
  public function getDCodEmpSeg(): string | null
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
    //children
    $res->appendChild($this->gGrupoPolSeg->toDomElement());
    return $res;
  }

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return GGrupSeg
  //  */
  // public static function fromDOMElement(DOMElement $xml): GGrupSeg
  // {
  //   if (strcmp($xml->tagName, 'GGrupSeg' == 0) && $xml->childElementCount == 2) {
  //     $res = new GGrupSeg();
  //     $res->setDCodEmpSeg($xml->getElementsByTagName('dCodEmpSeg')->item(0)->nodeValue);
  //     ///children
  //     $res->setGGrupoPolSeg($res->gGrupoPolSeg->fromDOMElement($xml->getElementsByTagName('GGrupoPolSeg')->item(0)->nodeValue));
  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }

  //====================================================//
  //Others
  //====================================================//

  /**
   * Get the value of gGrupoPolSeg
   *
   * @return GGrupPolSeg
   */
  public function getGGrupoPolSeg(): GGrupPolSeg | null
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

  public static function fromResponse($response):self
  {
    $res = new GGrupSeg();
    $res->setDCodEmpSeg($response->dCodEmpSeg);
    if(isset($response->gGrupoPolSeg)){
      $res->setGGrupoPolSeg(GGrupPolSeg::fromResponse($response->gGrupoPolSeg));
    }
    return $res;
  }
}
