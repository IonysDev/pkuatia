<?php

namespace Abiliomp\Pkuatia\Core\Fields\Signature;

class Reference 
{
    public String $URI;
    public array $Transforms;
    public DigestMethod $DigestMethod;
    public String $DigestValue;
    
    /**
     * Constructor de la clase Reference
     */
    public function __construct()
    {
        $this->Transforms = [];
    }

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Establece la URI del documento a firmar
     *
     * @param String $URI
     *
     * @return self
     */
    public function setURI(String $URI): self
    {
        $this->URI = $URI;
        return $this;
    }

    /**
     * Establece los algoritmos de transformación de la firma
     *
     * @param array $Transforms
     *
     * @return self
     */
    public function setTransforms(array $Transforms): self
    {
        $this->Transforms = $Transforms;
        return $this;
    }

    /**
     * Establece el algoritmo digest de la firma
     *
     * @param DigestMethod $DigestMethod
     *
     * @return self
     */
    public function setDigestMethod(DigestMethod $DigestMethod): self
    {
        $this->DigestMethod = $DigestMethod;
        return $this;
    }

    /**
     * Establece el valor del digest del documento a firmar
     *
     * @param String $DigestValue
     *
     * @return self
     */
    public function setDigestValue(String $DigestValue): self
    {
        $this->DigestValue = $DigestValue;
        return $this;
    }

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Devuelve la URI del documento a firmar
     *
     * @return String
     */
    public function getURI(): String
    {
        return $this->URI;
    }

    /**
     * Devuelve los algoritmos de transformación de la firma
     *
     * @return array
     */
    public function getTransforms(): array
    {
        return $this->Transforms;
    }

    /**
     * Devuelve el algoritmo digest de la firma
     *
     * @return DigestMethod
     */
    public function getDigestMethod(): DigestMethod
    {
        return $this->DigestMethod;
    }

    /**
     * Devuelve el valor del digest del documento a firmar
     *
     * @return String
     */
    public function getDigestValue(): String
    {
        return $this->DigestValue;
    }

    ///////////////////////////////////////////////////////////////////////
    // Instanciadores
    ///////////////////////////////////////////////////////////////////////

    /**
     * Instancia un objeto Reference a partir de SimpleXMLElement
     * 
     * @param SimpleXMLElement $Reference
     * 
     * @return self
     */
    public static function FromSimpleXMLElement(\SimpleXMLElement $Reference): self
    {
        $res = new self();
        $res->setURI((String) $Reference->attributes()->URI);
        if(isset($Reference->Transforms) && isset($Reference->Transforms->Transform) && count($Reference->Transforms->Transform) > 0) 
        {
            foreach($Reference->Transforms->Transform as $t)
            {
                $res->Transforms[] = Transform::FromSimpleXMLElement($t);
            }
        }
        $res->setDigestMethod(DigestMethod::FromSimpleXMLElement($Reference->DigestMethod));
        $res->setDigestValue((String) $Reference->DigestValue);
        return $res;
    }


}

?>