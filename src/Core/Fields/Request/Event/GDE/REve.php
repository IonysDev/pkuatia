<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\Event\GDE;

use DOMElement;
use DateTime;

/**
 * Nodo: GDE002 - REve - Grupos de Campos Generales del Evento 
 * Padre: GDE001 - rGesEve - Raíz de Gestión de Eventos
 */
class REve
{
    public int          $Id;          // GDE003 - Identificador del evento - ATRIBUTO DEL CAMPO
    public DateTime     $dFecFirma;   // GDE004 - Fecha y Hora del firmado
    public int          $dVerFor;     // GDE005 - Versión del formato
    public GGroupTiEvt $gGroupTiEvt; // GDE007 - Grupo de campos del tipo de evento

    ///Setters

    /**
     * Set the value of Id
     *
     * @param int $Id
     *
     * @return self
     */
    public function setId(int $Id): self
    {
        $this->Id = $Id;

        return $this;
    }


    /**
     * Set the value of dFecFirma
     *
     * @param DateTime $dFecFirma
     *
     * @return self
     */
    public function setDFecFirma(DateTime $dFecFirma): self
    {
        $this->dFecFirma = $dFecFirma;

        return $this;
    }


    /**
     * Set the value of dVerFor
     *
     * @param int $dVerFor
     *
     * @return self
     */
    public function setDVerFor(int $dVerFor): self
    {
        $this->dVerFor = $dVerFor;

        return $this;
    }


    /**
     * Set the value of gGroupTiEvt
     *
     * @param TgGroupTiEvt $gGroupTiEvt
     *
     * @return self
     */
    public function setGGroupTiEvt(GGroupTiEvt $gGroupTiEvt): self
    {
        $this->gGroupTiEvt = $gGroupTiEvt;

        return $this;
    }

    //GETTERS
    

    /**
     * Get the value of Id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->Id;
    }

    /**
     * Get the value of dFecFirma
     *
     * @return DateTime
     */
    public function getDFecFirma(): DateTime
    {
        return $this->dFecFirma;
    }

    /**
     * Get the value of dVerFor
     *
     * @return int
     */
    public function getDVerFor(): int
    {
        return $this->dVerFor;
    }

    /**
     * Get the value of gGroupTiEvt
     *
     * @return TgGroupTiEvt
     */
    public function getGGroupTiEvt(): GGroupTiEvt
    {
        return $this->gGroupTiEvt;
    }
    

    ///////////////////////////////////////////////////////////////////////
    // Conversiones XML
    ///////////////////////////////////////////////////////////////////////

    /**
     * Función que genera el elemento DOM XML
     *
     * @return DOMElement
     */
    public function toDOMElement(): DOMElement
    {
        $res = new DOMElement('rEve');
        $res->setAttribute('Id', $this->Id);
        $res->appendChild(new DOMElement('dFecFirma', $this->dFecFirma->format('Y-m-d\TH:i:s')));
        $res->appendChild(new DOMElement('dVerFor', $this->dVerFor));
        $res->appendChild($this->gGroupTiEvt->toDOMElement());
        return $res;
    }
    
    /**
     * fromDOMElement
     *
     * @param  mixed $xml
     * @return REve
     */
    public static function fromDOMElement(DOMElement $xml): REve
    {
        if (strcmp($xml->tagName, 'rEve') == 0 && $xml->childElementCount == 4) {
            $res = new REve();
            $res->setId(intval($xml->getElementsByTagName('Id')->item(0)->nodeValue));
            $res->setDFecFirma(DateTime::createFromFormat("Y-m-d\TH:i:s",$xml->getElementsByTagName('dFecFirma')->item(0)->nodeValue));
            $res->setDVerFor(intval($xml->getElementsByTagName('dVerFor')->item(0)->nodeValue));

            ///children
            $aux = new GGroupTiEvt();
            $aux->fromDOMElement($xml->getElementsByTagName('gGroupTiEvt')->item(0)->nodeValue);
            $res->setGGroupTiEvt($aux);
            return $res;
          } else {
            throw new \Exception("Invalid XML Element: $xml->tagName");
            return null;
          }
    }

}