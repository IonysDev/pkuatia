<?php

namespace IonysDev\Pkuatia\Core\Exceptions;

use Throwable;

/**
 * Marca común de todas las excepciones que lanza PKuatia desde 0.3.0 (Fase C).
 *
 * PHP no permite que una clase herede de dos bases a la vez, y la librería necesita conservar las bases históricas
 * (\Exception, \InvalidArgumentException y \SoapFault) para que todo catch escrito contra 0.2.x siga funcionando.
 * Esta interfaz permite atraparlas todas con un solo `catch (PkuatiaExceptionInterface $e)`.
 */
interface PkuatiaExceptionInterface extends Throwable
{
  /**
   * Datos que ayudan a diagnosticar el error (operación, campo, código del SIFEN, tipo de falla…).
   * Nunca incluye secretos: ni contraseñas, ni CSC, ni material de claves.
   *
   * @return array<string, mixed>
   */
  public function getContexto(): array;
}
