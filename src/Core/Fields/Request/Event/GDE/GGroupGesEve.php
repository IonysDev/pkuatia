<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\Event\GDE;

use DOMDocument;
use DOMElement;

/**
 * Nodo: GEC000 - gGroupGesEve - Raíz del grupo deeventos 
 * Padre: GSch03 - dEvReg - Evento a ser registrado
 */
class GGroupGesEve
{
  public array $rGesEve; // GDE001 - Raíz de Gestión de Eventos - OCURRENCIA 1-15
 
  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of rGesEve
   *
   * @param array $rGesEve
   *
   * @return self
   */
  public function setRGesEve(array $rGesEve): self
  {
    $this->rGesEve = $rGesEve;

    return $this;
  }


  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  public function getRGesEve(): array
  {
    return $this->rGesEve;
  }



  ///////////////////////////////////////////////////////////////////////
  // XML Element 
  ///////////////////////////////////////////////////////////////////////


  public function toDOMDocument(): DOMDocument
  {
    $doc = new DOMDocument('1.0', 'utf-8');
    $domElement = $this->toDOMElement($doc);
    $doc->appendChild($domElement);
    return $doc;
  }

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    // Validaciones
    if(!isset($this->rGesEve))
      throw new \Exception('[GGroupGesEve] El campo rGesEve no puede ser nulo.');

    //cabecera dEvReg
    $res = $doc->createElement('dEvReg');
    // Conversión
    $res->appendChild($doc->createElement('gGroupGesEve'));
    foreach ($this->rGesEve as $key => $value) {
      ///append in gGroupGesEve
      $res->getElementsByTagName('gGroupGesEve')->item(0)->appendChild($value->toDOMElement($doc));
    }
    return $res;
  }

  public function toXMLString(): string
  {
    $xmlString = $this->toDOMDocument()->saveXML();
    if(!$xmlString)
    {
      throw new \Exception('[GGroupGesEve] Error al convertir el objeto a XML.');
    }

    ///remove the first line of the xml
    $xmlString = substr($xmlString, strpos($xmlString, "\n") + 1);
    
    return $xmlString;
  }
  
  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return GGroupGesEve
  //  */
  // public static function fromDOMElement(DOMElement $xml): GGroupGesEve
  // {
  //   if(strcmp($xml->tagName, 'gGroupGesEve') == 0 && $xml->childElementCount  == 2)
  //   { 
  //     $res = new GGroupGesEve();
  //     //Children
  //     // $res->setRGesEve($res->rGesEve->fromDOMElement($xml->getElementsByTagName('rGesEve')->item(0)->nodeValue));
  
  //     return $res;
  //   }
  //   else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }



}
