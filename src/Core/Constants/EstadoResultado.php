<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Estado del resultado de procesamiento (dEstRes de rProtDe, gResProcLote y gResProcEVe), según la sección 12.1 del
 * Manual Técnico v150 (ekuat-ia 08-errores-y-respuestas/estructura-codigos.md): A aprobado, AO aprobado con
 * observaciones (el DE se convierte en DTE, por ejemplo por extemporaneidad), R rechazado. Fase C, paso C4.
 *
 * Literales reales: "Aprobado" y "Rechazado" (capturas 2026-10-06, 09 y 11). El literal de "aprobado con observación"
 * nunca fue capturado: `[PENDIENTE DE VERIFICACIÓN]`; fromTexto() lo reconoce con o sin tilde.
 */
enum EstadoResultado: string
{
  case Aprobado = 'Aprobado';
  case AprobadoConObservacion = 'Aprobado con observación';
  case Rechazado = 'Rechazado';

  /** Reconoce el texto con tolerancia a espacios, mayúsculas y tildes. Null si no es un estado conocido. */
  public static function fromTexto(?string $texto): ?self
  {
    if ($texto === null)
      return null;
    $n = mb_strtolower(trim($texto));
    $n = strtr($n, ['á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u']);
    $n = preg_replace('/\s+/', ' ', $n);
    return match (true) {
      $n === 'aprobado' => self::Aprobado,
      str_starts_with($n, 'aprobado con observaci') => self::AprobadoConObservacion,
      $n === 'rechazado' => self::Rechazado,
      default => null,
    };
  }

  /** Aprobado o aprobado con observaciones: en ambos casos el DE queda como DTE. */
  public function esAprobado(): bool
  {
    return $this !== self::Rechazado;
  }

  /** Abreviatura con la que el MT lo escribe en las tablas de validación: A, AO o R. */
  public function letra(): string
  {
    return match ($this) {
      self::Aprobado => 'A',
      self::AprobadoConObservacion => 'AO',
      self::Rechazado => 'R',
    };
  }
}
