<?php

namespace IonysDev\Pkuatia\Utils;

/**
 * Normalización y validación de montos y medidas contra los tipos decimales del XSD del SIFEN:
 * xs:decimal con totalDigits y fractionDigits, como tMontoBase4 (19 dígitos, 4 decimales) y
 * tMontoBase6 (10 dígitos, 4 decimales), DE_Types_v150.xsd:1290-1314.
 *
 * Reúne el criterio que GGrupSup (Q-B10) y GVehNuevo (Q-B12) aplicaban por separado, sin cambiarlo
 * (Fase C, paso C1):
 * - El valor se devuelve como texto, sin redondear, con su signo si lo tiene.
 * - Como en xs:decimal, los ceros a la izquierda y los decimales finales en cero no cuentan para los límites,
 *   pero se conservan en el texto devuelto.
 * - Se aceptan, normalizados, los textos numéricos que hasta 0.2.0 entraban por la conversión de PHP a int:
 *   "+5" y "5." como "5", ".5" como "0.5" y la notación exponencial ("1e3") como "1000".
 */
final class DecimalXsd
{
  /**
   * Valida y normaliza un valor decimal.
   *
   * @param int|String $valor        Valor recibido (entero o texto numérico).
   * @param String     $campo        Nombre del campo, para el mensaje de error (p. ej. "dEfectivo").
   * @param int        $totalDigitos totalDigits del tipo XSD (19 en tMontoBase4, 10 en tMontoBase6).
   * @param int        $decimales    fractionDigits del tipo XSD (4 en ambos).
   * @param String     $prefijo      Prefijo del mensaje, p. ej. "[GGrupSup]"; vacío para omitirlo.
   * @param String     $tipo         Referencia citada en el mensaje de límite (p. ej. "tMontoBase6").
   *
   * @return String Texto decimal normalizado.
   *
   * @throws \InvalidArgumentException Si el valor no es numérico o excede los dígitos o decimales permitidos.
   */
  public static function normalizar(int|String $valor, String $campo, int $totalDigitos, int $decimales = 4, String $prefijo = '', String $tipo = 'DE_Types_v150.xsd'): String
  {
    $original = trim((string) $valor);
    $texto = $original;
    $pre = $prefijo === '' ? '' : $prefijo . ' ';
    if (preg_match('/^[+-]?(\d+\.?\d*|\.\d+)$/D', $texto) !== 1) {
      if (!is_numeric($texto))
        throw new \InvalidArgumentException("{$pre}$campo debe ser un número decimal: '$original'");
      $texto = rtrim(rtrim(sprintf('%.10F', (float) $texto), '0'), '.'); // notación exponencial
    }
    $signo = str_starts_with($texto, '-') ? '-' : '';
    $texto = ltrim($texto, '+-');
    if (str_starts_with($texto, '.'))
      $texto = '0' . $texto;
    if (str_ends_with($texto, '.'))
      $texto = substr($texto, 0, -1);
    [$enteros, $parteDecimal] = array_pad(explode('.', $texto, 2), 2, '');
    $enteros = ltrim($enteros, '0');
    $parteDecimal = rtrim($parteDecimal, '0');
    if (strlen($parteDecimal) > $decimales || strlen($enteros) + strlen($parteDecimal) > $totalDigitos)
      throw new \InvalidArgumentException("{$pre}$campo admite hasta $totalDigitos dígitos, de los cuales hasta $decimales decimales ($tipo): '$original'");
    return $signo . $texto;
  }

  /**
   * Valor decimal exacto, salvo que la propiedad pública entera se haya asignado directamente con otro valor
   * (compatibilidad con quien escribe la propiedad entera sin pasar por el setter).
   */
  public static function exacto(?String $decimal, int $entero): String
  {
    return ($decimal !== null && intval($decimal) === $entero) ? $decimal : (string) $entero;
  }

  /**
   * Indica si el valor cumple con el tipo, sin lanzar excepción (para el validador de reglas).
   */
  public static function esValido(mixed $valor, int $totalDigitos, int $decimales = 4): bool
  {
    if (!is_int($valor) && !is_string($valor))
      return false;
    try {
      self::normalizar($valor, 'valor', $totalDigitos, $decimales);
      return true;
    } catch (\InvalidArgumentException) {
      return false;
    }
  }
}
