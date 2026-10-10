<?php

namespace IonysDev\Pkuatia\Tests\Support;

use DOMElement;
use stdClass;

/**
 * Respuestas reales de los web services del SIFEN (ambiente sifen-test, 06 y 09/10/2026), capturadas
 * crudas con SoapClient::__doRequest y anonimizadas (RUC 80000000-5, receptor 80012345, timbrado
 * 12345678, material criptográfico reemplazado por marcadores en base64).
 *
 * Son copias byte a byte de ekuat-ia/06-ejemplos/respuestas-ws/ (commit 16070af), guardadas sin
 * conversión de fin de línea (.gitattributes); RespuestasWsSincroniaTest verifica que sigan iguales.
 * El README.md de la carpeta describe cada captura y las observaciones sobre el formato real.
 * Regla de autoridad: para el formato de las respuestas, estas capturas mandan sobre el Manual Técnico.
 */
final class RespuestasSifenFactory
{
  public const DIR = __DIR__ . '/../Resources/sifen/respuestas-ws';

  // 09/10/2026, flujo completo (hora de Asunción)
  /** rResEnviConsRUC 0502 "RUC encontrado" con xContRUC. */
  public const RUC_0502 = '2026-10-09/01-rEnviConsRUC-response.xml';
  /** rEnviConsDeResponse 0420 "Documento No Existe en SIFEN o ha sido Rechazado", sin xContenDE. */
  public const CONSULTA_DE_0420 = '2026-10-09/02-rEnviConsDe-previo-response.xml';
  /** rRetEnviDe 0260 "Autorización del DE satisfactoria": rProtDe { Id, dFecProc, dDigVal, dEstRes, dProtAut, gResProc }. */
  public const ENVIO_DE_0260 = '2026-10-09/03-rEnviDe-response.xml';
  /** FE firmada (anonimizada) que recibió el 0260; valida contra siRecepDE_v150.xsd, la firma ya no verifica. */
  public const FE_FIRMADA_0260 = '2026-10-09/03-FE-firmada-anonimizada.xml';
  /** rRetEnviEventoDe rechazado 4009 (cancelación 11 s después de aprobar; reloj adelantado de sifen-test). */
  public const EVENTO_4009 = '2026-10-09/04-rEnviEventoDe-response.xml';
  /** rEnviConsDeResponse 0422 "CDC encontrado": xContenDE con rDE + dProtAut + xContEv vacío. */
  public const CONSULTA_DE_0422 = '2026-10-09/05-rEnviConsDe-response.xml';
  /** rRetEnviEventoDe rechazado 0100 "Error Inesperado" (transitorio), id = 0. */
  public const EVENTO_0100 = '2026-10-09/06-rEnviEventoDe-response-0100.xml';
  /** rEnviConsDeResponse 0422 sin eventos, tras el 0100 (no se registró nada). */
  public const CONSULTA_DE_0422_PREVIA = '2026-10-09/07-rEnviConsDe-previo-response-0422-sin-eventos.xml';
  /** rRetEnviEventoDe aprobado 0600 "Evento registrado correctamente": gResProcEVe { dEstRes, dProtAut, id, gResProc }. */
  public const EVENTO_0600 = '2026-10-09/08-rEnviEventoDe-response-0600.xml';
  /** rEnviConsDeResponse 0422 del DE cancelado: xContEv con un rContEv (xEvento + rResEnviEventoDe). */
  public const CONSULTA_DE_0422_CANCELADO = '2026-10-09/09-rEnviConsDe-response-0422-cancelado.xml';

  // 06/10/2026, ambiente degradado
  /** rResEnviConsRUC 0502 antes de la degradación. */
  public const RUC_0502_0610 = '2026-10-06/01-rEnviConsRUC-response-0502.xml';
  /** rRetEnviDe 0160 "XML Mal Formado." a una FE válida: rechazo genérico sin Id, dDigVal ni dProtAut. */
  public const ENVIO_DE_0160 = '2026-10-06/02-rEnviDe-response-0160.xml';
  /** FE firmada (anonimizada) que recibió el 0160 genérico. */
  public const FE_FIRMADA_0160 = '2026-10-06/02-FE-firmada-anonimizada.xml';
  /** Consulta de RUC respondida con un rRetEnviDe 0160 (el sobre de rechazo genérico es siempre rRetEnviDe). */
  public const RUC_0160 = '2026-10-06/03-rEnviConsRUC-response-0160-0704.xml';
  /** Ídem, 36 minutos después. */
  public const RUC_0160_0740 = '2026-10-06/04-rEnviConsRUC-response-0160-0740.xml';

  /** Ruta absoluta de una captura (relativa a la carpeta respuestas-ws). */
  public static function ruta(string $captura): string
  {
    $ruta = self::DIR . '/' . $captura;
    if (!is_file($ruta)) {
      throw new \InvalidArgumentException("RespuestasSifenFactory: no existe la captura $captura");
    }
    return $ruta;
  }

  /** Bytes exactos de la captura, tal como los envió el SIFEN (salvo la anonimización). */
  public static function crudo(string $captura): string
  {
    return file_get_contents(self::ruta($captura));
  }

  /** Elemento de respuesta (primer hijo de env:Body). */
  public static function elementoRespuesta(string $captura): DOMElement
  {
    return CapturaSoapClient::elementoRespuesta(self::crudo($captura));
  }

  /**
   * Objeto que entregaría SoapClient a la librería para esta captura (ver CapturaSoapClient: hojas
   * como string, elementos repetidos como arreglo, xContenDE como texto ya decodificado).
   */
  public static function objetoSoap(string $captura): stdClass
  {
    $cliente = new CapturaSoapClient(self::crudo($captura));
    return $cliente->captura();
  }

  /** Contenido decodificado de xContenDE (texto, no XML anidado), o null si la respuesta no lo trae. */
  public static function xContenDE(string $captura): ?string
  {
    return self::objetoSoap($captura)->xContenDE ?? null;
  }

  /** Instala en el facade un cliente SOAP sin red que responde toda operación con esta captura. */
  public static function instalar(string $captura): void
  {
    CapturaSoapClient::instalar(self::crudo($captura));
  }
}
