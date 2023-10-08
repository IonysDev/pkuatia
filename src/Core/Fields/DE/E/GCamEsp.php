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
                                // Id - Longitud - Ocurrencia - Descripción
  public GGrupEner $gGrupoEner; // E791 - - 0-1 - Campos del sector de energía eléctrica
  public GGrupSeg  $gGrupoSeg;  // E800 - - 0-1 - Campos del sector de seguros
  public GGrupSup  $gGrupSup;   // E810 - - 0-1 - Campos del sector de supermercados
  public GGrupAdi  $gGrupAdi;   // E820 - - 0-1 - Grupo  de  datos adicionales de uso comercial 

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de gGrupoEner (Campos del sector de energía eléctrica)
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
   * Establece el valor de gGrupoSeg (Campos del sector de seguros)
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
   * Get the value of gGrupoEner
   *
   * @return GGrupEner
   */
  public function getGGrupoEner(): GGrupEner
  {
    return $this->gGrupoEner;
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
   * Get the value of gGrupSup
   *
   * @return GGrupSup
   */
  public function getGGrupSup(): GGrupSup
  {
    return $this->gGrupSup;
  }

  /**
   * Get the value of gGrupAdi
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
    if(isset($node->gGrupoEner))
    {
      $res->setGGrupoEner(GGrupEner::FromSimpleXMLElement($node->gGrupoEner));
    }
    if(isset($node->gGrupoSeg))
    {
      $res->setGGrupoSeg(GGrupSeg::FromSimpleXMLElement($node->gGrupoSeg));
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
    if(isset($object->gGrupoEner))
    {
      $res->setGGrupoEner(GGrupEner::FromSifenResponseObject($object->gGrupoEner));
    }

    if(isset($object->gGrupoSeg))
    {
      $res->setGGrupoSeg(GGrupSeg::FromSifenResponseObject($object->gGrupoSeg));
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
    if (isset($this->gGrupoEner)) {
      $res->appendChild($this->gGrupoEner->toDOMElement($doc));
    }
    if (isset($this->gGrupSup)) {
      $res->appendChild($this->gGrupSup->toDOMElement($doc));
    }
    if (isset($this->gGrupoSeg)) {
      $res->appendChild($this->gGrupSup->toDOMElement($doc));
    }
    if (isset($this->gGrupAdi)) {
      $res->appendChild($this->gGrupAdi->toDOMElement($doc));
    }
    return $res;
  }
}
