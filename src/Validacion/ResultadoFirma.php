<?php

namespace IonysDev\Pkuatia\Validacion;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

/**
 * Resultado de Sifen::VerificarFirma() (Fase C, paso C8): las firmas encontradas y los errores. Es válido cuando hay
 * al menos una firma y ningún error. Se puede contar (cantidad de firmas) y recorrer (InfoFirma).
 *
 * @implements IteratorAggregate<int, InfoFirma>
 */
final class ResultadoFirma implements Countable, IteratorAggregate
{
  /**
   * @param list<InfoFirma>       $firmas
   * @param list<ErrorValidacion> $errores
   * @param string                $tipoDocumento "rDE", "gGroupGesEve", "rGesEve" o "desconocido".
   */
  public function __construct(
    private readonly array $firmas,
    private readonly array $errores,
    private readonly string $tipoDocumento,
  ) {
  }

  public function esValida(): bool
  {
    return $this->firmas !== [] && $this->errores === [];
  }

  /** @return list<InfoFirma> */
  public function getFirmas(): array
  {
    return $this->firmas;
  }

  /** @return list<ErrorValidacion> */
  public function getErrores(): array
  {
    return $this->errores;
  }

  public function getTipoDocumento(): string
  {
    return $this->tipoDocumento;
  }

  public function count(): int
  {
    return count($this->firmas);
  }

  public function getIterator(): Traversable
  {
    return new ArrayIterator($this->firmas);
  }

  public function __toString(): string
  {
    if ($this->esValida())
      return sprintf('Firma válida: %d firma(s) en %s', count($this->firmas), $this->tipoDocumento);
    return sprintf('Firma inválida (%s): %s', $this->tipoDocumento, implode('; ', array_map('strval', $this->errores)));
  }
}
