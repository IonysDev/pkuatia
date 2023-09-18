<?php

namespace Abiliomp\Pkuatia\Core\Requests;

use SoapVar;

/**
 * ID GSch01: Clase que coforma una petición de recepción de documento electrónico.
 * 
 */

class REnviEventoDe {

    public int $dId; // GSch02 - Identificador de la solicitud generado el sistema que utilice PKuatia para identificar la solicitud.
    public SoapVar $dEvReg;  // GSch03 - Evento a ser registrado en XML.


    public function __construct(int $dId, SoapVar $dEvReg )
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
     * @param String $dEvReg
     * 
     * @return self
     */
    public function setDEvReg(String $dEvReg): self
    {
        $this->dEvReg = $dEvReg;
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

?>