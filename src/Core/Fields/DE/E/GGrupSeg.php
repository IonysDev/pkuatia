<?php

namespace IonysDev\Pkuatia\Core\Fields\DE\E;

use IonysDev\Pkuatia\Core\Fields\BaseSifenField;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;
use IonysDev\Pkuatia\Helpers\XmlHelper;
use stdClass;
use IonysDev\Pkuatia\Core\Exceptions\ValidacionException;

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
      throw new ValidacionException('[gGrupSeg] El nombre del nodo no corresponde a gGrupSeg: ' . $node->getName(), 1);
    }
    $res = new GGrupSeg();
    if(isset($node->dCodEmpSeg))
    {
      $res->setDCodEmpSeg((String) $node->dCodEmpSeg);
    }
    // Hasta 0.2.0 se buscaba "gGrupoPolSeg" (el elemento es gGrupPolSeg) y las pólizas se perdían (PK-25).
    if(isset($node->gGrupPolSeg))
    {
      foreach($node->gGrupPolSeg as $gGrupPolSeg)
      {
        $res->gGrupPolSeg[] = GGrupPolSeg::FromSimpleXMLElement($gGrupPolSeg);
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
    // Hasta 0.2.0 se buscaba "gGrupoPolSeg" (el elemento es gGrupPolSeg) y las pólizas se perdían (PK-25).
    if(isset($object->gGrupPolSeg))
    {
      if(!is_array($object->gGrupPolSeg))
      {
        $res->gGrupPolSeg[] = GGrupPolSeg::FromSifenResponseObject($object->gGrupPolSeg);
      }
      else if(count($object->gGrupPolSeg) > 0)
      {
        foreach($object->gGrupPolSeg as $gGrupPolSeg)
        {
          $res->gGrupPolSeg[] = GGrupPolSeg::FromSifenResponseObject($gGrupPolSeg);
        }
      }
    }
    return $res;
  }


  ///////////////////////////////////////////////////////////////////////
  // Conversores
  ///////////////////////////////////////////////////////////////////////

  public static function FromDOMElement(DOMElement $node): self
  {
    if (strcmp($node->nodeName, 'gGrupSeg') != 0) {
      throw new ValidacionException('[GGrupSeg] Nodo con nombre inválido: ' . $node->nodeName);
    }
    $res = new GGrupSeg();
    if ($node->getElementsByTagName('dCodEmpSeg')->length > 0) {
      $res->setDCodEmpSeg(trim($node->getElementsByTagName('dCodEmpSeg')->item(0)->nodeValue));
    }
    foreach ($node->getElementsByTagName('gGrupPolSeg') as $polNode) {
      $res->gGrupPolSeg[] = GGrupPolSeg::FromDOMElement($polNode);
    }
    return $res;
  }

  /**
   * Convierte este GGrupSeg en un DOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gGrupSeg');
    $res->appendChild(XmlHelper::elemento($doc, 'dCodEmpSeg', $this->getDCodEmpSeg()));
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
