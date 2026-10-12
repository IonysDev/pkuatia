<?php

namespace IonysDev\Pkuatia\Validacion;

use IonysDev\Pkuatia\Core\Constants\EstadoResultado;

/**
 * Descripción de un código de validación del SIFEN (Fase C, paso C5): lo que el Manual Técnico dice de ese código
 * y, cuando se conoce, qué método de PKuatia toca el campo. Ver CatalogoValidaciones::describir().
 */
final class InfoValidacion
{
  /**
   * @param string      $codigo        Código de cuatro dígitos con cero inicial, como en dCodRes (p. ej. "1321").
   * @param string|null $id            ID de la validación en el MT (p. ej. "D208c"); null cuando no tiene.
   * @param string      $mensaje       Mensaje de validación del MT (lo que el SIFEN devuelve en dMsgRes, sin el prefijo del ambiente).
   * @param string      $estado        Estado resultante según el MT: "A", "AO" o "R".
   * @param string      $grupo         Sección del MT a la que pertenece (grupo de campos o web service).
   * @param string      $observacion   Observación del MT: la regla que aplica.
   * @param bool        $vigente       False si el MT v150 eliminó la validación.
   * @param string      $origen        "de" (validaciones del DE), "evento" o "ws" (códigos de los web services).
   * @param string      $fuente        Archivo y línea de ekuat-ia (o enum) de donde sale.
   * @param string|null $metodoPkuatia Método de PKuatia con el que se informa el campo, si se conoce.
   */
  public function __construct(
    public readonly string $codigo,
    public readonly ?string $id,
    public readonly string $mensaje,
    public readonly string $estado,
    public readonly string $grupo,
    public readonly string $observacion,
    public readonly bool $vigente,
    public readonly string $origen,
    public readonly string $fuente,
    public readonly ?string $metodoPkuatia,
  ) {
  }

  public function getEstadoResultado(): ?EstadoResultado
  {
    return match ($this->estado) {
      'A' => EstadoResultado::Aprobado,
      'AO' => EstadoResultado::AprobadoConObservacion,
      'R' => EstadoResultado::Rechazado,
      default => null,
    };
  }

  public function esRechazo(): bool
  {
    return $this->estado === 'R';
  }

  public function __toString(): string
  {
    return $this->codigo . ($this->id !== null ? " ({$this->id})" : '') . ': ' . $this->mensaje;
  }
}
