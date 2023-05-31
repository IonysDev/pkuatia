<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\E;

use DOMElement;

/**
 *ID:E790 
 *Campos complementarios comerciales de uso específico
 *PADRE:E001 
 */
class GCamEsp
{
  public GGrupEner $gGrupoEner;
  public GGrupSeg $gGrupoSeg;
  public GGrupSup $gGrupSup;

  //====================================================//
  ///Others
  //====================================================//

  /**
   * Get the value of gGrupoEner
   *
   * @return GGrupEner
   */
  public function getGGrupoEner(): GGrupEner
  {
    return $this->gGrupoEner;
  }

  /**
   * Set the value of gGrupoEner
   *
   * @param GGrupEner $gGrupoEner
   *
   * @return self
   */
  public function setGGrupoEner(GGrupEner $gGrupoEner): self
  {
    $this->gGrupoEner = $gGrupoEner;

    return $this;
  }

  /**
   * Get the value of gGrupoSeg
   *
   * @return GGrupSeg
   */
  public function getGGrupoSeg(): GGrupSeg
  {
    return $this->gGrupoSeg;
  }

  /**
   * Set the value of gGrupoSeg
   *
   * @param GGrupSeg $gGrupoSeg
   *
   * @return self
   */
  public function setGGrupoSeg(GGrupSeg $gGrupoSeg): self
  {
    $this->gGrupoSeg = $gGrupoSeg;

    return $this;
  }

  /**
   * Get the value of gGrupSup
   *
   * @return GGrupSup
   */
  public function getGGrupSup(): GGrupSup
  {
    return $this->gGrupSup;
  }

  /**
   * Set the value of gGrupSup
   *
   * @param GGrupSup $gGrupSup
   *
   * @return self
   */
  public function setGGrupSup(GGrupSup $gGrupSup): self
  {
    $this->gGrupSup = $gGrupSup;

    return $this;
  }

  //XML Element  
  /**
   * toDomElement
   *
   * @return DOMElement
   */
  public function toDomElement(): DOMElement
  {
    $res = new DOMElement('gCamEsp');
    if (isset($this->gGrupoEner)) {
      $res->appendChild($this->gGrupoEner->toDomElement());
    }

    if (isset($this->gGrupSup)) {
      $res->appendChild($this->gGrupSup->toDomElement());
    }

    if (isset($this->gGrupoSeg)) {
      $res->appendChild($this->gGrupSup->toDomElement());
    }

    return $res;
  }

  
  /**
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return GCamEsp
   */
  public static function fromDOMElement(DOMElement $xml): GCamEsp
  {
    if (strcmp($xml->tagName, 'gCamEsp') == 0 && $xml->childElementCount >= 1) {
      $res = new GCamEsp();
      $res->setGGrupoEner($res->gGrupoEner->fromDOMElement($xml->getElementsByTagName('gGrupoEner')->item(0)->nodeValue));
      $res->setGGrupSup($res->gGrupSup->fromDOMElement($xml->getElementsByTagName('gGrupoSup')->item(0)->nodeValue));
      $res->setGGrupoSeg($res->gGrupoSeg->fromDOMElement($xml->getElementsByTagName('gGrupoSeg')->item(0)->nodeValue));
      return $res;
    } else {
      throw new \Exception("Invalid XML Element: $xml->tagName");
      return null;
    }
  }

  //====================================================//
  public static function fromResponse($response):self
  {
    $res = new GCamEsp();
    if(isset($response->gGrupoEner))
    {
      $res->setGGrupoEner(GGrupEner::fromResponse($response->gGrupoEner));
    }

    if(isset($response->gGrupoSeg))
    {
      $res->setGGrupoSeg(GGrupSeg::fromResponse($response->gGrupoSeg));
    }

    if(isset($response->gGrupoSup))
    {
      $res->setGGrupSup(GGrupSup::fromResponse($response->gGrupoSup));
    }

    return $res;
  }
}
