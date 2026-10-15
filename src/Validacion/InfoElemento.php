<?php

namespace IonysDev\Pkuatia\Validacion;

/**
 * Un elemento del XSD del DE (DE_v150.xsd, copia fiel de ekuat-ia) con sus ocurrencias, su padre, su línea y el ID
 * del Manual Técnico. Fase C, paso C5; lo usan el validador de reglas (completitud) y ValidarXSD (campo del error).
 */
final class InfoElemento
{
  /**
   * @param string      $nombre         Nombre del elemento, sin espacios (p. ej. "dEntCont").
   * @param string      $nombreOriginal Nombre tal como lo declara el XSD (p. ej. "dEntCont " con espacio final, PK-44).
   * @param string|null $tipo           Tipo declarado (p. ej. "tgDTim", "tdNumTim") o null si es un tipo en línea.
   * @param int         $minOccurs      1 = obligatorio dentro de su grupo.
   * @param int|null    $maxOccurs      Null = sin límite ("unbounded").
   * @param string|null $padre          Tipo complejo (p. ej. "tgDTim") o elemento que lo contiene.
   * @param string      $contenedor     "sequence", "choice" o "all".
   * @param int         $linea          Línea en DE_v150.xsd, para citar.
   * @param string|null $campoMT        ID del Manual Técnico (p. ej. "C004"), si campos-obligatorios.md lo tiene.
   * @param bool        $esGrupo        True si contiene otros elementos.
   */
  public function __construct(
    public readonly string $nombre,
    public readonly string $nombreOriginal,
    public readonly ?string $tipo,
    public readonly int $minOccurs,
    public readonly ?int $maxOccurs,
    public readonly ?string $padre,
    public readonly string $contenedor,
    public readonly int $linea,
    public readonly ?string $campoMT,
    public readonly bool $esGrupo,
  ) {
  }

  public function esObligatorio(): bool
  {
    return $this->minOccurs >= 1 && $this->contenedor !== 'choice';
  }

  public function esLista(): bool
  {
    return $this->maxOccurs === null || $this->maxOccurs > 1;
  }

  /** Cita para docblocks y mensajes: "DE_v150.xsd:327". */
  public function cita(): string
  {
    return 'DE_v150.xsd:' . $this->linea;
  }
}
