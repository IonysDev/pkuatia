<?php

namespace IonysDev\Pkuatia\Core\Requests;

/**
 * Clase que compone la solicitud de consulta masiva de RUC (WS siConsArchivoRUC, NT-011).
 * Devuelve un archivo comprimido con la razón social, el estado del RUC y la marca de facturador
 * electrónico de todos los contribuyentes activos. El SIFEN permite una descarga por día.
 */
class REnviConsArchivoRUC {

                                // ID - DESCRIPCION - LONGITUD - OCURRENCIA
    public int $dId;            // ESch04 - Identificador de control de envío generado por el sistema que utilice PKuatia - 1-15 - 1-1
    public String $dRucFactElec;// ESch05 - RUC del facturador electrónico que consulta, sin dígito verificador - 5-8 - 1-1

    /**
     * Constructor de la clase
     *
     * @param int $dId Identificador de control de envío.
     * @param String $dRucFactElec RUC del facturador electrónico, sin dígito verificador.
     */
    public function __construct(int $dId, String $dRucFactElec) {
        $this->dId = $dId;
        $this->dRucFactElec = $dRucFactElec;
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
     * Establece el valor dRucFactElec de la solicitud.
     *
     * @param String $dRucFactElec RUC del facturador electrónico, sin dígito verificador.
     *
     * @return self
     */
    public function setDRucFactElec(String $dRucFactElec): self
    {
        $this->dRucFactElec = $dRucFactElec;
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
     * Obtiene el valor dRucFactElec de la solicitud.
     *
     * @return String
     */
    public function getDRucFactElec(): String
    {
        return $this->dRucFactElec;
    }
}
