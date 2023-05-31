<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\D;

use DOMElement;

/**
 * ID:D130 Grupo de campos que describen la actividad económica del emisor PADRE:D100
 */

class GActEco
{

    public ?string $cActEco = null; // D131 - Código de la actividad económica del emisor 

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    public function setCActEco(string $cActEco): void
    {
        $this->cActEco = $cActEco;
    }

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

    public function getCActEco(): string | null
    {
        return $this->cActEco;
    }

    /**
     * D132 Descripción de la actividad económica del emisor
     *
     * @return string
     */
    public function getDDesActEco(): string | null
    {
        return "Mordor";
    }

    ///////////////////////////////////////////////////////////////////////
    // XML Element
    ///////////////////////////////////////////////////////////////////////

    public function toDOMElement(): DOMElement
    {
        $res = new DOMElement('gActEco');
        $res->appendChild(new DOMElement('cActEco', $this->cActEco));
        $res->appendChild(new DOMElement('dDesActEco', $this->getDDesActEco()));
        return $res;
    }

    // /**
    //  * fromDOMElement
    //  *
    //  * @param  mixed $xml
    //  * @return GActEco
    //  */
    // public static function fromDOMElement(DOMElement $xml): GActEco
    // {
    //     if (strcmp($xml->tagName, 'gActEco') == 0 && $xml->childElementCount >= 1) {
    //         $res = new GActEco();
    //         $res->setCActEco($xml->getElementsByTagName('cActEco')->item(0)->nodeValue);
    //         return $res;
    //     } else {
    //         throw new \Exception("Invalid XML Element: $xml->tagName");
    //         return null;
    //     }
    // }
    
    /**
     * fromResponse
     *
     * @param  mixed $response
     * @return self
     */
    public static function fromResponse($response):self
    {
        $res = new GActEco();
        $res->setCActEco($response->cActEco);
        return $res; 
    }
}
