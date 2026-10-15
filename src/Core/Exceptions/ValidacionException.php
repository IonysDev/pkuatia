<?php

namespace IonysDev\Pkuatia\Core\Exceptions;

use InvalidArgumentException;

/**
 * Un dato que recibió la librería no cumple una regla del SIFEN o del XSD: valor fuera de rango, descripción
 * inválida, documento incompleto, lote mal armado, evento con CDC o motivo inválidos. Se detecta antes de tocar
 * la red. Hereda de \InvalidArgumentException (que ya es una \Exception), la base de las validaciones que la
 * librería lanzaba hasta 0.2.1, así que ningún catch existente deja de atraparla.
 *
 * CampoInvalidoException agrega el campo del Manual Técnico, el elemento XML y el código de validación del SIFEN.
 */
class ValidacionException extends InvalidArgumentException implements PkuatiaExceptionInterface
{
  use ContextoDeExcepcion;
}
