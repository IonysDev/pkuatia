<?php

namespace IonysDev\Pkuatia\Core\Requests;

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
     * @param String|SoapVar $xDE XML del elemento xDE ya armado (p. ej. `<ns1:xDE>…rDE…</ns1:xDE>`, como lo pasa el
     *                            facade), que se envuelve en un SoapVar XSD_ANYXML; o un SoapVar listo. Hasta 0.3.0
     *                            el parámetro era `String` y se asignaba a la propiedad SoapVar: TypeError en toda
     *                            llamada (Fase D, D1).
     * 
     * @return self
     */
    public function setXDe(string|SoapVar $xDE): self
    {
        $this->xDE = $xDE instanceof SoapVar ? $xDE : new SoapVar($xDE, XSD_ANYXML);
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
