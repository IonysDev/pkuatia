<?php

namespace Abiliomp\Pkuatia\Fields\E;

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
}
