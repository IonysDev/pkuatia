<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use Abiliomp\Pkuatia\Core\Fields\BaseSifenField;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id:     E790 
 * Nombre:      gCamEsp
 * Descripción: Campos complementarios comerciales de uso específico
 * Nodo Padre:  E001 
 */
class GCamEsp extends BaseSifenField
{
                                // Id   - Longitud - Ocurrencia - Descripción
  public GGrupEner $gGrupEner;  // E791 - - 0-9    - Campos del sector de energía eléctrica
  public GGrupSeg  $gGrupSeg;   // E800 - - 0-1    - Campos del sector de seguros
  public GGrupSup  $gGrupSup;   // E810 - - 0-1    - Campos del sector de supermercados
  public GGrupAdi  $gGrupAdi;   // E820 - - 0-1    - Grupo  de  datos adicionales de uso comercial 

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de gGrupEner (Campos del sector de energía eléctrica)
   *
   * @param GGrupEner $gGrupEner
   *
   * @return self
   */
  public function setgGrupEner(GGrupEner $gGrupEner): self
  {
    $this->gGrupEner = $gGrupEner;
    return $this;
  }

  /**
   * Establece el valor de gGrupSeg (Campos del sector de seguros)
   *
   * @param GGrupSeg $gGrupSeg
   *
   * @return self
   */
  public function setGGrupSeg(GGrupSeg $gGrupSeg): self
  {
    $this->gGrupSeg = $gGrupSeg;
    return $this;
  }

  /**
   * Establece el valor de gGrupSup (Campos del sector de supermercados)
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

  /**
   * Establece el valor de gGrupAdi (Grupo  de  datos adicionales de uso comercial)
   *
   * @param GGrupAdi $gGrupAdi
   *
   * @return self
   */
  public function setGGrupAdi(GGrupAdi $gGrupAdi): self
  {
    $this->gGrupAdi = $gGrupAdi;
    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de gGrupEner
   *
   * @return GGrupEner
   */
  public function getgGrupEner(): GGrupEner
  {
    return $this->gGrupEner;
  }

  /**
   * Obtiene el valor de gGrupSeg
   *
   * @return GGrupSeg
   */
  public function getGGrupoSeg(): GGrupSeg
  {
    return $this->gGrupSeg;
  }

  /**
   * Obtiene el valor de gGrupSup
   *
   * @return GGrupSup
   */
  public function getGGrupSup(): GGrupSup
  {
    return $this->gGrupSup;
  }

  /**
   * Obtiene el valor de gGrupAdi
   *
   * @return GGrupAdi
   */
  public function getGGrupAdi(): GGrupAdi
  {
    return $this->gGrupAdi;
  }

  ///////////////////////////////////////////////////////////////////////
  // Instanciadores
  ///////////////////////////////////////////////////////////////////////

  /**
   * Instancia un objeto GCamEsp a partir de un SimpleXMLElement
   * 
   * @param  SimpleXMLElement $node
   * 
   * @return self
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node): self
  {
    if(strcmp($node->getName(), 'gCamEsp') != 0)
      throw new \Exception('[GCamEsp] El nombre del nodo no corresponde a gCamEsp: ' . $node->getName(), 1);
    $res = new GCamEsp();
    if(isset($node->gGrupEner))
    {
      $res->setgGrupEner(GGrupEner::FromSimpleXMLElement($node->gGrupEner));
    }
    if(isset($node->gGrupSeg))
    {
      $res->setGGrupoSeg(GGrupSeg::FromSimpleXMLElement($node->gGrupSeg));
    }
    if(isset($node->gGrupSup))
    {
      $res->setGGrupSup(GGrupSup::FromSimpleXMLElement($node->gGrupSup));
    }
    if(isset($node->gGrupAdi))
    {
      $res->setGGrupAdi(GGrupAdi::FromSimpleXMLElement($node->gGrupAdi));
    }
    return $res;
  }

  /**
   * Instancia un objeto GCamEsp a partir de un objeto stdClass que contiene datos de la respuesta del Sifen
   *
   * @param  stdClass $object
   * 
   * @return self
   */
  public static function FromSifenResponseObject($object): self
  {
    $res = new GCamEsp();
    if(isset($object->gGrupEner))
    {
      $res->setgGrupEner(GGrupEner::FromSifenResponseObject($object->gGrupEner));
    }

    if(isset($object->gGrupSeg))
    {
      $res->setGGrupoSeg(GGrupSeg::FromSifenResponseObject($object->gGrupSeg));
    }

    if(isset($object->gGrupoSup))
    {
      $res->setGGrupSup(GGrupSup::FromSifenResponseObject($object->gGrupoSup));
    }

    if(isset($object->gGrupAdi))
    {
      $res->setGGrupAdi(GGrupAdi::FromSifenResponseObject($object->gGrupAdi));
    }
    return $res;
  }

  public static function FromDOMElement(DOMElement $node): self
  {
    if(strcmp($node->nodeName, 'gCamEsp') != 0)
      throw new \Exception('[GCamEsp] El nombre del nodo no corresponde a gCamEsp: ' . $node->nodeName, 1);
    $res = new GCamEsp();
    if($node->getElementsByTagName('gGrupEner')->length > 0)
      $res->setgGrupEner(GGrupEner::FromDOMElement($node->getElementsByTagName('gGrupEner')->item(0)));
    if($node->getElementsByTagName('gGrupSeg')->length > 0)
      $res->setGGrupoSeg(GGrupSeg::FromDOMElement($node->getElementsByTagName('gGrupSup')->item(0)));
    if($node->getElementsByTagName('gGrupSup')->length > 0)
      $res->setGGrupSup(GGrupSup::FromDOMElement($node->getElementsByTagName('gGrupSup')->item(0)));
    if($node->getElementsByTagName('gGrupAdi')->length > 0)
      $res->setGGrupAdi(GGrupAdi::FromDOMElement($node->getElementsByTagName('gGrupAdi')->item(0)));
    return $res;
  }

  ///////////////////////////////////////////////////////////////////////
  // Conversores
  ///////////////////////////////////////////////////////////////////////

  /**
   * Convierte este GCamEsp en un DOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement("gCamEsp");
    if (isset($this->gGrupEner)) {
      $res->appendChild($this->gGrupEner->toDOMElement($doc));
    }
    if (isset($this->gGrupSup)) {
      $res->appendChild($this->gGrupSup->toDOMElement($doc));
    }
    if (isset($this->gGrupSeg)) {
      $res->appendChild($this->gGrupSup->toDOMElement($doc));
    }
    if (isset($this->gGrupAdi)) {
      $res->appendChild($this->gGrupAdi->toDOMElement($doc));
    }
    return $res;
  }
}
