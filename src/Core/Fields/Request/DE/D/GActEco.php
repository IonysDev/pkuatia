<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\D;

use Abiliomp\Pkuatia\Config;
use DOMElement;

/**
 * ID:D130 Grupo de campos que describen la actividad económica del emisor PADRE:D100
 */

class GActEco
{

    public ?string $cActEco = null; // D131 - Código de la actividad económica del emisor 
    public ?string $dDesActEco = null; // D132 - Descripción de la actividad económica del emisor

  
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
        return $this->dDesActEco;////no se donde se consigue la tabla de actividades economicas
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

    /**
     * Set the value of dDesActEco
     *
     * @param ?string $dDesActEco
     *
     * @return self
     */
    public function setDDesActEco(?string $dDesActEco): self
    {
        $this->dDesActEco = $dDesActEco;

        return $this;
    }
}
