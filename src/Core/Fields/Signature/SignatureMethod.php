<?php

namespace IonysDev\Pkuatia\Core\Fields\Signature;

use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * Clase que representa el campo SignatureMethod de la firma
 */
class SignatureMethod 
{

    public String $Algorithm;    

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Establece la URI del algoritmo de la firma
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
     * Devuelve la URI del algoritmo de la firma
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
     * Instancia un objeto SignatureMethod a partir de un SimpleXMLElement
     * 
     * @param \SimpleXMLElement $node
     * 
     * @return self
     */
    public static function FromSimpleXMLElement(SimpleXMLElement $node): self
    {
        $SignatureMethod = new self();
        $SignatureMethod->setAlgorithm($node->attributes()->Algorithm);
        return $SignatureMethod;
    }

    /**
     * Instancia un objeto SignatureMethod a partir de un DOMElement
     * 
     * @param DOMElement $node
     * 
     * @return self
     */
    public static function FromDOMElement(DOMElement $node): self
    {
        $SignatureMethod = new self();
        $SignatureMethod->setAlgorithm($node->getAttribute('Algorithm'));
        return $SignatureMethod;
    }

    ///////////////////////////////////////////////////////////////////////
    // Conversores
    ///////////////////////////////////////////////////////////////////////
    
    /**
     * Convierte este SignatureMethod a un DOMElement para ser usado en un DOMDocument
     * 
     * @param DOMDocument $doc Documento DOMDocument donde se podrá usarse el DOMElement
     * 
     * @return DOMElement DOMElement generado
     */
    public function toDOMElement(DOMDocument $doc): DOMElement
    {
        $SignatureMethod = $doc->createElement('SignatureMethod');
        $SignatureMethod->setAttribute('Algorithm', $this->getAlgorithm());
        return $SignatureMethod;
    }
    
}

?>