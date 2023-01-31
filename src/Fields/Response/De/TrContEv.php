<?php

namespace Abiliomp\Pkuatia\Fields\Response\De;

use Abiliomp\Pkuatia\Fields\Request\Events\GDE\TrGesEve;
use Abiliomp\Pkuatia\Fields\Response\Event\TgResProcEVe;
use DOMElement;

/**
 * Nodo: ContEv01 - Elemento Raíz de Contenedor de Evento
 */
class TrContEv
{
    public TrGesEve $xEvento;              //ContEv02 - XML del Evento
    public TgResProcEVe $rResEnviEventoDe; //ContEv03 - Respuesta del WS Recepción Evento 


    //====================================================//
    // Setters
    //====================================================//

    /**
     * Establece el valor de xEvento
     *
     * @param TrGesEve $xEvento
     *
     * @return self
     */
    public function setXEvento(TrGesEve $xEvento): self
    {
        $this->xEvento = $xEvento;
        return $this;
    }

    /**
     * Establece el valor de rResEnviEventoDe
     *
     * @param TgResProcEVe $rResEnviEventoDe
     *
     * @return self
     */
    public function setRResEnviEventoDe(TgResProcEVe $rResEnviEventoDe): self
    {
        $this->rResEnviEventoDe = $rResEnviEventoDe;
        return $this;
    }


    //====================================================//
    // Getters
    //====================================================//

    /**
     * Obtiene el valor de xEvento
     *
     * @return TrGesEve
     */
    public function getXEvento(): TrGesEve
    {
        return $this->xEvento;
    }

    /**
     * Obtiene el valor de rResEnviEventoDe
     *
     * @return TgResProcEVe
     */
    public function getRResEnviEventoDe(): TgResProcEVe
    {
        return $this->rResEnviEventoDe;
    }


    //====================================================//
    // Conversiones XML
    //====================================================// 

    /**
     * toDOMElement
     *
     * @return DOMElement
     */
    public function toDOMElement(): DOMElement
    {
        $res = new DOMElement('TrContEv');
        $res->appendChild($this->xEvento->toDOMElement());
        $res->appendChild($this->rResEnviEventoDe->toDOMElement());
        return $res;
    }

    public static function fromDOMElement(DOMElement $xml): TrContEv
    {
        $res = new TrContEv();
        // To Do!
        
        return $res;
    }
}
