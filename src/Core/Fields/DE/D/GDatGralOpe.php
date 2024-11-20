<?php

namespace IonysDev\Pkuatia\Core\Fields\DE\D;

use IonysDev\Pkuatia\Core\Fields\BaseSifenField;
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
   * Establece el valor de dFeEmiDE (D002) que es la fecha y hora de emisión del DE.
   *
   * @param DateTime $dFeEmiDE Fecha y hora de emisión del DE.
   *
   * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
   */
  public function setDFeEmiDE(DateTime $dFeEmiDE): self
  {
    $this->dFeEmiDE = $dFeEmiDE;
    return $this;
  }

  /**
   * Establece el valor de gOpeCom (D010) que son los campos inherentes a la operación comercial.
   *
   * @param GOpeCom $gOpeCom Campos inherentes a la operación comercial.
   *
   * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
   */
  public function setGOpeCom(GOpeCom $gOpeCom): self
  {
    $this->gOpeCom = $gOpeCom;
    return $this;
  }

  /**
   * Establece el valor de gEmis (D100) que son los campos que identifican al emisor.
   *
   * @param GEmis $gEmis Campos que identifican al emisor.
   *
   * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
   */
  public function setGEmis(GEmis $gEmis): self
  {
    $this->gEmis = $gEmis;
    return $this;
  }

  /**
   * Establece el valor de gDatRec (D200) que son los campos que identifican al receptor.
   *
   * @param GDatRec $gDatRec Campos que identifican al receptor.
   *
   * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
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
   * Devuelve el valor de dFeEmiDE (D002) que es la fecha y hora de emisión del DE.
   *
   * @return DateTime Fecha y hora de emisión del DE.
   */
  public function getDFeEmiDE(): DateTime
  {
    return $this->dFeEmiDE;
  }

  /**
   * Devuelve el valor de gOpeCom (D010) que son los campos inherentes a la operación comercial.
   *
   * @return GOpeCom Campos inherentes a la operación comercial.
   */
  public function getGOpeCom(): GOpeCom
  {
    return $this->gOpeCom;
  }

  /**
   * Devuelve el valor de gEmis (D100) que son los campos que identifican al emisor.
   *
   * @return GEmis Campos que identifican al emisor.
   */
  public function getGEmis(): GEmis
  {
    return $this->gEmis;
  }

  /**
   * Devuelve el valor de gDatRec (D200) que son los campos que identifican al receptor.
   *
   * @return GDatRec Campos que identifican al receptor.
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
   * Instancia un objeto GDatGralOpe a partir de un objeto stdClass que contiene los datos de respuesa SOAP del SIFEN.
   *
   * @param stdClass $object Objeto respuesta del SIFEN.
   * 
   * @return self Objeto GDatGralOpe instanciado.
   */
  public static function FromSifenResponseObject($object): self
  {
    $res = new GDatGralOpe();
    if(isset($object->dFeEmiDE))
      $res->setDFeEmiDE(DateTime::createFromFormat('Y-m-d\TH:i:s', $object->dFeEmiDE));
    if(isset($object->gOpeCom))
      $res->setGOpeCom(GOpeCom::FromSifenResponseObject($object->gOpeCom));
    if(isset($object->gEmis))
      $res->setGEmis(GEmis::FromSifenResponseObject($object->gEmis));
    if(isset($object->gDatRec))
      $res->setGDatRec(GDatRec::FromSifenResponseObject($object->gDatRec));
    return $res;
  }

  /**
   * Instancia un objeto GDatGralOpe a partir de un DOMElement con los datos del mismo.
   * 
   * @param DOMElement $node Nodo DOM que contiene los datos del objeto.
   * 
   * @return self Objeto GDatGralOpe instanciado.
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

  ///////////////////////////////////////////////////////////////////////
  // Conversores
  ///////////////////////////////////////////////////////////////////////

  /**
   * Convierte este GDatGralOpe en un DOMElement generado en el DOMDocument especificado.
   * 
   * @param DOMDocument $doc DOMDocument que generará el DOMElement.
   *
   * @return DOMElement DOMElement creado pero no insertado.
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
}
