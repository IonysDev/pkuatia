<?php

namespace Abiliomp\Pkuatia\Core\Responses;

use Abiliomp\Pkuatia\Core\Fields\Response\RProtDe;

/**
 * Nodo Id:     ARSch01
 * Nombre:      rRetEnviDe
 * Descripción: Clase que representa la respuesta de la recepcion de documentos electronicos.
 * Nodo Padre:  Es raíz.
 */

class RRetEnviDe {

                             // Id - Longitud - Ocurrencia - Descripción
    public String  $xProtDe; // ARSch02 - - 1-1 - XML de protocolo de procesamiento de documento electrónico.
    public RProtDe $rProtDe; // Valor convertido a objeto del XML de protocolo de procesamiento de documento electrónico.

    /**
     * Constructor de la clase
     */
    public function __construct($xProtDe) {
        $this->xProtDe = $xProtDe;
        $this->rProtDe = RProtDe::FromXMLString($xProtDe);
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
    public static function FromSifenResponseObject($object): self
    {
        if(!isset($object->xProtDe)) {
            throw new \Exception("[RRetEnviDe] El objeto recibido no tiene el atributo xProtDe.");
        }
        return new self($object->xProtDe);
    }

}