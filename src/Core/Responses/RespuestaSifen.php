<?php

namespace IonysDev\Pkuatia\Core\Responses;

use DateTime;
use IonysDev\Pkuatia\Core\Constants\CodigoResultadoWS;
use IonysDev\Pkuatia\Validacion\InfoValidacion;

/**
 * Lo que tienen en común las siete respuestas del facade (Fase C, paso C6; evaluación §7.2): el código y el mensaje
 * principales, si el SIFEN aceptó la solicitud, y la descripción del código según el catálogo.
 *
 * Los nombres son nuevos a propósito: los getters históricos (getDCodRes() devuelve int en unas clases y String en
 * otras, getDCodResLot() en la consulta de lote) no cambian; getCodigo() siempre devuelve el código como texto de
 * cuatro dígitos con cero inicial, listo para comparar con CodigoResultadoWS o con CatalogoValidaciones.
 */
interface RespuestaSifen
{
  /** Código de resultado principal, como texto de cuatro dígitos ("0260"); null si la respuesta no lo trae. */
  public function getCodigo(): ?string;

  /** Mensaje de resultado principal (dMsgRes), o null si la respuesta no lo trae. */
  public function getMensaje(): ?string;

  /**
   * El SIFEN aceptó la solicitud: DE autorizado, lote encolado o concluido, CDC o RUC encontrado, eventos registrados,
   * archivo encontrado. Un rechazo es una respuesta válida, no una excepción: ver getInfoValidacion().
   */
  public function esExitosa(): bool;

  /** El código como caso del enum, o null si no es un código de web service (p. ej. una validación del DE). */
  public function getCodigoResultado(): ?CodigoResultadoWS;

  /** Descripción del código según el catálogo del MT (campo, regla, método de PKuatia), o null si no se conoce. */
  public function getInfoValidacion(): ?InfoValidacion;

  /** Fecha y hora de procesamiento (dFecProc), o null si la respuesta no la trae (consulta de RUC). */
  public function getFechaProceso(): ?DateTime;

  /**
   * Resumen de la respuesta con claves estables (codigo, mensaje, exitosa, fechaProceso y las propias de cada
   * operación), para registrar o serializar.
   *
   * @return array<string, mixed>
   */
  public function toArray(): array;
}
