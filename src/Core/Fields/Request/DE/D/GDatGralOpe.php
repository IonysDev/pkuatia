<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\D;

use DateTime;
use DOMElement;

/**
 * Campos generales del DE (D001)
 * Nodo padre DE (A001): Campos firmados del DE
 */

class GDatGralOpe
{

  public DateTime $dFeEmiDE; // D002 - Fecha y hora de emisión del DE (D002) AAAA-MM-DDThh:mm:ss
  public GOpeCom $gOpeCom;   // Campos inherentes a la operación comercial (D010)
  public GEmis $gEmis;       // Grupo de campos que identifican al emisor (D100)
  public GDatRec $gDatRec;   // Grupo de campos que identifican al receptor (D200)

  //====================================================//
  ///Setters
  //====================================================//

  /**
   * Set the value of dFeEmiDE
   *
   * @param DateTime $dFeEmiDE
   *
   * @return self
   */
  public function setDFeEmiDE(DateTime $dFeEmiDE): self
  {
    $this->dFeEmiDE = $dFeEmiDE;

    return $this;
  }


  /**
   * Set the value of gOpeCom
   *
   * @param GOpeCom $gOpeCom
   *
   * @return self
   */
  public function setGOpeCom(GOpeCom $gOpeCom): self
  {
    $this->gOpeCom = $gOpeCom;

    return $this;
  }


  /**
   * Set the value of gEmis
   *
   * @param GEmis $gEmis
   *
   * @return self
   */
  public function setGEmis(GEmis $gEmis): self
  {
    $this->gEmis = $gEmis;

    return $this;
  }


  /**
   * Set the value of gDatRec
   *
   * @param GDatRec $gDatRec
   *
   * @return self
   */
  public function setGDatRec(GDatRec $gDatRec): self
  {
    $this->gDatRec = $gDatRec;

    return $this;
  }


  //====================================================//
  ///Getters
  //====================================================//


  /**
   * Get the value of dFeEmiDE
   *
   * @return DateTime
   */
  public function getDFeEmiDE(): DateTime
  {
    return $this->dFeEmiDE;
  }

  /**
   * Get the value of gOpeCom
   *
   * @return GOpeCom
   */
  public function getGOpeCom(): GOpeCom
  {
    return $this->gOpeCom;
  }

  /**
   * Get the value of gEmis
   *
   * @return GEmis
   */
  public function getGEmis(): GEmis
  {
    return $this->gEmis;
  }

  /**
   * Get the value of gDatRec
   *
   * @return GDatRec
   */
  public function getGDatRec(): GDatRec
  {
    return $this->gDatRec;
  }

  //====================================================//
  ///XML Element
  //====================================================//

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('dDatGralOpe');
    $res->appendChild(new DOMElement('dFeEmiDE', $this->dFeEmiDE->format('Y-m-d\TH:i:s')));
    ///children
    $res->appendChild($this->gOpeCom->toDOMElement());
    $res->appendChild($this->gEmis->toDOMElement());
    $res->appendChild($this->gDatRec->toDOMElement());
    return $res;
  }

  /**
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return GDatGralOpe
   */
  public static function fromDOMElement(DOMElement $xml): GDatGralOpe
  {
    if (strcmp($xml->tagName, 'dDatGralOpe') == 0 && $xml->childElementCount == 4) {
      $res = new GDatGralOpe();
      $res->setDFeEmiDE(DateTime::createFromFormat('Y-m-d\TH:i:s',$xml->getElementsByTagName('dFeEmiDE')->item(0)->nodeValue));
      ///children
      $res->setGOpeCom($res->gOpeCom->fromDOMElement($xml->getElementsByTagName('gOpeCom')->item(0)->nodeValue));
      $res->setGEmis($res->gEmis->fromDOMElement($xml->getElementsByTagName('gEmis')->item(0)->nodeValue));
      $res->setGDatRec($res->gDatRec->fromDOMElement($xml->getElementsByTagName('gDatRec')->item(0)->nodeValue));
      return $res;
    } else {
      throw new \Exception("Invalid XML Element: $xml->tagName");
      return null;
    }
  }

  public static function fromResponse($response):self
  {
    $res = new GDatGralOpe();
    $res->setDFeEmiDE(DateTime::createFromFormat('Y-m-d\TH:i:s',$response->dFeEmiDE));
    ///children
    $res->setGOpeCom(GOpeCom::fromResponse($response->gOpeCom));
    $res->setGEmis(GEmis::fromResponse($response->gEmis));
    $res->setGDatRec(GDatRec::fromResponse($response->gDatRec));
    return $res;
  }
}
