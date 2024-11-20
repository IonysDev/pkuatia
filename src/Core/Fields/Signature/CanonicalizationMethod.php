<?php

namespace IonysDev\Pkuatia\Core\Fields\Signature;

use DOMDocument;
use DOMElement;
use SimpleXMLElement;

class CanonicalizationMethod 
{
    public String $Algorithm;

    /**
     * Devuelve la URI del algoritmo de la canonicalización
     *
     * @return String 
     */
    public function getAlgorithm(): ?String
    {
        if(!isset($this->Algorithm))
            return null;
        return $this->Algorithm;
    }

    /**
     * Establece la URI del algoritmo de la canonicalización
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
    // Instanciadores
    ///////////////////////////////////////////////////////////////////////

    /**
     * Instancia un objeto CanonicalizationMethod a partir de un SimpleXMLElement
     * 
     * @param SimpleXMLElement $node Nodo XML que contiene los datos del objeto
     * 
     * @return self Objeto instanciado
     */
    public static function FromSimpleXMLElement(SimpleXMLElement $node): self
    {
        $CanonicalizationMethod = new self();
        $CanonicalizationMethod->setAlgorithm($node->attributes()->Algorithm);
        return $CanonicalizationMethod;
    }

    /**
     * Instancia un objeto CanonicalizationMethod a partir de un DOMElement
     * 
     * @param DOMElement $node Nodo DOMElement que contiene los datos del objeto
     * 
     * @return self Objeto instanciado
     */
    public static function FromDOMElement(DOMElement $node): self
    {
        $CanonicalizationMethod = new self();
        $CanonicalizationMethod->setAlgorithm($node->getAttribute('Algorithm'));
        return $CanonicalizationMethod;
    }

    ///////////////////////////////////////////////////////////////////////
    // Conversores
    ///////////////////////////////////////////////////////////////////////

    /**
     * Convierte este CanonicalizationMethod a un DOMElement para ser usado en un DOMDocument
     * 
     * @param DOMDocument $doc Documento DOMDocument donde se insertará el DOMElement
     * 
     * @return DOMElement Objeto DOMElement que representa el objeto
     */
    public function toDOMElement(DOMDocument $doc): DOMElement
    {
        $CanonicalizationMethod = $doc->createElement('CanonicalizationMethod');
        $CanonicalizationMethod->setAttribute('Algorithm', $this->getAlgorithm());
        return $CanonicalizationMethod;
    }
    
    
}

?>