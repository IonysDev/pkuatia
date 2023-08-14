<?php

namespace Abiliomp\Pkuatia\Core\Requests;

class REnviDe {

    /**
     * ID ASch01: solitud de envio de documento electronico
     */

    public int $dId;    // ASch02 - Identificador  de control de envío 
    public String $xDe; // ASch03 - XML  del  DE transmitido 

    public function __construct(int $dId, String $xDe)
    {
        $this->dId = $dId;
        $this->xDe = $xDe;
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
     * Establece el valor en XML del xDe de la solicitud.
     * 
     * @param String $xDe
     * 
     * @return self
     */
    public function setXDe(String $xDe): self
    {
        $this->xDe = $xDe;
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
     * Obtiene el valor XML xDe de la solicitud.
     */
    public function getXDe(): String
    {
        return $this->xDe;
    }

}

?>
