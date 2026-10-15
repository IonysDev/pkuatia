<?php

namespace IonysDev\Pkuatia\Core\Responses;

use IonysDev\Pkuatia\Core\Fields\Response\Event\GResProcEVe;
use IonysDev\Pkuatia\Core\Fields\Response\RProtDe;
use IonysDev\Pkuatia\Helpers\FechaHelper;

use DateTime;
use SimpleXMLElement;
use IonysDev\Pkuatia\Core\Exceptions\RespuestaException;

//id: GRSch01,respuesta del registro de eventos
class RRetEnviEventoDe implements RespuestaSifen
{                            // Id - Longitud - Ocurrencia - Descripción
  public DateTime $dFecProc; //GRSch02 - 19 - 1-1  - Fecha y hora del procesamiento del último evento enviado - 19 - 1-1
  public array $gResProcEVe; //GRSch03 - G  - 1-15 - Grupo Resultado del procesamiento del evento - Sin longitud - 0-50


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
   * Establece el valor de gResProcEVe
   *
   * @param array $gResProcEVe
   *
   * @return self
   */
  public function setGResProcEVe(array $gResProcEVe): self
  {
    return $this->seGResProcEVe($gResProcEVe);
  }

  /**
   * @deprecated Usar setGResProcEVe() (typo histórico en el nombre del método).
   *
   * @param array $gResProcEVe
   *
   * @return self
   */
  public function seGResProcEVe(array $gResProcEVe): self
  {
    $this->gResProcEVe = $gResProcEVe;

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
   * Obtiene el valor de gResProcEVe
   *
   * @return array
   */
  public function getGResProcEVe(): array
  {
    return $this->geGResProcEVe();
  }

  /**
   * @deprecated Usar getGResProcEVe() (typo histórico en el nombre del método).
   *
   * @return array
   */
  public function geGResProcEVe(): array
  {
    return $this->gResProcEVe;
  }

  public static function FromSifenResponseObject($object)
  {
    if (is_null($object)) {
      throw new RespuestaException("Error Processing Request: null", 1);
    }
    $res = new RRetEnviEventoDe();
    // Rechazo genérico: el SIFEN responde con el sobre rRetEnviDe > rProtDe (capturado para recepción y
    // consulta de RUC, respuestas-ws/2026-10-06; para eventos [PENDIENTE DE VERIFICACIÓN]). Se expone como
    // un gResProcEVe con el estado y los mensajes, sin id.
    if (isset($object->rProtDe)) {
      $prot = RProtDe::FromSifenResponseObject($object->rProtDe);
      if (isset($prot->dFecProc))
        $res->setDFecProc($prot->getDFecProc());
      $res->seGResProcEVe([(new GResProcEVe())->setDEstRes($prot->getDEstRes())->setGResProc($prot->getGResProc())]);
      return $res;
    }
    // Con zona en la respuesta directa, sin zona dentro de xContEv: FechaHelper acepta los dos (PK-29).
    $res->setDFecProc(FechaHelper::FromSifen($object->dFecProc, 'dFecProc'));
    $gResProcEVe = array();
    if (isset($object->gResProcEVe)) {
      if(is_array($object->gResProcEVe)) {
        foreach($object->gResProcEVe as $item) {
          $aux = GResProcEVe::FromSifenResponseObject($item);
          array_push($gResProcEVe, $aux);
        }
      } else {
        $aux = GResProcEVe::FromSifenResponseObject($object->gResProcEVe);
        array_push($gResProcEVe, $aux);
      }
    }
    $res->seGResProcEVe($gResProcEVe);
    return $res;
  }

  public static function FromSimpleXMLElement(SimpleXMLElement $node):self
  {
    if(strcmp($node->getName(),'rRetEnviEventoDe') != 0) {
      throw new RespuestaException("Invalid XML Element:" . $node->getName());
    }

    $res = new RRetEnviEventoDe();
    // Hasta 0.2.0 solo se aceptaba la fecha sin zona; la respuesta directa la trae con zona (PK-29).
    $res->setDFecProc(FechaHelper::FromSifen($node->dFecProc, 'dFecProc'));
    ///create the array
    $gResProcEVe = array();
    if (isset($node->gResProcEVe)) {
      foreach ($node->gResProcEVe as $procNode) {
        $gResProcEVe[] = GResProcEVe::FromSimpleXMLElement($procNode);
      }
      $res->setGResProcEVe($gResProcEVe);
    }

    return $res;
  }

  use RespuestaSifenTrait;

  // --- Fase C (C6): RespuestaSifen y lectura de los eventos --------------------------------------------------------

  /**
   * Resultado de cada evento del sobre (gResProcEVe), en el orden recibido.
   *
   * @return list<GResProcEVe>
   */
  public function getResultados(): array
  {
    return array_values($this->gResProcEVe ?? []);
  }

  /** Código del primer evento, como texto de cuatro dígitos; null si no hay resultados. */
  public function getCodigo(): ?string
  {
    return ($this->getResultados()[0] ?? null)?->getCodigo();
  }

  public function getMensaje(): ?string
  {
    return ($this->getResultados()[0] ?? null)?->getMensaje();
  }

  /** Todos los eventos del sobre fueron registrados (0600). */
  public function esExitosa(): bool
  {
    return $this->todosAprobados();
  }

  public function todosAprobados(): bool
  {
    $resultados = $this->getResultados();
    if ($resultados === [])
      return false;
    foreach ($resultados as $resultado) {
      if (!$resultado->esAprobado())
        return false;
    }
    return true;
  }

  /** @return list<GResProcEVe> */
  public function getRechazados(): array
  {
    return array_values(array_filter($this->getResultados(), static fn (GResProcEVe $r): bool => $r->esRechazado()));
  }

  /** Resultado del evento con ese Id (el Id del rEve enviado), o null. */
  public function getResultadoDelEvento(int|string $id): ?GResProcEVe
  {
    foreach ($this->getResultados() as $resultado) {
      if ($resultado->getIdEvento() === (string) $id)
        return $resultado;
    }
    return null;
  }

  public function getFechaProceso(): ?DateTime
  {
    return $this->dFecProc ?? null;
  }

  public function toArray(): array
  {
    return [
      'codigo' => $this->getCodigo(),
      'mensaje' => $this->getMensaje(),
      'exitosa' => $this->esExitosa(),
      'fechaProceso' => self::fechaIso($this->getFechaProceso()),
      'eventos' => array_map(static fn (GResProcEVe $r): array => $r->toArray(), $this->getResultados()),
    ];
  }
}
