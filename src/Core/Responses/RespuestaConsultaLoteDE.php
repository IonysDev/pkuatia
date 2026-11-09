<?php

namespace IonysDev\Pkuatia\Core\Responses;

use IonysDev\Pkuatia\Core\Exceptions\RespuestaException;

/**
 * RespuestaConsultaLoteDE
 *
 * @deprecated 0.2.1 Versión anterior de la respuesta de la consulta de lote, sin uso en la librería: Sifen::ConsultaLote()
 *             devuelve RResEnviConsLoteDe, que además lee el detalle por documento (gResProcLote) (PK-43).
 */
class RespuestaConsultaLoteDE
{
    public string $dFecProd; //fecha de la consulta
    public string $dCodResLot; //codigo de respuesta del lote
    public string $dMsgResLot; //descripcion del codigo de respuesta del lote

    ///////////////////////////////////////////////////////////////////////
    ///SETTERS
    ///////////////////////////////////////////////////////////////////////
    /**
     * Establece el valor de dFecProd
     *
     * @param String $dFecProd
     *
     * @return self
     */
    public function setDFecProd(string $dFecProd): self
    {
        $this->dFecProd = $dFecProd;

        return $this;
    }


    /**
     * Establece el valor de dCodResLot
     *
     * @param String $dCodResLot
     *
     * @return self
     */
    public function setDCodResLot(string $dCodResLot): self
    {
        $this->dCodResLot = $dCodResLot;

        return $this;
    }


    /**
     * Establece el valor de dMsgResLot
     *
     * @param String $dMsgResLot
     *
     * @return self
     */
    public function setDMsgResLot(string $dMsgResLot): self
    {
        $this->dMsgResLot = $dMsgResLot;

        return $this;
    }

    ///////////////////////////////////////////////////////////////////////
    ///GETTERS
    ///////////////////////////////////////////////////////////////////////



    /**
     * Obtiene el valor de dFecProd
     *
     * @return String
     */
    public function getDFecProd(): string
    {
        return $this->dFecProd;
    }

    /**
     * Obtiene el valor de dCodResLot
     *
     * @return String
     */
    public function getDCodResLot(): string
    {
        return $this->dCodResLot;
    }

    /**
     * Obtiene el valor de dMsgResLot
     *
     * @return String
     */
    public function getDMsgResLot(): string
    {
        return $this->dMsgResLot;
    }

    ///////////////////////////////////////////////////////////////////////
    //From Response
    ///////////////////////////////////////////////////////////////////////

    public static function FromSifenResponseObject($object): self
    {
        ///is is null
        if (is_null($object)) {
            throw new RespuestaException("Error Processing Request: null", 1);
        }

        ///check response codes
        if ($object->dCodResLot != "0362") {
            ///retorna el objeto
            $res = new RespuestaConsultaLoteDE();
            $res->setDFecProd($object->dFecProc);
            $res->setDCodResLot($object->dCodResLot);
            $res->setDMsgResLot($object->dMsgResLot);
        } else {
            ///retorna el objeto
            $res = new RespuestaConsultaLoteDE();
            $res->setDFecProd($object->dFecProc);
            $res->setDCodResLot($object->dCodResLot);
            $res->setDMsgResLot($object->dMsgResLot);
            ///Acá la logica al obtener el lote
        }

        return $res;
    }

    public function printData()
    {
        return "RespuestaConsultaDE: " . PHP_EOL .
          "Fecha de Consulta: " . $this->dFecProd . PHP_EOL .
          "Código de Respuesta: " . $this->dCodResLot . PHP_EOL .
          "Mensaje de Respuesta: " . $this->dMsgResLot . PHP_EOL;
    }
}
