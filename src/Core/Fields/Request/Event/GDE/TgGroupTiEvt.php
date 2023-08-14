<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\Events\GDE;

use Abiliomp\Pkuatia\Core\Fields\Request\Events\GEA\TrGeDevCCFFCue;
use Abiliomp\Pkuatia\Core\Fields\Request\Events\GEA\TrGeDevCCFFDev;
use Abiliomp\Pkuatia\Core\Fields\Request\Events\GEA\TrGeVeAnt;
use Abiliomp\Pkuatia\Core\Fields\Request\Events\GEA\TrGeVeCCFF;
use Abiliomp\Pkuatia\Core\Fields\Request\Events\GEA\TrGeVeRem;
use Abiliomp\Pkuatia\Core\Fields\Request\Events\GEA\TrGeVeRetAce;
use Abiliomp\Pkuatia\Core\Fields\Request\Events\GEA\TrGeVeRetAnu;
use Abiliomp\Pkuatia\Core\Fields\Request\Events\GER\TrGeVeConf;
use Abiliomp\Pkuatia\Core\Fields\Request\Events\GER\TrGeVeDescon;
use Abiliomp\Pkuatia\Core\Fields\Request\Events\GER\TrGeVeDisconf;
use Abiliomp\Pkuatia\Core\Fields\Request\Events\GER\TrGeVeNotRec;
use DOMElement;

/**
 * Nodo: GDE007 - gGroupTiEvt - Grupo de campos del tipo de evento 
 * Padre: GDE002 - rEve - Grupos de campos generales del evento
 */

class TgGroupTiEvt
{

  // Eventos de Emisor
  public TrGeVeCan  $rGeVeCan; // GEC001 - Raíz Gestión de Eventos Cancelación 
  public TrGeVeInu  $rGeVeInu; // GEI001 - Raiz Gestión de Eventos Inutilización
  public TrGeVeTr   $rGeVeTr;  // GET001 - Raíz Gestión de Eventos por actualización de datos del transporte

  // Eventos de Receptor
  public TrGeVeNotRec   $rGeVeNotRec;  // GEN001 - Raíz Gestión de Eventos Notificación – Recepción DE o DTE
  public TrGeVeConf     $rGeVeConf;    // GCO001 - Raiz Gestión de Eventos Conformidad
  public TrGeVeDisconf  $rGeVeDisconf; // GDI001 - Raiz Gestión de Eventos Disconformidad 
  public TrGeVeDescon   $rGeVeDescon;  // GED001 - Raiz Gestión de Eventos Desconocimiento

  // Eventos Automáticos
  public TrGeVeRetAce   $rGeVeRetAce;  // GER001  - Raíz Gestión de Eventos de retención
  public TrGeVeRetAnu   $rGeVeRetAnu;  // GERA001 - Gestión de Eventos de retención anulación
  public TrGeVeCCFF     $rGeVeCCFF;    // GECF001 - Raíz Gestión de Eventos de créditos  fiscales
  public TrGeDevCCFFCue $rGeDevCCFFCue; // GEDF001 - Raíz Gestión de Eventos de devolución de créditos fiscales - Cuestionado
  public TrGeDevCCFFDev $rGeDevCCFFDev; // GEDD001 - Raíz Gestión de Eventos de devolución de créditos fiscales -Devuelto
  public TrGeVeAnt      $rGeVeAnt;     // GEA001  - Raíz Gestión de Eventos anticipo
  public TrGeVeRem      $rGeVeRem;     // GERE001 - Raíz Gestión de Eventos remisión 

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

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


  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////  

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


  ///////////////////////////////////////////////////////////////////////
  ///XML ELEMENT
  ///////////////////////////////////////////////////////////////////////

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('gGroupTiEvt');
    // Eventos de Emisor
    if (isset($this->rGeVeCan)) {
      $res->appendChild($this->rGeVeCan->toDOMElement());
    } else if (isset($this->rGeVeInu)) {
      $res->appendChild($this->rGeVeInu->toDOMElement());
    } else if (isset($this->rGeVeTr)) {
      $res->appendChild($this->rGeVeTr->toDOMElement());
    }

    // Eventos de Receptor
    if (isset($this->rGeVeNotRec)) {
      $res->appendChild($this->rGeVeNotRec->toDOMElement());
    } else if (isset($this->rGeVeConf)) {
      $res->appendChild($this->rGeVeConf->toDOMElement());
    } else if (isset($this->rGeVeDisconf)) {
      $res->appendChild($this->rGeVeDisconf->toDOMElement());
    } else if (isset($this->rGeVeDescon)) {
      $res->appendChild($this->rGeVeDescon->toDOMElement());
    }

    // Eventos Automáticos
    if (isset($this->rGeVeRetAce)) {
      $res->appendChild($this->rGeVeRetAce->toDOMElement());
    } else if (isset($this->rGeVeRetAnu)) {
      $res->appendChild($this->rGeVeRetAnu->toDOMElement());
    } else if (isset($this->rGeVeCCFF)) {
      $res->appendChild($this->rGeVeCCFF->toDOMElement());
    } else if (isset($this->rGeDevCCFFCue)) {
      $res->appendChild($this->rGeDevCCFFCue->toDOMElement());
    } else if (isset($this->rGeDevCCFFDev)) {
      $res->appendChild($this->rGeDevCCFFDev->toDOMElement());
    } else if (isset($this->rGeVeAnt)) {
      $res->appendChild($this->rGeVeAnt->toDOMElement());
    } else if (isset($this->rGeVeRem)) {
      $res->appendChild($this->rGeVeRem->toDOMElement());
    }

    return $res;
  }

  /**
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return TgGroupTiEvt
   */
  public static function fromDOMElement(DOMElement $xml): TgGroupTiEvt
  {
    if (strcmp($xml->tagName, 'gGroupTiEvt') == 0 && $xml->childElementCount == 3) {
      $res = new TgGroupTiEvt();

      $aux = new TrGeVeCan();
      $aux->fromDOMElement($xml->getElementsByTagName('rGeVeCan')->item(0)->nodeValue);
      $res->setRGeVeCan($aux);

      $aux = new TrGeVeInu();
      $aux->fromDOMElement($xml->getElementsByTagName('rGeVeInu')->item(0)->nodeValue);
      $res->setRGeVeInu($aux);

      $aux = new TrGeVeTr();
      $aux->fromDOMElement($xml->getElementsByTagName('rGeVeTr')->item(0)->nodeValue);
      $res->setRGeVeTr($aux);

      //===================================================================================//
      $aux = new TrGeVeNotRec();
      $aux->fromDOMElement($xml->getElementsByTagName('rGeVeNotRec')->item(0)->nodeValue);
      $res->setRGeVeNotRec($aux);

      $aux = new TrGeVeConf();
      $aux->fromDOMElement($xml->getElementsByTagName('rGeVeConf')->item(0)->nodeValue);
      $res->setRGeVeConf($aux);

      $aux = new TrGeVeDisconf();
      $aux->fromDOMElement($xml->getElementsByTagName('rGeVeDisconf')->item(0)->nodeValue);
      $res->setRGeVeDisconf($aux);

      $aux = new TrGeVeDescon();
      $aux->fromDOMElement($xml->getElementsByTagName('rGeVeDescon')->item(0)->nodeValue);
      $res->setRGeVeDescon($aux);

      //===============================================================================//

      $aux = new TrGeVeRetAce();
      $aux->fromDOMElement($xml->getElementsByTagName('rGeVeRetAce')->item(0)->nodeValue);
      $res->setRGeVeRetAce($aux);

      $aux = new TrGeVeRetAnu();
      $aux->fromDOMElement($xml->getElementsByTagName('rGeVeRetAnu')->item(0)->nodeValue);
      $res->setRGeVeRetAnu($aux);

      $aux = new TrGeVeCCFF();
      $aux->fromDOMElement($xml->getElementsByTagName('rGeVeCCFF')->item(0)->nodeValue);
      $res->setRGeVeCCFF($aux);

      $aux = new TrGeDevCCFFCue();
      $aux->fromDOMElement($xml->getElementsByTagName('rGeDevCCFFCue')->item(0)->nodeValue);
      $res->setRGeDevCCFFCue($aux);

      $aux = new TrGeDevCCFFDev();
      $aux->fromDOMElement($xml->getElementsByTagName('rGeDevCCFFDev')->item(0)->nodeValue);
      $res->setRGeDevCCFFDev($aux);

      $aux = new TrGeVeAnt();
      $aux->fromDOMElement($xml->getElementsByTagName('rGeVeAnt')->item(0)->nodeValue);
      $res->setRGeVeAnt($aux);

      $aux = new TrGeVeRem();
      $aux->fromDOMElement($xml->getElementsByTagName('rGeVeRem')->item(0)->nodeValue);
      $res->setRGeVeRem($aux);

      return $res;
    } else {
      throw new \Exception("Invalid XML Element: $xml->tagName");
      return null;
    }
  }
}
