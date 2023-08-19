<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\D;

use DateTime;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id:     D001
 * Nombre:      dDatGralOpe
 * Descripción: Campos generales del DE
 * Nodo Padre:  A001 - DE - Campos firmados del DE
 */

class GDatGralOpe
{

  public DateTime $dFeEmiDE; // D002 - Fecha y hora de emisión del DE (D002) AAAA-MM-DDThh:mm:ss
  public GOpeCom $gOpeCom;   // Campos inherentes a la operación comercial (D010)
  public GEmis $gEmis;       // Grupo de campos que identifican al emisor (D100)
  public GDatRec $gDatRec;   // Grupo de campos que identifican al receptor (D200)

  ///////////////////////////////////////////////////////////////////////
  ///Constructor
  ///////////////////////////////////////////////////////////////////////
  public function __construct()
  {
    ///General
    $this->gEmis = new GEmis();
    $this->gDatRec = new GDatRec();
    ///FOR TEST ONLY
    $this->dFeEmiDE = new DateTime();
  }


  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

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


  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////


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

  ///////////////////////////////////////////////////////////////////////
  // XML Element
  ///////////////////////////////////////////////////////////////////////

  /**
   * Instancia un objeto GDatGralOpe a partir de un SimpleXMLElement
   * 
   * @param  SimpleXMLElement $node
   * 
   * @return self
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node): self
  {
    if(strcmp($node->getName(), 'gDatGralOpe') != 0)
    {
      throw new \Exception("Invalid XML Element: $node->getName()");
      return null;
    }
    $res = new GDatGralOpe();
    $res->setDFeEmiDE(DateTime::createFromFormat('Y-m-d\TH:i:s', $node->dFeEmiDE));
    if(isset($node->gOpeCom))
      $res->setGOpeCom(GOpeCom::FromSimpleXMLElement($node->gOpeCom));
    $res->gEmis = GEmis::FromSimpleXMLElement($node->gEmis);
    $res->gDatRec = GDatRec::FromSimpleXMLElement($node->gDatRec);
    return $res;
  }


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
   * FromSifenResponseObject
   *
   * @param  mixed $object
   * @return self
   */
  public static function FromSifenResponseObject($object): self
  {
    $res = new GDatGralOpe();
    if(isset($object->dFeEmiDE))
    {
      $res->setDFeEmiDE(DateTime::createFromFormat('Y-m-d\TH:i:s', $object->dFeEmiDE));
    }
    ///children
    if(isset($object->gOpeCom))
    {
      $res->setGOpeCom(GOpeCom::FromSifenResponseObject($object->gOpeCom));
    }
    if(isset($object->gEmis))
    {
      $res->setGEmis(GEmis::FromSifenResponseObject($object->gEmis));
    }
    if(isset($object->gDatRec))
    {
      $res->setGDatRec(GDatRec::FromSifenResponseObject($object->gDatRec));
    }
    return $res;
  }
}
