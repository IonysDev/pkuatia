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
        $res = new DOMElement('trGesEve');
        $res->appendChild($this->rEve->toDOMElement());
        return $res;
    }



    //====================================================//
    ///XML ELEMENT
    //====================================================//  
    
    /**
     * fromDOMElement
     *
     * @param  mixed $xml
     * @return TrGesEve
     */
    public static function fromDOMElement(DOMElement $xml): TrGesEve
    {
        if (strcmp($xml->tagName, 'trGesEve') == 0 && $xml->childElementCount == 1) {
            $res = new TrGesEve();

            $aux = new TrEve();
            $aux->fromDOMElement($xml->getElementsByTagName('rEve')->item(0)->nodeValue);
            $res->setEve($aux);

            return $res;
        } else {
            throw new \Exception("Invalid XML Element: $xml->tagName");
            return null;
        }
    }
}
