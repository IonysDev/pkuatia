<?php

namespace Abiliomp\Pkuatia\Core\Fields\Signature;

/**
 * Clase que representa el campo SignatureMethod de la firma
 */
class SignatureMethod 
{

    public String $Algorithm;

    /**
     * Devuelve la URI del algoritmo de la firma
     *
     * @return String
     */
    public function getAlgorithm(): String
    {
        return $this->Algorithm;
    }

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

    /**
     * Instancia un objeto SignatureMethod a partir de un SimpleXMLElement
     * 
     * @param \SimpleXMLElement $node
     * 
     * @return self
     */
    public static function FromSimpleXMLElement(\SimpleXMLElement $node): self
    {
        $SignatureMethod = new self();
        $SignatureMethod->setAlgorithm($node->attributes()->Algorithm);
        return $SignatureMethod;
    }
    
}

?>