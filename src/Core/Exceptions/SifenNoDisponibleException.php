<?php

namespace IonysDev\Pkuatia\Core\Exceptions;

/**
 * Falla de comunicación con el patrón de saturación o bloqueo temporal del SIFEN: el WSDL no carga o llega a medias,
 * o la respuesta viene vacía o no es XML. Es lo que sifen-test produce cuando limita la tasa de solicitudes (memoria
 * de rutas y rate limit: bloqueos de 10 a 60 minutos según la guía de la DNIT). Es una sospecha, no una certeza:
 * la misma falla aparece si el servicio está caído.
 *
 * Qué hacer: no reintentar en ráfaga; validar el documento localmente, probar con una consulta de solo lectura
 * (canario) y, si un envío se cortó, consultar su CDC antes de reenviarlo (0420 = no quedó registrado).
 */
class SifenNoDisponibleException extends TransporteException
{
}
