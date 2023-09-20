<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\Event\GEA;

use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 *  ID:GERE001  Raíz Gestión de Eventos remisión PADRE:GDE007
 */
class RGeVeRem
{
                     // ID - DESCRIPCION- LONGITUD - OCURRENCIA
  public String $Id; // GERE002 - CDC del DTE asociado - 44 - 1-1

   ///////////////////////////////////////////////////////////////////////
  ///SETTERS
   ///////////////////////////////////////////////////////////////////////


  /**
   * Set the value of Id
   *
   * @param String $Id
   *
   * @return self
   */
  public function setId(String $Id): self
  {
    $this->Id = $Id;

    return $this;
  }

   ///////////////////////////////////////////////////////////////////////
  ///GETTERS
   ///////////////////////////////////////////////////////////////////////

  /**
   * Get the value of Id
   *
   * @return String
   */
  public function getId(): String
  {
    return $this->Id;
  }

   ///////////////////////////////////////////////////////////////////////
  ///XML ELEMENT
   ///////////////////////////////////////////////////////////////////////

    
  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('rGeVeRem');
    $res->appendChild(new DOMElement('Id',$this->getId()));

    return $res;
  }

//     /**
//    * fromDOMElement
//    *
//    * @param  mixed $xml
//    * @return TrGeVeRetAce
//    */
//   public static function fromDOMElement(DOMElement $xml): RGeVeRem
//   {
//     if (strcmp($xml->tagName, "rGeVeRem") == 0 && $xml->childElementCount == 7) {
//       $res = new RGeVeRem();
//       $res->setId($xml->getElementsByTagName('Id')->item(0)->nodeValue);
      
//       return $res;
//     } else {
//       throw new \Exception("Invalid XML Element: $xml->tagName");
//       return null;
//     }
//   }

    public static function FromSimpleXMLElement(SimpleXMLElement $xml)
    {
        $res = new RGeVeRem();
        $res->setId($xml->Id);

        return $res;
    }
}
