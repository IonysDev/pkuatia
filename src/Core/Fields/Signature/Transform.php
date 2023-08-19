<?php

namespace Abiliomp\Pkuatia\Core\Fields\Signature;

/**
 * Clase que representa el campo Transform de la firma
 */
class Transform 
{

    public String $Algorithm;

    /**
     * Devuelve la URI del algoritmo de transformación
     *
     * @return String
     */
    public function getAlgorithm(): String
    {
        return $this->Algorithm;
    }

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
    // Instanciadores
    ///////////////////////////////////////////////////////////////////////

    /**
     * Instancia un objeto Transform a partir de un SimpleXMLElement
     * 
     * @param \SimpleXMLElement $node
     * 
     * @return self
     */
    public static function FromSimpleXMLElement(\SimpleXMLElement $node): self
    {
        $Transform = new self();
        $Transform->setAlgorithm($node->attributes()->Algorithm);
        return $Transform;
    }
    
}

?>