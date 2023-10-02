<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\D;

use Abiliomp\Pkuatia\Core\Fields\BaseSifenField;
use DateTime;
use DOMDocument;
use DOMElement;
use Exception;
use SimpleXMLElement;

/**
 * Nodo Id:     D001
 * Nombre:      dDatGralOpe
 * Descripción: Campos generales del DE
 * Nodo Padre:  A001 - DE - Campos firmados del DE
 */

class GDatGralOpe extends BaseSifenField
{
                             // Id - Longitud - Ocurrencia - Descripción
  public DateTime $dFeEmiDE; // D002 - 19 - 1-1 - Fecha y hora de emisión del DE formato AAAA-MM-DDThh:mm:ss
  public GOpeCom  $gOpeCom;  // D010 -    - 0-1 - Campos inherentes a la operación comercial (obligatorio si C002 != 7)
  public GEmis    $gEmis;    // D100 -    - 1-1 - Grupo de campos que identifican al emisor (D100)
  public GDatRec  $gDatRec;  // D200 -    - 1-1 - Grupo de campos que identifican al receptor (D200)

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
  // Instanciadores
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
      throw new Exception("Invalid XML Element: $node->getName()");
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

  ///////////////////////////////////////////////////////////////////////
  // Conversores
  ///////////////////////////////////////////////////////////////////////

  /**
   * Convierte este GDatGralOpe a un DOMElement
   * 
   * @param  DOMDocument $doc Documento DOM donde se creará el nodo, pero NO será agregado.
   *
   * @return DOMElement Nodo DOM que representa el objeto
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    if(!isset($this->dFeEmiDE))
      throw new Exception('[GDatGralOpe] El campo dFeEmiDE no puede ser nulo');
    if(!isset($this->gEmis))
      throw new Exception('[GDatGralOpe] El campo gEmis no puede ser nulo');
    if(!isset($this->gDatRec))
      throw new Exception('[GDatGralOpe] El campo gDatRec no puede ser nulo');
    $res = $doc->createElement('gDatGralOpe');
    $res->appendChild(new DOMElement('dFeEmiDE', $this->dFeEmiDE->format('Y-m-d\TH:i:s')));
    if(isset($this->gOpeCom)) 
      $res->appendChild($this->gOpeCom->toDOMElement($doc));
    $res->appendChild($this->gEmis->toDOMElement($doc));
    $res->appendChild($this->gDatRec->toDOMElement($doc));
    return $res;
  }

  /**
   * Instancia un objeto GDatGralOpe a partir de un DOMElement que lo representa.
   * 
   * @param  DOMElement $node Nodo DOM que representa el objeto.
   * 
   * @return self
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    if(strcmp($node->nodeName, 'gDatGralOpe') != 0)
      throw new \Exception('[GDatGralOpe] Nodo con nombre inválido: ' . $node->nodeName);
    $res = new GDatGralOpe();
    $res->setDFeEmiDE(DateTime::createFromFormat('Y-m-d\TH:i:s', trim($node->getElementsByTagName('dFeEmiDE')[0]->nodeValue)));
    if($node->getElementsByTagName('gOpeCom')->length > 0)
      $res->setGOpeCom(GOpeCom::FromDOMElement($node->getElementsByTagName('gOpeCom')[0]));
    $res->setGEmis(GEmis::FromDOMElement($node->getElementsByTagName('gEmis')[0]));
    $res->setGDatRec(GDatRec::FromDOMElement($node->getElementsByTagName('gDatRec')[0]));
    return $res;
  }
  
  
}
