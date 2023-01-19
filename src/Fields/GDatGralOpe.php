<?php

namespace Abiliomp\Pkuatia\Fields;

use DateTime;
use DOMElement;

/**
 * Campos generales del DE (D001)
 * Nodo padre DE (A001): Campos firmados del DE
 */

class GDatGralOpe {

    public DateTime $dFeEmiDE; // Fecha y hora de emisión del DE (D002) AAAA-MM-DDThh:mm:ss
    public GOpeCom $gOpeCom; // Campos inherentes a la operación comercial (D010)
    public GEmis $gEmis; // Grupo de campos que identifican al emisor (D100)
    public GDatRec $gDatRec; // Grupo de campos que identifican al receptor (D200)

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    public function setDFeEmiDE(DateTime $dFeEmiDE): void
    {
        $this->dFeEmiDE = $dFeEmiDE;
    }

    public function setGOpeCom(GOpeCom $gOpeCom): void
    {
        $this->gOpeCom = $gOpeCom;
    }

    public function setGEmis(GEmis $gEmis): void
    {
        $this->gEmis = $gEmis;
    }

    public function setGDatRec(GDatRec $gDatRec): void
    {
        $this->gDatRec = $gDatRec;
    }

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

    public function getDFeEmiDE(): DateTime
    {
        return $this->dFeEmiDE;
    }
    
    public function getGOpeCom(): GOpeCom
    {
        return $this->gOpeCom;
    }
    
    public function getGEmis(): GEmis
    {
        return $this->gEmis;
    }
    
    public function getGDatRec(): GDatRec
    {
        return $this->gDatRec;
    }

    ///////////////////////////////////////////////////////////////////////
    // XML Element
    ///////////////////////////////////////////////////////////////////////

    public function toDOMElement(): DOMElement
    {
        $res = new DOMElement('gDatGralOpe');
        $res->appendChild(new DOMElement('dFeEmiDE', $this->dFeEmiDE->format('Y-m-d\TH:i:s')));
        if(isset($this->gOpeCom)){
            $res->appendChild($this->gOpeCom->toDOMElement());
        }
        if(isset($this->gEmis)){
            $res->appendChild($this->gEmis->toDOMElement());
        }
        if(isset($this->gDatRec)){
            $res->appendChild($this->gDatRec->toDOMElement());
        }
        return $res;
    }

}

?> 