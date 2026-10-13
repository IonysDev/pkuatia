<?php

namespace IonysDev\Pkuatia\Core\Responses;

use IonysDev\Pkuatia\Core\Fields\Response\RProtDe;
use IonysDev\Pkuatia\Core\Fields\Response\RUC\RContRUC;
use stdClass;
use IonysDev\Pkuatia\Core\Exceptions\RespuestaException;
use IonysDev\Pkuatia\Core\Constants\EstadoRuc;
use DateTime;

/**
 * RespuestaConsultaRUC
 */
class RResEnviConsRUC implements RespuestaSifen 
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
      throw new RespuestaException("Error Processing Request: null", 1);
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

  use RespuestaSifenTrait;

  // --- Fase C (C6): RespuestaSifen y lectura del RUC -----------------------------------------------------------------

  public function getCodigo(): ?string
  {
    return isset($this->dCodRes) ? self::codigoTexto($this->dCodRes) : null;
  }

  public function getMensaje(): ?string
  {
    return $this->dMsgRes ?? null;
  }

  /** El RUC existe y se devolvieron sus datos (0502). */
  public function esExitosa(): bool
  {
    return $this->fueEncontrado();
  }

  public function fueEncontrado(): bool
  {
    return $this->getCodigo() === '0502';
  }

  /** Estado del RUC consultado (dCodEstCons), o null si no vino o no se reconoce. */
  public function getEstadoRuc(): ?EstadoRuc
  {
    return isset($this->rContRuc) && isset($this->rContRuc->dCodEstCons) ? EstadoRuc::tryFrom(strtoupper(trim($this->rContRuc->dCodEstCons))) : null;
  }

  /** Si el RUC es facturador electrónico (dRUCFactElec S/N), o null si no vino. */
  public function esFacturadorElectronico(): ?bool
  {
    return isset($this->rContRuc) && isset($this->rContRuc->dRUCFactElec) ? strtoupper(trim($this->rContRuc->dRUCFactElec)) === 'S' : null;
  }

  public function getRazonSocial(): ?string
  {
    return isset($this->rContRuc) && isset($this->rContRuc->dRazCons) ? $this->rContRuc->dRazCons : null;
  }

  /** La consulta de RUC no trae dFecProc: siempre null. */
  public function getFechaProceso(): ?DateTime
  {
    return null;
  }

  public function toArray(): array
  {
    return [
      'codigo' => $this->getCodigo(),
      'mensaje' => $this->getMensaje(),
      'exitosa' => $this->esExitosa(),
      'ruc' => isset($this->rContRuc) && isset($this->rContRuc->dRUCCons) ? $this->rContRuc->dRUCCons : null,
      'razonSocial' => $this->getRazonSocial(),
      'estadoRuc' => $this->getEstadoRuc()?->value,
      'facturadorElectronico' => $this->esFacturadorElectronico(),
    ];
  }
}
