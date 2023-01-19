<?php

namespace Abiliomp\Pkuatia\Fields;

use DOMElement;

/**
 * Campos que describen la actividad económica del emisor (D130)
 * Nodo Padre gEmis (D100): Campos que identifican al emisor del Documento Electrónico DE
 */

class GActEco {
    
    public string $cActEco; // Código de la actividad económica del emisor 
    public string $dDesActEco; // Descripción de la actividad económica del emisor

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    public function setCActEco(string $cActEco): void
    {
        $this->cActEco = $cActEco;
    }

    public function setDDesActEco(string $dDesActEco): void
    {
        $this->dDesActEco = $dDesActEco;
    }

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

    public function getCActEco(): string
    {
        return $this->cActEco;
    }

    public function getDDesActEco(): string
    {
        return $this->dDesActEco;
    }

    ///////////////////////////////////////////////////////////////////////
    // XML Element
    ///////////////////////////////////////////////////////////////////////

    public function toDOMElement(): DOMElement
    {
        $res = new DOMElement('gActEco');
        $res->appendChild(new DOMElement('cActEco', $this->cActEco));
        $res->appendChild(new DOMElement('dDesActEco', $this->dDesActEco));
        return $res;
    }

}

?> 