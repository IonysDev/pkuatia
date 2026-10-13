<?php

namespace IonysDev\Pkuatia\Core\Fields\Response\Event;

use IonysDev\Pkuatia\Core\Fields\Response\GResProc;
use SimpleXMLElement;
use IonysDev\Pkuatia\Core\Exceptions\RespuestaException;
use IonysDev\Pkuatia\Core\Constants\EstadoResultado;
use IonysDev\Pkuatia\Validacion\CatalogoValidaciones;
use IonysDev\Pkuatia\Validacion\InfoValidacion;

//ID: CRSch05, Grupo resultado del procesamiento del lote


class GResProcEVe
{
                          // Id - Longitud - Ocurrencia - Descripción
  public String $dEstRes; // GRSch030 - 8-30 - 1-1   - Estado del resultado
  public int $dProtAut;   // GRSch031 - 10   - 0-1   - Número de transacción
  public int $id;         // GRSch032 - 10   - 1-1   - Identificador del evento
  public array $gResProc; // GRSch033 - G    - 1-100 - Grupo Resultado de Procesamiento 
                        

  /**
   * Establece el valor de id
   *
   * @param string $id
   *
   * @return self
   */
  public function setId(string $id): self
  {
    $this->id = $id;

    return $this;
  }


  /**
   * Establece el valor de dEstRes
   *
   * @param string $dEstRes
   *
   * @return self
   */
  public function setDEstRes(string $dEstRes): self
  {
    $this->dEstRes = $dEstRes;

    return $this;
  }


  /**
   * Establece el valor de dProtAut
   *
   * @param string $dProtAut
   *
   * @return self
   */
  public function setDProtAut(string $dProtAut): self
  {
    $this->dProtAut = $dProtAut;

    return $this;
  }




  /**
   * Obtiene el id del evento (GRSch032), o null si no viene: la copia de la respuesta dentro de xContEv no
   * lo trae (respuestas-ws/2026-10-09/09, observación 5). Hasta 0.2.0 terminaba en Error.
   *
   * @return string|null
   */
  public function getId(): ?string
  {
    return isset($this->id) ? (string) $this->id : null;
  }

  /**
   * Obtiene el valor de dEstRes
   *
   * @return string
   */
  public function getDEstRes(): string
  {
    return $this->dEstRes;
  }

  /**
   * Obtiene el número de transacción (GRSch031, 0-1), o null si el evento no fue aprobado (4009, 0100...).
   * Hasta 0.2.0 terminaba en Error en esos casos.
   *
   * @return string|null
   */
  public function getDProtAut(): ?string
  {
    return isset($this->dProtAut) ? (string) $this->dProtAut : null;
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

  public static function FromSimpleXMLElement(SimpleXMLElement $node):self
  {
      if(strcmp($node->getName(),'gResProcEVe') != 0) {
        throw new RespuestaException("Invalid XML Element: $node->getName()");
      }

      $res = new GResProcEVe();
      $res->setDEstRes($node->dEstRes);
      if(isset($node->dProtAut)) {
        $res->setDProtAut($node->dProtAut);
      }
      if(isset($node->id)) {
        $res->setId($node->id);
      }
      // gResProc puede ocurrir de 1 a 100 veces: iterar con foreach recorre todos los
      // hermanos del mismo nombre en SimpleXML (un if is_array() jamás se cumple aquí).
      $gResProc = array();
      foreach($node->gResProc as $proc) {
        $aux = new GResProc();
        $aux->setDCodRes($proc->dCodRes);
        $aux->setDMsgRes($proc->dMsgRes);
        $gResProc[] = $aux;
      }
      $res->setGResProc($gResProc);

      return $res;
  }

  /**
   * Creates a GResProcEVe instance from a Sifen Response Object
   * 
   * @param mixed $object The response object from Sifen
   * @return self
   * @throws \Exception If object is null or invalid
   */
  public static function FromSifenResponseObject($object): self
  {
    if (is_null($object)) {
      throw new RespuestaException("[GResProcEVe] Error Processing Request: null");
    }

    $res = new GResProcEVe();
    $res->setDEstRes($object->dEstRes);
    if (isset($object->dProtAut)) {
      $res->setDProtAut($object->dProtAut);
    }
    $res->setId($object->id);
    
    $gResProc = array();
    if (isset($object->gResProc)) {
      if (is_array($object->gResProc)) {
        foreach ($object->gResProc as $proc) {
          $aux = GResProc::FromSifenResponseObject($proc);
          $gResProc[] = $aux;
        }

      } else {
        $aux = GResProc::FromSifenResponseObject($object->gResProc);
        $gResProc[] = $aux;
      }
    }
    $res->setGResProc($gResProc);
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

  /** Identificador del evento (id, repite el Id del rEve enviado) como texto, o null. */
  public function getIdEvento(): ?string
  {
    return isset($this->id) ? (string) $this->id : null;
  }

  /** @return array<string, mixed> */
  public function toArray(): array
  {
    return ['id' => $this->getIdEvento(), 'estado' => $this->dEstRes ?? null, 'codigo' => $this->getCodigo(), 'mensaje' => $this->getMensaje(), 'protocolo' => $this->getProtocolo()];
  }
}
