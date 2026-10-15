<?php

namespace IonysDev\Pkuatia\Core\Exceptions;

use IonysDev\Pkuatia\Core\Constants\MotivoCertificado;
use Throwable;

/**
 * Problema con el certificado o la clave privada del emisor: archivo que no existe, contraseña incorrecta, PKCS#12
 * con cifrado heredado que OpenSSL 3 no abre, PEM sin certificado o sin clave, formato no soportado.
 * El motivo permite reaccionar sin analizar el mensaje (por ejemplo, pedir de nuevo la contraseña).
 */
class CertificadoException extends ConfiguracionException
{
  private ?MotivoCertificado $motivo = null;

  public static function porMotivo(MotivoCertificado $motivo, string $mensaje, ?Throwable $causa = null): self
  {
    $e = new self($mensaje, 0, $causa);
    $e->motivo = $motivo;
    $e->contexto['motivo'] = $motivo->value;
    return $e;
  }

  public function getMotivo(): ?MotivoCertificado
  {
    return $this->motivo;
  }
}
