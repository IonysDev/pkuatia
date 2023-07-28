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
  public ?GGrupEner $gGrupoEner = null;
  public ?GGrupSeg $gGrupoSeg  = null;
  public ?GGrupSup $gGrupSup  = null;
  public ?GGrupAdi $gGrupAdi = null;

  public function __construct()
  {
    //General
    $this->gGrupoEner = new GGrupEner();
    $this->gGrupoSeg  = new GGrupSeg();
    $this->gGrupSup  = new GGrupSup();
    $this->gGrupAdi = new GGrupAdi();
  }

  //====================================================//
  ///Others
  //====================================================//

  /**
   * Get the value of gGrupoEner
   *
   * @return GGrupEner
   */
  public function getGGrupoEner(): GGrupEner | null
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
  public function getGGrupoSeg(): GGrupSeg | null
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
  public function getGGrupSup(): GGrupSup | null
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

    if (isset($this->gGrupAdi)) {
      $res->appendChild($this->gGrupAdi->toDomElement());
    }

    return $res;
  }

  
  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return GCamEsp
  //  */
  // public static function fromDOMElement(DOMElement $xml): GCamEsp
  // {
  //   if (strcmp($xml->tagName, 'gCamEsp') == 0 && $xml->childElementCount >= 1) {
  //     $res = new GCamEsp();
  //     $res->setGGrupoEner($res->gGrupoEner->fromDOMElement($xml->getElementsByTagName('gGrupoEner')->item(0)->nodeValue));
  //     $res->setGGrupSup($res->gGrupSup->fromDOMElement($xml->getElementsByTagName('gGrupoSup')->item(0)->nodeValue));
  //     $res->setGGrupoSeg($res->gGrupoSeg->fromDOMElement($xml->getElementsByTagName('gGrupoSeg')->item(0)->nodeValue));
  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }

   
  /**
   * fromResponse
   *
   * @param  mixed $response
   * @return self
   */
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

    if(isset($response->gGrupAdi))
    {
      $res->setGGrupAdi(GGrupAdi::fromResponse($response->gGrupAdi));
    }

    return $res;
  }

  /**
   * Get the value of gGrupAdi
   *
   * @return ?GGrupAdi
   */
  public function getGGrupAdi(): ?GGrupAdi
  {
    return $this->gGrupAdi;
  }

  /**
   * Set the value of gGrupAdi
   *
   * @param ?GGrupAdi $gGrupAdi
   *
   * @return self
   */
  public function setGGrupAdi(?GGrupAdi $gGrupAdi): self
  {
    $this->gGrupAdi = $gGrupAdi;

    return $this;
  }
}
