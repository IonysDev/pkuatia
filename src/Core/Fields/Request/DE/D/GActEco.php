<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\D;

use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id: D130 
 * Descripción: Grupo de campos que describen la actividad económica del emisor.
 * Nodo Padre: D100 - Grupo de campos que identifican al emisor 
 */

class GActEco
{

    public String $cActEco;    // D131 - Código de la actividad económica del emisor 
    public String $dDesActEco; // D132 - Descripción de la actividad económica del emisor
  
    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Establece el valor de cActEco que representa el código de la actividad económica del emisor.
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
     * Establece el valor de dDesActEco que representa la descripción de la actividad económica del emisor.
     *
     * @param ?String $dDesActEco
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
     * Devuelve el valor de cActEco que representa el código de la actividad económica del emisor.
     * El mismo corresponde al nodo D131 del manual técnico.
     * 
     * @return String
     */
    public function getCActEco(): String
    {
        return $this->cActEco;
    }

    /**
     * Devuelve el valor de dDesActEco que representa la descripción de la actividad económica del emisor.
     * El mismo corresponde al nodo D132 del manual técnico.
     *
     * @return String
     */
    public function getDDesActEco(): String
    {
        return $this->dDesActEco;
    }

    ///////////////////////////////////////////////////////////////////////
    // XML Element
    ///////////////////////////////////////////////////////////////////////

    /**
     * Instancia la clase a partir de un SimpleXMLElement
     *
     * @param  SimpleXMLElement $node
     * 
     * @return self
     */
    public static function FromSimpleXMLElement(SimpleXMLElement $node) 
    {
        if(strcmp($node->getName(), 'gActEco') != 0)
        {
            throw new \Exception('El nombre del nodo debe ser "gActEco"');
        }
        $res = new GActEco();
        $res->setCActEco((String) $node->cActEco);
        $res->setDDesActEco((String) $node->dDesActEco);
        return $res;
    }


    
    public function toDOMElement(): DOMElement
    {
        $res = new DOMElement('gActEco');
        $res->appendChild(new DOMElement('cActEco', $this->cActEco));
        $res->appendChild(new DOMElement('dDesActEco', $this->getDDesActEco()));
        return $res;
    }
    
    /**
     * fromResponse
     *
     * @param  mixed $response
     * @return self
     */
    public static function fromResponse($response):self
    {
        $res = new GActEco();
        if(isset($response->cActEco))
        {
            $res->setCActEco($response->cActEco);
        }
        if(isset($response->dDesActEco))
        {
            $res->setDDesActEco($response->dDesActEco);
        }

        return $res; 
    }

    
}
