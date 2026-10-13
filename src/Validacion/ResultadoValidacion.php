<?php

namespace IonysDev\Pkuatia\Validacion;

use ArrayIterator;
use Countable;
use IonysDev\Pkuatia\Core\Exceptions\DocumentoInvalidoException;
use IteratorAggregate;
use Traversable;

/**
 * Resultado de una validación (Fase C): la lista de errores y de advertencias. Es válido cuando no hay errores; las
 * advertencias (reglas que el SIFEN aprueba con observaciones) no invalidan. Se cuenta y se recorre por los errores.
 *
 * @implements IteratorAggregate<int, ErrorValidacion>
 */
final class ResultadoValidacion implements Countable, IteratorAggregate
{
  /** @var list<ErrorValidacion> */
  private array $errores = [];
  /** @var list<ErrorValidacion> */
  private array $advertencias = [];

  public function agregar(ErrorValidacion $error): self
  {
    if ($error->esAdvertencia)
      $this->advertencias[] = $error;
    else
      $this->errores[] = $error;
    return $this;
  }

  public function esValido(): bool
  {
    return $this->errores === [];
  }

  /** @return list<ErrorValidacion> */
  public function getErrores(): array
  {
    return $this->errores;
  }

  /** @return list<ErrorValidacion> */
  public function getAdvertencias(): array
  {
    return $this->advertencias;
  }

  /** Errores y advertencias, en el orden en que se detectaron. @return list<ErrorValidacion> */
  public function getTodos(): array
  {
    return array_merge($this->errores, $this->advertencias);
  }

  /** @return list<ErrorValidacion> */
  public function porCodigo(string $codigoSifen): array
  {
    return array_values(array_filter($this->getTodos(), static fn (ErrorValidacion $e): bool => $e->codigoSifen === $codigoSifen));
  }

  /** @return list<ErrorValidacion> */
  public function porCampo(string $campoMT): array
  {
    return array_values(array_filter($this->getTodos(), static fn (ErrorValidacion $e): bool => $e->campoMT === $campoMT));
  }

  /** @return list<ErrorValidacion> */
  public function porOrigen(OrigenError $origen): array
  {
    return array_values(array_filter($this->getTodos(), static fn (ErrorValidacion $e): bool => $e->origen === $origen));
  }

  /** Lanza DocumentoInvalidoException (una ValidacionException) si hay errores; con solo advertencias no lanza. */
  public function lanzarSiInvalido(string $mensaje = 'El documento no es válido'): void
  {
    if (!$this->esValido())
      throw DocumentoInvalidoException::desde($this, $mensaje);
  }

  public function count(): int
  {
    return count($this->errores);
  }

  public function getIterator(): Traversable
  {
    return new ArrayIterator($this->errores);
  }

  public function __toString(): string
  {
    $texto = $this->esValido() ? 'Válido' : count($this->errores) . ' error(es):' . "\n- " . implode("\n- ", array_map('strval', $this->errores));
    if ($this->advertencias !== [])
      $texto .= ($this->esValido() ? ' con ' : "\n") . count($this->advertencias) . ' advertencia(s)' . ($this->esValido() ? '' : ":\n- " . implode("\n- ", array_map('strval', $this->advertencias)));
    return $texto;
  }
}
