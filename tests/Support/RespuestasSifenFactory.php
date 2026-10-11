<?php

namespace IonysDev\Pkuatia\Tests\Support;

use DOMElement;
use stdClass;

/**
 * Respuestas reales de los web services del SIFEN (ambiente sifen-test, 06, 09 y 11/10/2026), capturadas
 * crudas con SoapClient::__doRequest y anonimizadas (RUC 80000000-5, receptor 80012345, timbrado
 * 12345678, material criptográfico reemplazado por marcadores en base64).
 *
 * Son copias byte a byte de ekuat-ia/06-ejemplos/respuestas-ws/ (commit cf55702), guardadas sin
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

  // 11/10/2026, homologación de la Fase B (B13), con el ambiente intermitente (hora de Asunción)
  /** rEnviConsDeResponse 0420 del CDC de un envío cortado por SSL: el SIFEN no lo registró. */
  public const CONSULTA_DE_0420_1110 = '2026-10-11/02-rEnviConsDe-previo-response-0420.xml';
  /** rRetEnviDe 0260 de una FE a crédito en dos cuotas sin entrega inicial (D-A1). */
  public const ENVIO_FE_CUOTAS_0260 = '2026-10-11/03-rEnviDe-fe-cuotas-response-0260.xml';
  /** rRetEnviDe 0260 de una NR asociada a la FE en cuotas (D-A1). */
  public const ENVIO_NR_0260 = '2026-10-11/04-rEnviDe-nr-response-0260.xml';
  /** rRetEnviDe 2562 "El vendedor no debe ser contribuyente": la cédula del vendedor de la AF es un RUC registrado. */
  public const ENVIO_AF_2562 = '2026-10-11/05-rEnviDe-af-response-2562.xml';
  /** Consulta de RUC respondida con el rechazo genérico 0160 (rRetEnviDe) con el ambiente degradado. */
  public const RUC_0160_1145 = '2026-10-11/06-rEnviConsRUC-response-0160-generico.xml';
  /** rRetEnviDe 0260 de la AF con constancia de no ser contribuyente con número y control (PK-35, Q-B11). */
  public const ENVIO_AF_0260 = '2026-10-11/07-rEnviDe-af-response-0260.xml';
  /** rEnviConsDeResponse 0422 de esa AF: gCamDEAsoc con iTipCons 1, dNumCons y dNumControl. */
  public const CONSULTA_AF_0422 = '2026-10-11/08-rEnviConsDe-af-response-0422.xml';
  /** rRetEnviDe 1206 de una FE en ANG con la descripción de la moneda recortada a 20 caracteres (D-A3). */
  public const ENVIO_FE_ANG_1206 = '2026-10-11/09-rEnviDe-fe-ang-response-1206.xml';
  /** rRetEnviDe 0260 de una FE con los cuatro grupos de gCamEsp (Q-B8). */
  public const ENVIO_FE_SECTORES_0260 = '2026-10-11/10-rEnviDe-fe-sectores-response-0260.xml';
  /** rRetEnviDe 0260 de una FE con vehículo nuevo y medidas con decimales (B12, Q-B12). */
  public const ENVIO_FE_VEHICULO_0260 = '2026-10-11/11-rEnviDe-fe-vehiculo-response-0260.xml';
  /** rEnviConsDeResponse 0422 de esa FE: gVehNuevo con iTipOpVN 2 y las medidas con decimales. */
  public const CONSULTA_FE_VEHICULO_0422 = '2026-10-11/12-rEnviConsDe-fe-vehiculo-response-0422.xml';
  /** rResEnviLoteDe 0300 "Lote recibido con éxito" con dProtConsLote de 17 dígitos. */
  public const LOTE_0300 = '2026-10-11/13-rEnvioLote-response-0300.xml';
  /** rResEnviConsLoteDe 0362 a los 10 minutos: dos gResProcLote aprobados; dFecProc es la hora de recepción del lote. */
  public const CONSULTA_LOTE_0362 = '2026-10-11/14-rEnviConsLoteDe-response-0362.xml';
  /** rRetEnviEventoDe con cinco gResProcEVe (id 1 a 5), cada uno 0143: eventos del receptor firmados por el emisor. */
  public const EVENTOS_RECEPTOR_0143 = '2026-10-11/15-rEnviEventoDe-receptor-response-0143x5.xml';

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
