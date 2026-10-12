<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Categoría de un código de resultado de los web services del SIFEN, según los rangos de la sección 12.1.1 del
 * Manual Técnico v150 (ekuat-ia 08-errores-y-respuestas/estructura-codigos.md). Fase C, paso C4.
 */
enum CategoriaCodigoWS: string
{
  case CertificadoTransmision = 'certificado_transmision';   // AA, 0000-0099: certificado de transmisión (TLS)
  case FormaAreaDatos = 'forma_area_datos';                  // AB, 0100-0119: forma del área de datos (eliminado en v150; 0100 se sigue observando)
  case CertificadoFirma = 'certificado_firma';               // AC, 0120-0139: certificado digital con el que se firma
  case FirmaDigital = 'firma_digital';                       // AD, 0140-0159: firma digital
  case GenericaMensajes = 'generica_mensajes';               // AE, 0160-0179: validaciones genéricas de los mensajes de entrada
  case GenericaControlLlamada = 'generica_control_llamada';  // AF, 0180-0199: control de la llamada
  case RecepcionDe = 'recepcion_de';                         // BA-BC, 0200-0269: siRecepDE
  case RecepcionLote = 'recepcion_lote';                     // BD-BF, 0270-0319: siRecepLoteDE
  case ResultadoLote = 'resultado_lote';                     // BG-BI, 0320-0379: siResultLoteDE
  case ConsultaDe = 'consulta_de';                           // BJ-BL, 0380-0459: siConsDE
  case ConsultaRuc = 'consulta_ruc';                         // BM-BO, 0460-0559: siConsRUC
  case ConsultaArchivoRuc = 'consulta_archivo_ruc';          // BO04-BO07, 0520-0523: siConsArchivoRUC (NT-011)
  case RecepcionEvento = 'recepcion_evento';                 // BS-BU, 0560-0619: siRecepEvento

  public function descripcion(): string
  {
    return match ($this) {
      self::CertificadoTransmision => 'Certificado de transmisión (protocolo TLS)',
      self::FormaAreaDatos => 'Forma del área de datos de los mensajes de entrada (validaciones eliminadas en v150)',
      self::CertificadoFirma => 'Certificado digital utilizado para firmar',
      self::FirmaDigital => 'Firma digital',
      self::GenericaMensajes => 'Validaciones genéricas sobre los mensajes de entrada de los WS',
      self::GenericaControlLlamada => 'Validaciones genéricas sobre el control de la llamada a los WS',
      self::RecepcionDe => 'WS siRecepDE (recepción de documento electrónico)',
      self::RecepcionLote => 'WS siRecepLoteDE (recepción de lote)',
      self::ResultadoLote => 'WS siResultLoteDE (resultado de lote)',
      self::ConsultaDe => 'WS siConsDE (consulta de documento electrónico)',
      self::ConsultaRuc => 'WS siConsRUC (consulta de RUC)',
      self::ConsultaArchivoRuc => 'WS siConsArchivoRUC (consulta masiva de RUC, NT-011)',
      self::RecepcionEvento => 'WS siRecepEvento (recepción de eventos)',
    };
  }

  /**
   * Categoría por rango numérico (estructura-codigos.md 12.1.1). Los códigos 0520-0523 son del WS de archivo de RUC
   * aunque caen en el rango del WS de consulta de RUC.
   */
  public static function deCodigo(string $codigo): self
  {
    $n = (int) $codigo;
    return match (true) {
      $n >= 520 && $n <= 523 => self::ConsultaArchivoRuc,
      $n < 100 => self::CertificadoTransmision,
      $n < 120 => self::FormaAreaDatos,
      $n < 140 => self::CertificadoFirma,
      $n < 160 => self::FirmaDigital,
      $n < 180 => self::GenericaMensajes,
      $n < 200 => self::GenericaControlLlamada,
      $n < 270 => self::RecepcionDe,
      $n < 320 => self::RecepcionLote,
      $n < 380 => self::ResultadoLote,
      $n < 460 => self::ConsultaDe,
      $n < 560 => self::ConsultaRuc,
      default => self::RecepcionEvento,
    };
  }
}
