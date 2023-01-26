<?php

namespace Abiliomp\Pkuatia\Fields\E;

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
}
