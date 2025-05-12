<?php

namespace IonysDev\Pkuatia\Core\Responses;

use DateTime;
use stdClass;

/**
 * Nodo Id:     BRSch01        
 * Nombre:      rResEnviLoteDe       
 * Descripción: Nodo raiz de Respuesta del WS Recepción Lote de Documentos Electrónicos
 * Nodo Padre:  Es raíz.
 */
class RResEnviLoteDe
{

    public const COD_RES_ACEPTADO = 300;
    public const COD_RES_RECHAZADO = 301;

                                    // Id - Longitud - Ocurrencia - Descripción        
    public DateTime $dFecProc;     // BRSch02 - 19    - 1-1 - Fecha y hora de recepción
    public int      $dCodRes;       // BRSch03 - 4     - 1.1 - Código del resultado de recepción 
    public string   $dMsgRes;       // BRSch04 - 1-255 - 1-1 - Mensaje de resultado de recepción
    public int      $dProtConsLote; // BRSch05 - 1-15  - 0-1 - Número de Lote (se genera solo si el estado es Aceptado)
    public int      $dTpoProces;    // BRSch06 - 1-5   - 1-1 - Tiempo medio de procesamiento en segundos

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Establece el valor de dFecProc
     *
     * @param DateTime $dFecProc
     *
     * @return self
     */
    public function setDFecProc(DateTime $dFecProc): self
    {
        $this->dFecProc = $dFecProc;

        return $this;
    }


    /**
     * Establece el valor de dCodRes
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
     * Establece el valor de dMsgRes
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
     * Establece el valor de dProtConsLote
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
     * Establece el valor de dTpoProces
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
     * Obtiene el valor de dFecProc
     *
     * @return DateTime
     */
    public function getDFecProc(): DateTime
    {
        return $this->dFecProc;
    }

    /**
     * Obtiene el valor de dCodRes
     *
     * @return int
     */
    public function getDCodRes(): int
    {
        return $this->dCodRes;
    }

    /**
     * Obtiene el valor de dMsgRes
     *
     * @return string
     */
    public function getDMsgRes(): string
    {
        return $this->dMsgRes ?? "";
    }

    /**
     * Obtiene el valor de dProtConsLote
     *
     * @return int
     */
    public function getdProtConsLote(): int
    {
        return $this->dProtConsLote;
    }

    /**
     * Obtiene el valor de dTpoProces
     *
     * @return int
     */
    public function getDTpoProces(): int
    {
        return $this->dTpoProces;
    }

    //////////////////////////////////////////////////////////////////////////
    // Instanciadores
    //////////////////////////////////////////////////////////////////////////

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
            throw new \Exception("[RResEnviLoteDe] Error Processing Request: null", 1);
        }
        $res = new RResEnviLoteDe();
        if (isset($object->dFecProc)) $res->setdFecProc(DateTime::createFromFormat(DateTime::ATOM, $object->dFecProc));
        else throw new \Exception("[RResEnviLoteDe] Error al instanciar respuesta, falta parametro: dFecProc", 1);
        
        if(isset($object->dCodRes)) $res->setDCodRes($object->dCodRes);
        else throw new \Exception("[RResEnviLoteDe] Error al instanciar respuesta, falta parametro: dCodRes", 1);
        
        if(isset($object->dMsgRes)) $res->setDMsgRes($object->dMsgRes);
        else throw new \Exception("[RResEnviLoteDe] Error al instanciar respuesta, falta parametro: dMsgRes", 1);
        
        if(isset($object->dProtConsLote)) {
            if(is_numeric($object->dProtConsLote)) 
                $res->setdProtConsLote(intval($object->dProtConsLote));
            else throw new \Exception("[RResEnviLoteDe] Error al instanciar respuesta, parametro dProtConsLote no es un numero. Objeto recibido: " . var_export($object, true), 1);
        }
        else if($res->getDCodRes() == self::COD_RES_ACEPTADO) throw new \Exception("[RResEnviLoteDe] Error al instanciar respuesta, falta parametro: dProtConsLote", 1);

        if(isset($object->dTpoProces)) $res->setDTpoProces($object->dTpoProces);
        else throw new \Exception("[RResEnviLoteDe] Error al instanciar respuesta, falta parametro: dTpoProces", 1);
        
        return $res;
    }
}
