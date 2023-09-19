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

  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gGroupGesEve');;
    foreach ($this->rGesEve as $rGesEve) {
      $res->appendChild($rGesEve->toDOMElement($doc));
    }
    return $res;
  }

  public function toXMLString(): string
  {
    $xmlString = $this->toDOMDocument()->saveXML();
    if (!$xmlString) {
      throw new \Exception('Error al generar el XML');
    }
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
