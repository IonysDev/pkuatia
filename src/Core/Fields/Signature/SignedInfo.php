<?php

namespace Abiliomp\Pkuatia\Core\Fields\Signature;

class SignedInfo 
{
    public CanonicalizationMethod $CanonicalizationMethod;
    public SignatureMethod $SignatureMethod;
    public Reference $Reference;
    
    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Establece el algoritmo de canonicalización de la firma
     *
     * @param CanonicalizationMethod $CanonicalizationMethod
     *
     * @return self
     */
    public function setCanonicalizationMethod(CanonicalizationMethod $CanonicalizationMethod): self
    {
        $this->CanonicalizationMethod = $CanonicalizationMethod;
        return $this;
    }

    /**
     * Establece el algoritmo de firma de la firma
     *
     * @param SignatureMethod $SignatureMethod
     *
     * @return self
     */
    public function setSignatureMethod(SignatureMethod $SignatureMethod): self
    {
        $this->SignatureMethod = $SignatureMethod;
        return $this;
    }

    /**
     * Establece la referencia de la firma
     *
     * @param Reference $Reference
     *
     * @return self
     */
    public function setReference(Reference $Reference): self
    {
        $this->Reference = $Reference;
        return $this;
    }

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Devuelve el algoritmo de canonicalización de la firma
     *
     * @return CanonicalizationMethod
     */
    public function getCanonicalizationMethod(): CanonicalizationMethod
    {
        return $this->CanonicalizationMethod;
    }

    /**
     * Devuelve el algoritmo de firma de la firma
     *
     * @return SignatureMethod
     */
    public function getSignatureMethod(): SignatureMethod
    {
        return $this->SignatureMethod;
    }

    /**
     * Devuelve la referencia de la firma
     *
     * @return Reference
     */
    public function getReference(): Reference
    {
        return $this->Reference;
    }

    ///////////////////////////////////////////////////////////////////////
    // Instanciadores
    ///////////////////////////////////////////////////////////////////////

    /**
     * Instancia un objeto SignedInfo a partir de un SimpleXMLElement
     * 
     * @param \SimpleXMLElement $node
     * 
     * @return self
     */
    public static function FromSimpleXMLElement(\SimpleXMLElement $node): self
    {
        $SignedInfo = new self();
        $SignedInfo->setCanonicalizationMethod(CanonicalizationMethod::FromSimpleXMLElement($node->CanonicalizationMethod));
        $SignedInfo->setSignatureMethod(SignatureMethod::FromSimpleXMLElement($node->SignatureMethod));
        $SignedInfo->setReference(Reference::FromSimpleXMLElement($node->Reference));
        return $SignedInfo;
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
        $doc = new \DOMDocument();
        $res = $doc->createElement('SignedInfo');

        $importNode = $doc->importNode($this->CanonicalizationMethod->toDOMElement(), true);
        $res->appendChild($importNode);

        $importNode = $doc->importNode($this->SignatureMethod->toDOMElement(), true);
        $res->appendChild($importNode);


        $importNode = $doc->importNode($this->Reference->toDOMElement(), true);
        $res->appendChild($importNode);

        return $res;
    }
}

?>