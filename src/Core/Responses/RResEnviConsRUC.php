<?php

namespace IonysDev\Pkuatia\Core\Responses;

use IonysDev\Pkuatia\Core\Fields\Response\RProtDe;
use IonysDev\Pkuatia\Core\Fields\Response\RUC\RContRUC;
use stdClass;

/**
 * RespuestaConsultaRUC
 */
class RResEnviConsRUC 
{
  public const COD_RES_RUC_NOT_FOUND = 500;
  public const COD_RES_FORBIDDEN = 501;
  public const COD_RES_RUC_FOUND = 502;
  
                             // ID - DESCRIPCION- LONGITUD - OCURRENCIA
  public int    $dCodRes;    // RRSch02 - Código del resultado de la consulta RUC  - 4 - 1-1
  public String $dMsgRes;    // RRSch03 - Mensaje del resultado  de  la consulta RUC - 1-255 - 1-1
  public RContRUC $rContRuc; // RRSch04 - Contenedor del RUC consultado - X - 1-1

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

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
   * @param String $dMsgRes
   *
   * @return self
   */
  public function setDMsgRes(String $dMsgRes): self
  {
    $this->dMsgRes = $dMsgRes;

    return $this;
  }


  /**
   * Establece el valor de RContRUC
   *
   * @param RContRUC $rContRuc
   *
   * @return self
   */
  public function setRContRUC(RContRUC $rContRuc): self
  {
    $this->rContRuc = $rContRuc;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////


  /**
   * Obtiene el valor de dCodRes
   *
   * @return String
   */
  public function getDCodRes(): String
  {
    return $this->dCodRes;
  }

  /**
   * Obtiene el valor de dMsgRes
   *
   * @return String
   */
  public function getDMsgRes(): String
  {
    return $this->dMsgRes;
  }

  /**
   * Obtiene el valor de rContRuc
   *
   * @return RContRUC
   */
  public function getRContRUC(): RContRUC
  {
    if(isset($this->rContRuc))
    {
      return $this->rContRuc;
    }
    else
    {
      return new RContRUC();
    }
  }

  ///////////////////////////////////////////////////////////////////////
  // Métodos especiales de instanciación
  ///////////////////////////////////////////////////////////////////////

  /**
   * Crea una nueva instancia de RResEnviConsRUC a partir de un objeto stdClass.
   * Pensado para castear la respuesta de una llamada SOAP.
   * 
   * @param stdClass $object
   * 
   * @return RResEnviConsRUC
   */

  public static function fromStdClassObject($object)
  {
    if (is_null($object)) {
      throw new \Exception("Error Processing Request: null", 1);
      return null;
    }
    $res = new RResEnviConsRUC();
    // Rechazo genérico: la consulta de RUC responde con el sobre rRetEnviDe > rProtDe (respuestas-ws/2026-10-06/03 y
    // 04, observación 2 del 06/10). Hasta 0.2.0 terminaba en Warning y TypeError (PK-29).
    if (isset($object->rProtDe)) {
      $proc = RProtDe::FromSifenResponseObject($object->rProtDe)->getGResProc()[0] ?? null;
      if ($proc !== null) {
        $res->setDCodRes(intval($proc->getDCodRes()));
        $res->setDMsgRes($proc->getDMsgRes());
      }
      return $res;
    }
    $res->setDCodRes($object->dCodRes);
    $res->setDMsgRes($object->dMsgRes);
    if ($object->dCodRes == "0502")
    {
      if(isset($object->xContRUC))
        //  RRSch04 - rContRUC se denomina xContRUC en las respuestas del SIFEN
        $res->setRContRUC(RContRUC::fromStdClassObject($object->xContRUC));
      else if(isset($object->rContRUC))
        $res->setRContRUC(RContRUC::fromStdClassObject($object->rContRUC));
    }
    return $res;
  }
}
