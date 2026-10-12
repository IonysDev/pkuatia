<?php

namespace IonysDev\Pkuatia\Core\Exceptions;

/**
 * Validación de un campo concreto, con los datos que permiten pasar del error a "qué tocar": el ID del campo en el
 * Manual Técnico (p. ej. D208), el elemento XML (iTipIDRec), el valor recibido, la regla esperada y, cuando existe,
 * el código de validación con el que el SIFEN rechazaría el documento (p. ej. 1321).
 */
class CampoInvalidoException extends ValidacionException
{
  private ?string $campoMT = null;
  private ?string $elemento = null;
  private mixed $valorRecibido = null;
  private ?string $reglaEsperada = null;
  private ?string $codigoSifen = null;

  public static function deCampo(string $mensaje, ?string $campoMT = null, ?string $elemento = null, mixed $valorRecibido = null, ?string $reglaEsperada = null, ?string $codigoSifen = null): self
  {
    $e = new self($mensaje);
    $e->campoMT = $campoMT;
    $e->elemento = $elemento;
    $e->valorRecibido = $valorRecibido;
    $e->reglaEsperada = $reglaEsperada;
    $e->codigoSifen = $codigoSifen;
    $e->contexto = array_filter(
      ['campoMT' => $campoMT, 'elemento' => $elemento, 'valorRecibido' => $valorRecibido, 'reglaEsperada' => $reglaEsperada, 'codigoSifen' => $codigoSifen],
      static fn ($v) => $v !== null
    );
    return $e;
  }

  /** ID del campo en el Manual Técnico (p. ej. "D208"), si se conoce. */
  public function getCampoMT(): ?string
  {
    return $this->campoMT;
  }

  /** Nombre del elemento XML (p. ej. "iTipIDRec"), si se conoce. */
  public function getElemento(): ?string
  {
    return $this->elemento;
  }

  public function getValorRecibido(): mixed
  {
    return $this->valorRecibido;
  }

  /** Regla que el valor debía cumplir, en texto (tipo del XSD, rango, fórmula). */
  public function getReglaEsperada(): ?string
  {
    return $this->reglaEsperada;
  }

  /** Código de validación del SIFEN con cero inicial (p. ej. "1321"), si la regla tiene uno. */
  public function getCodigoSifen(): ?string
  {
    return $this->codigoSifen;
  }
}
