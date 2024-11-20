<?php

namespace IonysDev\Pkuatia\Core\Requests;

/**
 * ID DSch01: Clase que compone la solicitud de consulta de un DE por su CDC
 * 
 */

class REnviConsDe {

                         // ID - DESCRIPCION- LONGITUD - OCURRENCIA
    public int $dId;     // DSch02 - Identificador de la solicitud generado el sistema que utilice PKuatia para identificar la solicitud - 1-15 - 1-1
    public String $dCDC; // DSch03 - CDC del documento electrónico que se desea consultar - 44 - 1-1

    /**
     * Constructor de la clase
     */
    public function __construct($dId, $dCDC) {
        $this->dId = $dId;
        $this->dCDC = $dCDC;
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
     * Establece el valor dCDC de la solicitud.
     *
     * @param String $dCDC
     *
     * @return self
     */
    public function setDCDC(String $dCDC): self
    {
        $this->dCDC = $dCDC;
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
     * Obtiene el valor dCDC de la solicitud.
     *
     * @return String
     */
    public function getDCDC(): String
    {
        return $this->dCDC;
    }
    
}


?>