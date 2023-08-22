<?php

namespace Abiliomp\Pkuatia\Core\Fields\Signature;

class CanonicalizationMethod 
{
    public String $Algorithm;

    /**
     * Devuelve la URI del algoritmo de la canonicalización
     *
     * @return String
     */
    public function getAlgorithm(): String
    {
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
     * @param \SimpleXMLElement $node
     * 
     * @return self
     */
    public static function FromSimpleXMLElement(\SimpleXMLElement $node): self
    {
        $CanonicalizationMethod = new self();
        $CanonicalizationMethod->setAlgorithm($node->attributes()->Algorithm);
        return $CanonicalizationMethod;
    }

    ///////////////////////////////////////////////////////////////////////
    // Conversores
    ///////////////////////////////////////////////////////////////////////

    /**
     * Convierte el objeto a un DOMElement
     * 
     * @return \DOMElement
     */
    public function toDOMElement(): \DOMElement
    {
        $dom = new \DOMDocument();
        $CanonicalizationMethod = $dom->createElement('CanonicalizationMethod');
        $CanonicalizationMethod->setAttribute('Algorithm', $this->getAlgorithm());
        return $CanonicalizationMethod;
    }
    
    
}

?>