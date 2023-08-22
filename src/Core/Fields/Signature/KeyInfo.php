<?php

namespace Abiliomp\Pkuatia\Core\Fields\Signature;

/**
 * Clase que representa el campo KeyData de la firma
 */
class KeyInfo 
{

    public X509Data $X509Data;

    /**
     * Devuelve los datos del certificado X509
     *
     * @return X509Data
     */
    public function getX509Data(): X509Data
    {
        return $this->X509Data;
    }

    /**
     * Establece los datos del certificado X509
     *
     * @param X509Data $X509Data
     *
     * @return self
     */
    public function setX509Data(X509Data $X509Data): self
    {
        $this->X509Data = $X509Data;
        return $this;
    }

    /**
     * Instancia un objeto KeyData a partir de un SimpleXMLElement
     * 
     * @param \SimpleXMLElement $node
     * 
     * @return self
     */
    public static function FromSimpleXMLElement(\SimpleXMLElement $node): self
    {
        $res = new self();
        $res->setX509Data(X509Data::FromSimpleXMLElement($node->X509Data));
        return $res;
    }
    
    /**
     * Convierte el objeto a un DOMElement
     * 
     * @return \DOMElement
     */
    public function toDOMElement(): \DOMElement
    {
        $dom = new \DOMDocument();
        $KeyInfo = $dom->createElement('KeyInfo');
        $KeyInfo->setAttribute('xmlns:ds', 'http://www.w3.org/2000/09/xmldsig#');

        $importNode = $dom->importNode($this->getX509Data()->toDOMElement(), true);
        $KeyInfo->appendChild($importNode);

        return $KeyInfo;
    }
}

?>