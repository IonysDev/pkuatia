<?php

namespace IonysDev\Pkuatia\Core\Responses;


use IonysDev\Pkuatia\Core\Fields\Response\GResProc;
use DateTime;
use IonysDev\Pkuatia\Core\Fields\Response\Batch\GResProcLote;
use IonysDev\Pkuatia\Core\Fields\Response\RProtDe;
use IonysDev\Pkuatia\Helpers\FechaHelper;
use IonysDev\Pkuatia\Core\Exceptions\RespuestaException;

/**
 * Nodo Id:     CRSch01        
 * Nombre:      rResEnviConsLoteDe       
 * Descripción: Nodo raiz de Respuesta del WS Consulta Resultado Lote
 * Nodo Padre:  Es raíz.
 */
class RResEnviConsLoteDe
{
  public const COD_RES_RECHAZADO_INEXISTENTE = 360;
  public const COD_RES_EN_PROCESAMIENTO = 361;
  public const COD_RES_ACEPTADO = 362;
  public const COD_RES_RECHAZADO_DIFERENTES_TIPOS_DE = 363;
  // Consulta extemporánea: pasaron más de 48 horas desde el envío y hay que consultar cada CDC con ConsultarDE(). No figura
  // en el MT v150 (12.x); lo agrega la guía de mejores prácticas de envío de la DNIT, §7 (PK-41, 0.2.1).
  public const COD_RES_CONSULTA_EXTEMPORANEA = 364;
  
                                 // Id - Longirud - Ocurrencia - Descripción
  public DateTime $dFecProc;    // CRSch02 - 19    - 1-1  - Fecha y hora del procesamiento del lote (nombre no coincide con MT150)
  public int      $dCodResLot;   // CRSch03 - 4     - 1-1  - Código de resultado del procesamiento del lote
  public string   $dMsgResLot;   // CRSch04 - 1-255 - 1-1  - Comentario del resultado del procesamiento del lote
  public array    $gResProcLote; // CRSch05 - G     - 0-50 - Grupo Resultado del procesamiento del lote

  /**
   * Establece el valor de dFecProc
   *
   * @param DateTime $dFecProc
   *
   * @return self
   */
  public function setdFecProc(DateTime $dFecProc): self
  {
    $this->dFecProc = $dFecProc;

    return $this;
  }


  /**
   * Establece el valor de dCodResLot
   *
   * @param int $dCodResLot
   *
   * @return self
   */
  public function setDCodResLot(int $dCodResLot): self
  {
    $this->dCodResLot = $dCodResLot;

    return $this;
  }


  /**
   * Establece el valor de dMsgResLot
   *
   * @param string $dMsgResLot
   *
   * @return self
   */
  public function setDMsgResLot(string $dMsgResLot): self
  {
    $this->dMsgResLot = $dMsgResLot;

    return $this;
  }


  /**
   * Establece el valor de gResProcLote
   *
   * @param array $gResProcLote
   *
   * @return self
   */
  public function setGResProcLote(array $gResProcLote): self
  {
    $this->gResProcLote = $gResProcLote;

    return $this;
  }

  /**
   * Obtiene el valor de dFecProc
   *
   * @return DateTime
   */
  public function getdFecProc(): DateTime
  {
    return $this->dFecProc;
  }

  /**
   * Obtiene el valor de dCodResLot
   *
   * @return int
   */
  public function getDCodResLot(): int
  {
    return $this->dCodResLot;
  }

  /**
   * Obtiene el valor de dMsgResLot
   *
   * @return string
   */
  public function getDMsgResLot(): string
  {
    return $this->dMsgResLot;
  }

  /**
   * Obtiene el valor de gResProcLote
   *
   * @return array
   */
  public function getGResProcLote(): array
  {
    return $this->gResProcLote;
  }

  public static function FromSifenResponseObject($object)
  {

    if (is_null($object)) {
      throw new RespuestaException("[RResEnviConsLoteDe] Error Processing Request: null", 1);
    }

    $res = new RResEnviConsLoteDe();
    
    // Rechazo genérico: sobre rRetEnviDe > rProtDe (capturado para recepción y consulta de RUC,
    // respuestas-ws/2026-10-06; para la consulta de lote [PENDIENTE DE VERIFICACIÓN]).
    if (isset($object->rProtDe)) {
      $prot = RProtDe::FromSifenResponseObject($object->rProtDe);
      if (isset($prot->dFecProc)) $res->setdFecProc($prot->getDFecProc());
      $proc = $prot->getGResProc()[0] ?? null;
      if ($proc !== null) {
        $res->setDCodResLot(intval($proc->getDCodRes()));
        $res->setDMsgResLot($proc->getDMsgRes());
      }
      $res->gResProcLote = array();
      return $res;
    }
    if(isset($object->dFecProc)) $res->setdFecProc(FechaHelper::FromSifen($object->dFecProc, 'dFecProc')); // con o sin zona (PK-29)
    else throw RespuestaException::porCampoFaltante("[RResEnviConsLoteDe] Error al instanciar respuesta, falta parametro: dFecProc", 'dFecProc');
    
    if(isset($object->dCodResLot)) $res->setDCodResLot($object->dCodResLot);
    else throw RespuestaException::porCampoFaltante("[RResEnviConsLoteDe] Error al instanciar respuesta, falta parametro: dCodResLot", 'dCodResLot');
    
    if(isset($object->dMsgResLot)) $res->setDMsgResLot($object->dMsgResLot);
    else throw RespuestaException::porCampoFaltante("[RResEnviConsLoteDe] Error al instanciar respuesta, falta parametro: dMsgResLot", 'dMsgResLot');
    

    $res->gResProcLote = array();

    if(isset($object->gResProcLote)){
      if(is_array($object->gResProcLote)){
        foreach ($object->gResProcLote as $item) {
          array_push($res->gResProcLote, GResProcLote::FromSifenResponseObject($item));
        }
      }
      else {
        array_push($res->gResProcLote, GResProcLote::FromSifenResponseObject($object->gResProcLote));
      }
    }
    return $res;
  }
}
