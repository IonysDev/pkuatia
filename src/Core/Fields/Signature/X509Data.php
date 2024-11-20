<?php

namespace IonysDev\Pkuatia\Core\Fields\Signature;

/**
 * Clase que representa el campo X509Data de la firma
 */
class X509Data 
{

    public String $X509Certificate;

    /**
     * Devuelve el certificado X509
     *
     * @return String
     */
    public function getX509Certificate(): String
    {
        return $this->X509Certificate;
    }

    /**
     * Establece el certificado X509
     *
     * @param String $X509Certificate
     *
     * @return self
     */
    public function setX509Certificate(String $X509Certificate): self
    {
        $this->X509Certificate = $X509Certificate;
        return $this;
    }

    /**
     * Instancia un objeto X509Data a partir de un SimpleXMLElement
     * 
     * @param \SimpleXMLElement $node
     * 
     * @return self
     */
    public static function FromSimpleXMLElement(\SimpleXMLElement $node): self
    {
        $res = new self();
        $res->setX509Certificate($node->X509Certificate);
        return $res;
    }

    /**
     * Instancia un objeto X509Data a partir de un DOMElement
     * 
     * @param \DOMElement $node
     * 
     * @return self
     */
    public static function FromDOMElement(\DOMElement $node): self
    {
        $res = new self();
        $res->setX509Certificate($node->getElementsByTagName('X509Certificate')->item(0)->nodeValue);
        return $res;
    }

    /**
     * Instancia un objeto X509Data a partir de un objeto stdClass de respuesta a una petición SOAP al SIFEN
     * 
     * @param \stdClass $object
     * 
     * @return self
     */
    public static function FromSifenResponseObject(\stdClass $object): self
    {
        $res = new self();
        $res->setX509Certificate($object->X509Certificate);
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
        $X509Data = $dom->createElement('X509Data');
        $X509Certificate = $dom->createElement('X509Certificate', $this->getX509Certificate());
        $X509Data->appendChild($X509Certificate);
        return $X509Data;
    }
    
}

?>