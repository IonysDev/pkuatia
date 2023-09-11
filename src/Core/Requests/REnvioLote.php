<?php

namespace Abiliomp\Pkuatia\Core\Requests;

    // Nodo ID: BSch01 rEnvioLote Raíz
    // Nombre: rEnvioLote
    // Descripción: Clase que conforma la solicitud de envío de lote de documentos electrónicos.
    // Nodo Padre: Es raíz.
class REnvioLote {
                        // Id - Longitud - Ocurrencia - Descripción
    public int $dId;    // BSch02 - 1-15 - 1-1 - Identificador de control de envío.
    public string $xDE; //BSch01  -  no tiene  - 1-1 - Campo comprimido en formato Base64 según el esquema del Protocolo de procesamiento del Lote.


    public function __construct(int $dId, string $xDE)
    {
        $this->dId = $dId;
        $this->xDE = $xDE;
    }

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Set the value of dId
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
     * Set the value of xDE
     *
     * @param string $xDE
     *
     * @return self
     */
    public function setXDE(string $xDE): self
    {
        $this->xDE = $xDE;

        return $this;
    }

    //////////////////////////////////////////////////////////////////////////
    // Getters
    //////////////////////////////////////////////////////////////////////////

    

    /**
     * Get the value of dId
     *
     * @return int
     */
    public function getDId(): int
    {
        return $this->dId;
    }

    /**
     * Get the value of xDE
     *
     * @return string
     */
    public function getXDE(): string
    {
        return $this->xDE;
    }
}



