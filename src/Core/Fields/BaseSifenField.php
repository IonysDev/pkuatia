<?php

namespace Abiliomp\Pkuatia\Core\Fields;

use DOMElement;

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
    abstract public function toDOMElement(): DOMElement;

    /**
     * Serializa el objeto en una cadena XML.
     */
    public function toXMLString(): String
    {
      $domElement = $this->toDOMElement();
      $xmlString = $domElement->ownerDocument->saveXML($domElement);
      if(!$xmlString)
        throw new \Exception('[' . self::class . '] Error al convertir el objeto a XML.');
      return $xmlString;
    }
}

?>