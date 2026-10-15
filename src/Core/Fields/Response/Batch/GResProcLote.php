<?php

namespace IonysDev\Pkuatia\Core\Fields\Response\Batch;


use DOMElement;
use IonysDev\Pkuatia\Core\Fields\Response\GResProc;
use stdClass;
use IonysDev\Pkuatia\Core\Exceptions\RespuestaException;
use IonysDev\Pkuatia\Core\Constants\EstadoResultado;
use IonysDev\Pkuatia\Validacion\CatalogoValidaciones;
use IonysDev\Pkuatia\Validacion\InfoValidacion;

/**
 * Nodo Id:     CRSch05        
 * Nombre:      gResProcLote       
 * Descripción: Grupo Resultado de Procesamiento del Lote   
 * Nodo Padre:  CRSch01 - rResEnviConsLoteDe - Respuesta del WS Consulta Resultado Lote
 */
class GResProcLote
{
  // Id - Longirud - Ocurrencia - Descripción
  public String    $id;       // CRSch050 - 44   - 1-1   - CDC del DE
  public String    $dEstRes;  // CRSch051 - 8-30 - 1-1   - Estado del resultado (Aprobado, Aprobado con Obs. o Rechazado)
  public int       $dProtAut; // CRSch052 - 10   - 0-1   - Número de transacción (se genera solo si el estado es Aprobado)
  public array     $gResProc; // CRSch053 - G    - 1-100 - Grupo Mensaje de Resultado

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de id
   *
   * @param String $id
   *
   * @return self
   */
  public function setId(String $id): self
  {
    $this->id = $id;

    return $this;
  }


  /**
   * Establece el valor de dEstRes
   *
   * @param String $dEstRes
   *
   * @return self
   */
  public function setDEstRes(String $dEstRes): self
  {
    $this->dEstRes = $dEstRes;

    return $this;
  }


  /**
   * Establece el valor de dProtAut
   *
   * @param String $dProtAut
   *
   * @return self
   */
  public function setDProtAut(String $dProtAut): self
  {
    $this->dProtAut = $dProtAut;

    return $this;
  }


  /**
   * Establece el valor de gResProc
   *
   * @param array $gResProc
   *
   * @return self
   */
  public function setGResProc(array $gResProc): self
  {
    $this->gResProc = $gResProc;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de id
   *
   * @return String
   */
  public function getId(): String
  {
    return $this->id;
  }

  /**
   * Obtiene el valor de dEstRes
   *
   * @return String
   */
  public function getDEstRes(): String
  {
    return $this->dEstRes;
  }

  /**
   * Obtiene el valor de dProtAut
   *
   * @return String
   */
  public function getDProtAut(): String
  {
    return $this->dProtAut;
  }

  /**
   * Obtiene el valor de gResProc
   *
   * @return array
   */
  public function getGResProc(): array
  {
    return $this->gResProc;
  }

  ///////////////////////////////////////////////////////////////////////
  // Instanciadores
  ///////////////////////////////////////////////////////////////////////  

  /**
   * Instancia un GResProcLote a partir de un objeto stdClass recibido como respuesta a una llamada SOAP al SIFEN.
   * 
   * @param stdClass $object
   * 
   * @return GResProcLote
   */
  public static function FromSifenResponseObject($object): GResProcLote
  {
    $res = new GResProcLote();

    if (isset($object->id)) $res->setId($object->id);
    else throw RespuestaException::porCampoFaltante("[GResProcLote] Error al instanciar respuesta, falta parametro: id", 'id');

    if (isset($object->dEstRes)) $res->setDEstRes($object->dEstRes);
    else throw RespuestaException::porCampoFaltante("[GResProcLote] Error al instanciar respuesta, falta parametro: dEstRes", 'dEstRes');

    if (isset($object->dProtAut)) $res->setDProtAut($object->dProtAut);

    if (isset($object->gResProc)) {
      $aux = array();
      if (is_array($object->gResProc)) {
        foreach ($object->gResProc as $item) {
          array_push($aux, GResProc::FromSifenResponseObject($item));
        }        
      }
      else {
        array_push($aux, GResProc::FromSifenResponseObject($object->gResProc));
      };
      $res->setGResProc($aux);
    } else throw RespuestaException::porCampoFaltante("[GResProcLote] Error al instanciar respuesta, falta parametro: gResProc", 'gResProc');

    return $res;
  }

  // --- Fase C (C6): lectura del resultado -------------------------------------------------------------------------

  /** Estado del resultado (dEstRes) como enum, o null si no vino o no se reconoce. */
  public function getEstado(): ?EstadoResultado
  {
    return EstadoResultado::fromTexto($this->dEstRes ?? null);
  }

  /** Aprobado o aprobado con observaciones según dEstRes; si no vino, decide el primer código (0260). */
  public function esAprobado(): bool
  {
    $estado = $this->getEstado();
    if ($estado !== null)
      return $estado->esAprobado();
    return ($this->getMotivos()[0] ?? null)?->esAprobacion() === true;
  }

  public function esRechazado(): bool
  {
    return !$this->esAprobado();
  }

  /**
   * Resultados de procesamiento (gResProc) en el orden recibido; el primero es el motivo principal.
   *
   * @return list<GResProc>
   */
  public function getMotivos(): array
  {
    return array_values($this->gResProc ?? []);
  }

  /** Código del primer resultado, como texto de cuatro dígitos; null si no hay resultados. */
  public function getCodigo(): ?string
  {
    return ($this->getMotivos()[0] ?? null)?->getCodigo();
  }

  /** Mensaje del primer resultado, o null si no hay resultados. */
  public function getMensaje(): ?string
  {
    return ($this->getMotivos()[0] ?? null)?->getMensaje();
  }

  /** Número de transacción (dProtAut) como texto, o null si no fue aprobado. */
  public function getProtocolo(): ?string
  {
    return isset($this->dProtAut) && (string) $this->dProtAut !== '' ? (string) $this->dProtAut : null;
  }

  /** Descripción del código principal según el catálogo del MT, o null. */
  public function getInfoValidacion(): ?InfoValidacion
  {
    $codigo = $this->getCodigo();
    return $codigo === null ? null : CatalogoValidaciones::describir($codigo);
  }

  /** CDC del DE (id), o null. */
  public function getCdc(): ?string
  {
    return $this->id ?? null;
  }

  /** @return array<string, mixed> */
  public function toArray(): array
  {
    return ['cdc' => $this->getCdc(), 'estado' => $this->dEstRes ?? null, 'codigo' => $this->getCodigo(), 'mensaje' => $this->getMensaje(), 'protocolo' => $this->getProtocolo()];
  }
}
