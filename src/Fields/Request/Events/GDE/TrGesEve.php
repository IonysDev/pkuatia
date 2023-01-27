<?php

namespace Abiliomp\Pkuatia\Fields\Request\events\GDE;

use DOMElement;

/**
 * ID: GDE001 Raíz de Gestión de Eventos - Nodo padre: GDE000 gGroupGesEve
 */
class TgGroupGesEve
{
    public TrEve $rEve; // GDE002 Grupos de campos generales del evento
    public TgGroupTiEvt $gGroupTiEvt; // GDE007 Grupo de campos del tipo de evento

    //====================================================//
    // Getters
    //====================================================//

    public function getEve(): TrEve
    {
        return $this->rEve;
    }

    //====================================================//
    // Setters
    //====================================================//

    public function setEve(TrEve $rEve): self
    {
        $this->rEve = $rEve;
        return $this;
    }

    /**
     * Función que genera el elemento DOM XML
     *
     * @return DOMElement
     */
    public function toDOMElement(): DOMElement
    {
        $res = new DOMElement('rGesEve');
        $res->appendChild(new DOMElement('rEve', $this->toDOMElement()));
        return $res;
    }
}