<?php

namespace IonysDev\Pkuatia\Validacion;

use IonysDev\Pkuatia\Core\Constants\CodigoResultadoWS;

/**
 * Catálogo de los códigos de validación del SIFEN y de los elementos del XSD del DE (Fase C, paso C5).
 *
 * Los datos viven en src/Resources/codigos/*.php, generados desde ekuat-ia con tools/generar-catalogos.php:
 * validaciones-de.php (MT §12.4: 282 validaciones vigentes del DE y las eliminadas en v150), validaciones-evento.php
 * (MT §11.6), respuestas-ws.php (MT §12.2 y §12.3) y elementos-de.php (DE_v150.xsd fiel con el ID del MT de cada
 * elemento). campos-metodos.php, mantenido a mano, dice con qué método de PKuatia se informa cada campo del MT.
 *
 * Uso típico: ante un rechazo, `CatalogoValidaciones::describir($respuesta->getCodigo())` devuelve la regla que
 * falló, el campo del MT y el método que lo carga.
 */
final class CatalogoValidaciones
{
  private const DIR = __DIR__ . '/../Resources/codigos';
  private const ORIGENES = ['de' => 'validaciones-de', 'evento' => 'validaciones-evento', 'ws' => 'respuestas-ws'];

  /** @var array<string, array> */
  private static array $cache = [];

  /**
   * La validación que corresponde a un código (la vigente, si hay varias). Acepta 1321, "1321" y "0260".
   * Null si el código no existe en el MT ni entre los códigos de WS que la librería conoce.
   */
  public static function describir(int|string $codigo): ?InfoValidacion
  {
    $todas = self::describirTodos($codigo);
    foreach ($todas as $info) {
      if ($info->vigente)
        return $info;
    }
    return $todas[0] ?? null;
  }

  /**
   * Todas las entradas de un código (el MT repite algunos, p. ej. 4313-4323 en la tabla 11.6.7).
   *
   * @return list<InfoValidacion>
   */
  public static function describirTodos(int|string $codigo): array
  {
    $c = self::normalizar($codigo);
    if ($c === null)
      return [];
    $res = [];
    foreach (self::ORIGENES as $origen => $archivo) {
      foreach (self::datos($archivo)['entradas'] as $e) {
        if ($e['codigo'] === $c)
          $res[] = self::info($e, $origen);
      }
    }
    $ws = CodigoResultadoWS::fromAny($c);
    if ($ws !== null && ($res === [] || $ws->esObservado())) {
      // Observados en capturas (0100, 0143), NT-011 y guía de la DNIT: están en el enum y no en las tablas del MT. Un
      // observado va primero: 0100 es hoy "Error Inesperado", no el AB01 que el MT v150 eliminó.
      $info = new InfoValidacion($ws->value, $ws->idMT(), $ws->descripcion(), $ws->esAprobacion() ? 'A' : 'R',
        $ws->categoria()->descripcion(), '', $ws->vigente(), 'ws', 'CodigoResultadoWS: ' . $ws->fuente(), null);
      $ws->esObservado() ? array_unshift($res, $info) : $res[] = $info;
    }
    return $res;
  }

  /**
   * Validaciones de un campo del MT: el ID exacto y sus variantes con letra (D208, D208a, D208b, …).
   *
   * @return list<InfoValidacion>
   */
  public static function porCampo(string $idMT): array
  {
    $res = [];
    $patron = '/^' . preg_quote($idMT, '/') . '[a-z]?$/';
    foreach (['de', 'evento'] as $origen) {
      foreach (self::datos(self::ORIGENES[$origen])['entradas'] as $e) {
        if ($e['id'] !== null && preg_match($patron, $e['id']))
          $res[] = self::info($e, $origen);
      }
    }
    return $res;
  }

  /**
   * Todas las validaciones, o las de un origen ("de", "evento", "ws").
   *
   * @return list<InfoValidacion>
   */
  public static function todas(?string $origen = null): array
  {
    $res = [];
    foreach (self::ORIGENES as $o => $archivo) {
      if ($origen !== null && $origen !== $o)
        continue;
      foreach (self::datos($archivo)['entradas'] as $e)
        $res[] = self::info($e, $o);
    }
    return $res;
  }

  /** Primera declaración de un elemento del XSD del DE, o null si no existe. */
  public static function elemento(string $nombre): ?InfoElemento
  {
    $ocurrencias = self::ocurrenciasElemento($nombre);
    return $ocurrencias[0] ?? null;
  }

  /**
   * Todas las declaraciones de un elemento (un nombre puede aparecer en más de un tipo).
   *
   * @return list<InfoElemento>
   */
  public static function ocurrenciasElemento(string $nombre): array
  {
    $datos = self::datos('elementos-de');
    return array_map([self::class, 'infoElemento'], $datos['elementos'][$nombre] ?? []);
  }

  /**
   * Elementos hijos de un tipo complejo ("tgDTim") o de un elemento de grupo ("gTimb"), en el orden del XSD.
   *
   * @return list<InfoElemento>
   */
  public static function hijosDe(string $tipoOElemento): array
  {
    $datos = self::datos('elementos-de');
    $tipo = $tipoOElemento;
    if (!isset($datos['tipos'][$tipo])) {
      $elemento = self::elemento($tipoOElemento);
      if ($elemento === null)
        return [];
      $tipo = $elemento->tipo ?? $elemento->nombre; // tipo en línea: los hijos cuelgan del nombre del elemento
      if (!isset($datos['tipos'][$tipo])) {
        $res = [];
        foreach ($datos['elementos'] as $ocurrencias) {
          foreach ($ocurrencias as $o) {
            if ($o['padre'] === $tipo)
              $res[] = self::infoElemento($o);
          }
        }
        usort($res, static fn (InfoElemento $a, InfoElemento $b): int => $a->linea <=> $b->linea);
        return $res;
      }
    }
    $res = [];
    foreach ($datos['tipos'][$tipo]['hijos'] as $nombre) {
      foreach ($datos['elementos'][$nombre] ?? [] as $o) {
        if ($o['padre'] === $tipo) {
          $res[] = self::infoElemento($o);
          break;
        }
      }
    }
    return $res;
  }

  /** ID del MT de un elemento del XSD (p. ej. "dNumTim" → "C004"), o null. */
  public static function campoMT(string $elemento): ?string
  {
    return self::elemento($elemento)?->campoMT;
  }

  /** Método de PKuatia con el que se informa un campo del MT (p. ej. "C004" → "setTimbrado()…"), o null. */
  public static function metodoPkuatia(string $idMT): ?string
  {
    $mapa = self::datos('campos-metodos');
    if (isset($mapa[$idMT]))
      return $mapa[$idMT];
    $base = preg_replace('/[a-z]$/', '', $idMT);
    return $mapa[$base] ?? null;
  }

  private static function info(array $e, string $origen): InfoValidacion
  {
    return new InfoValidacion($e['codigo'], $e['id'], $e['mensaje'], $e['estado'], $e['grupo'], $e['observacion'],
      $e['vigente'], $origen, $e['fuente'], $e['id'] !== null ? self::metodoPkuatia($e['id']) : null);
  }

  private static function infoElemento(array $o): InfoElemento
  {
    return new InfoElemento($o['nombre'], $o['nombreOriginal'], $o['tipo'], $o['minOccurs'], $o['maxOccurs'], $o['padre'],
      $o['contenedor'], $o['linea'], $o['campoMT'], $o['esGrupo']);
  }

  private static function normalizar(int|string $codigo): ?string
  {
    $texto = trim((string) $codigo);
    if ($texto === '' || !ctype_digit($texto))
      return null;
    return str_pad($texto, 4, '0', STR_PAD_LEFT);
  }

  private static function datos(string $nombre): array
  {
    return self::$cache[$nombre] ??= require self::DIR . "/$nombre.php";
  }
}
