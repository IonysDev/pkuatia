<?php

namespace IonysDev\Pkuatia\Core\Fields\Response\DE;

use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\RGesEve;
use IonysDev\Pkuatia\Core\Responses\RRetEnviEventoDe;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo: ContEv01 - Elemento Raíz de Contenedor de Evento
 */
class RContEv
{
                                               // ID - DESCRIPCION- LONGITUD - OCURRENCIA
    public RGesEve $xEvento;                   // ContEv02 - XML del Evento - X - 1-1
    public RRetEnviEventoDe $rResEnviEventoDe; // ContEv03 - Respuesta del WS Recepción Evento  X - ??


    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Establece el valor de xEvento
     *
     * @param RGesEve $xEvento
     *
     * @return self
     */
    public function setXEvento(RGesEve $xEvento): self
    {
        $this->xEvento = $xEvento;
        return $this;
    }

    /**
     * Establece el valor de rResEnviEventoDe
     *
     * @param RRetEnviEventoDe $rResEnviEventoDe
     *
     * @return self
     */
    public function setRResEnviEventoDe(RRetEnviEventoDe $rResEnviEventoDe): self
    {
        $this->rResEnviEventoDe = $rResEnviEventoDe;
        return $this;
    }


    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Obtiene el valor de xEvento
     *
     * @return RGesEve
     */
    public function getXEvento(): RGesEve
    {
        return $this->xEvento;
    }

    /**
     * Obtiene el valor de rResEnviEventoDe
     *
     * @return GResProcEVe
     */
    public function getRResEnviEventoDe(): RRetEnviEventoDe
    {
        return $this->rResEnviEventoDe;
    }


    ///////////////////////////////////////////////////////////////////////
    // Conversiones XML
    /////////////////////////////////////////////////////////////////////// 

    /**
     * toDOMElement
     *
     * @return DOMElement
     */
    // public function toDOMElement(): DOMElement
    // {
    //     $res = new DOMElement('rContEv');
    //     $res->appendChild($this->xEvento->toDOMElement());
    //     $res->appendChild($this->rResEnviEventoDe->toDOMElement());
    //     return $res;
    // }

    // /**
    //  * fromDOMElement
    //  *
    //  * @param  mixed $xml
    //  * @return RContEv
    //  */
    // public static function fromDOMElement(DOMElement $xml): self
    // {
    //     if (strcmp($xml->tagName, 'rContEv') == 0 && $xml->childElementCount == 2) {
    //         $res = new RContEv();

    //         $aux = new RGesEve;
    //         $aux->fromDOMElement($xml->getElementsByTagName('xEvento')->item(0)->nodeValue);
    //         $res->setXEvento($aux);

    //         $aux = new GResProcEVe;
    //         $aux->fromDOMElement($xml->getElementsByTagName('rResEnviEventoDe')->item(0)->nodeValue);
    //         $res->setRResEnviEventoDe($aux);

    //         return $res;

    //     } else {
    //         throw new \Exception("Invalid XML Element: $xml->tagName");
    //         return null;
    //     }
    // }

    /**
     * FromSimpleXMLElement
     *
     * @param  mixed $xml
     * @return self
     */
    public static function FromSimpleXMLElement(SimpleXMLElement $node): self
    {
        if (strcmp($node->getName(), 'rContEv') != 0) {
            throw new \Exception("Invalid XML Element:". $node->getName());
            return null;
        }

        $res = new self();

        if(isset($node->xEvento)) {
           $res->setXEvento(RGesEve::FromSimpleXMLElement($node->xEvento->rGesEve));
        } 

        if(isset($node->rResEnviEventoDe))
        {
          $res->setRResEnviEventoDe(RRetEnviEventoDe::FromSimpleXMLElement($node->rResEnviEventoDe->rRetEnviEventoDe));
        }


        return $res;
    }
}
