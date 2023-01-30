<?php

namespace Abiliomp\Pkuatia\Fields\Request\Events\GDE;

use DOMElement;
use DateTime;

/**
 * Nodo: GDE002 - rEve - Grupos de Campos Generales del Evento 
 * Padre: GDE001 - rGesEve - Raíz de Gestión de Eventos
 */
class TrEve
{
    public int          $Id;          // GDE003 - Identificador del evento - ATRIBUTO DEL CAMPO
    public DateTime     $dFecFirma;   // GDE004 - Fecha y Hora del firmado
    public int          $dVerFor;     // GDE005 - Versión del formato
    public TgGroupTiEvt $gGroupTiEvt; // GDE007 - Grupo de campos del tipo de evento

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
    public function setGGroupTiEvt(TgGroupTiEvt $gGroupTiEvt): self
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
    public function getGGroupTiEvt(): TgGroupTiEvt
    {
        return $this->gGroupTiEvt;
    }
    

    //====================================================//
    // Conversiones XML
    //====================================================//

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
        $res->appendChild(new DOMElement('gGroupTiEvt', $this->gGroupTiEvt->toDOMElement()));
        return $res;
    }

}