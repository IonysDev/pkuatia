<?php

namespace Abiliomp\Pkuatia\Core\Fields\Signature;

use DOMDocument;
use DOMElement;
use SimpleXMLElement;

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
    public static function FromSimpleXMLElement(SimpleXMLElement $node): self
    {
        $SignedInfo = new self();
        $SignedInfo->setCanonicalizationMethod(CanonicalizationMethod::FromSimpleXMLElement($node->CanonicalizationMethod));
        $SignedInfo->setSignatureMethod(SignatureMethod::FromSimpleXMLElement($node->SignatureMethod));
        $SignedInfo->setReference(Reference::FromSimpleXMLElement($node->Reference));
        return $SignedInfo;
    }

    /**
     * Instancia un objeto SignedInfo a partir de un DOMElement
     * 
     * @param DOMElement $node
     * 
     * @return self
     */
    public static function FromDOMElement(DOMElement $node): self
    {
        $SignedInfo = new self();
        $SignedInfo->setCanonicalizationMethod(CanonicalizationMethod::FromDOMElement($node->getElementsByTagName("CanonicalizationMethod")->item(0)));
        $SignedInfo->setSignatureMethod(SignatureMethod::FromDOMElement($node->getElementsByTagName("SignatureMethod")->item(0)));
        $SignedInfo->setReference(Reference::FromDOMElement($node->getElementsByTagName("Reference")->item(0)));
        return $SignedInfo;
    }

    ///////////////////////////////////////////////////////////////////////
    // Conversores
    ///////////////////////////////////////////////////////////////////////

    /**
     * Convierte este SignedInfo a un DOMElement para ser usado en un DOMDocument determinado.
     *
     * @param DOMDocument $doc DOMDocument con el que se generará el elemento.
     * 
     * @return DOMElement Elemento DOM que representa este SignedInfo.
     */
    public function toDOMElement(DOMDocument $doc): \DOMElement
    {
        $res = $doc->createElement('SignedInfo');
        $res->appendChild($this->CanonicalizationMethod->toDOMElement($doc));
        $res->appendChild($this->SignatureMethod->toDOMElement($doc));
        $res->appendChild($this->Reference->toDOMElement($doc));
        return $res;
    }
}

?>