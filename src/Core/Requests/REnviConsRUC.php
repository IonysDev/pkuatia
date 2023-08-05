<?php

namespace Abiliomp\Pkuatia\Core\Requests;

use DOMDocument;
use Abiliomp\Pkuatia\Core\Constants;

/**
 * ID RSch01: Clase que compone la solicitud de consulta de RUC
 * 
 */

class REnviConsRUC {

    public int $dId; // RSch02 - Identificador de la solicitud generado el sistema que utilice PKuatia para identificar la solicitud.
    public String $dRUCCons; // RSch03 - RUC que se desea consultar sin dígito verificador.

    //====================================================//
    // Setters
    //====================================================//

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
     * Establece el valor dRUCCons de la solicitud.
     *
     * @param String $dRUCCons
     *
     * @return self
     */
    public function setDRUCCons(String $dRUCCons): self
    {
        $this->dRUCCons = $dRUCCons;
        return $this;
    }

    //====================================================//
    // Getters
    //====================================================//

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
     * Obtiene el valor dRUCCons de la solicitud.
     *
     * @return String
     */
    public function getDRUCCons(): String
    {
        return $this->dRUCCons;
    }
}

?>