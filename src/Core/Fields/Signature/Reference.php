<?php

namespace IonysDev\Pkuatia\Core\Fields\Signature;

use DOMElement;
use IonysDev\Pkuatia\Helpers\XmlHelper;

class Reference
{
    public string $URI;
    public array $Transforms;
    public DigestMethod $DigestMethod;
    public string $DigestValue;

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
    public function setURI(string $URI): self
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
    public function setDigestValue(string $DigestValue): self
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
    public function getURI(): string
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
    public function getDigestValue(): string
    {
        return $this->DigestValue;
    }

    ///////////////////////////////////////////////////////////////////////
    // Instanciadores
    ///////////////////////////////////////////////////////////////////////

    /**
     * Instancia un objeto Reference a partir de SimpleXMLElement
     *
     * @param \SimpleXMLElement $Reference
     *
     * @return self
     */
    public static function FromSimpleXMLElement(\SimpleXMLElement $Reference): self
    {
        $res = new self();
        $res->setURI((string) $Reference->attributes()->URI);
        if (isset($Reference->Transforms) && isset($Reference->Transforms->Transform) && count($Reference->Transforms->Transform) > 0) {
            foreach ($Reference->Transforms->Transform as $t) {
                $res->Transforms[] = Transform::FromSimpleXMLElement($t);
            }
        }
        $res->setDigestMethod(DigestMethod::FromSimpleXMLElement($Reference->DigestMethod));
        $res->setDigestValue((string) $Reference->DigestValue);
        return $res;
    }

    /**
     * Instancia un objeto Reference a partir de un DOMElement
     *
     * @param DOMElement $node
     *
     * @return self
     */
    public static function FromDOMElement(DOMElement $node): self
    {
        $res = new self();
        $res->setURI((string) $node->getAttribute('URI'));
        // Hasta 0.3.0 recorría los contenedores Transforms (uno) en vez de los Transform (dos): se perdían los
        // algoritmos de las transformaciones (Fase D, D8).
        if ($node->getElementsByTagName("Transform")->length > 0) {
            foreach ($node->getElementsByTagName("Transform") as $t) {
                $res->Transforms[] = Transform::FromDOMElement($t);
            }
        }
        $res->setDigestMethod(DigestMethod::FromDOMElement($node->getElementsByTagName("DigestMethod")->item(0)));
        $res->setDigestValue((string) $node->getElementsByTagName("DigestValue")->item(0)->nodeValue);
        return $res;
    }

    ///////////////////////////////////////////////////////////////////////
    // Conversores
    ///////////////////////////////////////////////////////////////////////

    /**
     * Convierte el objeto a un DOMElement (Transforms, DigestMethod y DigestValue, en ese orden).
     *
     * @param \DOMDocument|null $doc Documento en el que se crean los nodos. Null (comportamiento hasta 0.3.0) crea un
     *                               documento propio, cuyo nodo no puede colgarse de otro documento (Fase D, D8).
     *
     * @return \DOMElement
     */
    public function toDOMElement(?\DOMDocument $doc = null): \DOMElement
    {
        $doc ??= new \DOMDocument();
        $res = $doc->createElement('Reference');
        $res->setAttribute('URI', $this->getURI());
        if (count($this->getTransforms()) > 0) {
            $transforms = $doc->createElement('Transforms');
            foreach ($this->getTransforms() as $t) {
                $transforms->appendChild($t->toDOMElement($doc));
            }
            $res->appendChild($transforms);
        }
        $res->appendChild($this->getDigestMethod()->toDOMElement($doc));
        $res->appendChild(XmlHelper::elemento($doc, 'DigestValue', $this->getDigestValue()));
        return $res;
    }

}
