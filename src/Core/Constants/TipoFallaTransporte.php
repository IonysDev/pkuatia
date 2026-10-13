<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Tipo de una falla de comunicación con el SIFEN (TransporteException, Fase C, paso C2), deducido del faultcode y
 * del mensaje del SoapFault de PHP. Los patrones salen de lo observado contra sifen-test: WSDL que no carga o llega
 * a medias ("can't import schema", 04/10/2026), cuerpo vacío ("Document is empty", "looks like we got no XML document"),
 * corte de la conexión TLS (09/10/2026) y lectura agotada ("Error Fetching http headers").
 */
enum TipoFallaTransporte: string
{
  case Wsdl = 'wsdl';
  case RespuestaVaciaONoXml = 'respuesta_vacia_o_no_xml';
  case Conexion = 'conexion';
  case TiempoAgotado = 'tiempo_agotado';
  case Tls = 'tls';
  case SoapFault = 'soap_fault';
  case Desconocida = 'desconocida';

  public function descripcion(): string
  {
    return match ($this) {
      self::Wsdl => 'No se pudo cargar o interpretar el WSDL del servicio',
      self::RespuestaVaciaONoXml => 'El SIFEN respondió vacío o con algo que no es XML',
      self::Conexion => 'No se pudo establecer la conexión con el SIFEN',
      self::TiempoAgotado => 'Se agotó el tiempo de espera de la respuesta',
      self::Tls => 'Falla en la conexión TLS (certificado de transmisión o corte de la conexión segura)',
      self::SoapFault => 'Falla SOAP informada por el servidor o por el cliente SOAP',
      self::Desconocida => 'Falla de comunicación no reconocida',
    };
  }

  /**
   * Patrón compatible con la saturación o el bloqueo temporal del ambiente (WSDL o cuerpo vacío intermitentes).
   * Es una sospecha, no una certeza: la misma falla se produce si el servicio está caído o la ruta es incorrecta.
   */
  public function esPosibleSaturacion(): bool
  {
    return $this === self::Wsdl || $this === self::RespuestaVaciaONoXml;
  }

  public static function deducir(?string $faultcode, string $mensaje): self
  {
    $codigo = strtoupper(trim((string) $faultcode));
    $m = strtolower($mensaje);
    $contiene = static fn (string ...$patrones): bool => array_reduce($patrones, static fn (bool $r, string $p): bool => $r || str_contains($m, strtolower($p)), false);

    if ($codigo === 'WSDL' || $contiene('Parsing WSDL', 'Parsing Schema', "Couldn't load from", 'failed to load external entity', "can't import schema"))
      return self::Wsdl;
    if ($contiene('Document is empty', 'looks like we got no XML document', 'Start tag expected', 'Premature end of data', 'Extra content at the end of the document'))
      return self::RespuestaVaciaONoXml;
    if ($contiene('Error Fetching http headers', 'timed out', 'timeout'))
      return self::TiempoAgotado;
    if ($contiene('SSL', 'TLS', 'certificate', 'handshake', 'crypto'))
      return self::Tls;
    if ($contiene('Could not connect to host', 'Connection refused', 'Connection reset', 'getaddrinfo', 'php_network_getaddresses', 'Name or service not known', 'No route to host', 'Broken pipe', 'Network is unreachable'))
      return self::Conexion;
    if (in_array($codigo, ['CLIENT', 'SERVER', 'RECEIVER', 'SENDER', 'VERSIONMISMATCH', 'MUSTUNDERSTAND', 'DATAENCODINGUNKNOWN'], true)
      || str_contains($codigo, ':'))
      return self::SoapFault;
    return self::Desconocida;
  }
}
