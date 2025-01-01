<?php

namespace IonysDev\Pkuatia\Core\Responses;


use IonysDev\Pkuatia\Core\Fields\Response\GResProc;
use DateTime;
use IonysDev\Pkuatia\Core\Fields\Response\Batch\GResProcLote;

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
  
                                 // Id - Longirud - Ocurrencia - Descripción
  public DateTime $dFecProc;     // CRSch02 - 19    - 1-1  - Fecha y hora del procesamiento del lote
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
  public function setDFecProc(DateTime $dFecProc): self
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
  public function getDFecProc(): DateTime
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
      throw new \Exception("[RResEnviConsLoteDe] Error Processing Request: null", 1);
    }

    $res = new RResEnviConsLoteDe();
    
    if(isset($object->dFecProc)) $res->setDFecProc(DateTime::createFromFormat(DateTime::ATOM, $object->dFecProc));
    else throw new \Exception("[RResEnviConsLoteDe] Error al instanciar respuesta, falta parametro: dFecProc", 1);
    
    if(isset($object->dCodResLot)) $res->setDCodResLot($object->dCodResLot);
    else throw new \Exception("[RResEnviConsLoteDe] Error al instanciar respuesta, falta parametro: dCodResLot", 1);
    
    if(isset($object->dMsgResLot)) $res->setDMsgResLot($object->dMsgResLot);
    else throw new \Exception("[RResEnviConsLoteDe] Error al instanciar respuesta, falta parametro: dMsgResLot", 1);
    

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
