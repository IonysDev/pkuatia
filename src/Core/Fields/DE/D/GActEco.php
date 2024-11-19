<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\D;

use Abiliomp\Pkuatia\Core\Fields\BaseSifenField;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id:     D130
 * Nombre:      gActEco
 * Descripción: Grupo de campos que describen la actividad económica del emisor.
 * Nodo Padre:  D100 - gEmis - Grupo de campos que identifican al emisor 
 */
class GActEco extends BaseSifenField
{
                               // Id - Longitud - Ocurrencia - Descripción
    public String $cActEco;    // D131 - 1-8   - 1-1 - Código de la actividad económica del emisor 
    public String $dDesActEco; // D132 - 1-300 - 1-1 - Descripción de la actividad económica del emisor

    ///////////////////////////////////////////////////////////////////////
    // Constructor
    ///////////////////////////////////////////////////////////////////////

    /**
     * Constructor de la clase GActEco
     *
     * @param String $cActEco Código de la actividad económica del emisor.
     * @param String $dDesActEco Descripción de la actividad económica del emisor.
     *
     * @return self
     */
    public function __construct(String $cActEco = '', String $dDesActEco = '')
    {
        $this->cActEco = $cActEco;
        $this->dDesActEco = $dDesActEco;
    }
  
    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Establece el valor de cActEco (D131) que representa el código de la actividad económica del emisor.
     * 
     * @param String $cActEco
     * 
     * @return self
     */
    public function setCActEco(String $cActEco): self
    {
        $this->cActEco = $cActEco;
        return $this;
    }

    /**
     * Establece el valor de dDesActEco (D132) que representa la descripción de la actividad económica del emisor.
     *
     * @param String $dDesActEco
     *
     * @return self
     */
    public function setDDesActEco(String $dDesActEco): self
    {
        $this->dDesActEco = $dDesActEco;
        return $this;
    }

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Devuelve el valor de cActEco (D131) que representa el código de la actividad económica del emisor.
     * 
     * @return String
     */
    public function getCActEco(): String
    {
        return $this->cActEco;
    }

    /**
     * Devuelve el valor de dDesActEco (D132) que representa la descripción de la actividad económica del emisor.
     *
     * @return String
     */
    public function getDDesActEco(): String
    {
        return $this->dDesActEco;
    }

    ///////////////////////////////////////////////////////////////////////
    // Instanciadores
    ///////////////////////////////////////////////////////////////////////

    /**
     * Instancia un objeto GActEco a partir de un DOMElement con los datos del mismo.
     * 
     * @param  DOMElement $node Nodo DOM que contiene los datos del objeto.
     * 
     * @return self Objeto GActEco instanciado.
     */
    public static function FromDOMElement(DOMElement $node): self
    {
        if(strcmp($node->nodeName, 'gActEco') != 0)
            throw new \Exception('[GActEco] Nodo con nombre inválido: ' . $node->nodeName);
        $res = new self();
        $res->setCActEco(trim(strval($node->getElementsByTagName('cActEco')->item(0)->nodeValue)));
        $res->setDDesActEco(trim(strval($node->getElementsByTagName('dDesActEco')->item(0)->nodeValue)));
        return $res;
    }

    /**
     * Instancia un objeto GActEco a partir de un SimpleXMLElement
     *
     * @param  SimpleXMLElement $node
     * 
     * @return self
     */
    public static function FromSimpleXMLElement(SimpleXMLElement $node) 
    {
        if(strcmp($node->getName(), 'gActEco') != 0)
            throw new \Exception('[GActEco] Nodo con nombre inválido: ' . $node->getName());
        $res = new GActEco();
        $res->setCActEco(strval($node->cActEco));
        $res->setDDesActEco(strval($node->dDesActEco));
        return $res;
    }

    /**
     * Instancia un objeto GActEco a partir de un objeto stdClass que contiene los datos de respuesa SOAP del SIFEN.
     *
     * @param stdClass $object Objeto respuesta del SIFEN.
     * 
     * @return self Objeto GActEco instanciado.
     */
    public static function FromSifenResponseObject(stdClass $object):self
    {
        $res = new GActEco();
        if(isset($object->cActEco))
            $res->setCActEco($object->cActEco);
        if(isset($object->dDesActEco))
            $res->setDDesActEco($object->dDesActEco);
        return $res; 
    }

    ///////////////////////////////////////////////////////////////////////
    // Conversores
    ///////////////////////////////////////////////////////////////////////

    /**
     * Convierte este GActEco en un DOMElement generado en el DOMDocument especificado.
     * 
     * @param DOMDocument $doc DOMDocument que generará el DOMElement.
     *
     * @return DOMElement DOMElement creado pero no insertado.
     */
    public function toDOMElement(DOMDocument $doc): DOMElement
    {
        $res = $doc->createElement('gActEco');
        $res->appendChild(new DOMElement('cActEco', $this->getCActEco()));
        $res->appendChild(new DOMElement('dDesActEco', $this->getDDesActEco()));
        return $res;
    }    
}
