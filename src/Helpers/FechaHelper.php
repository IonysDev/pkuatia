<?php

namespace IonysDev\Pkuatia\Helpers;

use DateTime;
use DateTimeZone;
use IonysDev\Pkuatia\Core\Constants;

/**
 * Lectura de las fechas y horas que devuelve el SIFEN en sus respuestas. Formatos reales (capturas de
 * sifen-test del 09/10/2026, ekuat-ia/06-ejemplos/respuestas-ws/README.md, observaciones 1, 2 y 5):
 * con zona horaria en las respuestas directas (2026-10-09T17:07:15-03:00) y sin zona dentro de xContEv
 * (2026-10-09T17:16:57), que se interpreta en la hora de Asunción (Constants::SIFEN_TIMEZONE).
 *
 * Hasta 0.2.0 cada respuesta usaba un único formato con DateTime::createFromFormat() y, si el SIFEN mandaba
 * el otro, el false resultante terminaba en TypeError (PK-29). Nuevo en 0.2.1.
 */
final class FechaHelper
{
  /**
   * Convierte una fecha y hora del SIFEN (AAAA-MM-DDThh:mm:ss, con o sin zona) en DateTime.
   *
   * @param mixed  $valor Texto de la fecha (string o nodo SimpleXML).
   * @param String $campo Nombre del campo, para el mensaje de error.
   *
   * @throws \InvalidArgumentException Si el valor está vacío o no es una fecha válida en alguno de los dos formatos.
   *
   * @return DateTime
   */
  public static function FromSifen(mixed $valor, String $campo): DateTime
  {
    $texto = trim((string) $valor);
    $zonaSifen = new DateTimeZone(Constants::SIFEN_TIMEZONE);
    foreach (['!Y-m-d\TH:i:sP', '!Y-m-d\TH:i:s'] as $formato) {
      $fecha = DateTime::createFromFormat($formato, $texto, $zonaSifen);
      $errores = DateTime::getLastErrors();
      $sinAvisos = $errores === false || ($errores['warning_count'] === 0 && $errores['error_count'] === 0);
      if ($fecha !== false && $sinAvisos)
        return $fecha;
    }
    throw new \InvalidArgumentException("[FechaHelper] $campo no es una fecha y hora del SIFEN (AAAA-MM-DDThh:mm:ss, con o sin zona horaria): '$texto'");
  }
}
