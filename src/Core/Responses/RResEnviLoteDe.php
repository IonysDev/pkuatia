<?php

namespace IonysDev\Pkuatia\Core\Responses;

use DateTime;
use stdClass;
use IonysDev\Pkuatia\Core\Fields\Response\RProtDe;
use IonysDev\Pkuatia\Helpers\FechaHelper;
use IonysDev\Pkuatia\Core\Exceptions\RespuestaException;

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
    public DateTime $dFecProc;      // BRSch02 - 19    - 1-1 - Fecha y hora de recepción
    public int      $dCodRes;       // BRSch03 - 4     - 1.1 - Código del resultado de recepción 
    public string   $dMsgRes;       // BRSch04 - 1-255 - 1-1 - Mensaje de resultado de recepción
    public string   $dProtConsLote; // BRSch05 - 1-20  - 0-1 - Número de Lote (se genera solo si el estado es Aceptado) como cadena de texto debido a la longitud de la respuesta del WS.
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
     * @param string $dProtConsLote
     *
     * @return self
     */
    public function setdProtConsLote(string $dProtConsLote): self
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
     * Obtiene el valor de dProtConsLote convertido a int. Falla con números de más de 19 dígitos (el WS admite hasta 20)
     * y con un lote rechazado, que no trae número: preferir getDProtConsLoteString().
     *
     * @return int
     */
    public function getdProtConsLote(): int
    {
        return $this->dProtConsLote;
    }

    /**
     * Obtiene dProtConsLote tal como lo devolvió el SIFEN (17 dígitos en la práctica, hasta 20), o null si el lote no fue
     * aceptado (0301). Es el valor para guardar y pasar a Sifen::ConsultaLote() o Sifen::EsperarResultadoLote() (PK-41, 0.2.1).
     *
     * @return String|null
     */
    public function getDProtConsLoteString(): ?String
    {
        return $this->dProtConsLote ?? null;
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
            throw new RespuestaException("[RResEnviLoteDe] Error Processing Request: null", 1);
        }
        $res = new RResEnviLoteDe();
        // Rechazo genérico: sobre rRetEnviDe > rProtDe (capturado para recepción y consulta de RUC,
        // respuestas-ws/2026-10-06; para lotes [PENDIENTE DE VERIFICACIÓN]).
        if (isset($object->rProtDe)) {
            $prot = RProtDe::FromSifenResponseObject($object->rProtDe);
            if (isset($prot->dFecProc)) $res->setdFecProc($prot->getDFecProc());
            $proc = $prot->getGResProc()[0] ?? null;
            if ($proc !== null) {
                $res->setDCodRes(intval($proc->getDCodRes()));
                $res->setDMsgRes($proc->getDMsgRes());
            }
            return $res;
        }
        if (isset($object->dFecProc)) $res->setdFecProc(FechaHelper::FromSifen($object->dFecProc, 'dFecProc')); // con o sin zona (PK-29)
        else throw RespuestaException::porCampoFaltante("[RResEnviLoteDe] Error al instanciar respuesta, falta parametro: dFecProc", 'dFecProc');
        
        if(isset($object->dCodRes)) $res->setDCodRes($object->dCodRes);
        else throw RespuestaException::porCampoFaltante("[RResEnviLoteDe] Error al instanciar respuesta, falta parametro: dCodRes", 'dCodRes');
        
        if(isset($object->dMsgRes)) $res->setDMsgRes($object->dMsgRes);
        else throw RespuestaException::porCampoFaltante("[RResEnviLoteDe] Error al instanciar respuesta, falta parametro: dMsgRes", 'dMsgRes');
        
        if(isset($object->dProtConsLote)) {
            if(ctype_digit($object->dProtConsLote)) 
                $res->setdProtConsLote($object->dProtConsLote);
            else throw new RespuestaException("[RResEnviLoteDe] Error al instanciar respuesta, parametro dProtConsLote no es un numero. Objeto recibido: " . var_export($object, true), 1);
        }
        else if($res->getDCodRes() == self::COD_RES_ACEPTADO) throw RespuestaException::porCampoFaltante("[RResEnviLoteDe] Error al instanciar respuesta, falta parametro: dProtConsLote", 'dProtConsLote');

        if(isset($object->dTpoProces)) $res->setDTpoProces($object->dTpoProces);
        else throw RespuestaException::porCampoFaltante("[RResEnviLoteDe] Error al instanciar respuesta, falta parametro: dTpoProces", 'dTpoProces');
        
        return $res;
    }
}
