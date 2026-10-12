<?php

namespace IonysDev\Pkuatia\Validacion\Reglas;

use DateTime;
use DateTimeInterface;
use IonysDev\Pkuatia\Validacion\CatalogoValidaciones;
use IonysDev\Pkuatia\Validacion\ErrorValidacion;
use IonysDev\Pkuatia\Validacion\OrigenError;
use IonysDev\Pkuatia\Validacion\ResultadoValidacion;
use IonysDev\Pkuatia\Validacion\VistaDocumento;

/**
 * Base de los conjuntos de reglas del validador (Fase C). Cada conjunto agrega al resultado un ErrorValidacion por
 * regla incumplida, con el mensaje del Manual Técnico (catálogo de C5), el campo del MT, el elemento XML, la ruta y
 * el método de PKuatia que informa el campo. Todas las lecturas pasan por v()/entero()/texto()/fecha(): propiedades
 * públicas con isset, nunca getters, para no terminar en Error con un documento a medio armar.
 */
abstract class ConjuntoDeReglas
{
  abstract public static function aplicar(VistaDocumento $v, ResultadoValidacion $r, DateTime $ahora): void;

  /** Agrega el error del catálogo cuando la condición se cumple; si el MT lo marca AO, va como advertencia. */
  protected static function regla(ResultadoValidacion $r, bool $condicion, string $codigo, string $elemento, string $ruta, mixed $valor = null, ?string $detalle = null): void
  {
    if (!$condicion)
      return;
    $info = CatalogoValidaciones::describir($codigo);
    $campo = $info?->id !== null ? preg_replace('/[a-z]$/', '', $info->id) : null;
    $metodo = $campo !== null ? CatalogoValidaciones::metodoPkuatia($campo) : null;
    $sugerencia = trim(($detalle !== null ? $detalle . ' ' : '') . ($metodo !== null ? "Ver $metodo." : ''));
    $r->agregar(new ErrorValidacion(OrigenError::Regla, $info?->mensaje ?? "Validación $codigo del SIFEN.", $codigo, $campo, $elemento, $ruta,
      $valor, $sugerencia !== '' ? $sugerencia : null, null, $info !== null && $info->estado === 'AO'));
  }

  /** Propiedad pública inicializada y no nula, o null (sin getters ni Error). */
  protected static function v(?object $objeto, string $propiedad): mixed
  {
    if ($objeto === null || !property_exists($objeto, $propiedad))
      return null;
    return isset($objeto->{$propiedad}) ? $objeto->{$propiedad} : null;
  }

  protected static function entero(?object $objeto, string $propiedad): ?int
  {
    $x = self::v($objeto, $propiedad);
    return $x === null || $x === '' || !is_numeric($x) ? null : (int) $x;
  }

  protected static function texto(?object $objeto, string $propiedad): ?string
  {
    $x = self::v($objeto, $propiedad);
    if ($x === null || is_object($x) || is_array($x))
      return null;
    $t = trim((string) $x);
    return $t === '' ? null : $t;
  }

  protected static function fecha(?object $objeto, string $propiedad): ?DateTime
  {
    $x = self::v($objeto, $propiedad);
    if ($x instanceof DateTime)
      return $x;
    return $x instanceof DateTimeInterface ? DateTime::createFromInterface($x) : null;
  }

  /** @return list<object> */
  protected static function lista(?object $objeto, string $propiedad): array
  {
    $x = self::v($objeto, $propiedad);
    if ($x === null)
      return [];
    return is_array($x) ? array_values(array_filter($x, 'is_object')) : (is_object($x) ? [$x] : []);
  }
}
