<?php

namespace Abiliomp\Pkuatia\Core\Responses;

use DateTime;
use stdClass;

// Nodo Id: BRSch01 
// Nombre: rResEnviLoteDe
// Descripción: Clase que representa la respuesta de la recepcion de lote de documentos electronicos.
// Nodo Padre: Es raíz.

class RResEnviLoteDe
{
    // Id - Longitud - Ocurrencia - Descripción        
    public DateTime $dFechProc; // BRSch02 - 19 - 1-1 - Fecha y hora de recepción
    public int $dCodRes;        // BRSch03 - 4  - 1.1 - s Código del resultado de recepción 
    public string $dMsgRes;     // BRSch04 - 1-255 - 1-1 - Mensaje de resultado de recepción
    public int $dProtConsLote;  // BRSch05 - 1-15 - 0-1 - Número de Lote
    public int $dTpoProces;     // BRSch06 - 1-5 - 1-1 - Tiempo medio de procesamiento en segundos

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////



    /**
     * Set the value of dFechProc
     *
     * @param DateTime $dFechProc
     *
     * @return self
     */
    public function setdFechProc(DateTime $dFechProc): self
    {
        $this->dFechProc = $dFechProc;

        return $this;
    }


    /**
     * Set the value of dCodRes
     *
     * @param int $dCodRes
     *
     * @return self
     */
    public function setDCodRes(int $dCodRes): self
    {
        $this->dCodRes = $dCodRes;

        return $this;
    }


    /**
     * Set the value of dMsgRes
     *
     * @param string $dMsgRes
     *
     * @return self
     */
    public function setDMsgRes(string $dMsgRes): self
    {
        $this->dMsgRes = $dMsgRes;

        return $this;
    }


    /**
     * Set the value of dProtConsLote
     *
     * @param int $dProtConsLote
     *
     * @return self
     */
    public function setdProtConsLote(int $dProtConsLote): self
    {
        $this->dProtConsLote = $dProtConsLote;

        return $this;
    }


    /**
     * Set the value of dTpoProces
     *
     * @param int $dTpoProces
     *
     * @return self
     */
    public function setDTpoProces(int $dTpoProces): self
    {
        $this->dTpoProces = $dTpoProces;

        return $this;
    }

    //////////////////////////////////////////////////////////////////////////
    // Getters
    //////////////////////////////////////////////////////////////////////////


    /**
     * Get the value of dFechProc
     *
     * @return DateTime
     */
    public function getdFechProc(): DateTime
    {
        return $this->dFechProc;
    }

    /**
     * Get the value of dCodRes
     *
     * @return int
     */
    public function getDCodRes(): int
    {
        return $this->dCodRes;
    }

    /**
     * Get the value of dMsgRes
     *
     * @return string
     */
    public function getDMsgRes(): string
    {
        return $this->dMsgRes;
    }

    /**
     * Get the value of dProtConsLote
     *
     * @return int
     */
    public function getdProtConsLote(): int
    {
        return $this->dProtConsLote;
    }

    /**
     * Get the value of dTpoProces
     *
     * @return int
     */
    public function getDTpoProces(): int
    {
        return $this->dTpoProces;
    }

  /**
   * Crea una nueva instancia de RResEnviConsDe a partir de un objeto stdClass.
   * Pensado para castear la respuesta de una llamada SOAP.
   * 
   * @param stdClass $object
   * 
   * @return self
   */
    public static function FromSifenResponseObject($object)
    {
        if (is_null($object)) {
            throw new \Exception("Error Processing Request: null", 1);
            return null;
        }

        $res = new RResEnviLoteDe();
        $res->setdFechProc(DateTime::createFromFormat(DateTime::ATOM, $object->dFecProc));
        $res->setDCodRes($object->dCodRes);
        $res->setDMsgRes($object->dMsgRes);
        $res->setdProtConsLote($object->dProtConsLote);
        $res->setDTpoProces($object->dTpoProces);

        return $res;

    }
}
