<?php

namespace IonysDev\Pkuatia\Validacion;

/**
 * Un problema encontrado al validar un documento, una firma o un XML (Fase C): el mismo tipo para el XSD, la
 * completitud, las reglas del MT y la firma, para que quien lo recibe pueda tratarlos igual.
 */
final class ErrorValidacion
{
  /**
   * @param OrigenError $origen        Control que lo detectó.
   * @param string      $mensaje       Qué está mal, en castellano.
   * @param string|null $codigoSifen   Código con el que el SIFEN rechazaría el documento (p. ej. "1321"), si existe.
   * @param string|null $campoMT       ID del campo en el Manual Técnico (p. ej. "D208").
   * @param string|null $elemento      Elemento XML (p. ej. "iTipIDRec").
   * @param string|null $ruta          Dónde está dentro del documento (p. ej. "gCamItem[2].gCamIVA.dTasaIVA").
   * @param mixed       $valor         Valor recibido, si aplica.
   * @param string|null $sugerencia    Qué hacer: método de PKuatia o regla esperada.
   * @param int|null    $linea         Línea del XML, cuando el control trabaja sobre texto.
   * @param bool        $esAdvertencia True si el SIFEN aprobaría con observaciones (AO) en vez de rechazar.
   */
  public function __construct(
    public readonly OrigenError $origen,
    public readonly string $mensaje,
    public readonly ?string $codigoSifen = null,
    public readonly ?string $campoMT = null,
    public readonly ?string $elemento = null,
    public readonly ?string $ruta = null,
    public readonly mixed $valor = null,
    public readonly ?string $sugerencia = null,
    public readonly ?int $linea = null,
    public readonly bool $esAdvertencia = false,
  ) {
  }

  /** Descripción del código del SIFEN según el catálogo, o null si no tiene código. */
  public function getInfoValidacion(): ?InfoValidacion
  {
    return $this->codigoSifen === null ? null : CatalogoValidaciones::describir($this->codigoSifen);
  }

  public function __toString(): string
  {
    $partes = [strtoupper($this->origen->value)];
    if ($this->codigoSifen !== null)
      $partes[] = $this->codigoSifen;
    if ($this->campoMT !== null)
      $partes[] = $this->campoMT;
    if ($this->elemento !== null)
      $partes[] = $this->elemento;
    $texto = '[' . implode(' ', $partes) . '] ' . $this->mensaje;
    if ($this->ruta !== null)
      $texto .= " (en {$this->ruta})";
    if ($this->linea !== null)
      $texto .= " (línea {$this->linea})";
    if ($this->sugerencia !== null)
      $texto .= '. Sugerencia: ' . $this->sugerencia;
    return $texto;
  }
}
