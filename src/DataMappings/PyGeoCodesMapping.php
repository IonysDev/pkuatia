<?php

namespace IonysDev\Pkuatia\DataMappings;


/**
 * PyGeoCodesMapping
 */
class PyGeoCodesMapping
{
  /**
   * getArray
   *
   * @return array
   */
  public static function getArray()
  {
    $xml = simplexml_load_file(__DIR__ . '/Sources/PyGeoCodes.xml');
    $json = json_encode($xml);
    $array = json_decode($json, true);
    return $array;
  }

  /**
   * getDistName
   *
   * @param  mixed $code
   * @return String
   */
  public static function getDistName($code): ?String
  {
    $array = self::getArray();
    ///iterate the array
    foreach ($array['geo'] as $key => $value) {
      if (isset($value['CODIGO_DIST']) && $value['CODIGO_DIST'] == $code) {
        return $value['DISTRITO'];
      }
    }
    return null;
  }

  
  /**
   * getDistName
   *
   * @param  mixed $code
   * @return String
   */
  public static function getCiudName($code): ?String
  {
    $array = self::getArray();
    ///iterate the array
    foreach ($array['geo'] as $key => $value) {
      if (isset($value['CODIGO_CIUD']) && $value['CODIGO_CIUD'] == $code) {
        return $value['CIUDAD'];
      }
    }
    return null;
  }

    
  /**
   * por el momento sin suo
   *
   * @param  mixed $code
   * @return String
   */
  public static function getBarrName($code): ?String
  {
    $array = self::getArray();
    ///iterate the array
    foreach ($array['geo'] as $key => $value) {
      if (isset($value['CODIGO_BARR']) && $value['CODIGO_BARR'] == $code) {
        return $value['BARRIO'];
      }
    }
    return null;
  }

  /** @var array<int, array<string, mixed>>|null filas de PyGeoCodes.xml, cargadas una sola vez (Fase C, C10) */
  private static ?array $filas = null;

  /**
   * Indica si el departamento, el distrito (si se informa) y la ciudad pertenecen a una misma fila de PyGeoCodes.xml
   * (validaciones 1255, 1328, 2153, 2203, 2553 y 2557 del MT). Nuevo en 0.3.0 (Fase C, C10).
   */
  public static function estanRelacionados(?int $departamento, ?int $distrito, ?int $ciudad): bool
  {
    if ($departamento === null || $ciudad === null)
      return true;
    self::$filas ??= array_values(self::getArray()['geo'] ?? []);
    foreach (self::$filas as $fila) {
      if ((int) ($fila['CODIGO_DEPTO'] ?? 0) !== $departamento || (int) ($fila['CODIGO_CIUD'] ?? 0) !== $ciudad)
        continue;
      if ($distrito === null || (int) ($fila['CODIGO_DIST'] ?? 0) === $distrito)
        return true;
    }
    return false;
  }
}
