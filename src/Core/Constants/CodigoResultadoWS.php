<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Códigos de resultado de los web services del SIFEN (dCodRes / dCodResLot), como texto de cuatro dígitos con cero
 * inicial, tal como llegan en las respuestas. Fase C, paso C4.
 *
 * Fuentes: Manual Técnico v150 §12.2 y §12.3 según ekuat-ia 08-errores-y-respuestas/respuestas-ws.md (con la
 * resolución del 03/10/2026 para la consulta de DE: 0420 inexistente, 0421 RUC sin permiso, 0422 CDC encontrado) y
 * estructura-codigos.md (rangos); NT-011 Tabla L (0520-0523, ekuat-ia 05-api-sifen/consulta-ruc.md); guía de mejores
 * prácticas de la DNIT §7 (0364, ekuat-ia 05-api-sifen/envio-lote.md). Dos códigos no figuran en las tablas y se
 * incorporan porque el SIFEN los responde (esObservado()): 0100 "Error Inesperado" (captura 2026-10-09/06, el rango AB
 * está eliminado en v150 y aun así el ambiente lo devuelve) y 0143 "La firma digital del evento debe corresponder al
 * receptor del DE/DTE" (captura 2026-10-11/15). Los eliminados en v150 (AB02-AB08, AC04-AC07) se conservan con
 * vigente() = false para poder describirlos si aparecen.
 *
 * Los códigos de validación del DE (1000-2650) y de los eventos (4000-4323) no son códigos de WS: ver
 * Validacion\CatalogoValidaciones. Comparar siempre con fromAny() o con ->value: GResProc::getDCodRes() devuelve texto
 * ("0260") y las constantes históricas COD_RES_* son enteros (260).
 */
enum CodigoResultadoWS: string
{
  // 12.2.1 Certificado de transmisión (TLS), AA01-AA07
  case CertificadoTransmisorInvalido = '0001';
  case CertificadoTransmisorVencido = '0002';
  case CadenaCertificacionInvalida = '0003';
  case LcrTransmisorInvalida = '0004';
  case CertificadoTransmisorRevocado = '0005';
  case CertificadoRaizNoMic = '0006';
  case SinRucEnCertificadoTransmisor = '0007';
  // 12.2.3 Forma del área de datos, AB (eliminado en v150). 0100 se observa en la práctica como "Error Inesperado".
  case ErrorInesperado = '0100';
  case SinCampoRaiz = '0101';
  case SinAtributoVersion = '0102';
  case NamespaceDistinto = '0104';
  case CaracteresDeEdicion = '0105';
  case PrefijoEnNamespace = '0106';
  case CodificacionNoUtf8 = '0107';
  // 12.2.4 Certificado de firma, AC01-AC07 (AC04-AC07 eliminados en v150, absorbidos por 0141)
  case CertificadoFirmaInvalido = '0120';
  case CertificadoFirmaFechasInvalidas = '0121';
  case SinRucEnCertificadoFirma = '0122';
  case CadenaCertificacionFirmaInvalida = '0123';
  case LcrFirmaInvalida = '0124';
  case CertificadoFirmaRevocado = '0125';
  case CertificadoRaizFirmaNoMic = '0126';
  // 12.2.5 Firma digital, AD01-AD03; 0143 observado
  case FirmaDifiereDelEstandar = '0140';
  case ValorDeFirmaInvalido = '0141';
  case RucDelCertificadoNoEsDelEmisor = '0142';
  case FirmaDelEventoNoEsDelReceptor = '0143';
  // 12.2.6 Genéricas de los mensajes de entrada, AE01-AE04
  case XmlMalFormado = '0160';
  case ServidorSinRespuestaMomentanea = '0161';
  case ServidorParalizado = '0162';
  case VersionDelFormatoNoSoportada = '0163';
  // 12.2.7 Genéricas del control de la llamada, AF01 y AF04
  case SinHeaderMsg = '0180';
  case RucDeConexionNoActivo = '0183';
  // 12.3.1 siRecepDE
  case MensajeRecepDeSuperaTamano = '0200';
  case AutorizacionDeSatisfactoria = '0260';
  // 12.3.2 siRecepLoteDE
  case MensajeRecepLoteSuperaTamano = '0270';
  case LoteRecibido = '0300';
  case LoteNoEncolado = '0301';
  // 12.3.3 siResultLoteDE (+ 0364 de la guía de la DNIT)
  case MensajeResultLoteSuperaTamano = '0320';
  case RucNoAutorizadoAConsultarLote = '0340';
  case LoteInexistente = '0360';
  case LoteEnProcesamiento = '0361';
  case LoteConcluido = '0362';
  case LoteConTiposDistintos = '0363';
  case ConsultaLoteExtemporanea = '0364';
  // 12.3.4 siConsDE
  case MensajeConsDeSuperaTamano = '0380';
  case CdcInexistente = '0420';
  case RucSinPermisoParaConsultar = '0421';
  case CdcEncontrado = '0422';
  // 12.3.5 siConsRUC (+ NT-011 siConsArchivoRUC)
  case MensajeConsRucSuperaTamano = '0460';
  case RucInexistente = '0500';
  case RucSinPermisoParaElWs = '0501';
  case RucEncontrado = '0502';
  case ArchivoRucEncontrado = '0520';
  case ArchivoRucNoEncontrado = '0521';
  case ArchivoRucLimiteDeDescargas = '0522';
  case ArchivoRucRucNoCoincide = '0523';
  // 12.3.6 siRecepEvento
  case MensajeRecepEventoSuperaTamano = '0560';
  case EventoRegistrado = '0600';

  private const VIGENTE = 'vigente';
  private const ELIMINADO = 'eliminado';
  private const OBSERVADO = 'observado';

  /** Por código: ID del MT (null si no lo tiene), descripción, estado (A/R), vigencia y fuente. */
  private const DATOS = [
    '0001' => ['AA01', 'Certificado de transmisor inválido', 'R', self::VIGENTE, 'respuestas-ws.md §12.2.1'],
    '0002' => ['AA02', 'Plazo de validez del certificado digital vencido o inválido', 'R', self::VIGENTE, 'respuestas-ws.md §12.2.1'],
    '0003' => ['AA03', 'Cadena de certificación inválida', 'R', self::VIGENTE, 'respuestas-ws.md §12.2.1'],
    '0004' => ['AA04', 'LCR del certificado transmisor inválida o inaccesible', 'R', self::VIGENTE, 'respuestas-ws.md §12.2.1'],
    '0005' => ['AA05', 'Certificado del transmisor revocado', 'R', self::VIGENTE, 'respuestas-ws.md §12.2.1'],
    '0006' => ['AA06', 'Certificado raíz no pertenece al MIC', 'R', self::VIGENTE, 'respuestas-ws.md §12.2.1'],
    '0007' => ['AA07', 'No existe la extensión del RUC del emisor en el certificado', 'R', self::VIGENTE, 'respuestas-ws.md §12.2.1'],
    '0100' => [null, 'Error Inesperado', 'R', self::OBSERVADO, 'captura 2026-10-09/06 (en el MT v100 era AB01 "Fallo de schema XML del área de datos", eliminado en v150)'],
    '0101' => ['AB02', 'Fallo de schema: no existe el campo raíz esperado para el mensaje', 'R', self::ELIMINADO, 'respuestas-ws.md §12.2.3'],
    '0102' => ['AB03', 'Fallo de schema: no existe el atributo versión para el campo raíz esperado para el mensaje', 'R', self::ELIMINADO, 'respuestas-ws.md §12.2.3'],
    '0104' => ['AB05', 'Existe algún namespace diferente del namespace estándar del DE', 'R', self::ELIMINADO, 'respuestas-ws.md §12.2.3'],
    '0105' => ['AB06', 'Existen caracteres de edición en el inicio o en el final del mensaje, o entre los campos XML', 'R', self::ELIMINADO, 'respuestas-ws.md §12.2.3'],
    '0106' => ['AB07', 'Utilizado prefijo en el namespace', 'R', self::ELIMINADO, 'respuestas-ws.md §12.2.3'],
    '0107' => ['AB08', 'Utilizada codificación diferente de UTF-8', 'R', self::ELIMINADO, 'respuestas-ws.md §12.2.3'],
    '0120' => ['AC01', 'Certificado inválido', 'R', self::VIGENTE, 'respuestas-ws.md §12.2.4'],
    '0121' => ['AC02', 'Alguna o todas las fechas del certificado (inicio o final de validez) inválidas', 'R', self::VIGENTE, 'respuestas-ws.md §12.2.4'],
    '0122' => ['AC03', 'No existe la extensión del RUC en el certificado', 'R', self::VIGENTE, 'respuestas-ws.md §12.2.4'],
    '0123' => ['AC04', 'Cadena de certificación inválida', 'R', self::ELIMINADO, 'respuestas-ws.md §12.2.4 (absorbido por 0141)'],
    '0124' => ['AC05', 'Problema en la LCR del certificado de firma', 'R', self::ELIMINADO, 'respuestas-ws.md §12.2.4 (absorbido por 0141)'],
    '0125' => ['AC06', 'Certificado de firma revocado', 'R', self::ELIMINADO, 'respuestas-ws.md §12.2.4 (absorbido por 0141)'],
    '0126' => ['AC07', 'Certificado raíz no corresponde al MIC', 'R', self::ELIMINADO, 'respuestas-ws.md §12.2.4 (absorbido por 0141)'],
    '0140' => ['AD01', 'Firma difiere del estándar', 'R', self::VIGENTE, 'respuestas-ws.md §12.2.5'],
    '0141' => ['AD02', 'Valor de la firma (SignatureValue) diferente del calculado por el PKI', 'R', self::VIGENTE, 'respuestas-ws.md §12.2.5'],
    '0142' => ['AD03', 'RUC del certificado utilizado para firmar no pertenece al contribuyente emisor', 'R', self::VIGENTE, 'respuestas-ws.md §12.2.5'],
    '0143' => [null, 'La firma digital del evento debe corresponder al receptor del DE/DTE', 'R', self::OBSERVADO, 'captura 2026-10-11/15 (no figura en el MT v150)'],
    '0160' => ['AE01', 'XML malformado', 'R', self::VIGENTE, 'respuestas-ws.md §12.2.6 (el ambiente degradado lo responde también a mensajes válidos: capturas 2026-10-06 y 2026-10-11/06)'],
    '0161' => ['AE02', 'Servidor de procesamiento momentáneamente sin respuesta', 'R', self::VIGENTE, 'respuestas-ws.md §12.2.6'],
    '0162' => ['AE03', 'Servidor de procesamiento paralizado, sin tiempo de regreso', 'R', self::VIGENTE, 'respuestas-ws.md §12.2.6'],
    '0163' => ['AE04', 'Versión del formato del WS no soportada', 'R', self::VIGENTE, 'respuestas-ws.md §12.2.6'],
    '0180' => ['AF01', 'Elemento de HeaderMsg inexistente en el SOAP Header', 'R', self::VIGENTE, 'respuestas-ws.md §12.2.7'],
    '0183' => ['AF04', 'RUC del certificado utilizado en la conexión no pertenece a un contribuyente activo en la base de datos de RUC', 'R', self::VIGENTE, 'respuestas-ws.md §12.2.7'],
    '0200' => ['BA01', 'Mensaje de datos de entrada del WS siRecepDE superior a 1.000 KB', 'R', self::VIGENTE, 'respuestas-ws.md §12.3.1.1'],
    '0260' => ['BC01', 'Autorización del DE satisfactoria', 'A', self::VIGENTE, 'respuestas-ws.md §12.3.1.3; captura 2026-10-09/03'],
    '0270' => ['BD01', 'Mensaje de datos de entrada del WS siRecepLoteDE superior a 10.000 KB', 'R', self::VIGENTE, 'respuestas-ws.md §12.3.2.1'],
    '0300' => ['BF01', 'Lote recibido con éxito', 'A', self::VIGENTE, 'respuestas-ws.md §12.3.2.3; captura 2026-10-11/13'],
    '0301' => ['BF02', 'Lote no encolado para procesamiento', 'R', self::VIGENTE, 'respuestas-ws.md §12.3.2.3'],
    '0320' => ['BG01', 'Mensaje de datos de entrada del WS siResultLoteDE superior a 1.000 KB', 'R', self::VIGENTE, 'respuestas-ws.md §12.3.3.1'],
    '0340' => ['BH01', 'RUC del certificado de conexión no autorizado a consultar el lote', 'R', self::VIGENTE, 'respuestas-ws.md §12.3.3.2'],
    '0360' => ['BI01', 'Lote inexistente', 'R', self::VIGENTE, 'respuestas-ws.md §12.3.3.3'],
    '0361' => ['BI02', 'Lote en procesamiento', 'R', self::VIGENTE, 'respuestas-ws.md §12.3.3.3'],
    '0362' => ['BI03', 'Procesamiento de lote concluido', 'A', self::VIGENTE, 'respuestas-ws.md §12.3.3.3; captura 2026-10-11/14'],
    '0363' => ['BI04', 'Lotes con tipos distintos de DE', 'R', self::VIGENTE, 'respuestas-ws.md §12.3.3.3 (la tabla escribe "B104")'],
    '0364' => [null, 'Consulta extemporánea del lote: pasaron más de 48 horas desde el envío, consultar cada CDC con siConsDE', 'R', self::VIGENTE, 'guía de mejores prácticas de la DNIT §7 (envio-lote.md); no figura en el MT v150'],
    '0380' => ['BJ01', 'Mensaje de datos de entrada del WS siConsDE superior a 1.000 KB', 'R', self::VIGENTE, 'respuestas-ws.md §12.3.4.1'],
    '0420' => ['BL01', 'CDC inexistente', 'R', self::VIGENTE, 'respuestas-ws.md §12.3.4.3; captura 2026-10-09/02 ("Documento No Existe en SIFEN o ha sido Rechazado")'],
    '0421' => ['BL02', 'RUC del certificado sin permiso para consultar el DE', 'R', self::VIGENTE, 'respuestas-ws.md §12.3.4.3, MT §9.4.2 Tabla G (resolución del 03/10/2026)'],
    '0422' => ['BL03', 'CDC encontrado', 'A', self::VIGENTE, 'respuestas-ws.md §12.3.4.3, MT §9.4.2 Tabla G; capturas 2026-10-09/05 y 09'],
    '0460' => ['BM01', 'Mensaje de datos de entrada del WS siConsRUC superior a 1.000 KB', 'R', self::VIGENTE, 'respuestas-ws.md §12.3.5.1'],
    '0500' => ['BO01', 'RUC inexistente', 'R', self::VIGENTE, 'respuestas-ws.md §12.3.5.3'],
    '0501' => ['BO02', 'RUC no tiene permiso para utilizar el WS', 'R', self::VIGENTE, 'respuestas-ws.md §12.3.5.3'],
    '0502' => ['BO03', 'Éxito en la consulta', 'A', self::VIGENTE, 'respuestas-ws.md §12.3.5.3; captura 2026-10-09/01 ("RUC encontrado")'],
    '0520' => ['BO04', 'Archivo encontrado', 'A', self::VIGENTE, 'NT-011 Tabla L (consulta-ruc.md)'],
    '0521' => ['BO05', 'No se encontró el archivo generado en el día', 'R', self::VIGENTE, 'NT-011 Tabla L (consulta-ruc.md)'],
    '0522' => ['BO06', 'Se ha superado el límite de descargas del día', 'R', self::VIGENTE, 'NT-011 Tabla L (consulta-ruc.md)'],
    '0523' => ['BO07', 'El RUC del certificado no coincide con el RUC de consulta', 'R', self::VIGENTE, 'NT-011 Tabla L (consulta-ruc.md)'],
    '0560' => ['BS01', 'Mensaje de datos de entrada del WS siRecepEvento superior a 1.000 KB', 'R', self::VIGENTE, 'respuestas-ws.md §12.3.6.1'],
    '0600' => ['BU01', 'Evento registrado correctamente', 'A', self::VIGENTE, 'respuestas-ws.md §12.3.6.3; captura 2026-10-09/08'],
  ];

  /**
   * Resuelve un código en cualquiera de las formas en que circula: entero (260), texto sin cero (`"260"`) o texto de
   * cuatro dígitos (`"0260"`). Null si no es un código de WS conocido (por ejemplo, 1321 es una validación del DE).
   */
  public static function fromAny(int|string|null $codigo): ?self
  {
    if ($codigo === null)
      return null;
    $texto = trim((string) $codigo);
    if ($texto === '' || !ctype_digit($texto))
      return null;
    return self::tryFrom(str_pad($texto, 4, '0', STR_PAD_LEFT));
  }

  /** Código de cuatro dígitos con cero inicial, como en dCodRes. */
  public function codigo(): string
  {
    return $this->value;
  }

  /** Texto del resultado según la tabla del MT (o el literal real, en los observados). */
  public function descripcion(): string
  {
    return self::DATOS[$this->value][1];
  }

  /** ID de la validación en el MT (AA01, BC01, …), o null cuando el código no viene del MT. */
  public function idMT(): ?string
  {
    return self::DATOS[$this->value][0];
  }

  /** Estado que el MT asigna al código: aprobación (A) o rechazo (R). */
  public function esAprobacion(): bool
  {
    return self::DATOS[$this->value][2] === 'A';
  }

  /**
   * Respuesta transitoria del servidor: conviene reintentar más tarde (0100 "Error Inesperado": captura 2026-10-09/06,
   * el mismo evento se aprobó 36 s después; 0161 y 0162: servidor sin respuesta; 0361: lote todavía en procesamiento).
   * 0160 no se marca transitorio aunque el ambiente degradado lo responda a mensajes válidos: no se puede distinguir
   * de un XML realmente inválido sin validarlo localmente (Sifen::ValidarXSD()).
   */
  public function esTransitorio(): bool
  {
    return in_array($this, [self::ErrorInesperado, self::ServidorSinRespuestaMomentanea, self::ServidorParalizado, self::LoteEnProcesamiento], true);
  }

  /** False para los códigos que el MT v150 eliminó (AB02-AB08, AC04-AC07). */
  public function vigente(): bool
  {
    return self::DATOS[$this->value][3] !== self::ELIMINADO;
  }

  /** True para los códigos que no figuran en las tablas del MT pero el SIFEN responde (0100, 0143). */
  public function esObservado(): bool
  {
    return self::DATOS[$this->value][3] === self::OBSERVADO;
  }

  public function categoria(): CategoriaCodigoWS
  {
    return CategoriaCodigoWS::deCodigo($this->value);
  }

  /** De dónde sale el código: sección de ekuat-ia, NT, guía o captura. */
  public function fuente(): string
  {
    return self::DATOS[$this->value][4];
  }
}
