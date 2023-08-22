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
    public static function FromSifenResponseObject($object): self
    {
        $res = new RRetEnviDe();
        $res->setRProtDe(RProtDe::FromSifenResponseObject($object->rProtDe));
        return $res;
    }

}