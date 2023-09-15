<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\Event\GDE;

use Abiliomp\Pkuatia\Core\Fields\DE\I\Signature;
use DOMElement;

/**
 * Nodo: GDE001 - rGesEve - Raíz de Gestión de Eventos
 * Padre: GDE000 - gGroupGesEve - Raiz del Grupo de Eventos
 */
class RrGesEve
{
    public REve $REve; // GDE002 - Grupos de campos generales del evento
    public Signature $signature; // GDE008 - Grupo de la firma digital

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

    public function getEve(): REve
    {
        return $this->REve;
    }

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    public function setREve(REve $REve): self
    {
        $this->REve = $REve;
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
        $res->appendChild($this->REve->toDOMElement());
        return $res;
    }



    ///////////////////////////////////////////////////////////////////////
    ///XML ELEMENT
    ///////////////////////////////////////////////////////////////////////  
    
    /**
     * fromDOMElement
     *
     * @param  mixed $xml
     * @return RrGesEve
     */
    public static function fromDOMElement(DOMElement $xml): RrGesEve
    {
        if (strcmp($xml->tagName, 'rGesEve') == 0 && $xml->childElementCount == 1) {
            $res = new RrGesEve();

            $aux = new REve();
            $aux->fromDOMElement($xml->getElementsByTagName('REve')->item(0)->nodeValue);
            $res->setREve($aux);

            return $res;
        } else {
            throw new \Exception("Invalid XML Element: $xml->tagName");
            return null;
        }
    }
}
