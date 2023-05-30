<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\E;

use DOMElement;

// Campos específicos por tipo de Documento Electrónico (E001-E009)
//ID:E001
//Padre:A001
class GDtipDE
{
  public GCamFE $gCamFE;
  public GCamAE $gCamAE;
  public GCamNCDE $gCamNCDE;
  public GCamNRE $gCamNRE;
  public GCamCond $gCamCond;
  public GCamItem $gCamItem;
  public GCamEsp $gCamEsp;

  //====================================================//
  ///Others
  //====================================================//

  /**
   * Get the value of gCamFE
   *
   * @return GCamFE
   */
  public function getGCamFE(): GCamFE
  {
    return $this->gCamFE;
  }

  /**
   * Set the value of gCamFE
   *
   * @param GCamFE $gCamFE
   *
   * @return self
   */
  public function setGCamFE(GCamFE $gCamFE): self
  {
    $this->gCamFE = $gCamFE;

    return $this;
  }

  /**
   * Get the value of gCamAE
   *
   * @return GCamAE
   */
  public function getGCamAE(): GCamAE
  {
    return $this->gCamAE;
  }

  /**
   * Set the value of gCamAE
   *
   * @param GCamAE $gCamAE
   *
   * @return self
   */
  public function setGCamAE(GCamAE $gCamAE): self
  {
    $this->gCamAE = $gCamAE;

    return $this;
  }

  /**
   * Get the value of gCamNCDE
   *
   * @return GCamNCDE
   */
  public function getGCamNCDE(): GCamNCDE
  {
    return $this->gCamNCDE;
  }

  /**
   * Set the value of gCamNCDE
   *
   * @param GCamNCDE $gCamNCDE
   *
   * @return self
   */
  public function setGCamNCDE(GCamNCDE $gCamNCDE): self
  {
    $this->gCamNCDE = $gCamNCDE;

    return $this;
  }

  /**
   * Get the value of gCamNRE
   *
   * @return GCamNRE
   */
  public function getGCamNRE(): GCamNRE
  {
    return $this->gCamNRE;
  }

  /**
   * Set the value of gCamNRE
   *
   * @param GCamNRE $gCamNRE
   *
   * @return self
   */
  public function setGCamNRE(GCamNRE $gCamNRE): self
  {
    $this->gCamNRE = $gCamNRE;

    return $this;
  }

  /**
   * Get the value of gCamCond
   *
   * @return GCamCond
   */
  public function getGCamCond(): GCamCond
  {
    return $this->gCamCond;
  }

  /**
   * Set the value of gCamCond
   *
   * @param GCamCond $gCamCond
   *
   * @return self
   */
  public function setGCamCond(GCamCond $gCamCond): self
  {
    $this->gCamCond = $gCamCond;

    return $this;
  }

  /**
   * Get the value of gCamItem
   *
   * @return GCamItem
   */
  public function getGCamItem(): GCamItem
  {
    return $this->gCamItem;
  }

  /**
   * Set the value of gCamItem
   *
   * @param GCamItem $gCamItem
   *
   * @return self
   */
  public function setGCamItem(GCamItem $gCamItem): self
  {
    $this->gCamItem = $gCamItem;

    return $this;
  }

  /**
   * Get the value of gCamEsp
   *
   * @return GCamEsp
   */
  public function getGCamEsp(): GCamEsp
  {
    return $this->gCamEsp;
  }

  /**
   * Set the value of gCamEsp
   *
   * @param GCamEsp $gCamEsp
   *
   * @return self
   */
  public function setGCamEsp(GCamEsp $gCamEsp): self
  {
    $this->gCamEsp = $gCamEsp;

    return $this;
  }

  ///XML ELement  
  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('gDtipDE');
    $res->appendChild($this->gCamFE->toDOMElement());
    $res->appendChild($this->gCamAE->toDOMElement());
    $res->appendChild($this->gCamNCDE->toDOMElement());
    $res->appendChild($this->gCamNRE->toDOMElement());
    $res->appendChild($this->gCamCond->toDOMElement());
    $res->appendChild($this->gCamItem->toDOMElement());
    $res->appendChild($this->gCamEsp->toDOMElement());
    return $res;
  }

  /**
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return GDtipDE
   */
  public static function fromDOMElement(DOMElement $xml): GDtipDE
  {
    if (strcmp($xml->tagName, 'gDtipDE') == 0 && $xml->childElementCount == 7) {
      $res = new GDtipDE();
      $res->setGCamFE($res->gCamFE->fromDOMElement($xml->getElementsByTagName('gDtipFE')->item(0)->nodeValue));
      $res->setGCamAE($res->gCamAE->fromDOMElement($xml->getElementsByTagName('gCamAE')->item(0)->nodeValue));
      $res->setGCamNCDE($res->gCamNCDE->fromDOMElement($xml->getElementsByTagName('gCamNCDE')->item(0)->nodeValue));
      $res->setGCamNRE($res->gCamNRE->fromDOMElement($xml->getElementsByTagName('gCamNRE')->item(0)->nodeValue));
      $res->setGCamCond($res->gCamCond->fromDOMElement($xml->getElementsByTagName('gCamCond')->item(0)->nodeValue));
      $res->setGCamItem($res->gCamItem->fromDOMElement($xml->getElementsByTagName('gCamItem')->item(0)->nodeValue));
      $res->setGCamEsp($res->gCamEsp->fromDOMElement($xml->getElementsByTagName('gCamEsp')->item(0)->nodeValue));

      return $res;
    } else {
      throw new \Exception("Invalid XML Element: $xml->tagName");
      return null;
    }
  }

 
   /**
    * fromResponse
    *
    * @param  mixed $response
    * @return self
    */
   public static function fromResponse($response):self
   {
      $res = new GDtipDE();
      if(isset($response->gCamFE))
      {
          $res->setGCamFE(GCamFE::fromResponse($response->gCamFE));
      }
      return $res;
   }
}
