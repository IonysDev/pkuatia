<?php

namespace IonysDev\Pkuatia;

use DateTime;
use DateTimeZone;
use Exception;
use IonysDev\Pkuatia\Core\Config;
use IonysDev\Pkuatia\Core\Constants;
use IonysDev\Pkuatia\Core\Constants\OpeComTipTrans;
use IonysDev\Pkuatia\Core\Constants\TimbTiDE;
use IonysDev\Pkuatia\Core\Constants\TipIDRec;
use IonysDev\Pkuatia\Core\Constants\MotivoCertificado;
use IonysDev\Pkuatia\Core\Exceptions\CampoInvalidoException;
use IonysDev\Pkuatia\Core\Exceptions\CertificadoException;
use IonysDev\Pkuatia\Core\Exceptions\ConfiguracionException;
use IonysDev\Pkuatia\Core\Exceptions\PkuatiaExceptionInterface;
use IonysDev\Pkuatia\Core\Exceptions\RespuestaException;
use IonysDev\Pkuatia\Core\Exceptions\TransporteException;
use IonysDev\Pkuatia\Core\Exceptions\ValidacionException;
use IonysDev\Pkuatia\Core\Requests\REnviConsRUC;
use IonysDev\Pkuatia\Core\Requests\REnviConsDe;
use IonysDev\Pkuatia\Core\Responses\RResEnviConsRUC;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\DocumentoElectronico;
use IonysDev\Pkuatia\Core\Fields\DE\A\DE;
use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;
use IonysDev\Pkuatia\Core\Fields\DE\I\Signature;
use IonysDev\Pkuatia\Core\Fields\DE\J\GCamFuFD;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\GGroupGesEve;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\GGroupTiEvt;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\REve;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\RGesEve;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\RGEveNom;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\RGeVeCan;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\RGeVeInu;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\RGeVeTr;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GER\RGeVeConf;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GER\RGeVeDescon;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GER\RGeVeDisconf;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GER\RGeVeNotRec;
use IonysDev\Pkuatia\Core\Requests\REnviConsArchivoRUC;
use IonysDev\Pkuatia\Core\Requests\REnviConsLoteDe;
use IonysDev\Pkuatia\Core\Requests\REnviDe;
use IonysDev\Pkuatia\Core\Requests\REnviEventoDe;
use IonysDev\Pkuatia\Core\Requests\REnvioLote;
use IonysDev\Pkuatia\Core\Responses\RResEnviConsArchivoRUC;
use IonysDev\Pkuatia\Core\Responses\RResEnviConsDe;
use IonysDev\Pkuatia\Core\Responses\RResEnviConsLoteDe;
use IonysDev\Pkuatia\Core\Responses\RResEnviLoteDe;
use IonysDev\Pkuatia\Core\Responses\RRetEnviDe;
use IonysDev\Pkuatia\Core\Responses\RRetEnviEventoDe;
use IonysDev\Pkuatia\Helpers\PemHelper;
use IonysDev\Pkuatia\Helpers\Pkcs12Helper;
use IonysDev\Pkuatia\Helpers\QRHelper;
use IonysDev\Pkuatia\Helpers\SignHelper;
use IonysDev\Pkuatia\Validacion\ResultadoFirma;
use IonysDev\Pkuatia\Validacion\VerificadorFirma;
use SoapClient;
use SoapFault;
use SoapVar;
use Stringable;
use ZipArchive;

class Sifen
{
  private static ?SoapClient $client = null; // último cliente usado: fuente de GetLastRequest()/GetLastResponse()
  private static Config $config;
  private static $options;
  /** @var callable(string, array): SoapClient|null Factoría de SoapClient para pruebas (null = comportamiento por defecto). */
  private static $soapClientFactory = null;
  /** Carpeta propia con el certificado y la clave extraídos del PKCS#12 (PK-39, 0.3.0); null si no se usó PKCS#12. */
  private static ?string $carpetaTemporal = null;
  private static bool $limpiezaRegistrada = false;

  /**
   * Inicializa la clase Sifen con la configuración necesaria para realizar las peticiones.
   * Es obligatorio que se llame a este método antes de realizar cualquier petición.
   * 
   * @param Config $config
   * 
   * @return void
   */
  public static function Init(Config $config)
  {
    if (!file_exists($config->privateKeyFilePath))
      throw CertificadoException::porMotivo(MotivoCertificado::NoEncontrado, "[Sifen] El archivo de clave privada no ha sido encontrado en: " . $config->privateKeyFilePath . ".");
    // Q-C6 (0.3.0): con el CSC de fábrica (el del ambiente de pruebas) el SIFEN de producción rechaza todo DE con 2501
    // (J002a), así que no se arranca en producción con él. En desarrollo no cambia nada.
    if ($config->env === Config::ENV_PROD && $config->usaCscDePrueba())
      throw new ConfiguracionException('[Sifen] El CSC configurado es el del ambiente de pruebas (' . Config::CSC_DE_PRUEBA . '): en producción '
        . '(env = prod) el SIFEN rechaza cada DE con 2501 (J002a). Informe en Config el CSC ($csc) y su identificador ($idCsc) asignados por el SIFEN.');
    $config->certificateFormat = Config::normalizeCertificateFormat($config->certificateFormat);
    self::$config = $config;

    if ($config->isPem() && $config->usesCombinedCertificateFile()) {
      PemHelper::validateCombinedPemFile($config->privateKeyFilePath);
    }
    else if ($config->isPem()) {
      if (!$config->certificateFilePath || !file_exists($config->certificateFilePath))
        throw CertificadoException::porMotivo(MotivoCertificado::NoEncontrado, "[Sifen] El archivo de certificado no ha sido encontrado en: " . $config->certificateFilePath . ".");
    }

    self::borrarTemporales(); // PK-39: un Init() repetido no deja en disco los temporales del anterior
    $sslContext = null;
    if ($config->isPem()) {
      $sslOptions = [
        'passphrase' => $config->privateKeyPassphrase,
        'verify_peer' => true,
        'verify_peer_name' => true,
      ];
      if ($config->usesCombinedCertificateFile()) {
        $sslOptions['local_cert'] = $config->privateKeyFilePath;
      }
      else {
        $sslOptions['local_cert'] = $config->certificateFilePath;
        $sslOptions['local_pk'] = $config->privateKeyFilePath;
      }
      $sslContext = stream_context_create(['ssl' => $sslOptions]);
    }
    else if ($config->isPkcs12()) {
      $sslContext = self::createStreamContextFromPkcs12($config->privateKeyFilePath, $config->privateKeyPassphrase);
    }
    else {
      throw CertificadoException::porMotivo(MotivoCertificado::NoSoportado, "[Sifen] Formato de certificado no soportado.");
    }

    self::$options = [
      'soap_version' => SOAP_1_2,
      'trace' => $config->soapTrace, // Config::$soapTrace (0.3.0): con false, GetLastRequest()/GetLastResponse() devuelven null
      'exceptions' => true,
      // El SIFEN limita la tasa de solicitudes: la caché de WSDL evita re-descargarlo en cada
      // operación (opt-in vía Config::$wsdlCacheEnabled para no alterar el comportamiento histórico).
      'cache_wsdl' => $config->wsdlCacheEnabled ? WSDL_CACHE_DISK : WSDL_CACHE_NONE,
      'stream_context' => $sslContext,
    ];
    // Opcionales (PK-31, 0.2.1): sin configurar no se agregan y rige el comportamiento de PHP, como hasta 0.2.0.
    if ($config->soapConnectionTimeout !== null)
      self::$options['connection_timeout'] = $config->soapConnectionTimeout;
    if ($config->soapUserAgent !== null)
      self::$options['user_agent'] = $config->soapUserAgent;
    self::$client = null;
    
    SignHelper::Init($config->privateKeyFilePath, $config->privateKeyPassphrase, $config->certificateFormat, $config->certificateFilePath);
  }

  /**
   * Libera lo que Init() dejó en disco y en memoria: borra la carpeta temporal con el certificado y la clave extraídos
   * del PKCS#12 (PK-39), descarta el cliente SOAP (GetLastRequest() y GetLastResponse() pasan a devolver null), olvida
   * las opciones y el firmador olvida la clave privada (SignHelper::Shutdown(), Q-C4). Se puede llamar varias veces;
   * un Init() posterior vuelve a dejar todo listo. La librería borra los temporales sola al terminar el script.
   * Nuevo en 0.3.0 (Fase C, C12).
   */
  public static function Shutdown(): void
  {
    self::borrarTemporales();
    self::$client = null;
    self::$options = null;
    SignHelper::Shutdown();
  }

  /**
   * Inyecta una factoría de SoapClient para pruebas unitarias sin red.
   * Pasar null restaura el comportamiento por defecto (new SoapClient).
   *
   * @param callable(string $wsdl, array $options): SoapClient|null $factory
   */
  public static function SetSoapClientFactory(?callable $factory): void
  {
    self::$soapClientFactory = $factory;
  }

  /**
   * @return SoapClient
   */
  /**
   * XML de la última solicitud SOAP enviada al SIFEN, o null si todavía no hubo ninguna desde Init().
   * Útil para auditar y para diagnosticar un rechazo. Nuevo en 0.2.1 (PK-31).
   *
   * @return String|null
   */
  public static function GetLastRequest(): ?String
  {
    return self::$client?->__getLastRequest();
  }

  /**
   * XML crudo de la última respuesta del SIFEN, o null si todavía no hubo ninguna desde Init(). Sigue
   * disponible aunque el parseo haya fallado: si una llamada lanza una excepción con un TypeError como
   * causa, la respuesta (por ejemplo, con el dProtAut de un DE ya aprobado) se puede guardar desde aquí.
   * Nuevo en 0.2.1 (PK-31).
   *
   * @return String|null
   */
  public static function GetLastResponse(): ?String
  {
    return self::$client?->__getLastResponse();
  }

  /**
   * Convierte la falla ocurrida en una operación del facade en la excepción tipada que corresponde (Fase C, C2, Q-C3):
   * - las excepciones propias de la librería (validación, configuración, firma) pasan tal cual;
   * - un SoapFault (WSDL, conexión, cuerpo vacío, falla del servidor) llega como TransporteException, o como
   *   SifenNoDisponibleException si el patrón es el de saturación; sigue siendo un \SoapFault y conserva la causa;
   * - cualquier otra falla (TypeError del parseo, \Exception de una clase de respuesta) llega como RespuestaException,
   *   con la respuesta cruda del SIFEN si se pudo recuperar.
   * El mensaje conserva el prefijo "[Sifen] …" de cada operación, como hasta 0.2.1.
   */
  private static function excepcionDeOperacion(\Throwable $e, string $operacion, string $prefijo): \Throwable
  {
    // Una RespuestaException de una clase de respuesta (campo faltante) se completa con la operación y la respuesta cruda.
    if ($e instanceof RespuestaException)
      return RespuestaException::desde($e, $operacion, $prefijo . ': ' . $e->getMessage(), self::respuestaCrudaSinFallar());
    if ($e instanceof PkuatiaExceptionInterface)
      return $e;
    if ($e instanceof SoapFault)
      return TransporteException::desde($e, $operacion, $prefijo);
    return RespuestaException::desde($e, $operacion, $prefijo . ': ' . $e->getMessage(), self::respuestaCrudaSinFallar());
  }

  /** Respuesta cruda del último cliente, o null si no hay cliente o no la puede dar. */
  private static function respuestaCrudaSinFallar(): ?string
  {
    try {
      $crudo = self::$client?->__getLastResponse();
      return is_string($crudo) ? $crudo : null;
    } catch (\Throwable) {
      return null;
    }
  }

  private static function createSoapClient(string $wsdl): SoapClient
  {
    // GetLastRequest() y GetLastResponse() se refieren a esta llamada: si crear el cliente falla (por ejemplo, el WSDL
    // no responde), no queda el cliente de la llamada anterior (QA de la Fase B).
    self::$client = null;
    if (self::$soapClientFactory !== null) {
      $client = (self::$soapClientFactory)($wsdl, self::$options);
      if (!$client instanceof SoapClient) {
        throw new ConfiguracionException('[Sifen] La factoría de SoapClient debe devolver una instancia de SoapClient.');
      }
      return $client;
    }

    return new SoapClient($wsdl, self::$options);
  }

  /**
   * Realiza la consulta de un RUC en el SIFEN.
   * 
   * @param String $ruc RUC a consultar.
   * 
   * @return RResEnviConsRUC
   */
  public static function ConsultarRUC(String $ruc): RResEnviConsRUC
  {
    // Fase C (Q-C3): toda falla llega tipada. El SoapFault llega como TransporteException, que sigue siendo un
    // \SoapFault (catch (\SoapFault) funciona como hasta 0.2.1); los errores de parseo, como RespuestaException con
    // la respuesta cruda (también en GetLastResponse(), PK-31).
    try {
      self::$client = self::createSoapClient(self::GetSifenUrlBase() . Constants::SIFEN_PATH_CONSULTA_RUC . "?wsdl");
      $object = self::RespuestaOGenerica(self::$client->rEnviConsRUC(new REnviConsRUC(self::GetDId(), $ruc)));
      return RResEnviConsRUC::fromStdClassObject($object);
    } catch (\Throwable $e) {
      throw self::excepcionDeOperacion($e, 'ConsultarRUC', "[Sifen] Error al consultar el RUC en el SIFEN");
    }
  }

  /**
   * Realiza la consulta masiva de RUC en el SIFEN (WS siConsArchivoRUC, NT-011).
   * Devuelve un archivo comprimido (ZIP en Base64) con la razón social, el estado del RUC y la marca de
   * facturador electrónico de todos los contribuyentes activos. El SIFEN permite una descarga por día.
   *
   * @param String $rucFacturador RUC del facturador electrónico que consulta, sin dígito verificador.
   *                              Debe coincidir con el RUC del certificado utilizado para la conexión.
   *
   * @return RResEnviConsArchivoRUC Respuesta del SIFEN con el archivo de contribuyentes.
   */
  public static function ConsultarArchivoRUC(String $rucFacturador): RResEnviConsArchivoRUC
  {
    try {
      self::$client = self::createSoapClient(self::GetSifenUrlBase() . Constants::SIFEN_PATH_CONSULTA_ARCHIVO_RUC . "?wsdl");
      $object = self::RespuestaOGenerica(self::$client->rEnviConsArchivoRUC(new REnviConsArchivoRUC(self::GetDId(), $rucFacturador)));
      return RResEnviConsArchivoRUC::FromSifenResponseObject($object);
    } catch (\Throwable $e) {
      throw self::excepcionDeOperacion($e, 'ConsultarArchivoRUC', "[Sifen] Error al consultar el archivo de RUC en el SIFEN");
    }
  }

  /**
   * Realiza la consulta de un Documento Electrónico en el SIFEN.
   * 
   * @param String $cdc Código de Control del Documento Electrónico a consultar.
   * 
   * @return RResEnviConsDe
   */
  public static function ConsultarDE(String $cdc): RResEnviConsDe
  {
    // Fase C (Q-C3): como en ConsultarRUC, toda falla llega tipada.
    try {
      self::$client = self::createSoapClient(self::GetSifenUrlBase() . Constants::SIFEN_PATH_CONSULTA . "?wsdl");
      $object = self::RespuestaOGenerica(self::$client->REnviConsDe(new REnviConsDe(self::GetDId(), $cdc)));
      return RResEnviConsDe::FromSifenResponseObject($object);
    } catch (\Throwable $e) {
      throw self::excepcionDeOperacion($e, 'ConsultarDE', "[Sifen] Error al consultar el documento electrónico en el SIFEN");
    }
  }

  /**
   * Verifica la firma digital de un rDE o de un sobre de eventos (gGroupGesEve) recibido: el digest de la referencia,
   * el valor de la firma contra el certificado de KeyInfo, los algoritmos del estándar (NT-016) y la vigencia del
   * certificado en dFecFirma (0140, 0141, 0120, 0121 y 2450 del MT). No necesita Init() ni red. No verifica la cadena
   * de certificación ni la revocación. Nuevo en 0.3.0 (Fase C, C8).
   *
   * @param String $xml XML del rDE firmado (p. ej. el que devuelve FirmarDE() o el que trae ConsultarDE()) o del sobre de eventos.
   *
   * @return ResultadoFirma esValida(), getFirmas() (una InfoFirma por Signature, con el certificado) y getErrores().
   */
  public static function VerificarFirma(String $xml): ResultadoFirma
  {
    return VerificadorFirma::verificar($xml);
  }

  /**
   * Firma un DE (contenido en un RDE) y devuelve en forma de cadena el XML firmado.
   * Además genera el link para el código QR del DE. 
   * Este XML estará listo para envío al SIFEN.
   *  
   * @param RDE $rde Contenedor del DE a firmar.
   * @param DateTime $fechaFirma Fecha y hora de la firma (dFecFirma); se respeta tal cual, con la zona horaria que traiga.
   * @param String $infoAdicionalEmisor Información adicional de interés del emisor (J003 dInfAdic, 1 a 5000 caracteres, DE_v150.xsd:1922-1931); se emite fuera de la firma, en gCamFuFD. Vacío = no se emite.
   *
   * @return String XML del DE firmado.
   */
  public static function FirmarDE(RDE $rde, DateTime $fechaFirma, String $infoAdicionalEmisor = ''): String
  {
    // Valida la regla de la NT-024 antes de firmar, para evitar un rechazo seguro del SIFEN (validación 1321).
    self::ValidarUmbralInnominadoNT024($rde->getDE());

    // Si el ambiente es "dev", se establece el valor de gEmis->dNomEmi a  "DE generado en ambiente de prueba - sin valor comercial ni fiscal
    if(self::$config->env == Config::ENV_DEV) {
      $rde->getDE()->getGDatGralOpe()->getGEmis()->setDNomEmi("DE generado en ambiente de prueba - sin valor comercial ni fiscal");
    }

    // Firma el documento electrónico
    $xmlDocument = SignHelper::SignRDE($rde, $fechaFirma);

    // Extrae la firma del documento electrónico
    $Signature = Signature::FromDOMElement($xmlDocument->getElementsByTagName("Signature")->item(0));

    // Verifica si en los campos fuera de la firma hay datos
    $gCamFuFD = $rde->getGCamFuFD();
    if (is_null($gCamFuFD))
      $gCamFuFD = new GCamFuFD();
    else {
      // Eliminar el nodo del gCamFuFD si es que existe del xmlDocument firmado
      $rdeNode = $xmlDocument->getElementsByTagName("rDE")->item(0);
      for ($i = 0; $i < $rdeNode->childNodes->length; $i++) {
        $node = $rdeNode->childNodes->item($i);
        if (strcmp($node->nodeName, 'gCamFuFD') == 0) {
          $rdeNode->removeChild($node);
        }
      }
    }

    // Establece el valor del link para el QR 
    $gCamFuFD->setDCarQR(QRHelper::GenerateQRContent(self::$config, $rde->getDE(), $Signature));

    // J003 dInfAdic (1 a 5000 caracteres, DE_v150.xsd:1922-1931) se establece antes de serializar el grupo;
    // antes se asignaba después de toDOMElement() y nunca llegaba al XML.
    if (!empty($infoAdicionalEmisor)) {
      $gCamFuFD->setDInfAdic($infoAdicionalEmisor);
    }
    $gCamFuFDNode = $gCamFuFD->toDOMElement($xmlDocument);

    // Agrega el nodo del QR al documento electrónico
    $xmlDocument->getElementsByTagName("rDE")->item(0)->appendChild($gCamFuFDNode);

    // Genera la cadena XML a ser enviada al SIFEN
    return $xmlDocument->saveXML($xmlDocument->getElementsByTagName("rDE")->item(0));
  }

  /**
   * Realiza el envío de un Documento Electrónico al SIFEN.
   * 
   * @param String $rdeXML Cadena XML del DE firmado en un contenedor XML.
   * 
   * @return RRetEnviDe Respuesta del SIFEN a la solicitud de Envío.
   */
  public static function EnviarDE(String $rdeXML): RRetEnviDe
  {
    // Realiza el envío del documento electrónico al SIFEN
    try {
      self::$client = self::createSoapClient(self::GetSifenUrlBase() . Constants::SIFEN_PATH_RECIBE . "?wsdl");
      $rEnviDe = new REnviDe(self::GetDId(), new SoapVar('<ns1:xDE>' . $rdeXML . '</ns1:xDE>', XSD_ANYXML));
      $object = self::$client->rEnviDe($rEnviDe);
      return RRetEnviDe::FromSifenResponseObject($object);
    } catch (\Throwable $e) {
      // Q-B4: \Throwable para que un TypeError del parseo también llegue como excepción del facade, con la causa en
      // getPrevious() y la respuesta cruda en GetLastResponse() (PK-31). Fase C (C2): la excepción es la tipada.
      throw self::excepcionDeOperacion($e, 'EnviarDE', "[Sifen] Error al enviar el documento electrónico al SIFEN");
    }
  }


  /**
   * Realiza el envío de un lote de Documentos Electrónicos al SIFEN.
   * De acuerdo a la versión 150 del MT, este WS soporta hasta 50 documentos electrónicos por lote
   * y todos deben ser del mismo tipo de documento (C002).
   * El lote se comprime en ZIP; la codificación Base64 que exige el protocolo la aplica la capa SOAP
   * automáticamente (el WSDL declara xDE como base64Binary).
   *
   * @param array $lote Lote de DEs (contenidos en sus RDE respectivos) firmados en formato de cadena XML
   *
   * @return RResEnviLoteDe Respuesta del SIFEN con el número de lote para su posterior consulta con ConsultaLote().
   */
  public static function EnviarLoteDE(array $lote): RResEnviLoteDe
  {
    if (count($lote) == 0)
      throw new ValidacionException("[Sifen] El lote debe contener al menos un documento electrónico.");
    if (count($lote) > Constants::MAX_DOCUMENTOS_ELECTRONICOS_POR_LOTE)
      throw new ValidacionException("[Sifen] El lote no puede contener más de " . Constants::MAX_DOCUMENTOS_ELECTRONICOS_POR_LOTE . " documentos electrónicos.");

    // Conforma el contenedor rLoteDE validando, antes de la red, lo que el SIFEN rechaza (0301) o castiga con un
    // bloqueo temporal de 10 a 60 minutos de la recepción del RUC emisor (guía de mejores prácticas de envío de la
    // DNIT, §4 y §5): tipos de documento (C002) o RUC emisores distintos, CDC repetido y documentos sin CDC, sin tipo
    // o sin RUC emisor, que el SIFEN trata como contenido inválido (PK-41, 0.2.1).
    $tipoLote = null;
    $rucLote = null;
    $cdcs = [];
    $rLotDe = '<rLoteDE>';
    foreach (array_values($lote) as $i => $rde) {
      $n = $i + 1;
      if (!is_string($rde))
        throw new ValidacionException("[Sifen] El lote debe contener documentos electrónicos en formato de cadena XML.");
      if (preg_match('/<(?:[\w.-]+:)?DE\s[^>]*?\bId\s*=\s*(["\'])([^"\']*)\1/', $rde, $matches) !== 1)
        throw new ValidacionException("[Sifen] El documento $n del lote no tiene el CDC (atributo Id de DE). Enviar documentos firmados y completos: el SIFEN bloquea temporalmente la recepción del RUC emisor ante un lote con contenido inválido.");
      $cdc = $matches[2];
      if (isset($cdcs[$cdc]))
        throw new ValidacionException("[Sifen] El CDC $cdc está repetido en el lote (documentos " . $cdcs[$cdc] . " y $n). El SIFEN bloquea la recepción del RUC emisor de 10 a 60 minutos ante un CDC repetido.");
      $cdcs[$cdc] = $n;
      if (preg_match('/<(?:[\w.-]+:)?iTiDE>\s*(\d+)\s*<\/(?:[\w.-]+:)?iTiDE>/', $rde, $matches) !== 1)
        throw new ValidacionException("[Sifen] El documento $n del lote ($cdc) no tiene el tipo de documento (iTiDE).");
      if (is_null($tipoLote))
        $tipoLote = $matches[1];
      else if (strcmp($tipoLote, $matches[1]) != 0)
        throw new ValidacionException("[Sifen] Todos los documentos electrónicos del lote deben ser del mismo tipo (C002). Se encontraron documentos de tipo " . $tipoLote . " y tipo " . $matches[1] . ".");
      if (preg_match('/<(?:[\w.-]+:)?dRucEm>\s*([^<]*?)\s*<\/(?:[\w.-]+:)?dRucEm>/', $rde, $matches) !== 1)
        throw new ValidacionException("[Sifen] El documento $n del lote ($cdc) no tiene el RUC emisor (dRucEm).");
      if (is_null($rucLote))
        $rucLote = $matches[1];
      else if (strcmp($rucLote, $matches[1]) != 0)
        throw new ValidacionException("[Sifen] Todos los documentos electrónicos del lote deben ser del mismo RUC emisor. Se encontraron los RUC " . $rucLote . " y " . $matches[1] . ".");
      $rLotDe .= $rde;
    }
    $rLotDe .= '</rLoteDE>';

    // Comprime el lote en un archivo ZIP temporal (evita colisiones de concurrencia
    // y problemas de permisos en el directorio de trabajo).
    $zipFilePath = tempnam(sys_get_temp_dir(), 'pkuatia_lote_');
    if ($zipFilePath === false)
      throw new ConfiguracionException("[Sifen] No se pudo crear el archivo temporal para el ZIP del lote.");
    try {
      $zip = new ZipArchive();
      if ($zip->open($zipFilePath, ZipArchive::OVERWRITE) !== true)
        throw new ConfiguracionException("[Sifen] No se pudo crear el archivo ZIP del lote en: " . $zipFilePath);
      $zip->addFromString("rLoteDE.xml", $rLotDe);
      $zip->close();
      $zipContent = file_get_contents($zipFilePath);
    } finally {
      @unlink($zipFilePath);
    }
    // El mensaje de entrada del WS no debe superar 1000 KB (guía, §4 motivo e): ZIP en Base64 más el sobre SOAP.
    $tamanoMensaje = 4 * intdiv(strlen($zipContent) + 2, 3) + 1024;
    if ($tamanoMensaje > Constants::MAX_BYTES_MENSAJE_LOTE)
      throw new ValidacionException("[Sifen] El lote supera el tamaño máximo del mensaje del WS (1000 KB): con el ZIP en Base64 son unos " . ceil($tamanoMensaje / 1000) . " KB. Dividirlo en lotes más chicos.");

    // Realiza el envío del lote de documentos electrónicos al SIFEN.
    // El WSDL declara xDE como base64Binary (verificado contra sifen-test en junio/2026), por lo que
    // SoapClient codifica el contenido binario a Base64 automáticamente: NO codificar manualmente
    // (hacerlo produciría doble encoding y el SIFEN no podría descomprimir el ZIP).
    try {
      self::$client = self::createSoapClient(self::GetSifenUrlBase() . Constants::SIFEN_PATH_RECIBE_LOTE . "?wsdl");
      $rEnvioLote = new REnvioLote(self::GetDId(), $zipContent);
      $object = self::RespuestaOGenerica(self::$client->rEnvioLote($rEnvioLote));
      // El parseo entra al try desde 0.2.1 (Q-B4), como en los demás métodos.
      return RResEnviLoteDe::FromSifenResponseObject($object);
    } catch (\Throwable $e) {
      throw self::excepcionDeOperacion($e, 'EnviarLoteDE', "[Sifen] Error al enviar el lote de documentos electrónicos al SIFEN");
    }
  }

  /**
   * Realiza la consulta de un lote de Documentos Electrónicos en el SIFEN. La guía de la DNIT pide consultar pasados
   * 10 minutos de la recepción y luego a intervalos no menores a 10 minutos: ver EsperarResultadoLote().
   *
   * @param string|int $nroLote Número de lote (dProtConsLote) que devolvió EnviarLoteDE(). Conviene guardarlo como texto
   *                            con RResEnviLoteDe::getDProtConsLoteString(): tiene 17 dígitos en la práctica y hasta 20.
   * @return RResEnviConsLoteDe
   */
  public static function ConsultaLote(string|int $nroLote): RResEnviConsLoteDe
  {
    try {
      self::$client = self::createSoapClient(self::GetSifenUrlBase() . Constants::SIFEN_PATH_CONSULTA_LOTE . "?wsdl");
      $rEnviConsLoteDe = new REnviConsLoteDe(self::GetDId(), $nroLote);
      $object = self::RespuestaOGenerica(self::$client->rEnviConsLoteDe($rEnviConsLoteDe));
      return RResEnviConsLoteDe::FromSifenResponseObject($object);
    } catch (\Throwable $e) {
      throw self::excepcionDeOperacion($e, 'ConsultaLote', "[Sifen] Error al consultar el lote de documentos electrónicos en el SIFEN");
    }
  }

  /**
   * Espera el resultado de un lote con la política de la DNIT (guía de mejores prácticas de envío, §3.4 y §7): la
   * primera consulta pasados al menos 10 minutos y las siguientes a intervalos no menores a 10 minutos, mientras el lote
   * siga en procesamiento (0361). Pensado para llamarse después de EnviarLoteDE(): nunca consulta antes del plazo, y una
   * espera menor lanza InvalidArgumentException sin consultar. Bloquea el proceso mientras espera (PK-41, 0.2.1).
   *
   * @param string|int    $nroLote          Número de lote (dProtConsLote) que devolvió EnviarLoteDE().
   * @param int           $esperaInicialSeg Segundos antes de la primera consulta (mínimo 600).
   * @param int           $intervaloSeg     Segundos entre consultas (mínimo 600).
   * @param int           $maxIntentos      Cantidad máxima de consultas (mínimo 1).
   * @param callable|null $onIntento        Se llama después de cada consulta con (int $intento, RResEnviConsLoteDe $respuesta).
   * @param callable|null $esperar          Recibe los segundos a esperar; por defecto sleep(). Permite integrarlo con un
   *                                        planificador o probarlo sin esperar.
   *
   * @return RResEnviConsLoteDe La primera respuesta que no es 0361 (0362 concluido, 0360 inexistente, 0364 consulta
   *                            extemporánea o un rechazo), o la última si tras $maxIntentos consultas sigue en 0361.
   * @throws \InvalidArgumentException si una espera es menor a 600 segundos o $maxIntentos es menor a 1.
   * @throws \Exception los errores de ConsultaLote().
   */
  public static function EsperarResultadoLote(
    string|int $nroLote,
    int $esperaInicialSeg = Constants::ESPERA_MINIMA_CONSULTA_LOTE_SEG,
    int $intervaloSeg = Constants::ESPERA_MINIMA_CONSULTA_LOTE_SEG,
    int $maxIntentos = 6,
    ?callable $onIntento = null,
    ?callable $esperar = null
  ): RResEnviConsLoteDe {
    $minimo = Constants::ESPERA_MINIMA_CONSULTA_LOTE_SEG;
    if ($esperaInicialSeg < $minimo || $intervaloSeg < $minimo)
      throw new ValidacionException("[Sifen] La guía de la DNIT pide consultar el lote pasados $minimo segundos de la recepción y luego a intervalos no menores a $minimo segundos; se recibió una espera inicial de $esperaInicialSeg y un intervalo de $intervaloSeg.");
    if ($maxIntentos < 1)
      throw new ValidacionException("[Sifen] La cantidad máxima de consultas del lote debe ser al menos 1; se recibió $maxIntentos.");
    $esperar ??= static function (int $segundos): void {
      sleep($segundos);
    };
    $esperar($esperaInicialSeg);
    for ($intento = 1; ; $intento++) {
      $respuesta = self::ConsultaLote($nroLote);
      if ($onIntento !== null)
        $onIntento($intento, $respuesta);
      if ($respuesta->getDCodResLot() !== RResEnviConsLoteDe::COD_RES_EN_PROCESAMIENTO || $intento >= $maxIntentos)
        return $respuesta;
      $esperar($intervaloSeg);
    }
  }

  /**
   * Registra uno o más eventos en el SIFEN (WS siRecepEvento).
   * Los eventos se firman individualmente antes del envío. Se admiten hasta 15 eventos por transmisión.
   *
   * @param GGroupGesEve $raiz Raíz del grupo de gestión de eventos a registrar.
   *
   * @return RRetEnviEventoDe Respuesta del SIFEN al registro de los eventos.
   */
  public static function RegistrarEvento(GGroupGesEve $raiz): RRetEnviEventoDe
  {
    if (count($raiz->getRGesEve()) > Constants::MAX_EVENTOS_POR_TRANSMISION)
      throw new ValidacionException("[Sifen] No se pueden registrar más de " . Constants::MAX_EVENTOS_POR_TRANSMISION . " eventos por transmisión.");
    // El atributo Id de cada rEve (tdIdEve, Evento_v150.xsd:487) es la URI de su firma: debe ser único dentro del sobre.
    $ids = [];
    foreach ($raiz->getRGesEve() as $rGesEve) {
      $id = $rGesEve->getREve()->getId();
      if (in_array($id, $ids, true))
        throw new ValidacionException("[Sifen] El Id $id de rEve está repetido dentro del sobre: cada evento debe llevar un Id distinto (Evento_v150.xsd:487), porque es la referencia de su firma.");
      $ids[] = $id;
    }

    // Firma los eventos y realiza el envío al SIFEN
    try {
      $xmlDocument = SignHelper::SingEvents($raiz, self::$config);
      $signedXML = $xmlDocument->saveXML($xmlDocument->getElementsByTagName("gGroupGesEve")->item(0));

      self::$client = self::createSoapClient(self::GetSifenUrlBase() . Constants::SIFEN_PATH_EVENTO . "?wsdl");
      $rEnviEventoDe = new REnviEventoDe(self::GetDId(), new SoapVar(
        '<ns1:dEvReg>' . $signedXML . '</ns1:dEvReg>',
        XSD_ANYXML
      ));
      $object = self::RespuestaOGenerica(self::$client->rEnviEventoDe($rEnviEventoDe));
      return RRetEnviEventoDe::FromSifenResponseObject($object);
    } catch (\Throwable $e) {
      throw self::excepcionDeOperacion($e, 'RegistrarEvento', "[Sifen] Error al registrar el evento");
    }
  }

  /**
   * Registra un evento de cancelación de un DTE aprobado (evento del emisor).
   *
   * @param String $cdc CDC del DTE a cancelar.
   * @param String $motivo Motivo de la cancelación (5 a 500 caracteres).
   * @param DateTime|null $fechaFirma Fecha y hora de la firma del evento (dFecFirma). Por defecto, la hora actual en America/Asuncion (Constants::SIFEN_TIMEZONE).
   *
   * @return RRetEnviEventoDe Respuesta del SIFEN al registro del evento.
   */
  public static function CancelarDE(String $cdc, String $motivo, ?DateTime $fechaFirma = null): RRetEnviEventoDe
  {
    self::ValidarCdcEvento($cdc);
    self::ValidarMotivoEvento($motivo, 'cancelación');
    $rGeVeCan = new RGeVeCan();
    $rGeVeCan->setId($cdc);
    $rGeVeCan->setMOtEve($motivo);

    $gGroupTiEvt = new GGroupTiEvt();
    $gGroupTiEvt->setRGeVeCan($rGeVeCan);

    return self::RegistrarEventoUnico($gGroupTiEvt, $fechaFirma);
  }

  /**
   * Registra un evento de inutilización de un rango de numeración de documentos (evento del emisor).
   *
   * @param int $timbrado Número de timbrado.
   * @param int $nroEstablecimiento Número de establecimiento (1 a 999).
   * @param int $nroPuntoEmision Número de punto de expedición (1 a 999).
   * @param int $nroDocumentoInicial Número inicial del rango a inutilizar.
   * @param int $nroDocumentoFinal Número final del rango a inutilizar.
   * @param TimbTiDE|int $tipoDE Tipo de documento electrónico del rango.
   * @param String $motivo Motivo de la inutilización (5 a 500 caracteres).
   * @param DateTime|null $fechaFirma Fecha y hora de la firma del evento (dFecFirma). Por defecto, la hora actual en America/Asuncion (Constants::SIFEN_TIMEZONE).
   * @param String|null $serie Serie de la numeración (dSerieNum, dos letras mayúsculas, tserieNum de Evento_v150.xsd; 0-1). Nuevo en 0.2.1.
   *
   * @return RRetEnviEventoDe Respuesta del SIFEN al registro del evento.
   */
  public static function InutilizarNumeros(int $timbrado, int $nroEstablecimiento, int $nroPuntoEmision, int $nroDocumentoInicial, int $nroDocumentoFinal, TimbTiDE|int $tipoDE, String $motivo, ?DateTime $fechaFirma = null, ?String $serie = null): RRetEnviEventoDe
  {

    $tipoDEId = $tipoDE instanceof TimbTiDE ? $tipoDE->value : $tipoDE;

    if($nroDocumentoFinal < $nroDocumentoInicial)
      throw new ValidacionException("[Sifen] El número de documento final debe ser mayor al número de documento inicial.");
    if($nroDocumentoInicial < 1)
      throw new ValidacionException("[Sifen] El número de documento inicial debe ser mayor a 0.");
    if($nroDocumentoFinal < 1)
      throw new ValidacionException("[Sifen] El número de documento final debe ser mayor a 0.");
    if($timbrado < 1)
      throw new ValidacionException("[Sifen] El timbrado debe ser mayor a 0.");
    if($nroEstablecimiento < 1)
      throw new ValidacionException("[Sifen] El número de establecimiento debe ser mayor a 0.");
    if($nroPuntoEmision < 1)
      throw new ValidacionException("[Sifen] El número de punto de emisión debe ser mayor a 0.");
    if($tipoDEId < 1)
      throw new ValidacionException("[Sifen] El tipo de documento electrónico debe ser mayor a 0.");
    // iTiDE del evento es tiTiDEEv, de 1 a 9 (Evento_Types_v150.xsd); el 10 de TimbTiDE (boleta resimple) no aplica (PK-42).
    if($tipoDEId > 9)
      throw new ValidacionException("[Sifen] El tipo de documento a inutilizar debe estar entre 1 y 9 (tiTiDEEv, Evento_Types_v150.xsd); se recibió $tipoDEId.");
    // dSerieNum de trGeVeInu es 0-1 y tserieNum es [A-Z][A-Z] (Evento_v150.xsd); hasta 0.2.0 no se podía informar (PK-42).
    if($serie !== null && !preg_match('/^[A-Z]{2}$/', $serie))
      throw new ValidacionException("[Sifen] La serie debe tener dos letras mayúsculas (tserieNum); se recibió '$serie'.");
    if($motivo == '')
      throw new ValidacionException("[Sifen] El motivo de la inutilización no puede ser vacío.");
    if(strlen($motivo) < 5)
      throw new ValidacionException("[Sifen] El motivo de la inutilización debe tener al menos 5 caracteres.");
    if($nroDocumentoFinal - $nroDocumentoInicial > 1000)
      throw new ValidacionException("[Sifen] La diferencia entre el número de documento inicial y el número de documento final no puede ser mayor a 1000.");

    $rGeVeInu = new RGeVeInu();
    $rGeVeInu->setDNumTim($timbrado);
    $rGeVeInu->setDEst(str_pad($nroEstablecimiento, 3, '0', STR_PAD_LEFT));
    $rGeVeInu->setDPunExp(str_pad($nroPuntoEmision, 3, '0', STR_PAD_LEFT));
    $rGeVeInu->setDNumIn(str_pad($nroDocumentoInicial, 7, '0', STR_PAD_LEFT));
    $rGeVeInu->setDNumFin(str_pad($nroDocumentoFinal, 7, '0', STR_PAD_LEFT));
    $rGeVeInu->setITiDE($tipoDEId);
    if($serie !== null)
      $rGeVeInu->setDSerieNum($serie);
    self::ValidarMotivoEvento($motivo, 'inutilización');
    $rGeVeInu->setMOtEve($motivo);

    $gGroupTiEvt = new GGroupTiEvt();
    $gGroupTiEvt->setRGeVeInu($rGeVeInu);

    return self::RegistrarEventoUnico($gGroupTiEvt, $fechaFirma);
  }

  /**
   * Registra el evento del receptor "Notificación de recepción" de un DE/DTE (GEN001).
   *
   * @param String $cdc CDC del DE/DTE recibido.
   * @param DateTime $fechaEmision Fecha de emisión del DE.
   * @param DateTime $fechaRecepcion Fecha de recepción del DE por parte del receptor.
   * @param String $nombreReceptor Nombre o razón social del receptor.
   * @param int $totalGs Total general de la operación en guaraníes.
   * @param String|null $rucReceptor RUC del receptor (obligatorio si el receptor es contribuyente).
   * @param int|null $dvReceptor Dígito verificador del RUC del receptor (obligatorio si el receptor es contribuyente).
   * @param int|TipIDRec|null $tipoDocumentoIdentidad Tipo de documento de identidad (obligatorio si el receptor no es contribuyente).
   * @param String|null $nroDocumentoIdentidad Número de documento de identidad (obligatorio si el receptor no es contribuyente).
   * @param DateTime|null $fechaFirma Fecha y hora de la firma del evento (dFecFirma). Por defecto, la hora actual en America/Asuncion (Constants::SIFEN_TIMEZONE).
   *
   * @return RRetEnviEventoDe Respuesta del SIFEN al registro del evento.
   */
  public static function NotificarRecepcionDE(
    String $cdc,
    DateTime $fechaEmision,
    DateTime $fechaRecepcion,
    String $nombreReceptor,
    int $totalGs,
    ?String $rucReceptor = null,
    ?int $dvReceptor = null,
    int|TipIDRec|null $tipoDocumentoIdentidad = null,
    ?String $nroDocumentoIdentidad = null,
    ?DateTime $fechaFirma = null
  ): RRetEnviEventoDe
  {
    $esContribuyente = !is_null($rucReceptor);
    if (!$esContribuyente && (is_null($tipoDocumentoIdentidad) || is_null($nroDocumentoIdentidad)))
      throw new ValidacionException("[Sifen] Si el receptor no es contribuyente, debe informarse el tipo y número de documento de identidad.");

    self::ValidarCdcEvento($cdc);
    $rGeVeNotRec = new RGeVeNotRec();
    $rGeVeNotRec->setId($cdc);
    $rGeVeNotRec->setDFecEmi($fechaEmision);
    $rGeVeNotRec->setDFecRecep($fechaRecepcion);
    $rGeVeNotRec->setITipRec($esContribuyente ? 1 : 2);
    $rGeVeNotRec->setDNomRec($nombreReceptor);
    if ($esContribuyente) {
      $rGeVeNotRec->setDRucRec($rucReceptor);
      if (!is_null($dvReceptor))
        $rGeVeNotRec->setDDVRec($dvReceptor);
    } else {
      $rGeVeNotRec->setDTipIDRec($tipoDocumentoIdentidad instanceof TipIDRec ? $tipoDocumentoIdentidad->value : $tipoDocumentoIdentidad);
      $rGeVeNotRec->setDNumID($nroDocumentoIdentidad);
    }
    $rGeVeNotRec->setDTotalGs($totalGs);

    $gGroupTiEvt = new GGroupTiEvt();
    $gGroupTiEvt->setRGeVeNotRec($rGeVeNotRec);

    return self::RegistrarEventoUnico($gGroupTiEvt, $fechaFirma);
  }

  /**
   * Registra el evento del receptor "Conformidad" con un DE/DTE (GCO001).
   *
   * @param String $cdc CDC del DE/DTE conformado.
   * @param int $tipoConformidad Tipo de conformidad: 1 (Conformidad total) o 2 (Conformidad parcial).
   * @param DateTime|null $fechaRecepcion Fecha estimada de recepción (obligatoria cuando la conformidad es parcial).
   * @param DateTime|null $fechaFirma Fecha y hora de la firma del evento (dFecFirma). Por defecto, la hora actual en America/Asuncion (Constants::SIFEN_TIMEZONE).
   *
   * @return RRetEnviEventoDe Respuesta del SIFEN al registro del evento.
   */
  public static function ConformarDE(String $cdc, int $tipoConformidad = 1, ?DateTime $fechaRecepcion = null, ?DateTime $fechaFirma = null): RRetEnviEventoDe
  {
    if ($tipoConformidad != 1 && $tipoConformidad != 2)
      throw new ValidacionException("[Sifen] El tipo de conformidad debe ser 1 (total) o 2 (parcial).");
    if ($tipoConformidad == 2 && is_null($fechaRecepcion))
      throw new ValidacionException("[Sifen] La fecha estimada de recepción es obligatoria cuando la conformidad es parcial.");

    self::ValidarCdcEvento($cdc);
    $rGeVeConf = new RGeVeConf();
    $rGeVeConf->setId($cdc);
    $rGeVeConf->setITipConf($tipoConformidad);
    if (!is_null($fechaRecepcion))
      $rGeVeConf->setDFecRecep($fechaRecepcion);

    $gGroupTiEvt = new GGroupTiEvt();
    $gGroupTiEvt->setRGeVeConf($rGeVeConf);

    return self::RegistrarEventoUnico($gGroupTiEvt, $fechaFirma);
  }

  /**
   * Registra el evento del receptor "Disconformidad" con un DE/DTE (GDI001).
   *
   * @param String $cdc CDC del DE/DTE objetado.
   * @param String $motivo Motivo de la disconformidad (5 a 500 caracteres).
   * @param DateTime|null $fechaFirma Fecha y hora de la firma del evento (dFecFirma). Por defecto, la hora actual en America/Asuncion (Constants::SIFEN_TIMEZONE).
   *
   * @return RRetEnviEventoDe Respuesta del SIFEN al registro del evento.
   */
  public static function DisconformarDE(String $cdc, String $motivo, ?DateTime $fechaFirma = null): RRetEnviEventoDe
  {
    self::ValidarCdcEvento($cdc);
    self::ValidarMotivoEvento($motivo, 'disconformidad');

    $rGeVeDisconf = new RGeVeDisconf();
    $rGeVeDisconf->setId($cdc);
    $rGeVeDisconf->setMOtEve($motivo);

    $gGroupTiEvt = new GGroupTiEvt();
    $gGroupTiEvt->setRGeVeDisconf($rGeVeDisconf);

    return self::RegistrarEventoUnico($gGroupTiEvt, $fechaFirma);
  }

  /**
   * Registra el evento del receptor "Desconocimiento" de un DE/DTE (GED001).
   *
   * @param String $cdc CDC del DE/DTE desconocido.
   * @param DateTime $fechaEmision Fecha de emisión del DE.
   * @param DateTime $fechaRecepcion Fecha de recepción del DE por parte del receptor.
   * @param String $nombreReceptor Nombre o razón social del receptor.
   * @param String $motivo Motivo del desconocimiento (5 a 500 caracteres).
   * @param String|null $rucReceptor RUC del receptor (obligatorio si el receptor es contribuyente).
   * @param int|null $dvReceptor Dígito verificador del RUC del receptor (obligatorio si el receptor es contribuyente).
   * @param int|TipIDRec|null $tipoDocumentoIdentidad Tipo de documento de identidad (obligatorio si el receptor no es contribuyente).
   * @param String|null $nroDocumentoIdentidad Número de documento de identidad (obligatorio si el receptor no es contribuyente).
   * @param DateTime|null $fechaFirma Fecha y hora de la firma del evento (dFecFirma). Por defecto, la hora actual en America/Asuncion (Constants::SIFEN_TIMEZONE).
   *
   * @return RRetEnviEventoDe Respuesta del SIFEN al registro del evento.
   */
  public static function DesconocerDE(
    String $cdc,
    DateTime $fechaEmision,
    DateTime $fechaRecepcion,
    String $nombreReceptor,
    String $motivo,
    ?String $rucReceptor = null,
    ?int $dvReceptor = null,
    int|TipIDRec|null $tipoDocumentoIdentidad = null,
    ?String $nroDocumentoIdentidad = null,
    ?DateTime $fechaFirma = null
  ): RRetEnviEventoDe
  {
    self::ValidarCdcEvento($cdc);
    self::ValidarMotivoEvento($motivo, 'desconocimiento');
    $esContribuyente = !is_null($rucReceptor);
    if (!$esContribuyente && (is_null($tipoDocumentoIdentidad) || is_null($nroDocumentoIdentidad)))
      throw new ValidacionException("[Sifen] Si el receptor no es contribuyente, debe informarse el tipo y número de documento de identidad.");

    $rGeVeDescon = new RGeVeDescon();
    $rGeVeDescon->setId($cdc);
    $rGeVeDescon->setDFecEmi($fechaEmision);
    $rGeVeDescon->setDFecRecep($fechaRecepcion);
    $rGeVeDescon->setITipRec($esContribuyente ? 1 : 2);
    $rGeVeDescon->setDNomRec($nombreReceptor);
    if ($esContribuyente) {
      $rGeVeDescon->setDRucRec($rucReceptor);
      if (!is_null($dvReceptor))
        $rGeVeDescon->setDDVRec($dvReceptor);
    } else {
      $rGeVeDescon->setDTipIDRec($tipoDocumentoIdentidad instanceof TipIDRec ? $tipoDocumentoIdentidad->value : $tipoDocumentoIdentidad);
      $rGeVeDescon->setDNumID($nroDocumentoIdentidad);
    }
    $rGeVeDescon->setMOtEve($motivo);

    $gGroupTiEvt = new GGroupTiEvt();
    $gGroupTiEvt->setRGeVeDescon($rGeVeDescon);

    return self::RegistrarEventoUnico($gGroupTiEvt, $fechaFirma);
  }

  /**
   * Registra el evento de nominación de una factura electrónica emitida como innominada (GENFE001, NT-014).
   * El objeto RGEveNom debe conformarse previamente con los datos del receptor a nominar.
   *
   * @param RGEveNom $datosNominacion Datos del evento de nominación (CDC, motivo y datos del receptor).
   * @param DateTime|null $fechaFirma Fecha y hora de la firma del evento (dFecFirma). Por defecto, la hora actual en America/Asuncion (Constants::SIFEN_TIMEZONE).
   *
   * @return RRetEnviEventoDe Respuesta del SIFEN al registro del evento.
   */
  public static function NominarFE(RGEveNom $datosNominacion, ?DateTime $fechaFirma = null): RRetEnviEventoDe
  {
    $gGroupTiEvt = new GGroupTiEvt();
    $gGroupTiEvt->setRGeVeNom($datosNominacion);

    return self::RegistrarEventoUnico($gGroupTiEvt, $fechaFirma);
  }

  /**
   * Registra el evento de actualización de datos del transporte de una Nota de Remisión Electrónica (GET001).
   * El objeto RGeVeTr debe conformarse previamente con los datos del transporte a actualizar.
   *
   * @param RGeVeTr $datosTransporte Datos del evento de actualización del transporte (CDC, motivo y datos nuevos).
   * @param DateTime|null $fechaFirma Fecha y hora de la firma del evento (dFecFirma). Por defecto, la hora actual en America/Asuncion (Constants::SIFEN_TIMEZONE).
   *
   * @return RRetEnviEventoDe Respuesta del SIFEN al registro del evento.
   */
  public static function ActualizarDatosTransporte(RGeVeTr $datosTransporte, ?DateTime $fechaFirma = null): RRetEnviEventoDe
  {
    $gGroupTiEvt = new GGroupTiEvt();
    $gGroupTiEvt->setRGeVeTr($datosTransporte);

    return self::RegistrarEventoUnico($gGroupTiEvt, $fechaFirma);
  }

  /**
   * Verifica el formato del CDC de un evento antes de armar el sobre: tId exige 44 caracteres, dígitos salvo la posición
   * 10 que admite A-D (Evento_Types_v150.xsd:71-80). Evita un viaje a la red que termina en rechazo por esquema.
   *
   * @throws CampoInvalidoException Si el CDC no cumple el formato (elemento Id, valor recibido y regla tId).
   */
  private static function ValidarCdcEvento(String $cdc): void
  {
    if (!preg_match('/^[0-9]{9}[0-9A-D][0-9]{34}$/', $cdc))
      throw CampoInvalidoException::deCampo("[Sifen] El CDC debe tener 44 caracteres (dígitos; la posición 10 admite A-D) según tId (Evento_Types_v150.xsd:71-80); se recibió '" . $cdc . "' (" . strlen($cdc) . " caracteres).",
        null, 'Id', $cdc, 'tId: 44 caracteres, dígitos salvo la posición 10 que admite A-D (Evento_Types_v150.xsd:71-80)');
  }

  /**
   * Verifica la longitud del motivo de un evento: tmotEve exige de 5 a 500 caracteres (Evento_Types_v150.xsd:86-95).
   *
   * @throws CampoInvalidoException Si el motivo no tiene entre 5 y 500 caracteres (elemento mOtEve).
   */
  private static function ValidarMotivoEvento(String $motivo, String $evento): void
  {
    $largo = mb_strlen($motivo);
    if ($largo < 5 || $largo > 500)
      throw CampoInvalidoException::deCampo("[Sifen] El motivo de la $evento debe tener entre 5 y 500 caracteres (tmotEve, Evento_Types_v150.xsd:86-95); se recibieron $largo.",
        null, 'mOtEve', $motivo, 'tmotEve: de 5 a 500 caracteres (Evento_Types_v150.xsd:86-95)');
  }

  /**
   * Conforma el sobre de un único evento (rGesEve -> rEve -> gGroupTiEvt) y lo registra en el SIFEN.
   *
   * @param GGroupTiEvt $gGroupTiEvt Grupo del tipo de evento ya conformado.
   * @param DateTime|null $fechaFirma Fecha y hora de la firma del evento (dFecFirma). Por defecto, la hora actual en America/Asuncion (Constants::SIFEN_TIMEZONE).
   *
   * @return RRetEnviEventoDe Respuesta del SIFEN al registro del evento.
   */
  /**
   * Con el WSDL, SoapClient devuelve null cuando el elemento de respuesta no es el que declara la operación. Es lo que
   * pasa con el rechazo genérico del SIFEN (rRetEnviDe > rProtDe, p. ej. 0160 "XML Mal Formado."), que el ambiente
   * manda también a la consulta de RUC, de DE y de lote y a los eventos: hasta B13 la librería terminaba en
   * "Error Processing Request: null" (capturas reales del 06/10/2026, respuestas-ws/2026-10-06/meta-0704.json, y del
   * 11/10/2026). En ese caso se decodifica el rRetEnviDe de la respuesta cruda con la misma forma que daría SoapClient,
   * y la clase de respuesta lo lee como un rechazo con su código.
   */
  private static function RespuestaOGenerica(mixed $object): mixed
  {
    if ($object !== null || self::$client === null)
      return $object;
    try {
      $crudo = self::$client->__getLastResponse();
    } catch (\Throwable $e) {
      return $object;
    }
    if (!is_string($crudo) || trim($crudo) === '')
      return $object;
    $doc = new \DOMDocument();
    $previo = libxml_use_internal_errors(true);
    $leido = $doc->loadXML($crudo, LIBXML_NONET); // contenido del SIFEN: sin acceso a la red por DTD o entidades (0.3.0)
    libxml_clear_errors();
    libxml_use_internal_errors($previo);
    if (!$leido)
      return $object;
    $generico = $doc->getElementsByTagNameNS('*', 'rRetEnviDe')->item(0);
    return $generico instanceof \DOMElement ? self::NodoComoObjeto($generico) : $object;
  }

  /**
   * Decodifica un elemento como lo hace SoapClient: cada hijo es una propiedad (si se repite, un arreglo) y las hojas
   * son texto.
   */
  private static function NodoComoObjeto(\DOMElement $nodo): \stdClass|String
  {
    $res = new \stdClass();
    $conHijos = false;
    foreach ($nodo->childNodes as $hijo) {
      if (!$hijo instanceof \DOMElement)
        continue;
      $conHijos = true;
      $nombre = $hijo->localName;
      $valor = self::NodoComoObjeto($hijo);
      if (!property_exists($res, $nombre)) {
        $res->{$nombre} = $valor;
      } else {
        if (!is_array($res->{$nombre}))
          $res->{$nombre} = [$res->{$nombre}];
        $res->{$nombre}[] = $valor;
      }
    }
    return $conHijos ? $res : $nodo->textContent;
  }

  private static function RegistrarEventoUnico(GGroupTiEvt $gGroupTiEvt, ?DateTime $fechaFirma = null): RRetEnviEventoDe
  {
    $rEve = new REve();
    $rEve->setId(1);
    // dFecFirma: el SIFEN la compara con la hora de Asunción; con el servidor en otra zona horaria la fecha quedaba corrida.
    $rEve->setDFecFirma($fechaFirma ?? new DateTime('now', new DateTimeZone(Constants::SIFEN_TIMEZONE)));
    $rEve->setDVerFor(intval(Constants::SIFEN_VERSION));
    $rEve->setGGroupTiEvt($gGroupTiEvt);

    $rGesEve = new RGesEve();
    $rGesEve->setREve($rEve);

    $evento = new GGroupGesEve();
    $evento->setRGesEve([$rGesEve]);

    return self::RegistrarEvento($evento);
  }


  /**

   * Devuelve la URL base del WS del SIFEN según el entorno.
   *
   * @return String
   */
  private static function GetSifenUrlBase(): String
  {
    if (strtolower(self::$config->env) == "prod") {
      return Constants::SIFEN_URL_BASE_PROD;
    } else {
      return Constants::SIFEN_URL_BASE_DEV;
    }
  }

  /**
   * Valida la regla de la NT-024 (validación SIFEN 1321, vigente desde el 01/01/2025):
   * el tipo de documento de identidad del receptor no puede ser Innominado (D208 = 5) cuando el total
   * general de la operación en guaraníes es mayor o igual a 7.000.000 (F014 cuando la moneda de la
   * operación es PYG, F023 cuando es extranjera). Se exceptúan las operaciones de Muestras médicas (D011 = 13).
   *
   * @param DE $de Documento electrónico a validar.
   *
   * @return void
   *
   * @throws CampoInvalidoException Si el DE incumple la regla de la NT-024 (campo D208, código 1321).
   */
  private static function ValidarUmbralInnominadoNT024(DE $de): void
  {
    if (!isset($de->gDatGralOpe) || !isset($de->gDatGralOpe->gDatRec) || !isset($de->gTotSub))
      return;
    if ($de->gDatGralOpe->gDatRec->getITipIDRec() !== TipIDRec::Innominado->value)
      return;

    // Las operaciones de muestras médicas están exceptuadas de la regla
    if (isset($de->gDatGralOpe->gOpeCom) && isset($de->gDatGralOpe->gOpeCom->iTipTra)
      && $de->gDatGralOpe->gOpeCom->iTipTra == OpeComTipTrans::MuestrasMedicas->value)
      return;

    // Determina el total general de la operación expresado en guaraníes
    $esPYG = !isset($de->gDatGralOpe->gOpeCom) || strcmp($de->gDatGralOpe->gOpeCom->getCMoneOpe(), 'PYG') == 0;
    $totalGs = null;
    if ($esPYG && isset($de->gTotSub->dTotGralOpe))
      $totalGs = $de->gTotSub->dTotGralOpe;
    else if (!$esPYG && isset($de->gTotSub->dTotalGs))
      $totalGs = $de->gTotSub->dTotalGs;
    if (is_null($totalGs))
      return;

    if (bccomp($totalGs, Constants::UMBRAL_INNOMINADO_PYG, 8) >= 0)
      throw CampoInvalidoException::deCampo("[Sifen] NT-024: el receptor no puede ser innominado cuando el total general de la operación es mayor o igual a " . Constants::UMBRAL_INNOMINADO_PYG . " guaraníes (total de la operación: " . $totalGs . "). Identifique al receptor con su documento de identidad.",
        'D208', 'iTipIDRec', TipIDRec::Innominado->value, 'NT-024 (validación 1321): D208 distinto de 5 cuando el total en guaraníes es mayor o igual a ' . Constants::UMBRAL_INNOMINADO_PYG, '1321');
  }

  /**
   * Devuelve el siguiente valor correlativo de dId y lo persiste en el archivo configurado.
   * Utiliza un bloqueo exclusivo del archivo para evitar valores duplicados ante accesos concurrentes.
   *
   * @return int
   */
  private static function GetDId(): int
  {
    $fp = fopen(self::$config->dIdFilePath, 'c+');
    if ($fp === false)
      throw new ConfiguracionException("[Sifen] No se pudo abrir el archivo del dId: " . self::$config->dIdFilePath);
    try {
      flock($fp, LOCK_EX);
      $dId = 1;
      $json = stream_get_contents($fp);
      if ($json !== false && strlen(trim($json)) > 0) {
        $data = json_decode($json);
        if (isset($data->dId)) {
          $dId = $data->dId >= Constants::MAX_DID ? 1 : $data->dId + 1;
        }
      }
      ftruncate($fp, 0);
      rewind($fp);
      fwrite($fp, json_encode(array('dId' => $dId)));
      fflush($fp);
      return $dId;
    } finally {
      flock($fp, LOCK_UN);
      fclose($fp);
    }
  }

  /**
   * Genera un context SSL para certificados/clave en formato PKCS#12 (P12/PFX).
   *
   * PK-39 (0.3.0): el certificado y la clave van a una carpeta propia de nombre impredecible dentro de
   * sys_get_temp_dir() (0700 donde el sistema lo respeta; en Windows la protección es el nombre y el borrado
   * garantizado), la clave se exporta cifrada con la misma passphrase, una falla intermedia no deja restos y los
   * archivos se borran en Shutdown(), en el siguiente Init() y al terminar el script. Hasta 0.2.1 iban a
   * sys_get_temp_dir() como cert_* y key_*, con la clave en claro, y solo se borraban al terminar el script.
   * 
   */
  private static function createStreamContextFromPkcs12(string $pkcs12FilePath, string $password)
  {
    $certs = Pkcs12Helper::read((string) file_get_contents($pkcs12FilePath), $password);
    $claveCifrada = '';
    if (!openssl_pkey_export($certs['pkey'], $claveCifrada, $password))
      throw CertificadoException::porMotivo(MotivoCertificado::PemInvalido, '[Sifen] No se pudo exportar la clave privada del PKCS#12: ' . (openssl_error_string() ?: 'error desconocido'));
    $carpeta = rtrim(sys_get_temp_dir(), '/\\') . DIRECTORY_SEPARATOR . 'pkuatia-' . bin2hex(random_bytes(8));
    if (!@mkdir($carpeta, 0700) && !is_dir($carpeta))
      throw new ConfiguracionException('[Sifen] No se pudo crear la carpeta temporal para el certificado: ' . $carpeta);
    self::$carpetaTemporal = $carpeta;
    self::registrarLimpieza();
    try {
      $certFile = $carpeta . DIRECTORY_SEPARATOR . 'cert.pem';
      $keyFile = $carpeta . DIRECTORY_SEPARATOR . 'key.pem';
      if (file_put_contents($certFile, $certs['cert']) === false || file_put_contents($keyFile, $claveCifrada) === false)
        throw new ConfiguracionException('[Sifen] No se pudieron escribir los archivos temporales del certificado en: ' . $carpeta);
      @chmod($keyFile, 0600);
      return stream_context_create([
        'ssl' => [
          'local_cert' => $certFile,
          'local_pk' => $keyFile,
          'passphrase' => $password,
          'verify_peer' => true,
          'verify_peer_name' => true,
        ]
      ]);
    } catch (\Throwable $e) {
      self::borrarTemporales();
      throw $e;
    }
  }

  /** Registra una sola vez el borrado de los temporales al terminar el script (también tras un error fatal). */
  private static function registrarLimpieza(): void
  {
    if (self::$limpiezaRegistrada)
      return;
    self::$limpiezaRegistrada = true;
    register_shutdown_function(static function (): void {
      self::borrarTemporales();
    });
  }

  /** Borra la carpeta temporal del PKCS#12 si existe. Idempotente y nunca lanza. */
  private static function borrarTemporales(): void
  {
    $carpeta = self::$carpetaTemporal;
    self::$carpetaTemporal = null;
    if ($carpeta === null || !is_dir($carpeta))
      return;
    foreach (['cert.pem', 'key.pem'] as $archivo)
      @unlink($carpeta . DIRECTORY_SEPARATOR . $archivo);
    @rmdir($carpeta);
  }
}
