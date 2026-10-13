<?php

namespace IonysDev\Pkuatia\Core\Exceptions;

use Exception;

/**
 * Base de las excepciones de PKuatia que hasta 0.2.1 se lanzaban como \Exception genérica (Fase C, paso C2).
 * Conserva la firma del constructor de \Exception, así que reemplaza a la genérica sin cambiar ninguna llamada.
 *
 * Subclases: ConfiguracionException (y CertificadoException), FirmaException, RespuestaException.
 * ValidacionException y TransporteException no heredan de esta clase porque conservan otras bases históricas
 * (\InvalidArgumentException y \SoapFault); las une PkuatiaExceptionInterface.
 */
class PkuatiaException extends Exception implements PkuatiaExceptionInterface
{
  use ContextoDeExcepcion;
}
