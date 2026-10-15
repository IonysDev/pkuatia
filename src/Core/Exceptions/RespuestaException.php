<?php

namespace IonysDev\Pkuatia\Core\Exceptions;

use Throwable;

/**
 * El SIFEN respondió, pero la respuesta no se pudo interpretar: le falta un campo que la clase de respuesta exige,
 * trae un tipo inesperado (TypeError del parseo) o no tiene la forma declarada por el WSDL. Reemplaza al
 * "Error Processing Request: null" de las versiones anteriores. La respuesta cruda queda disponible para guardarla o
 * diagnosticarla (por ejemplo, el dProtAut de un DE ya aprobado), igual que en Sifen::GetLastResponse().
 *
 * No es un rechazo del SIFEN: los rechazos (dCodRes distinto de aprobación) se devuelven como objetos de respuesta.
 */
class RespuestaException extends PkuatiaException
{
  private ?string $operacion = null;
  private ?string $campoFaltante = null;
  private ?string $respuestaCruda = null;

  /**
   * Envuelve la causa (TypeError, \Error o \Exception de una clase de respuesta) ocurrida en una operación del facade.
   */
  public static function desde(Throwable $causa, string $operacion, string $mensaje, ?string $respuestaCruda = null): self
  {
    $e = new self($mensaje, 0, $causa);
    $e->operacion = $operacion;
    $e->respuestaCruda = $respuestaCruda;
    $e->contexto['operacion'] = $operacion;
    if ($causa instanceof self && $causa->campoFaltante !== null) {
      $e->campoFaltante = $causa->campoFaltante;
      $e->contexto['campoFaltante'] = $causa->campoFaltante;
    }
    return $e;
  }

  /**
   * Para las clases de respuesta: la respuesta del SIFEN no trae un campo obligatorio.
   */
  public static function porCampoFaltante(string $mensaje, string $campo, ?string $operacion = null): self
  {
    $e = new self($mensaje);
    $e->campoFaltante = $campo;
    $e->operacion = $operacion;
    $e->contexto['campoFaltante'] = $campo;
    if ($operacion !== null)
      $e->contexto['operacion'] = $operacion;
    return $e;
  }

  /** Método del facade en el que ocurrió (EnviarDE, ConsultarRUC, …), si se conoce. */
  public function getOperacion(): ?string
  {
    return $this->operacion;
  }

  /** Campo que la respuesta debía traer y no trajo, si fue esa la causa. */
  public function getCampoFaltante(): ?string
  {
    return $this->campoFaltante;
  }

  /** XML crudo de la respuesta del SIFEN, si el facade pudo recuperarlo. */
  public function getRespuestaCruda(): ?string
  {
    return $this->respuestaCruda;
  }
}
