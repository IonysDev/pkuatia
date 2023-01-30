<?php

namespace Abiliomp\Pkuatia\Fields\Request\Events\GDE;

use DOMElement;

/**
 * Nodo: GDE001 - rGesEve - Raíz de Gestión de Eventos
 * Padre: GDE000 - gGroupGesEve - Raiz del Grupo de Eventos
 */
class TrGesEve
{
    public TrEve $rEve; // GDE002 - Grupos de campos generales del evento

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
        $res = new DOMElement('TrGesEve');
        $res->appendChild(new DOMElement('rEve', $this->toDOMElement()));
        return $res;
    }
}