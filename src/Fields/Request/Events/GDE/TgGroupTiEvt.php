<?php

namespace Abiliomp\Pkuatia\Fields\Request\Events\GDE;

use Abiliomp\Pkuatia\Fields\Request\Eevents\GEA\TrGeDevCCFFCue;
use Abiliomp\Pkuatia\Fields\Request\events\GEA\TrGeDevCCFFDev;
use Abiliomp\Pkuatia\Fields\Request\events\GEA\TrGeVeAnt;
use Abiliomp\Pkuatia\Fields\Request\events\GEA\TrGeVeCCFF;
use Abiliomp\Pkuatia\Fields\Request\events\GEA\TrGeVeRem;
use Abiliomp\Pkuatia\Fields\Request\events\GEA\TrGeVeRetAce;
use Abiliomp\Pkuatia\Fields\Request\events\GEA\TrGeVeRetAnu;
use Abiliomp\Pkuatia\Fields\Request\events\GER\TrGeVeConf;
use Abiliomp\Pkuatia\Fields\Request\events\GER\TrGeVeDescon;
use Abiliomp\Pkuatia\Fields\Request\events\GER\TrGeVeDisconf;
use Abiliomp\Pkuatia\Fields\Request\events\GER\TrGeVeNotRec;
use DOMElement;

/**
 * ID: GDE007 Grupo de campos del tipo de evento - Nodo padre: GDE002 rEve
 */
class TgGroupTiEvt
{
  public TrGeVeCan $rGeVeCan;
  public TrGeVeInu $rGeVeInu;
  public TrGeVeNotRec $rGeVeNotRec;
  public TrGeVeConf $rGeVeConf;
  public TrGeVeDisconf $rGeVeDisconf;
  public TrGeVeDescon $rGeVeDescon;
  public TrGeVeTr $rGeVeTr;

  ///Automáticos
  public TrGeVeRetAce $rGeVeRetAce;
  public TrGeVeRetAnu $rGeVeRetAnu;
  public TrGeVeCCFF $rGeVeCCFF;
  public TrGeDevCCFFCue $rGeDevCCFFCue;
  public TrGeDevCCFFDev $rGeDevCCFFDev;
  public TrGeVeAnt $rGeVeAnt;
  public TrGeVeRem $rGeVeRem;

  ///SETTERS
  
  /**
   * Set the value of rGeVeCan
   *
   * @param TrGeVeCan $rGeVeCan
   *
   * @return self
   */
  public function setRGeVeCan(TrGeVeCan $rGeVeCan): self
  {
    $this->rGeVeCan = $rGeVeCan;

    return $this;
  }


  /**
   * Set the value of rGeVeInu
   *
   * @param TrGeVeInu $rGeVeInu
   *
   * @return self
   */
  public function setRGeVeInu(TrGeVeInu $rGeVeInu): self
  {
    $this->rGeVeInu = $rGeVeInu;

    return $this;
  }


  /**
   * Set the value of rGeVeNotRec
   *
   * @param TrGeVeNotRec $rGeVeNotRec
   *
   * @return self
   */
  public function setRGeVeNotRec(TrGeVeNotRec $rGeVeNotRec): self
  {
    $this->rGeVeNotRec = $rGeVeNotRec;

    return $this;
  }


  /**
   * Set the value of rGeVeConf
   *
   * @param TrGeVeConf $rGeVeConf
   *
   * @return self
   */
  public function setRGeVeConf(TrGeVeConf $rGeVeConf): self
  {
    $this->rGeVeConf = $rGeVeConf;

    return $this;
  }


  /**
   * Set the value of rGeVeDisconf
   *
   * @param TrGeVeDisconf $rGeVeDisconf
   *
   * @return self
   */
  public function setRGeVeDisconf(TrGeVeDisconf $rGeVeDisconf): self
  {
    $this->rGeVeDisconf = $rGeVeDisconf;

    return $this;
  }


  /**
   * Set the value of rGeVeDescon
   *
   * @param TrGeVeDescon $rGeVeDescon
   *
   * @return self
   */
  public function setRGeVeDescon(TrGeVeDescon $rGeVeDescon): self
  {
    $this->rGeVeDescon = $rGeVeDescon;

    return $this;
  }


  /**
   * Set the value of rGeVeTr
   *
   * @param TrGeVeTr $rGeVeTr
   *
   * @return self
   */
  public function setRGeVeTr(TrGeVeTr $rGeVeTr): self
  {
    $this->rGeVeTr = $rGeVeTr;

    return $this;
  }


  /**
   * Set the value of rGeVeRetAce
   *
   * @param TrGeVeRetAce $rGeVeRetAce
   *
   * @return self
   */
  public function setRGeVeRetAce(TrGeVeRetAce $rGeVeRetAce): self
  {
    $this->rGeVeRetAce = $rGeVeRetAce;

    return $this;
  }


  /**
   * Set the value of rGeVeRetAnu
   *
   * @param TrGeVeRetAnu $rGeVeRetAnu
   *
   * @return self
   */
  public function setRGeVeRetAnu(TrGeVeRetAnu $rGeVeRetAnu): self
  {
    $this->rGeVeRetAnu = $rGeVeRetAnu;

    return $this;
  }


  /**
   * Set the value of rGeVeCCFF
   *
   * @param TrGeVeCCFF $rGeVeCCFF
   *
   * @return self
   */
  public function setRGeVeCCFF(TrGeVeCCFF $rGeVeCCFF): self
  {
    $this->rGeVeCCFF = $rGeVeCCFF;

    return $this;
  }


  /**
   * Set the value of rGeDevCCFFCue
   *
   * @param TrGeDevCCFFCue $rGeDevCCFFCue
   *
   * @return self
   */
  public function setRGeDevCCFFCue(TrGeDevCCFFCue $rGeDevCCFFCue): self
  {
    $this->rGeDevCCFFCue = $rGeDevCCFFCue;

    return $this;
  }


  /**
   * Set the value of rGeDevCCFFDev
   *
   * @param TrGeDevCCFFDev $rGeDevCCFFDev
   *
   * @return self
   */
  public function setRGeDevCCFFDev(TrGeDevCCFFDev $rGeDevCCFFDev): self
  {
    $this->rGeDevCCFFDev = $rGeDevCCFFDev;

    return $this;
  }


  /**
   * Set the value of rGeVeAnt
   *
   * @param TrGeVeAnt $rGeVeAnt
   *
   * @return self
   */
  public function setRGeVeAnt(TrGeVeAnt $rGeVeAnt): self
  {
    $this->rGeVeAnt = $rGeVeAnt;

    return $this;
  }


  /**
   * Set the value of rGeVeRem
   *
   * @param TrGeVeRem $rGeVeRem
   *
   * @return self
   */
  public function setRGeVeRem(TrGeVeRem $rGeVeRem): self
  {
    $this->rGeVeRem = $rGeVeRem;

    return $this;
  }

  ///GETTERS
  

  /**
   * Get the value of rGeVeCan
   *
   * @return TrGeVeCan
   */
  public function getRGeVeCan(): TrGeVeCan
  {
    return $this->rGeVeCan;
  }

  /**
   * Get the value of rGeVeInu
   *
   * @return TrGeVeInu
   */
  public function getRGeVeInu(): TrGeVeInu
  {
    return $this->rGeVeInu;
  }

  /**
   * Get the value of rGeVeNotRec
   *
   * @return TrGeVeNotRec
   */
  public function getRGeVeNotRec(): TrGeVeNotRec
  {
    return $this->rGeVeNotRec;
  }

  /**
   * Get the value of rGeVeConf
   *
   * @return TrGeVeConf
   */
  public function getRGeVeConf(): TrGeVeConf
  {
    return $this->rGeVeConf;
  }

  /**
   * Get the value of rGeVeDisconf
   *
   * @return TrGeVeDisconf
   */
  public function getRGeVeDisconf(): TrGeVeDisconf
  {
    return $this->rGeVeDisconf;
  }

  /**
   * Get the value of rGeVeDescon
   *
   * @return TrGeVeDescon
   */
  public function getRGeVeDescon(): TrGeVeDescon
  {
    return $this->rGeVeDescon;
  }

  /**
   * Get the value of rGeVeTr
   *
   * @return TrGeVeTr
   */
  public function getRGeVeTr(): TrGeVeTr
  {
    return $this->rGeVeTr;
  }

  /**
   * Get the value of rGeVeRetAce
   *
   * @return TrGeVeRetAce
   */
  public function getRGeVeRetAce(): TrGeVeRetAce
  {
    return $this->rGeVeRetAce;
  }

  /**
   * Get the value of rGeVeRetAnu
   *
   * @return TrGeVeRetAnu
   */
  public function getRGeVeRetAnu(): TrGeVeRetAnu
  {
    return $this->rGeVeRetAnu;
  }

  /**
   * Get the value of rGeVeCCFF
   *
   * @return TrGeVeCCFF
   */
  public function getRGeVeCCFF(): TrGeVeCCFF
  {
    return $this->rGeVeCCFF;
  }

  /**
   * Get the value of rGeDevCCFFDev
   *
   * @return TrGeDevCCFFDev
   */
  public function getRGeDevCCFFDev(): TrGeDevCCFFDev
  {
    return $this->rGeDevCCFFDev;
  }

  /**
   * Get the value of rGeVeAnt
   *
   * @return TrGeVeAnt
   */
  public function getRGeVeAnt(): TrGeVeAnt
  {
    return $this->rGeVeAnt;
  }

  /**
   * Get the value of rGeVeRem
   *
   * @return TrGeVeRem
   */
  public function getRGeVeRem(): TrGeVeRem
  {
    return $this->rGeVeRem;
  }
}
