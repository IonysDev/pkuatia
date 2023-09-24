<?php

namespace Abiliomp\Pkuatia\Core\Fields\Signature;

use DOMElement;
use SimpleXMLElement;

/**
 * Clase que representa el campo DigestMethod de la firma
 */
class DigestMethod 
{
    public String $Algorithm;

    /**
     * Devuelve la URI del algoritmo utilizado para calcular el digest
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
     * Instancia un objeto DigestMethod a partir de un SimpleXMLElement
     * 
     * @param SimpleXMLElement $node
     * 
     * @return self
     */
    public static function FromSimpleXMLElement(SimpleXMLElement $node): self
    {
        $DigestMethod = new self();
        $DigestMethod->setAlgorithm($node->attributes()->Algorithm);
        return $DigestMethod;
    }

    /**
     * Instancia un objeto DigestMethod a partir de un DOMElement
     * 
     * @param DOMElement $node
     * 
     * @return self
     */
    public static function FromDOMElement(DOMElement $node): self
    {
        $DigestMethod = new self();
        $DigestMethod->setAlgorithm($node->getAttribute('Algorithm'));
        return $DigestMethod;
    }

    /**
     * Convierte el objeto a un DOMElement
     * 
     * @return DOMElement
     */
    public function toDOMElement(): DOMElement
    {
        $dom = new \DOMDocument();
        $DigestMethod = $dom->createElement('DigestMethod');
        $DigestMethod->setAttribute('Algorithm', $this->getAlgorithm());
        return $DigestMethod;
    }

}

?>