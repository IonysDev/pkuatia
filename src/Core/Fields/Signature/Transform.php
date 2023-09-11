<?php

namespace Abiliomp\Pkuatia\Core\Fields\Signature;

use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * Clase que representa el campo Transform de la firma
 */
class Transform 
{

    public String $Algorithm;

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Establece la URI del algoritmo de transformación
     *
     * @param String $Algorithm
     *
     * @return self
     */
    public function setAlgorithm(String $Algorithm): self
    {
        $this->Algorithm = $Algorithm;
        return $this;
    }

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Devuelve la URI del algoritmo de transformación
     *
     * @return String
     */
    public function getAlgorithm(): String
    {
        return $this->Algorithm;
    }

    ///////////////////////////////////////////////////////////////////////
    // Instanciadores
    ///////////////////////////////////////////////////////////////////////

    /**
     * Instancia un objeto Transform a partir de un SimpleXMLElement
     * 
     * @param SimpleXMLElement $node
     * 
     * @return self
     */
    public static function FromSimpleXMLElement(SimpleXMLElement $node): self
    {
        $Transform = new self();
        $Transform->setAlgorithm($node->attributes()->Algorithm);
        return $Transform;
    }

    /**
     * Instancia un objeto Transform a partir de un DOMElement
     * 
     * @param DOMElement $node 
     * 
     * @return self
     */
    public static function FromDOMElement(DOMElement $node): self
    {
        $Transform = new self();
        $Transform->setAlgorithm($node->getAttribute('Algorithm'));
        return $Transform;
    }

    ///////////////////////////////////////////////////////////////////////
    // Conversores
    ///////////////////////////////////////////////////////////////////////

    /**
     * Convierte el objeto a un DOMElement
     * 
     * @return DOMElement
     */
    public function toDOMElement(DOMDocument $doc): DOMElement
    {
        $Transform = $doc->createElement('Transform');
        $Transform->setAttribute('Algorithm', $this->getAlgorithm());
        return $Transform;
    }
    
}

?>