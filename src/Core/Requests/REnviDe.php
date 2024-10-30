<?php

namespace Abiliomp\Pkuatia\Core\Requests;

use SimpleXMLElement;
use SoapVar;

/**
 * Nodo Id:    ASch01
 * Nombre:     rEnviDe
 * Decripción: Clase que conforma la solitud de envio de documento electrónico.
 * Nodo Padre: Es raíz.
 */

class REnviDe {
                        // Id - Longitud - Ocurrencia - Descripción    
    public int $dId;    // ASch02 - 1-15 - 1-1 - Identificador  de control de envío 
    public SoapVar $xDE; // ASch03 - XML  - 1-1 - XML del DE transmitido 

    public function __construct(int $dId, SoapVar $xDE)
    {
        $this->dId = $dId;
        $this->xDE = $xDE;
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
    public function setXDe(String $xDE): self
    {
        $this->xDE = $xDE;
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
     * 
     * @return String
     */
    public function getXDE(): SoapVar
    {
        return $this->xDE;
    }



}

?>
