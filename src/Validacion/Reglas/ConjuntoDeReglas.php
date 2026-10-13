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

  /**
   * Agrega el error del catálogo cuando la condición se cumple; si el MT lo marca AO, o si $soloAdvertencia lo pide
   * (regla que todavía no se comprobó contra sifen-test), va como advertencia.
   */
  protected static function regla(ResultadoValidacion $r, bool $condicion, string $codigo, string $elemento, string $ruta, mixed $valor = null, ?string $detalle = null, bool $soloAdvertencia = false): void
  {
    if (!$condicion)
      return;
    $info = CatalogoValidaciones::describir($codigo);
    $campo = $info?->id !== null ? preg_replace('/[a-z]$/', '', $info->id) : null;
    $metodo = $campo !== null ? CatalogoValidaciones::metodoPkuatia($campo) : null;
    $sugerencia = trim(($detalle !== null ? $detalle . ' ' : '') . ($metodo !== null ? "Ver $metodo." : ''));
    $r->agregar(new ErrorValidacion(OrigenError::Regla, $info?->mensaje ?? "Validación $codigo del SIFEN.", $codigo, $campo, $elemento, $ruta,
      $valor, $sugerencia !== '' ? $sugerencia : null, null, $soloAdvertencia || ($info !== null && $info->estado === 'AO')));
  }

  /**
   * Como regla(), para un código que todavía no está en errores-validacion.md (p. ej. 1921 de la NT-013): usa el
   * catálogo si lo tiene y, si no, el mensaje y el campo del MT indicados.
   */
  protected static function reglaConMensaje(ResultadoValidacion $r, bool $condicion, string $codigo, string $campo, string $mensaje, string $elemento, string $ruta, mixed $valor = null, ?string $detalle = null): void
  {
    if (!$condicion)
      return;
    if (CatalogoValidaciones::describir($codigo) !== null) {
      self::regla($r, true, $codigo, $elemento, $ruta, $valor, $detalle);
      return;
    }
    $metodo = CatalogoValidaciones::metodoPkuatia($campo);
    $sugerencia = trim(($detalle !== null ? $detalle . ' ' : '') . ($metodo !== null ? "Ver $metodo." : ''));
    $r->agregar(new ErrorValidacion(OrigenError::Regla, $mensaje, $codigo, $campo, $elemento, $ruta, $valor, $sugerencia !== '' ? $sugerencia : null));
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

  /** Fecha del documento como hora de pared en Asunción (ver VistaDocumento::enZonaSifen()). */
  protected static function fecha(?object $objeto, string $propiedad): ?DateTime
  {
    $x = self::v($objeto, $propiedad);
    return $x instanceof DateTimeInterface ? VistaDocumento::enZonaSifen($x) : null;
  }

  /** @return list<object> */
  protected static function lista(?object $objeto, string $propiedad): array
  {
    $x = self::v($objeto, $propiedad);
    if ($x === null)
      return [];
    return is_array($x) ? array_values(array_filter($x, 'is_object')) : (is_object($x) ? [$x] : []);
  }

  /** Importe o cantidad como cadena decimal para BCMath, o null si no está informado o no es un decimal simple. */
  protected static function monto(?object $objeto, string $propiedad): ?string
  {
    $t = self::texto($objeto, $propiedad);
    return $t !== null && preg_match('/^-?\d+(\.\d+)?$/', $t) === 1 ? $t : null;
  }

  /**
   * True si el valor informado se aparta del esperado más de lo tolerable. Con tolerancia explícita (la "variación
   * permitida" del MT, p. ej. 0,8 en 1861) se admite hasta ese valor inclusive. Sin ella se admite menos de una unidad
   * del último decimal informado ("100000" → 1; "301.00" → 0,01): el emisor redondea o trunca a la precisión de su
   * moneda y el DE no dice cuál es, así que el validador no puede ser más fino que el propio documento.
   */
  protected static function difiere(string $informado, string $esperado, ?string $tolerancia = null): bool
  {
    $diferencia = bcsub($informado, $esperado, 10);
    if (bccomp($diferencia, '0', 10) < 0)
      $diferencia = bcmul($diferencia, '-1', 10);
    if ($tolerancia !== null)
      return bccomp($diferencia, $tolerancia, 10) > 0;
    $punto = strpos($informado, '.');
    $decimales = $punto === false ? 0 : strlen($informado) - $punto - 1;
    $unidad = $decimales === 0 ? '1' : '0.' . str_repeat('0', $decimales - 1) . '1';
    return bccomp($diferencia, $unidad, 10) >= 0;
  }
}
