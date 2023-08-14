<?php

namespace Abiliomp\Pkuatia\Core\Responses;

use Abiliomp\Pkuatia\Core\Fields\Response\RProtDe;

/**
 * ID ARSch01 - Clase que representa la respuesta de la recepcion de documentos electronicos.
 */

class RRetEnviDe {

    public String $xProtDe; // ARSch02 - XML de protocolo de procesamiento de documento electrónico.
    public RProtDe $rProtDe; // Valor convertido a objeto del XML de protocolo de procesamiento de documento electrónico.

    /**
     * Constructor de la clase
     */
    public function __construct($xProtDe) {
        $this->xProtDe = $xProtDe;
        $this->rProtDe = new RProtDe($xProtDe);
    }

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Establece el valor en XML del xProtDe de la respuesta.
     * 
     * @param String $xProtDe
     * 
     * @return self
     */
    public function setXProtDe(String $xProtDe): self
    {
        $this->xProtDe = $xProtDe;
        return $this;
    }

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////
    
    /**
     * Obtiene el valor en XML del xProtDe de la respuesta.
     * 
     * @return String
     */
    public function getXProtDe(): String
    {
        return $this->xProtDe;
    }

}