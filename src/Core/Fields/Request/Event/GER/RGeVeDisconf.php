<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\Event\GER;

use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 *  ID:GDI001 Raiz Gestión de Eventos Disconformidad PADRE:GDE007
 */
class RGeVeDisconf
{
                         // ID - DESCRIPCION- LONGITUD - OCURRENCIA
  public String $Id;     // GDI002 CDC del DTE - 44 - 1-1
  public String $mOtEve; // GDI004 Motivo del Evento - 5-500 - 1-1

  ///////////////////////////////////////////////////////////////////////
  //SETTERS
  ///////////////////////////////////////////////////////////////////////


  /**
   * Establece el valor de Id
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


  /**
   * Establece el valor de mOtEve
   *
   * @param String $mOtEve
   *
   * @return self
   */
  public function setMOtEve(String $mOtEve): self
  {
    $this->mOtEve = $mOtEve;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  ///GETTERS
  ///////////////////////////////////////////////////////////////////////



  /**
   * Obtiene el valor de Id
   *
   * @return String
   */
  public function getId(): String
  {
    return $this->Id;
  }

  /**
   * Obtiene el valor de mOtEve
   *
   * @return String
   */
  public function getMOtEve(): String
  {
    return $this->mOtEve;
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML Element
  ///////////////////////////////////////////////////////////////////////


  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('rGeVeDisconf');

    $res->appendChild(new DOMElement('Id', $this->getId()));
    $res->appendChild(new DOMElement('mOtEve', $this->getMOtEve()));

    return $res;
  }

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return DOMElement
  //  */
  // public static function fromDOMElement(DOMElement $xml): RGeVeDisconf
  // {
  //   if (strcmp($xml->tagName, 'rGeVeDisconf') == 0 && $xml->childElementCount == 2) {
  //     $res = new RGeVeDisconf();
  //     $res->setId($xml->getElementsByTagName('Id')->item(0)->nodeValue);
  //     $res->setMOtEve($xml->getElementsByTagName('mOtEve')->item(0)->nodeValue);
  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }

  public static function FromSimpleXMLElement(SimpleXMLElement $node):Self
  {
    if($node->getName() != 'rGeVeDisconf')
      throw new \Exception("Invalid XML Element: $node->getName()");

    $res = new RGeVeDisconf();
    $res->setId($node->Id);
    $res->setMOtEve($node->mOtEve);

    return $res;
  }
}
