<?php

namespace IonysDev\Pkuatia\Core\Requests;

use SoapVar;

/**
 * ID GSch01: Clase que coforma una petición de recepción de documento electrónico.
 *
 */

class REnviEventoDe
{
                            // Id  - Longitud - Ocurrencia - Descripción
    public int $dId;         // GSch02 - 1-15 - 1-1 - Identificador de la solicitud generado el sistema que utilice PKuatia para identificar la solicitud.
    public SoapVar $dEvReg;  // GSch03 - XML  - 1-1 - Evento a ser registrado en XML.


    public function __construct(int $dId, SoapVar $dEvReg)
    {
        $this->dId = $dId;
        $this->dEvReg = $dEvReg;
    }

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Establece el valor dId de la solicitud.
     *
     * @param int $dId
     *
     * @return self
     */
    public function setDId(int $dId): self
    {
        $this->dId = $dId;
        return $this;
    }

    /**
     * Establece el valor en XML del dEvReg de la solicitud.
     *
     * @param String|SoapVar $dEvReg XML del elemento dEvReg ya armado (p. ej. `<ns1:dEvReg>…gGroupGesEve…</ns1:dEvReg>`,
     *                               como lo pasa el facade), que se envuelve en un SoapVar XSD_ANYXML; o un SoapVar
     *                               listo. Hasta 0.3.0 el parámetro era `String` y se asignaba a la propiedad SoapVar:
     *                               TypeError en toda llamada (Fase D, D1).
     *
     * @return self
     */
    public function setDEvReg(string|SoapVar $dEvReg): self
    {
        $this->dEvReg = $dEvReg instanceof SoapVar ? $dEvReg : new SoapVar($dEvReg, XSD_ANYXML);
        return $this;
    }

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Obtiene el valor dId de la solicitud.
     *
     * @return int
     */
    public function getDId(): int
    {
        return $this->dId;
    }

    /**
     * Obtiene el valor XML dEvReg de la solicitud.
     */
    public function getDEvReg(): SoapVar
    {
        return $this->dEvReg;
    }


}
