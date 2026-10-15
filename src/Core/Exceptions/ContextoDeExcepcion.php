<?php

namespace IonysDev\Pkuatia\Core\Exceptions;

/**
 * Contexto de diagnóstico compartido por las excepciones de la librería (ver PkuatiaExceptionInterface).
 */
trait ContextoDeExcepcion
{
  /** @var array<string, mixed> */
  protected array $contexto = [];

  /**
   * Agrega datos de contexto y devuelve la misma excepción, para encadenar antes de lanzar. Nunca pasar secretos.
   *
   * @param array<string, mixed> $contexto
   */
  public function conContexto(array $contexto): static
  {
    $this->contexto = array_merge($this->contexto, $contexto);
    return $this;
  }

  /** @return array<string, mixed> */
  public function getContexto(): array
  {
    return $this->contexto;
  }
}
