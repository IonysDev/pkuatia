<?php

namespace IonysDev\Pkuatia\Core\Exceptions;

use IonysDev\Pkuatia\Core\Constants\TipoFallaTransporte;
use SoapFault;
use Throwable;

/**
 * Falla de comunicación con el SIFEN en cualquiera de las siete operaciones del facade: el WSDL no carga, la
 * conexión no se establece o se corta, se agota la espera, la respuesta llega vacía, o el servidor devuelve una
 * falla SOAP. No es un rechazo del SIFEN (los rechazos se devuelven como objetos de respuesta).
 *
 * Decisión Q-C3 (opción C): extiende la clase SoapFault de PHP, que ya es una \Exception. Así `catch (\SoapFault)`
 * sigue atrapando las fallas de ConsultarRUC/ConsultarDE como hasta 0.2.1, `catch (\Exception)` sigue atrapando las
 * de las otras operaciones, y `catch (PkuatiaExceptionInterface)` atrapa todo. Conserva faultcode y faultstring y
 * deja el SoapFault original en getPrevious() (SoapFault::__construct no acepta la causa, por eso se fija aparte).
 *
 * Patrón de saturación o bloqueo temporal (WSDL o cuerpo vacío): ver SifenNoDisponibleException.
 */
class TransporteException extends SoapFault implements PkuatiaExceptionInterface
{
  use ContextoDeExcepcion;

  private string $operacion = '';
  private TipoFallaTransporte $tipo = TipoFallaTransporte::Desconocida;

  /**
   * @param string            $mensaje   Mensaje completo (con el prefijo "[Sifen] …" de la operación).
   * @param string            $operacion Método del facade (EnviarDE, ConsultarRUC, …).
   * @param TipoFallaTransporte|null $tipo Tipo de falla; null lo deduce del faultcode y del mensaje.
   * @param Throwable|null    $causa     SoapFault (u otra excepción) original.
   * @param string|array|null $faultcode faultcode del SoapFault original.
   */
  public function __construct(string $mensaje, string $operacion = '', ?TipoFallaTransporte $tipo = null, ?Throwable $causa = null, string|array|null $faultcode = null)
  {
    parent::__construct($faultcode, $mensaje);
    // La causa no se puede fijar por SoapFault::__construct: se usa el constructor de \Exception, que sí la acepta.
    \Exception::__construct($mensaje, 0, $causa);
    $this->operacion = $operacion;
    $this->tipo = $tipo ?? TipoFallaTransporte::deducir(is_string($faultcode) ? $faultcode : null, $mensaje);
    $this->contexto = ['operacion' => $operacion, 'tipo' => $this->tipo->value, 'faultcode' => $faultcode];
  }

  /**
   * Envuelve el SoapFault de una operación. Devuelve SifenNoDisponibleException cuando el patrón es el de saturación.
   *
   * @param string $prefijo Texto que precede al mensaje original, p. ej. "[Sifen] Error al enviar el documento electrónico al SIFEN".
   */
  public static function desde(SoapFault $causa, string $operacion, string $prefijo): self
  {
    $faultcode = isset($causa->faultcode) && is_string($causa->faultcode) ? $causa->faultcode : null;
    $tipo = TipoFallaTransporte::deducir($faultcode, $causa->getMessage());
    $clase = $tipo->esPosibleSaturacion() ? SifenNoDisponibleException::class : self::class;
    $e = new $clase($prefijo . ': ' . $causa->getMessage(), $operacion, $tipo, $causa, $faultcode);
    foreach (['faultactor', 'detail', 'faultname', 'headerfault'] as $propiedad) {
      if (isset($causa->{$propiedad}))
        $e->{$propiedad} = $causa->{$propiedad};
    }
    return $e;
  }

  /** Método del facade en el que ocurrió la falla (EnviarDE, ConsultarRUC, …). */
  public function getOperacion(): string
  {
    return $this->operacion;
  }

  public function getTipo(): TipoFallaTransporte
  {
    return $this->tipo;
  }

  /** Ver TipoFallaTransporte::esPosibleSaturacion(). */
  public function esPosibleSaturacion(): bool
  {
    return $this->tipo->esPosibleSaturacion();
  }
}
