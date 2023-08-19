<?php

namespace Abiliomp\Pkuatia\Core\Fields\Signature;

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
     * @param \SimpleXMLElement $node
     * 
     * @return self
     */
    public static function FromSimpleXMLElement(\SimpleXMLElement $node): self
    {
        $DigestMethod = new self();
        $DigestMethod->setAlgorithm($node->attributes()->Algorithm);
        return $DigestMethod;
    }

}

?>