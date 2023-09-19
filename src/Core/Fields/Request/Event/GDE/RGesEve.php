<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\Event\GDE;

use Abiliomp\Pkuatia\Core\Constants;
use DOMDocument;
use DOMElement;

/**
 * Nodo: GDE001 - rGesEve - Raíz de Gestión de Eventos
 * Padre: GDE000 - gGroupGesEve - Raiz del Grupo de Eventos
 */
class RGesEve
{
    public REve $REve; // GDE002 - Grupos de campos generales del evento

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

    public function getREve(): REve
    {
        if (isset($this->REve))
        return $this->REve;
        else
        throw new \Exception('El campo REve no ha sido definido.');
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
    public function toDOMElement(DOMDocument $doc): DOMElement
    {
        $res = $doc->createElement('rGesEve');
        $res->setAttribute('xsi:schemaLocation', Constants::SIFEN_NS_URI_RECEP_EVENTO);
        $res->setAttribute('xmlns:xsi', Constants::SIFEN_NS_XSI);
        $res->appendChild($this->REve->toDOMElement($doc));
        return $res;
    }

    // ///////////////////////////////////////////////////////////////////////
    // ///XML ELEMENT
    // ///////////////////////////////////////////////////////////////////////  

    // /**
    //  * fromDOMElement
    //  *
    //  * @param  mixed $xml
    //  * @return RrGesEve
    //  */
    // public static function fromDOMElement(DOMElement $xml): RGesEve
    // {
    //     if (strcmp($xml->tagName, 'rGesEve') == 0 && $xml->childElementCount == 1) {
    //         $res = new RGesEve();

    //         $aux = new REve();
    //         $aux->fromDOMElement($xml->getElementsByTagName('REve')->item(0)->nodeValue);
    //         $res->setREve($aux);

    //         return $res;
    //     } else {
    //         throw new \Exception("Invalid XML Element: $xml->tagName");
    //         return null;
    //     }
    // }
}
