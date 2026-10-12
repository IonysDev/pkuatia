<?php

namespace IonysDev\Pkuatia\Core\Responses;

use IonysDev\Pkuatia\Core\Fields\Response\RProtDe;
use stdClass;
use IonysDev\Pkuatia\Core\Exceptions\RespuestaException;
use IonysDev\Pkuatia\Core\Constants\EstadoResultado;
use DateTime;
use IonysDev\Pkuatia\Core\Fields\Response\GResProc;

/**
 * Nodo Id:     ARSch01
 * Nombre:      rRetEnviDe
 * Descripción: Clase que representa la respuesta de la recepcion de documentos electronicos.
 * Nodo Padre:  Es raíz.
 */

class RRetEnviDe implements RespuestaSifen {

    public RProtDe $rProtDe; // Valor convertido a objeto del XML de protocolo de procesamiento de documento electrónico.

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Establece el valor en XML del xProtDe de la respuesta.
     * 
     * @param RProtDe $rProtDe
     * 
     * @return self
     */
    public function setRProtDe(RProtDe $rProtDe): self
    {
        $this->rProtDe = $rProtDe;
        return $this;
    }

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////
    
    /**
     * Obtiene el valor en XML del xProtDe de la respuesta.
     * 
     * @return RProtDe
     */
    public function getRProtDe(): RProtDe
    {
        return $this->rProtDe;
    }

    ///////////////////////////////////////////////////////////////////////
    // Instanciadores
    ///////////////////////////////////////////////////////////////////////

    /**
     * Crea una nueva instancia de RRetEnviDe a partir de un objeto stdClass.
     * Pensado para castear la respuesta a una llamada SOAP al SIFEN.
     * 
     * @param stdClass $object
     * 
     * @return self
     */
    public static function FromSifenResponseObject($object)
    {
        if(is_null($object))
        {
            throw new RespuestaException("Error Processing Request: null", 1);
        }
        
        $res = new RRetEnviDe();
        $res->setRProtDe(RProtDe::FromSifenResponseObject($object->rProtDe));
        return $res;
    }

    use RespuestaSifenTrait;

    // --- Fase C (C6): RespuestaSifen y lectura del resultado -------------------------------------------------------

    public function getCodigo(): ?string
    {
        return isset($this->rProtDe) ? $this->rProtDe->getCodigo() : null;
    }

    public function getMensaje(): ?string
    {
        return isset($this->rProtDe) ? $this->rProtDe->getMensaje() : null;
    }

    /** El DE fue autorizado (0260, dEstRes Aprobado o Aprobado con observaciones). */
    public function esExitosa(): bool
    {
        return $this->esAprobado();
    }

    public function esAprobado(): bool
    {
        return isset($this->rProtDe) && $this->rProtDe->esAprobado();
    }

    public function esRechazado(): bool
    {
        return !$this->esAprobado();
    }

    public function getEstado(): ?EstadoResultado
    {
        return isset($this->rProtDe) ? $this->rProtDe->getEstado() : null;
    }

    /** Número de transacción (dProtAut), o null si el DE no fue aprobado. */
    public function getProtocolo(): ?string
    {
        return isset($this->rProtDe) ? $this->rProtDe->getProtocolo() : null;
    }

    /** CDC del DE procesado (Id de rProtDe), o null (el rechazo genérico no lo trae). */
    public function getCdc(): ?string
    {
        return isset($this->rProtDe) ? $this->rProtDe->getId() : null;
    }

    /** @return list<GResProc> */
    public function getMotivos(): array
    {
        return isset($this->rProtDe) ? $this->rProtDe->getMotivos() : [];
    }

    public function getFechaProceso(): ?DateTime
    {
        return isset($this->rProtDe) && isset($this->rProtDe->dFecProc) ? $this->rProtDe->getDFecProc() : null;
    }

    public function toArray(): array
    {
        return [
            'codigo' => $this->getCodigo(),
            'mensaje' => $this->getMensaje(),
            'exitosa' => $this->esExitosa(),
            'estado' => $this->getEstado()?->value,
            'cdc' => $this->getCdc(),
            'protocolo' => $this->getProtocolo(),
            'fechaProceso' => self::fechaIso($this->getFechaProceso()),
            'motivos' => array_map(static fn (GResProc $m): array => ['codigo' => $m->getCodigo(), 'mensaje' => $m->getMensaje()], $this->getMotivos()),
        ];
    }
}
