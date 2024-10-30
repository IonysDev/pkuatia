<?php

namespace Abiliomp\Pkuatia\Core\Fields;

use DOMDocument;
use DOMElement;
use ReflectionClass;

/**
 * Clase que debe ser extendida por todos los campos de Sifen
 */
abstract class BaseSifenField
{
    /**
     * Convierte el objeto a un DOMElement.
     * 
     * @return DOMElement
     */
    abstract public function toDOMElement(DOMDocument $doc): DOMElement;

    /**
     * Instancia un objeto a partir de un DOMElement que representa el nodo XML del objeto.
     * 
     * @param DOMElement $node Nodo XML que representa el objeto.
     * 
     * @return self Objeto instanciado.
     */
    abstract public static function FromDOMElement(DOMElement $node): self;

    /**
     * Serializa el objeto en una cadena XML.
     */
    public function toXMLString(): String
    {
      $doc = new DOMDocument('1.0', 'UTF-8');
      $domElement = $this->toDOMElement($doc);
      $xmlString = $domElement->ownerDocument->saveXML($domElement);
      if(!$xmlString)
        throw new \Exception('[' . self::class . '] Error al convertir el objeto a XML.');
      return $xmlString;
    }
}

?>