<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use Abiliomp\Pkuatia\Core\Fields\BaseSifenField;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo:        E800  
 * Nombre:      gGrupSeg  
 * Descripción: Grupo del sector de seguros  
 * Nodo Padre:  E790
 */

class GGrupSeg extends BaseSifenField
{
                               // Id - Longitud - Ocurrencia - Descripción
  public String $dCodEmpSeg;   // E801  - 20 - 0-1   - Código de la empresa de seguros en la Superintendencia de Seguros
  public array  $gGrupPolSeg;  // EA790 -    - 1-999 - Grupos de pólizas de seguros (GGrupPolSeg[])

  ///////////////////////////////////////////////////////////////////////
  // Constructor
  ///////////////////////////////////////////////////////////////////////

  public function __construct()
  {
    $this->gGrupPolSeg = [];
  }

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de dCodEmpSeg (Código de la empresa de seguros en la Superintendencia de Seguros)
   *
   * @param String $dCodEmpSeg
   *
   * @return self
   */
  public function setDCodEmpSeg(String $dCodEmpSeg): self
  {
    $this->dCodEmpSeg = $dCodEmpSeg;
    return $this;
  }

  /**
   * Establece el valor de gGrupoPolSeg (Grupos de pólizas de seguros (GGrupPolSeg[]))
   *
   * @param array $gGrupoPolSeg
   *
   * @return self
   */
  public function setGGrupoPolSeg(array $gGrupPolSeg): self
  {
    $this->gGrupPolSeg = $gGrupPolSeg;
    return $this;
  }

  public function addGrupPolSeg(GGrupPolSeg $gGrupPolSeg): self
  {
    $this->gGrupPolSeg[] = $gGrupPolSeg;
    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Devuelve el valor de dCodEmpSeg (Código de la empresa de seguros en la Superintendencia de Seguros)
   *
   * @return String
   */
  public function getDCodEmpSeg(): String
  {
    return $this->dCodEmpSeg;
  }

  /**
   * Devuelve el valor de gGrupoPolSeg (Grupos de pólizas de seguros (GGrupPolSeg[]))
   *
   * @return array
   */
  public function getGGrupPolSeg(): array
  {
    return $this->gGrupPolSeg;
  }

  ///////////////////////////////////////////////////////////////////////
  // Instanciadores
  ///////////////////////////////////////////////////////////////////////

  /**
   * Instancia un objeto GGrupSeg a partir de un objeto SimpleXMLElement
   * 
   * @param  SimpleXMLElement $node
   * 
   * @return self
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node): self
  {
    if(strcmp($node->getName(), 'gGrupSeg') != 0)
    {
      throw new \Exception('[gGrupSeg] El nombre del nodo no corresponde a gGrupSeg: ' . $node->getName(), 1);
    }
    $res = new GGrupSeg();
    if(isset($node->dCodEmpSeg))
    {
      $res->setDCodEmpSeg((String) $node->dCodEmpSeg);
    }
    if(isset($node->gGrupoPolSeg))
    {
      foreach($node->gGrupoPolSeg as $gGrupoPolSeg)
      {
        $res->gGrupPolSeg[] = GGrupPolSeg::FromSimpleXMLElement($gGrupoPolSeg);
      }
    }
    return $res;
  }

  /**
   * Instancia un objeto GGrupSeg a partir de un objeto stdClass de respuesta a una petición SOAP al SIFEN
   * 
   * @param  stdClass $object
   * 
   * @return self
   */
  public static function FromSifenResponseObject($object):self
  {
    $res = new GGrupSeg();
    if(isset($object->dCodEmpSeg))
    {
      $res->setDCodEmpSeg($object->dCodEmpSeg);
    }
    if(isset($object->gGrupoPolSeg))
    {
      if(!is_array($object->gGrupoPolSeg))
      {
        $res->gGrupPolSeg[] = GGrupPolSeg::FromSifenResponseObject($object->gGrupoPolSeg);
      }
      else if(count($object->gGrupoPolSeg) > 0)
      {
        foreach($object->gGrupoPolSeg as $gGrupoPolSeg)
        {
          $res->gGrupPolSeg[] = GGrupPolSeg::FromSifenResponseObject($gGrupoPolSeg);
        }
      }
    }
    return $res;
  }


  ///////////////////////////////////////////////////////////////////////
  // Conversores
  ///////////////////////////////////////////////////////////////////////

  /**
   * Convierte este GGrupSeg en un DOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gGrupSeg');
    $res->appendChild(new DOMElement('dCodEmpSeg', $this->getDCodEmpSeg()));
    if(isset($this->gGrupPolSeg) && count($this->gGrupPolSeg) > 0)
    {
      foreach($this->gGrupPolSeg as $gGrupPolSeg)
      {
        $res->appendChild($gGrupPolSeg->toDOMElement($doc));
      }
    }
    return $res;
  }
  
 

  
}
