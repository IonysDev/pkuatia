<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\Event\GDE;

use Abiliomp\Pkuatia\Core\Constants;
use DOMDocument;
use DOMElement;

/**
 * Nodo: GEC000 - gGroupGesEve - Raíz del grupo deeventos 
 * Padre: GSch03 - dEvReg - Evento a ser registrado
 */
class GGroupGesEve
{
                         // ID - DESCRIPCION- LONGITUD - OCURRENCIA
  public array $rGesEve; // GDE001 - Raíz de Gestión de Eventos - x - 1-15

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de rGesEve
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
    $res = $doc->createElement('gGroupGesEve');
    $res->setAttribute('xmlns', Constants::SIFEN_NS_URI);
    $res->setAttribute('xmlns:xsi', Constants::SIFEN_NS_XSI);
    $res->setAttribute('xsi:schemaLocation', Constants::SIFEN_NS_URI_RECEP_EVENTO);
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
