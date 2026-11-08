<?php

namespace IonysDev\Pkuatia\Core\Fields\DE\I;

use IonysDev\Pkuatia\Core\Fields\BaseSifenField;
use IonysDev\Pkuatia\Core\Fields\Signature\KeyInfo;
use IonysDev\Pkuatia\Core\Fields\Signature\SignedInfo;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;
use IonysDev\Pkuatia\Helpers\XmlHelper;
use IonysDev\Pkuatia\Core\Exceptions\ValidacionException;

/**
 * ID I001 - Firma Digital del DTE  PADRE:AA001
 */
class Signature extends BaseSifenField
{
    public SignedInfo $SignedInfo;
    public string $SignatureValue;
    public KeyInfo $KeyInfo;

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Establece la información de la firma
     *
     * @param SignedInfo $SignedInfo
     *
     * @return self
     */
    public function setSignedInfo(SignedInfo $SignedInfo): self
    {
        $this->SignedInfo = $SignedInfo;
        return $this;
    }

    /**
     * Establece el valor de la firma
     *
     * @param String $SignatureValue
     *
     * @return self
     */
    public function setSignatureValue(string $SignatureValue): self
    {
        $this->SignatureValue = $SignatureValue;
        return $this;
    }

    /**
     * Establece los datos de la llave X509
     *
     * @param KeyInfo $KeyInfo
     *
     * @return self
     */
    public function setKeyInfo(KeyInfo $KeyInfo): self
    {
        $this->KeyInfo = $KeyInfo;
        return $this;
    }


    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Devuelve la información de la firma
     *
     * @return SignedInfo
     */
    public function getSignedInfo(): ?SignedInfo
    {
        if (!isset($this->SignedInfo)) {
            return null;
        }
        return $this->SignedInfo;
    }

    /**
     * Devuelve el valor de la firma
     *
     * @return String
     */
    public function getSignatureValue(): ?string
    {
        if (!isset($this->SignatureValue)) {
            return null;
        }
        return $this->SignatureValue;
    }

    /**
     * Devuelve los datos de la llave X509
     *
     * @return KeyInfo
     */
    public function getKeyInfo(): ?KeyInfo
    {
        if (!isset($this->KeyInfo)) {
            return null;
        }
        return $this->KeyInfo;
    }


    ///////////////////////////////////////////////////////////////////////
    // Instanciadores
    ///////////////////////////////////////////////////////////////////////

    /**
     * Instancia un objeto Signature a partir de un SimpleXMLElement
     *
     * @param \SimpleXMLElement $node
     *
     * @return self
     */
    public static function FromSimpleXMLElement(SimpleXMLElement $node): self
    {
        if (strcmp($node->getName(), 'Signature') != 0) {
            throw new ValidacionException("[Signature] Invalid XML Node Name: " . $node->getName());
        }
        $res = new Signature();
        $res->setSignedInfo(SignedInfo::FromSimpleXMLElement($node->SignedInfo));
        $res->setSignatureValue($node->SignatureValue);
        $res->setKeyInfo(KeyInfo::FromSimpleXMLElement($node->KeyInfo));
        return $res;
    }

    /**
     * Instancia un objeto Signature a partir de un DOMElement
     *
     * @param DOMElement $node
     *
     * @return self
     */
    public static function FromDOMElement(DOMElement $node): self
    {
        if (strcmp($node->nodeName, 'Signature') != 0) {
            throw new ValidacionException("[Signature] Nodo de nombre inválido: " . $node->nodeName);
        }
        $res = new Signature();
        $res->setSignedInfo(SignedInfo::FromDOMElement($node->getElementsByTagName('SignedInfo')->item(0)));
        $res->setSignatureValue($node->getElementsByTagName('SignatureValue')->item(0)->nodeValue);
        $res->setKeyInfo(KeyInfo::FromDOMElement($node->getElementsByTagName('KeyInfo')->item(0)));
        return $res;
    }

    ///////////////////////////////////////////////////////////////////////
    // Conversores
    ///////////////////////////////////////////////////////////////////////

    /**
     * Convierte el objeto a un DOMElement con solo la cabecera
     *
     * @param DOMDocument $doc Documento DOM donde se agregará el nodo
     *
     * @return \DOMElement Nodo DOM que representa el objeto
     */
    public function toHeaderOnlyDOMElement(DOMDocument $doc): \DOMElement
    {
        // Hasta 0.3.0 ignoraba $doc y creaba un documento propio: el nodo no podía colgarse del rDE (Fase D, D8).
        $res = $doc->createElement('Signature');
        $res->setAttribute('xmlns', 'http://www.w3.org/2000/09/xmldsig#');
        return $res;
    }

    /**
     * Convierte este objeto Signature a un DOMElement que puede ser insertado en el DOMDocument especificado
     * (SignedInfo, SignatureValue y KeyInfo, en el orden del estándar, con xmlns de xmldsig en Signature).
     *
     * Límite (Fase D, D8, PK-32): el modelo tipado no conserva los nodos de texto del original. Los espacios y saltos de
     * línea del SignedInfo forman parte de lo que se firma, así que una firma reemitida desde estos objetos es
     * estructuralmente equivalente a la original pero NO verifica. Sirve para inspeccionar o construir la estructura de
     * una firma; para reemitir una firma que siga verificando, leer el rDE con RDE::FromDOMElement/FromSimpleXMLElement,
     * que conserva el XML original de la firma y lo copia byte a byte (ver RDE::$signatureXml). Hasta 0.3.0 este
     * método terminaba en DOMException "Wrong Document Error" porque KeyInfo y Reference creaban sus nodos en otro
     * documento.
     *
     * @param DOMDocument $doc DOMDocument que crea el DOMElement
     *
     * @return DOMElement Objeto Signature convertido a DOMElement
     */
    public function toDOMElement(DOMDocument $doc): DOMElement
    {
        $res = $this->toHeaderOnlyDOMElement($doc);
        $res->appendChild($this->SignedInfo->toDOMElement($doc));
        $res->appendChild(XmlHelper::elemento($doc, 'SignatureValue', $this->SignatureValue));
        $res->appendChild($this->KeyInfo->toDOMElement($doc));
        return $res;
    }


}
