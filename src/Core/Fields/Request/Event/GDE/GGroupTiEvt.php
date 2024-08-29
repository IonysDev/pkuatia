<?php
namespace Abiliomp\Pkuatia\Core\Fields\Request\Event\GDE;

use Abiliomp\Pkuatia\Core\Fields\Request\Event\GEA\RGeDevCCFFCue;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GEA\RGeDevCCFFDev;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GEA\RGeVeAnt;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GEA\RGeVeCCFF;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GEA\RGeVeRem;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GEA\RGeVeRetAce;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GEA\RGeVeRetAnu;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GER\RGeVeConf;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GER\RGeVeDescon;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GER\RGeVeDisconf;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GER\RGeVeNotRec;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;

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
  public RGeDevCCFFDev $rGeDevCCFFDev; // GEDD001 - Raíz Gestión de Eventos de devolución de créditos fiscales -Devuelto
  public RGeVeAnt      $rGeVeAnt;     // GEA001  - Raíz Gestión de Eventos anticipo
  public RGeVeRem      $rGeVeRem;     // GERE001 - Raíz Gestión de Eventos remisión 

  // Eventos de Nominación
  public RGeVeNom      $rGeVeNom;     // GENFE001 - Raíz Gestión de Eventos de Nominación

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de rGeVeCan
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
   * Establece el valor de rGeVeInu
   *
   * @param RGeVeInu $rGeVeInu
   *
   * @return self
   */
  public function setRGeVeInu(RGeVeInu $rGeVeInu): self
  {
    $this->rGeVeInu = $rGeVeInu;

    return $this;
  }


  /**
   * Establece el valor de rGeVeNotRec
   *
   * @param RGeVeNotRec $rGeVeNotRec
   *
   * @return self
   */
  public function setRGeVeNotRec(RGeVeNotRec $rGeVeNotRec): self
  {
    $this->rGeVeNotRec = $rGeVeNotRec;

    return $this;
  }


  /**
   * Establece el valor de rGeVeConf
   *
   * @param RGeVeConf $rGeVeConf
   *
   * @return self
   */
  public function setRGeVeConf(RGeVeConf $rGeVeConf): self
  {
    $this->rGeVeConf = $rGeVeConf;

    return $this;
  }


  /**
   * Establece el valor de rGeVeDisconf
   *
   * @param RGeVeDisconf $rGeVeDisconf
   *
   * @return self
   */
  public function setRGeVeDisconf(RGeVeDisconf $rGeVeDisconf): self
  {
    $this->rGeVeDisconf = $rGeVeDisconf;

    return $this;
  }


  /**
   * Establece el valor de rGeVeDescon
   *
   * @param RGeVeDescon $rGeVeDescon
   *
   * @return self
   */
  public function setRGeVeDescon(RGeVeDescon $rGeVeDescon): self
  {
    $this->rGeVeDescon = $rGeVeDescon;

    return $this;
  }


  /**
   * Establece el valor de rGeVeTr
   *
   * @param RGeVeTr $rGeVeTr
   *
   * @return self
   */
  public function setRGeVeTr(RGeVeTr $rGeVeTr): self
  {
    $this->rGeVeTr = $rGeVeTr;

    return $this;
  }


  /**
   * Establece el valor de rGeVeRetAce
   *
   * @param rGeVeRetAce $rGeVeRetAce
   *
   * @return self
   */
  public function setrGeVeRetAce(rGeVeRetAce $rGeVeRetAce): self
  {
    $this->rGeVeRetAce = $rGeVeRetAce;
    return $this;
  }


  /**
   * Establece el valor de rGeVeRetAnu
   *
   * @param rGeVeRetAnu $rGeVeRetAnu
   *
   * @return self
   */
  public function setrGeVeRetAnu(rGeVeRetAnu $rGeVeRetAnu): self
  {
    $this->rGeVeRetAnu = $rGeVeRetAnu;
    return $this;
  }


  /**
   * Establece el valor de rGeVeCCFF
   *
   * @param rGeVeCCFF $rGeVeCCFF
   *
   * @return self
   */
  public function setrGeVeCCFF(rGeVeCCFF $rGeVeCCFF): self
  {
    $this->rGeVeCCFF = $rGeVeCCFF;
    return $this;
  }


  /**
   * Establece el valor de rGeDevCCFFCue
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
   * Establece el valor de rGeDevCCFFDev
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
   * Establece el valor de rGeVeAnt
   *
   * @param RGeVeAnt $rGeVeAnt
   *
   * @return self
   */
  public function setRGeVeAnt(RGeVeAnt $rGeVeAnt): self
  {
    $this->rGeVeAnt = $rGeVeAnt;
    return $this;
  }


  /**
   * Establece el valor de rGeVeRem
   *
   * @param RGeVeRem $rGeVeRem
   *
   * @return self
   */
  public function setRGeVeRem(RGeVeRem $rGeVeRem): self
  {
    $this->rGeVeRem = $rGeVeRem;
    return $this;
  }

  
  /**
   * Establece el valor de rGeVeNom
   *
   * @param RGeVeNom $rGeVeNom
   *
   * @return self
   */
  public function setRGeVeNom(RGeVeNom $rGeVeNom): self
  {
    $this->rGeVeNom = $rGeVeNom;
    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////  

  /**
   * Obtiene el valor de rGeVeCan
   *
   * @return TrGeVeCan
   */
  public function getRGeVeCan(): RGeVeCan
  {
    return $this->rGeVeCan;
  }

  /**
   * Obtiene el valor de rGeVeInu
   *
   * @return RGeVeInu
   */
  public function getRGeVeInu(): RGeVeInu
  {
    return $this->rGeVeInu;
  }

  /**
   * Obtiene el valor de rGeVeNotRec
   *
   * @return RGeVeNotRec
   */
  public function getRGeVeNotRec(): RGeVeNotRec
  {
    return $this->rGeVeNotRec;
  }

  /**
   * Obtiene el valor de rGeVeConf
   *
   * @return RGeVeConf
   */
  public function getRGeVeConf(): RGeVeConf
  {
    return $this->rGeVeConf;
  }

  /**
   * Obtiene el valor de rGeVeDisconf
   *
   * @return RGeVeDisconf
   */
  public function getRGeVeDisconf(): RGeVeDisconf
  {
    return $this->rGeVeDisconf;
  }

  /**
   * Obtiene el valor de rGeVeDescon
   *
   * @return RGeVeDescon
   */
  public function getRGeVeDescon(): RGeVeDescon
  {
    return $this->rGeVeDescon;
  }

  /**
   * Obtiene el valor de rGeVeTr
   *
   * @return RGeVeTr
   */
  public function getRGeVeTr(): RGeVeTr
  {
    return $this->rGeVeTr;
  }

  /**
   * Obtiene el valor de rGeVeRetAce
   *
   * @return rGeVeRetAce
   */
  public function getrGeVeRetAce(): rGeVeRetAce
  {
    return $this->rGeVeRetAce;
  }

  /**
   * Obtiene el valor de rGeVeRetAnu
   *
   * @return rGeVeRetAnu
   */
  public function getrGeVeRetAnu(): rGeVeRetAnu
  {
    return $this->rGeVeRetAnu;
  }

  /**
   * Obtiene el valor de rGeVeCCFF
   *
   * @return rGeVeCCFF
   */
  public function getGeVeCCFF(): rGeVeCCFF
  {
    return $this->rGeVeCCFF;
  }

  /**
   * Obtiene el valor de rGeDevCCFFDev
   *
   * @return RGeDevCCFFDev
   */
  public function getGeDevCCFFCue(): RGeDevCCFFDev
  {
    return $this->rGeDevCCFFDev;
  }

  /**
   * Obtiene el valor de rGeVeAnt
   *
   * @return RGeVeAnt
   */
  public function getRGeVeAnt(): RGeVeAnt
  {
    return $this->rGeVeAnt;
  }

  /**
   * Obtiene el valor de rGeVeRem
   *
   * @return RGeVeRem
   */
  public function getGeVeRem(): RGeVeRem
  {
    return $this->rGeVeRem;
  }

  /**
   * Obtiene el valor de rGeVeNom
   *
   * @return RGeVeNom
   */
  public function getRGeVeNom(): RGeVeNom
  {
    return $this->rGeVeNom;
  }


  ///////////////////////////////////////////////////////////////////////
  ///XML ELEMENT
  ///////////////////////////////////////////////////////////////////////

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gGroupTiEvt');

    // Eventos de Emisor
    if(isset($this->rGeVeCan))
      $res->appendChild($this->rGeVeCan->toDOMElement($doc));
    if(isset($this->rGeVeInu))
    $res->appendChild($this->rGeVeInu->toDOMElement($doc));
    if(isset($this->rGeVeTr))
    $res->appendChild($this->rGeVeTr->toDOMElement($doc));

    // Eventos de Receptor
    if(isset($this->rGeVeNotRec))
    $res->appendChild($this->rGeVeNotRec->toDOMElement($doc));
    if(isset($this->rGeVeConf))
    $res->appendChild($this->rGeVeConf->toDOMElement($doc));
    if(isset($this->rGeVeDisconf))
    $res->appendChild($this->rGeVeDisconf->toDOMElement($doc));
    if(isset($this->rGeVeDescon))
    $res->appendChild($this->rGeVeDescon->toDOMElement($doc));

    // Eventos Automáticos
    if(isset($this->rGeVeRetAce))
    $res->appendChild($this->rGeVeRetAce->toDOMElement($doc));
    if(isset($this->rGeVeRetAnu))
    $res->appendChild($this->rGeVeRetAnu->toDOMElement($doc));
    if(isset($this->rGeVeCCFF))
    $res->appendChild($this->rGeVeCCFF->toDOMElement($doc));
    if(isset($this->rGeDevCCFFCue))
    $res->appendChild($this->rGeDevCCFFCue->toDOMElement($doc));
    if(isset($this->rGeDevCCFFDev))
    $res->appendChild($this->rGeDevCCFFDev->toDOMElement($doc));
    if(isset($this->rGeVeAnt))
    $res->appendChild($this->rGeVeAnt->toDOMElement($doc));
    if(isset($this->rGeVeRem))
    $res->appendChild($this->rGeVeRem->toDOMElement($doc));
    if(isset($this->rGeVeNom))
    $res->appendChild($this->rGeVeNom->toDOMElement($doc));
    return $res;
  }

  /**
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return GGroupTiEvt
   */
  // public static function fromDOMElement(DOMElement $xml): GGroupTiEvt
  // {
  //   if (strcmp($xml->tagName, 'gGroupTiEvt') == 0 && $xml->childElementCount == 3) {
  //     $res = new GGroupTiEvt();

  //     $aux = new RGeVeCan();
  //     $aux->fromDOMElement($xml->getElementsByTagName('rGeVeCan')->item(0)->nodeValue);
  //     $res->setRGeVeCan($aux);

  //     $aux = new RGeVeInu();
  //     $aux->fromDOMElement($xml->getElementsByTagName('rGeVeInu')->item(0)->nodeValue);
  //     $res->seRGeVeInu($aux);

  //     $aux = new RGeVeTr();
  //     $aux->fromDOMElement($xml->getElementsByTagName('rGeVeTr')->item(0)->nodeValue);
  //     $res->seRGeVeTr($aux);

  //     //===================================================================================//
  //     $aux = new RGeVeNotRec();
  //     $aux->fromDOMElement($xml->getElementsByTagName('rGeVeNotRec')->item(0)->nodeValue);
  //     $res->seRGeVeNotRec($aux);

  //     $aux = new RGeVeConf();
  //     $aux->fromDOMElement($xml->getElementsByTagName('rGeVeConf')->item(0)->nodeValue);
  //     $res->seRGeVeConf($aux);

  //     $aux = new RGeVeDisconf();
  //     $aux->fromDOMElement($xml->getElementsByTagName('rGeVeDisconf')->item(0)->nodeValue);
  //     $res->seRGeVeDisconf($aux);

  //     $aux = new RGeVeDescon();
  //     $aux->fromDOMElement($xml->getElementsByTagName('rGeVeDescon')->item(0)->nodeValue);
  //     $res->seRGeVeDescon($aux);

  //     //===============================================================================//

  //     $aux = new rGeVeRetAce();
  //     $aux->fromDOMElement($xml->getElementsByTagName('rGeVeRetAce')->item(0)->nodeValue);
  //     $res->serGeVeRetAce($aux);

  //     $aux = new rGeVeRetAnu();
  //     $aux->fromDOMElement($xml->getElementsByTagName('rGeVeRetAnu')->item(0)->nodeValue);
  //     $res->serGeVeRetAnu($aux);

  //     $aux = new rGeVeCCFF();
  //     $aux->fromDOMElement($xml->getElementsByTagName('rGeVeCCFF')->item(0)->nodeValue);
  //     $res->serGeVeCCFF($aux);

  //     $aux = new rGeDevCCFFCue();
  //     $aux->fromDOMElement($xml->getElementsByTagName('rGeDevCCFFCue')->item(0)->nodeValue);
  //     $res->setGeDevCCFFCue($aux);

  //     $aux = new RGeDevCCFFDev();
  //     $aux->fromDOMElement($xml->getElementsByTagName('rGeDevCCFFDev')->item(0)->nodeValue);
  //     $res->setGeDevCCFFDev($aux);

  //     $aux = new RGeVeAnt();
  //     $aux->fromDOMElement($xml->getElementsByTagName('rGeVeAnt')->item(0)->nodeValue);
  //     $res->seRGeVeAnt($aux);

  //     $aux = new RGeVeRem();
  //     $aux->fromDOMElement($xml->getElementsByTagName('rGeVeRem')->item(0)->nodeValue);
  //     $res->seRGeVeRem($aux);

  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }

  public static function FromSimpleXMLElement(SimpleXMLElement $node):self
  {
      if(strcmp($node->getName(),'gGroupTiEvt') != 0) {
          throw new \Exception("Invalid XML Element:". $node->getName());
          return null;
      }

      $res = new GGroupTiEvt();

      if(isset($node->rGeVeCan))
      {

          $res->setRGeVeCan(RGeVeCan::FromSimpleXMLElement($node->rGeVeCan));
      }

      if(isset($node->rGeVeInu))
      {
          $res->setRGeVeInu(RGeVeInu::FromSimpleXMLElement($node->rGeVeInu));
      }

      if(isset($node->rGeVeTr))
      {
          $res->setRGeVeTr(RGeVeTr::FromSimpleXMLElement($node->rGeVeTr));
      }


      if(isset($node->rGeVeNotRec))
      {
          $res->setRGeVeNotRec(RGeVeNotRec::FromSimpleXMLElement($node->rGeVeNotRec));
      }

      if(isset($node->rGeVeConf))
      {
          $res->setRGeVeConf(RGeVeConf::FromSimpleXMLElement($node->rGeVeConf));
      }

      if(isset($node->rGeVeDisconf))
      {
          $res->setRGeVeDisconf(RGeVeDisconf::FromSimpleXMLElement($node->rGeVeDisconf));
      }

      if(isset($node->rGeVeDescon))
      {
          $res->setRGeVeDescon(RGeVeDescon::FromSimpleXMLElement($node->rGeVeDescon));
      }

      if(isset($node->rGeVeRetAce))
      {
          $res->setrGeVeRetAce(rGeVeRetAce::FromSimpleXMLElement($node->rGeVeRetAce));
      }

      if(isset($node->rGeVeRetAnu))
      {
          $res->setrGeVeRetAnu(rGeVeRetAnu::FromSimpleXMLElement($node->rGeVeRetAnu));
      }

      if(isset($node->rGeVeCCFF))
      {
          $res->setrGeVeCCFF(rGeVeCCFF::FromSimpleXMLElement($node->rGeVeCCFF));
      }

      if(isset($node->rGeDevCCFFCue))
      {
          $res->setGeDevCCFFCue(rGeDevCCFFCue::FromSimpleXMLElement($node->rGeDevCCFFCue));
      }

      if(isset($node->rGeDevCCFFDev))
      {
          $res->setGeDevCCFFDev(RGeDevCCFFDev::FromSimpleXMLElement($node->rGeDevCCFFDev));
      }

      if(isset($node->rGeVeAnt))
      {
          $res->setRGeVeAnt(RGeVeAnt::FromSimpleXMLElement($node->rGeVeAnt));
      }

      if(isset($node->rGeVeRem))
      {
          $res->setRGeVeRem(RGeVeRem::FromSimpleXMLElement($node->rGeVeRem));
      }

      if(isset($node->rGeVeNom))
      {
          $res->setRGeVeNom(RGeVeNom::FromSimpleXMLElement($node->rGeVeNom));
      }

      return $res;
    }
}
