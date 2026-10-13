<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Estado del RUC consultado (dCodEstCons de rContRUC, WS siConsRUC). Fase C, paso C4.
 *
 * Fuente: los códigos y descripciones que RContRUC::getDDesEstCons() deriva desde 2023; ACT está confirmado por las
 * capturas reales (dCodEstCons "ACT", dDesEstCons "ACTIVO", 2026-10-06/01 y 2026-10-09/01). Los demás códigos no
 * fueron capturados: `[PENDIENTE DE VERIFICACIÓN]` contra el MT o contra una consulta real.
 */
enum EstadoRuc: string
{
  case Activo = 'ACT';
  case SuspensionTemporal = 'SUS';
  case SuspensionAdministrativa = 'SAD';
  case Bloqueado = 'BLQ';
  case Cancelado = 'CAN';
  case CanceladoDefinitivo = 'CDE';

  public function descripcion(): string
  {
    return match ($this) {
      self::Activo => 'Activo',
      self::SuspensionTemporal => 'Suspensión Temporal',
      self::SuspensionAdministrativa => 'Suspensión Administrativa',
      self::Bloqueado => 'Bloqueado',
      self::Cancelado => 'Cancelado',
      self::CanceladoDefinitivo => 'Cancelado Definitivo',
    };
  }

  /** Solo un RUC activo puede emitir y recibir documentos electrónicos (validaciones 1252, 1307, 1308, 2304). */
  public function esActivo(): bool
  {
    return $this === self::Activo;
  }
}
