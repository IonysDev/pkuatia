<?php

namespace IonysDev\Pkuatia\Core\Fields\Signature;

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
     * Instancia un objeto KeyData a partir de un DOMElement
     *
     * @param \DOMElement $node
     *
     * @return self
     */
    public static function FromDOMElement(\DOMElement $node): self
    {
        $res = new self();
        $res->setX509Data(X509Data::FromDOMElement($node->getElementsByTagName('X509Data')->item(0)));
        return $res;
    }

    /**
     * Convierte el objeto a un DOMElement (KeyInfo con su X509Data).
     *
     * @param \DOMDocument|null $doc Documento en el que se crean los nodos. Null (comportamiento hasta 0.3.0) crea un
     *                               documento propio, cuyo nodo no puede colgarse de otro documento. Hasta 0.3.0 se
     *                               agregaba además un atributo xmlns:ds que ningún hijo usaba (Fase D, D8).
     *
     * @return \DOMElement
     */
    public function toDOMElement(?\DOMDocument $doc = null): \DOMElement
    {
        $doc ??= new \DOMDocument();
        $KeyInfo = $doc->createElement('KeyInfo');
        $KeyInfo->appendChild($this->getX509Data()->toDOMElement($doc));

        return $KeyInfo;
    }
}
