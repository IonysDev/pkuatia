<?php
namespace Abiliomp\Pkuatia\Core\Fields\Request\Event\GDE;

use Abiliomp\Pkuatia\Core\Fields\Request\Events\GEA\rGeDevCCFFCue;
use Abiliomp\Pkuatia\Core\Fields\Request\events\GEA\RGeDevCCFFDev;
use Abiliomp\Pkuatia\Core\Fields\Request\Events\GEA\RGeVeAnt;
use Abiliomp\Pkuatia\Core\Fields\Request\Events\GEA\rGeVeCCFF;
use Abiliomp\Pkuatia\Core\Fields\Request\Events\GEA\RGeVeRem;
use Abiliomp\Pkuatia\Core\Fields\Request\Events\GEA\rGeVeRetAce;
use Abiliomp\Pkuatia\Core\Fields\Request\Events\GEA\rGeVeRetAnu;
use Abiliomp\Pkuatia\Core\Fields\Request\Events\GER\RGeVeConf;
use Abiliomp\Pkuatia\Core\Fields\Request\Events\GER\RGeVeDescon;
use Abiliomp\Pkuatia\Core\Fields\Request\Events\GER\RGeVeDisconf;
use Abiliomp\Pkuatia\Core\Fields\Request\Events\GER\RGeVeNotRec;
use DOMElement;

/**
 * Nodo: GDE007 - gGroupTiEvt - Grupo de campos del tipo de evento 
 * Padre: GDE002 - rEve - Grupos de campos generales del evento
 */

class GGroupTiEvt
{

  // Eventos de Emisor
  public RGeVeCan  $rGeVeCan; // GEC001 - Raíz Gestión de Eventos Cancelación 
  public RGeVeInu  $rGeVeInu; // GEI001 - Raiz Gestión de Eventos Inutilización
  public RGeVeTr   $rGeVeTr;  // GET001 - Raíz Gestión de Eventos por actualización de datos del transporte

  // Eventos de Receptor
  public RGeVeNotRec   $rGeVeNotRec;  // GEN001 - Raíz Gestión de Eventos Notificación – Recepción DE o DTE
  public RGeVeConf     $rGeVeConf;    // GCO001 - Raiz Gestión de Eventos Conformidad
  public RGeVeDisconf  $rGeVeDisconf; // GDI001 - Raiz Gestión de Eventos Disconformidad 
  public RGeVeDescon   $rGeVeDescon;  // GED001 - Raiz Gestión de Eventos Desconocimiento

  // Eventos Automáticos
  public RGeVeRetAce   $rGeVeRetAce;  // GER001  - Raíz Gestión de Eventos de retención
  public RGeVeRetAnu   $rGeVeRetAnu;  // GERA001 - Gestión de Eventos de retención anulación
  public RGeVeCCFF     $rGeVeCCFF;    // GECF001 - Raíz Gestión de Eventos de créditos  fiscales
  public RGeDevCCFFCue $rGeDevCCFFCue; // GEDF001 - Raíz Gestión de Eventos de devolución de créditos fiscales - Cuestionado
  public RGeDevCCFFCue $rGeDevCCFFDev; // GEDD001 - Raíz Gestión de Eventos de devolución de créditos fiscales -Devuelto
  public RGeVeAnt      $rGeVeAnt;     // GEA001  - Raíz Gestión de Eventos anticipo
  public RGeVeRem      $rGeVeRem;     // GERE001 - Raíz Gestión de Eventos remisión 

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
  public function setRGeVeCan(RGeVeCan $rGeVeCan): self
  {
    $this->rGeVeCan = $rGeVeCan;

    return $this;
  }


  /**
   * Set the value of rGeVeInu
   *
   * @param RGeVeInu $rGeVeInu
   *
   * @return self
   */
  public function seRGeVeInu(RGeVeInu $rGeVeInu): self
  {
    $this->rGeVeInu = $rGeVeInu;

    return $this;
  }


  /**
   * Set the value of rGeVeNotRec
   *
   * @param RGeVeNotRec $rGeVeNotRec
   *
   * @return self
   */
  public function seRGeVeNotRec(RGeVeNotRec $rGeVeNotRec): self
  {
    $this->rGeVeNotRec = $rGeVeNotRec;

    return $this;
  }


  /**
   * Set the value of rGeVeConf
   *
   * @param RGeVeConf $rGeVeConf
   *
   * @return self
   */
  public function seRGeVeConf(RGeVeConf $rGeVeConf): self
  {
    $this->rGeVeConf = $rGeVeConf;

    return $this;
  }


  /**
   * Set the value of rGeVeDisconf
   *
   * @param RGeVeDisconf $rGeVeDisconf
   *
   * @return self
   */
  public function seRGeVeDisconf(RGeVeDisconf $rGeVeDisconf): self
  {
    $this->rGeVeDisconf = $rGeVeDisconf;

    return $this;
  }


  /**
   * Set the value of rGeVeDescon
   *
   * @param RGeVeDescon $rGeVeDescon
   *
   * @return self
   */
  public function seRGeVeDescon(RGeVeDescon $rGeVeDescon): self
  {
    $this->rGeVeDescon = $rGeVeDescon;

    return $this;
  }


  /**
   * Set the value of rGeVeTr
   *
   * @param RGeVeTr $rGeVeTr
   *
   * @return self
   */
  public function seRGeVeTr(RGeVeTr $rGeVeTr): self
  {
    $this->rGeVeTr = $rGeVeTr;

    return $this;
  }


  /**
   * Set the value of rGeVeRetAce
   *
   * @param rGeVeRetAce $rGeVeRetAce
   *
   * @return self
   */
  public function serGeVeRetAce(rGeVeRetAce $rGeVeRetAce): self
  {
    $this->rGeVeRetAce = $rGeVeRetAce;
    return $this;
  }


  /**
   * Set the value of rGeVeRetAnu
   *
   * @param rGeVeRetAnu $rGeVeRetAnu
   *
   * @return self
   */
  public function serGeVeRetAnu(rGeVeRetAnu $rGeVeRetAnu): self
  {
    $this->rGeVeRetAnu = $rGeVeRetAnu;
    return $this;
  }


  /**
   * Set the value of rGeVeCCFF
   *
   * @param rGeVeCCFF $rGeVeCCFF
   *
   * @return self
   */
  public function serGeVeCCFF(rGeVeCCFF $rGeVeCCFF): self
  {
    $this->rGeVeCCFF = $rGeVeCCFF;
    return $this;
  }


  /**
   * Set the value of rGeDevCCFFCue
   *
   * @param rGeDevCCFFCue $rGeDevCCFFCue
   *
   * @return self
   */
  public function setGeDevCCFFCue(rGeDevCCFFCue $rGeDevCCFFCue): self
  {
    $this->rGeDevCCFFCue = $rGeDevCCFFCue;
    return $this;
  }


  /**
   * Set the value of rGeDevCCFFDev
   *
   * @param rGeDevCCFFCue $rGeDevCCFFDev
   *
   * @return self
   */
  public function setGeDevCCFFDev(RGeDevCCFFDev $rGeDevCCFFDev): self
  {
    $this->rGeDevCCFFDev = $rGeDevCCFFDev;
    return $this;
  }


  /**
   * Set the value of rGeVeAnt
   *
   * @param RGeVeAnt $rGeVeAnt
   *
   * @return self
   */
  public function seRGeVeAnt(RGeVeAnt $rGeVeAnt): self
  {
    $this->rGeVeAnt = $rGeVeAnt;
    return $this;
  }


  /**
   * Set the value of rGeVeRem
   *
   * @param RGeVeRem $rGeVeRem
   *
   * @return self
   */
  public function seRGeVeRem(RGeVeRem $rGeVeRem): self
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
  public function getRGeVeCan(): RGeVeCan
  {
    return $this->rGeVeCan;
  }

  /**
   * Get the value of rGeVeInu
   *
   * @return RGeVeInu
   */
  public function geRGeVeInu(): RGeVeInu
  {
    return $this->rGeVeInu;
  }

  /**
   * Get the value of rGeVeNotRec
   *
   * @return RGeVeNotRec
   */
  public function geRGeVeNotRec(): RGeVeNotRec
  {
    return $this->rGeVeNotRec;
  }

  /**
   * Get the value of rGeVeConf
   *
   * @return RGeVeConf
   */
  public function geRGeVeConf(): RGeVeConf
  {
    return $this->rGeVeConf;
  }

  /**
   * Get the value of rGeVeDisconf
   *
   * @return RGeVeDisconf
   */
  public function geRGeVeDisconf(): RGeVeDisconf
  {
    return $this->rGeVeDisconf;
  }

  /**
   * Get the value of rGeVeDescon
   *
   * @return RGeVeDescon
   */
  public function geRGeVeDescon(): RGeVeDescon
  {
    return $this->rGeVeDescon;
  }

  /**
   * Get the value of rGeVeTr
   *
   * @return RGeVeTr
   */
  public function geRGeVeTr(): RGeVeTr
  {
    return $this->rGeVeTr;
  }

  /**
   * Get the value of rGeVeRetAce
   *
   * @return rGeVeRetAce
   */
  public function gerGeVeRetAce(): rGeVeRetAce
  {
    return $this->rGeVeRetAce;
  }

  /**
   * Get the value of rGeVeRetAnu
   *
   * @return rGeVeRetAnu
   */
  public function gerGeVeRetAnu(): rGeVeRetAnu
  {
    return $this->rGeVeRetAnu;
  }

  /**
   * Get the value of rGeVeCCFF
   *
   * @return rGeVeCCFF
   */
  public function gerGeVeCCFF(): rGeVeCCFF
  {
    return $this->rGeVeCCFF;
  }

  /**
   * Get the value of rGeDevCCFFDev
   *
   * @return rGeDevCCFFCue
   */
  public function gerGeDevCCFFCue(): rGeDevCCFFCue
  {
    return $this->rGeDevCCFFDev;
  }

  /**
   * Get the value of rGeVeAnt
   *
   * @return RGeVeAnt
   */
  public function geRGeVeAnt(): RGeVeAnt
  {
    return $this->rGeVeAnt;
  }

  /**
   * Get the value of rGeVeRem
   *
   * @return RGeVeRem
   */
  public function geRGeVeRem(): RGeVeRem
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
   * @return GGroupTiEvt
   */
  public static function fromDOMElement(DOMElement $xml): GGroupTiEvt
  {
    if (strcmp($xml->tagName, 'gGroupTiEvt') == 0 && $xml->childElementCount == 3) {
      $res = new GGroupTiEvt();

      $aux = new RGeVeCan();
      $aux->fromDOMElement($xml->getElementsByTagName('rGeVeCan')->item(0)->nodeValue);
      $res->setRGeVeCan($aux);

      $aux = new RGeVeInu();
      $aux->fromDOMElement($xml->getElementsByTagName('rGeVeInu')->item(0)->nodeValue);
      $res->seRGeVeInu($aux);

      $aux = new RGeVeTr();
      $aux->fromDOMElement($xml->getElementsByTagName('rGeVeTr')->item(0)->nodeValue);
      $res->seRGeVeTr($aux);

      //===================================================================================//
      $aux = new RGeVeNotRec();
      $aux->fromDOMElement($xml->getElementsByTagName('rGeVeNotRec')->item(0)->nodeValue);
      $res->seRGeVeNotRec($aux);

      $aux = new RGeVeConf();
      $aux->fromDOMElement($xml->getElementsByTagName('rGeVeConf')->item(0)->nodeValue);
      $res->seRGeVeConf($aux);

      $aux = new RGeVeDisconf();
      $aux->fromDOMElement($xml->getElementsByTagName('rGeVeDisconf')->item(0)->nodeValue);
      $res->seRGeVeDisconf($aux);

      $aux = new RGeVeDescon();
      $aux->fromDOMElement($xml->getElementsByTagName('rGeVeDescon')->item(0)->nodeValue);
      $res->seRGeVeDescon($aux);

      //===============================================================================//

      $aux = new rGeVeRetAce();
      $aux->fromDOMElement($xml->getElementsByTagName('rGeVeRetAce')->item(0)->nodeValue);
      $res->serGeVeRetAce($aux);

      $aux = new rGeVeRetAnu();
      $aux->fromDOMElement($xml->getElementsByTagName('rGeVeRetAnu')->item(0)->nodeValue);
      $res->serGeVeRetAnu($aux);

      $aux = new rGeVeCCFF();
      $aux->fromDOMElement($xml->getElementsByTagName('rGeVeCCFF')->item(0)->nodeValue);
      $res->serGeVeCCFF($aux);

      $aux = new rGeDevCCFFCue();
      $aux->fromDOMElement($xml->getElementsByTagName('rGeDevCCFFCue')->item(0)->nodeValue);
      $res->setGeDevCCFFCue($aux);

      $aux = new RGeDevCCFFDev();
      $aux->fromDOMElement($xml->getElementsByTagName('rGeDevCCFFDev')->item(0)->nodeValue);
      $res->setGeDevCCFFDev($aux);

      $aux = new RGeVeAnt();
      $aux->fromDOMElement($xml->getElementsByTagName('rGeVeAnt')->item(0)->nodeValue);
      $res->seRGeVeAnt($aux);

      $aux = new RGeVeRem();
      $aux->fromDOMElement($xml->getElementsByTagName('rGeVeRem')->item(0)->nodeValue);
      $res->seRGeVeRem($aux);

      return $res;
    } else {
      throw new \Exception("Invalid XML Element: $xml->tagName");
      return null;
    }
  }
}
