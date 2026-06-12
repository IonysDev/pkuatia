<?php

namespace IonysDev\Pkuatia;

use DateTime;
use Exception;
use IonysDev\Pkuatia\Core\Config;
use IonysDev\Pkuatia\Core\Constants;
use IonysDev\Pkuatia\Core\Constants\OpeComTipTrans;
use IonysDev\Pkuatia\Core\Constants\TimbTiDE;
use IonysDev\Pkuatia\Core\Constants\TipIDRec;
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
use SoapClient;
use SoapFault;
use SoapVar;
use Stringable;
use ZipArchive;

class Sifen
{
  private static SoapClient $client;
  private static Config $config;
  private static $options;

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
      throw new \Exception("[Sifen] El archivo de clave privada no ha sido encontrado en: " . $config->privateKeyFilePath . ".");
    $config->certificateFormat = Config::normalizeCertificateFormat($config->certificateFormat);
    self::$config = $config;

    if ($config->isPem() && $config->usesCombinedCertificateFile()) {
      PemHelper::validateCombinedPemFile($config->privateKeyFilePath);
    }
    else if ($config->isPem()) {
      if (!$config->certificateFilePath || !file_exists($config->certificateFilePath))
        throw new \Exception("[Sifen] El archivo de certificado no ha sido encontrado en: " . $config->certificateFilePath . ".");
    }

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
      throw new \Exception("[Sifen] Formato de certificado no soportado.");
    }

    self::$options = [
      'soap_version' => SOAP_1_2,
      'trace' => true,
      'exceptions' => true,
      // El SIFEN limita la tasa de solicitudes: la caché de WSDL evita re-descargarlo en cada
      // operación (opt-in vía Config::$wsdlCacheEnabled para no alterar el comportamiento histórico).
      'cache_wsdl' => $config->wsdlCacheEnabled ? WSDL_CACHE_DISK : WSDL_CACHE_NONE,
      'stream_context' => $sslContext,
    ];
    
    SignHelper::Init($config->privateKeyFilePath, $config->privateKeyPassphrase, $config->certificateFormat, $config->certificateFilePath);
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
    self::$client = new SoapClient(self::GetSifenUrlBase() . Constants::SIFEN_PATH_CONSULTA_RUC . "?wsdl", self::$options);
    $object = self::$client->rEnviConsRUC(new REnviConsRUC(self::GetDId(), $ruc));
    return RResEnviConsRUC::fromStdClassObject($object);
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
      self::$client = new SoapClient(self::GetSifenUrlBase() . Constants::SIFEN_PATH_CONSULTA_ARCHIVO_RUC . "?wsdl", self::$options);
      $object = self::$client->rEnviConsArchivoRUC(new REnviConsArchivoRUC(self::GetDId(), $rucFacturador));
      return RResEnviConsArchivoRUC::FromSifenResponseObject($object);
    } catch (\Exception $e) {
      throw new \Exception("[Sifen] Error al consultar el archivo de RUC en el SIFEN: " . $e->getMessage());
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
    self::$client = new SoapClient(self::GetSifenUrlBase() . Constants::SIFEN_PATH_CONSULTA . "?wsdl", self::$options);
    $object = self::$client->REnviConsDe(new REnviConsDe(self::GetDId(), $cdc));
    return RResEnviConsDe::FromSifenResponseObject($object);
  }

  /**
   * Firma un DE (contenido en un RDE) y devuelve en forma de cadena el XML firmado.
   * Además genera el link para el código QR del DE. 
   * Este XML estará listo para envío al SIFEN.
   *  
   * @param RDE $rde Contenedor del DE a firmar.
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
    $gCamFuFDNode = $gCamFuFD->toDOMElement($xmlDocument);

    if (!empty($infoAdicionalEmisor)) {
      $gCamFuFD->setDInfAdic($infoAdicionalEmisor);
    }

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
      self::$client = new SoapClient(self::GetSifenUrlBase() . Constants::SIFEN_PATH_RECIBE . "?wsdl", self::$options);
      $rEnviDe = new REnviDe(self::GetDId(), new SoapVar('<ns1:xDE>' . $rdeXML . '</ns1:xDE>', XSD_ANYXML));
      $object = self::$client->rEnviDe($rEnviDe);
      return RRetEnviDe::FromSifenResponseObject($object);
    } catch (\Exception $e) {
      throw new \Exception("[Sifen] Error al enviar el documento electrónico al SIFEN: " . $e->getMessage());
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
      throw new \Exception("[Sifen] El lote debe contener al menos un documento electrónico.");
    if (count($lote) > Constants::MAX_DOCUMENTOS_ELECTRONICOS_POR_LOTE)
      throw new \Exception("[Sifen] El lote no puede contener más de " . Constants::MAX_DOCUMENTOS_ELECTRONICOS_POR_LOTE . " documentos electrónicos.");

    // Conforma el contenedor rLoteDE validando que todos los DE sean del mismo tipo (C002),
    // ya que el SIFEN rechaza los lotes con tipos de documento mixtos.
    $tipoLote = null;
    $rLotDe = '<rLoteDE>';
    foreach ($lote as $rde) {
      if (!is_string($rde))
        throw new \Exception("[Sifen] El lote debe contener documentos electrónicos en formato de cadena XML.");
      if (preg_match('/<iTiDE>\s*(\d+)\s*<\/iTiDE>/', $rde, $matches) === 1) {
        if (is_null($tipoLote))
          $tipoLote = $matches[1];
        else if (strcmp($tipoLote, $matches[1]) != 0)
          throw new \Exception("[Sifen] Todos los documentos electrónicos del lote deben ser del mismo tipo (C002). Se encontraron documentos de tipo " . $tipoLote . " y tipo " . $matches[1] . ".");
      }
      $rLotDe .= $rde;
    }
    $rLotDe .= '</rLoteDE>';

    // Comprime el lote en un archivo ZIP temporal (evita colisiones de concurrencia
    // y problemas de permisos en el directorio de trabajo).
    $zipFilePath = tempnam(sys_get_temp_dir(), 'pkuatia_lote_');
    if ($zipFilePath === false)
      throw new \Exception("[Sifen] No se pudo crear el archivo temporal para el ZIP del lote.");
    try {
      $zip = new ZipArchive();
      if ($zip->open($zipFilePath, ZipArchive::OVERWRITE) !== true)
        throw new \Exception("[Sifen] No se pudo crear el archivo ZIP del lote en: " . $zipFilePath);
      $zip->addFromString("rLoteDE.xml", $rLotDe);
      $zip->close();
      $zipContent = file_get_contents($zipFilePath);
    } finally {
      @unlink($zipFilePath);
    }

    // Realiza el envío del lote de documentos electrónicos al SIFEN.
    // El WSDL declara xDE como base64Binary (verificado contra sifen-test en junio/2026), por lo que
    // SoapClient codifica el contenido binario a Base64 automáticamente: NO codificar manualmente
    // (hacerlo produciría doble encoding y el SIFEN no podría descomprimir el ZIP).
    try {
      self::$client = new SoapClient(self::GetSifenUrlBase() . Constants::SIFEN_PATH_RECIBE_LOTE . "?wsdl", self::$options);
      $rEnvioLote = new REnvioLote(self::GetDId(), $zipContent);
      $object = self::$client->rEnvioLote($rEnvioLote);
    } catch (\Exception $e) {
      throw new \Exception("[Sifen] Error al enviar el lote de documentos electrónicos al SIFEN: " . $e->getMessage());
    }

    return RResEnviLoteDe::FromSifenResponseObject($object);
  }

  /**
   * Realiza la consulta de un lote de Documentos Electrónicos en el SIFEN.
   *
   * @param  mixed $nroLote, nro del lote provisto por el SIFEN
   * @return RResEnviConsLoteDe
   */
  public static function ConsultaLote($nroLote): RResEnviConsLoteDe
  {
    try {
      self::$client = new SoapClient(self::GetSifenUrlBase() . Constants::SIFEN_PATH_CONSULTA_LOTE . "?wsdl", self::$options);
      $rEnviConsLoteDe = new REnviConsLoteDe(self::GetDId(), $nroLote);
      $object = self::$client->rEnviConsLoteDe($rEnviConsLoteDe);
      return RResEnviConsLoteDe::FromSifenResponseObject($object);
    } catch (\Exception $e) {
      throw new \Exception("[Sifen] Error al consultar el lote de documentos electrónicos en el SIFEN: " . $e->getMessage());
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
      throw new \Exception("[Sifen] No se pueden registrar más de " . Constants::MAX_EVENTOS_POR_TRANSMISION . " eventos por transmisión.");

    // Firma los eventos y realiza el envío al SIFEN
    try {
      $xmlDocument = SignHelper::SingEvents($raiz, self::$config);
      $signedXML = $xmlDocument->saveXML($xmlDocument->getElementsByTagName("gGroupGesEve")->item(0));

      self::$client = new SoapClient(self::GetSifenUrlBase() . Constants::SIFEN_PATH_EVENTO . "?wsdl", self::$options);
      $rEnviEventoDe = new REnviEventoDe(self::GetDId(), new SoapVar(
        '<ns1:dEvReg>' . $signedXML . '</ns1:dEvReg>',
        XSD_ANYXML
      ));
      $object = self::$client->rEnviEventoDe($rEnviEventoDe);
      return RRetEnviEventoDe::FromSifenResponseObject($object);
    } catch (\Exception $e) {
      throw new \Exception("[Sifen] Error al registrar el evento: " . $e->getMessage());
    }
  }

  /**
   * Registra un evento de cancelación de un DTE aprobado (evento del emisor).
   *
   * @param String $cdc CDC del DTE a cancelar.
   * @param String $motivo Motivo de la cancelación (5 a 500 caracteres).
   *
   * @return RRetEnviEventoDe Respuesta del SIFEN al registro del evento.
   */
  public static function CancelarDE(String $cdc, String $motivo): RRetEnviEventoDe
  {
    $rGeVeCan = new RGeVeCan();
    $rGeVeCan->setId($cdc);
    $rGeVeCan->setMOtEve($motivo);

    $gGroupTiEvt = new GGroupTiEvt();
    $gGroupTiEvt->setRGeVeCan($rGeVeCan);

    return self::RegistrarEventoUnico($gGroupTiEvt);
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
   *
   * @return RRetEnviEventoDe Respuesta del SIFEN al registro del evento.
   */
  public static function InutilizarNumeros(int $timbrado, int $nroEstablecimiento, int $nroPuntoEmision, int $nroDocumentoInicial, int $nroDocumentoFinal, TimbTiDE|int $tipoDE, String $motivo): RRetEnviEventoDe
  {

    $tipoDEId = $tipoDE instanceof TimbTiDE ? $tipoDE->value : $tipoDE;

    if($nroDocumentoFinal < $nroDocumentoInicial)
      throw new \Exception("[Sifen] El número de documento final debe ser mayor al número de documento inicial.");
    if($nroDocumentoInicial < 1)
      throw new \Exception("[Sifen] El número de documento inicial debe ser mayor a 0.");
    if($nroDocumentoFinal < 1)
      throw new \Exception("[Sifen] El número de documento final debe ser mayor a 0.");
    if($timbrado < 1)
      throw new \Exception("[Sifen] El timbrado debe ser mayor a 0.");
    if($nroEstablecimiento < 1)
      throw new \Exception("[Sifen] El número de establecimiento debe ser mayor a 0.");
    if($nroPuntoEmision < 1)
      throw new \Exception("[Sifen] El número de punto de emisión debe ser mayor a 0.");
    if($tipoDEId < 1)
      throw new \Exception("[Sifen] El tipo de documento electrónico debe ser mayor a 0.");
    if($motivo == '')
      throw new \Exception("[Sifen] El motivo de la inutilización no puede ser vacío.");
    if(strlen($motivo) < 5)
      throw new \Exception("[Sifen] El motivo de la inutilización debe tener al menos 5 caracteres.");
    if($nroDocumentoFinal - $nroDocumentoInicial > 1000)
      throw new \Exception("[Sifen] La diferencia entre el número de documento inicial y el número de documento final no puede ser mayor a 1000.");

    $rGeVeInu = new RGeVeInu();
    $rGeVeInu->setDNumTim($timbrado);
    $rGeVeInu->setDEst(str_pad($nroEstablecimiento, 3, '0', STR_PAD_LEFT));
    $rGeVeInu->setDPunExp(str_pad($nroPuntoEmision, 3, '0', STR_PAD_LEFT));
    $rGeVeInu->setDNumIn(str_pad($nroDocumentoInicial, 7, '0', STR_PAD_LEFT));
    $rGeVeInu->setDNumFin(str_pad($nroDocumentoFinal, 7, '0', STR_PAD_LEFT));
    $rGeVeInu->setITiDE($tipoDEId);
    $rGeVeInu->setMOtEve($motivo);

    $gGroupTiEvt = new GGroupTiEvt();
    $gGroupTiEvt->setRGeVeInu($rGeVeInu);

    return self::RegistrarEventoUnico($gGroupTiEvt);
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
    ?String $nroDocumentoIdentidad = null
  ): RRetEnviEventoDe
  {
    $esContribuyente = !is_null($rucReceptor);
    if (!$esContribuyente && (is_null($tipoDocumentoIdentidad) || is_null($nroDocumentoIdentidad)))
      throw new \Exception("[Sifen] Si el receptor no es contribuyente, debe informarse el tipo y número de documento de identidad.");

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

    return self::RegistrarEventoUnico($gGroupTiEvt);
  }

  /**
   * Registra el evento del receptor "Conformidad" con un DE/DTE (GCO001).
   *
   * @param String $cdc CDC del DE/DTE conformado.
   * @param int $tipoConformidad Tipo de conformidad: 1 (Conformidad total) o 2 (Conformidad parcial).
   * @param DateTime|null $fechaRecepcion Fecha estimada de recepción (obligatoria cuando la conformidad es parcial).
   *
   * @return RRetEnviEventoDe Respuesta del SIFEN al registro del evento.
   */
  public static function ConformarDE(String $cdc, int $tipoConformidad = 1, ?DateTime $fechaRecepcion = null): RRetEnviEventoDe
  {
    if ($tipoConformidad != 1 && $tipoConformidad != 2)
      throw new \Exception("[Sifen] El tipo de conformidad debe ser 1 (total) o 2 (parcial).");
    if ($tipoConformidad == 2 && is_null($fechaRecepcion))
      throw new \Exception("[Sifen] La fecha estimada de recepción es obligatoria cuando la conformidad es parcial.");

    $rGeVeConf = new RGeVeConf();
    $rGeVeConf->setId($cdc);
    $rGeVeConf->setITipConf($tipoConformidad);
    if (!is_null($fechaRecepcion))
      $rGeVeConf->setDFecRecep($fechaRecepcion);

    $gGroupTiEvt = new GGroupTiEvt();
    $gGroupTiEvt->setRGeVeConf($rGeVeConf);

    return self::RegistrarEventoUnico($gGroupTiEvt);
  }

  /**
   * Registra el evento del receptor "Disconformidad" con un DE/DTE (GDI001).
   *
   * @param String $cdc CDC del DE/DTE objetado.
   * @param String $motivo Motivo de la disconformidad (5 a 500 caracteres).
   *
   * @return RRetEnviEventoDe Respuesta del SIFEN al registro del evento.
   */
  public static function DisconformarDE(String $cdc, String $motivo): RRetEnviEventoDe
  {
    if (strlen($motivo) < 5)
      throw new \Exception("[Sifen] El motivo de la disconformidad debe tener al menos 5 caracteres.");

    $rGeVeDisconf = new RGeVeDisconf();
    $rGeVeDisconf->setId($cdc);
    $rGeVeDisconf->setMOtEve($motivo);

    $gGroupTiEvt = new GGroupTiEvt();
    $gGroupTiEvt->setRGeVeDisconf($rGeVeDisconf);

    return self::RegistrarEventoUnico($gGroupTiEvt);
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
    ?String $nroDocumentoIdentidad = null
  ): RRetEnviEventoDe
  {
    if (strlen($motivo) < 5)
      throw new \Exception("[Sifen] El motivo del desconocimiento debe tener al menos 5 caracteres.");
    $esContribuyente = !is_null($rucReceptor);
    if (!$esContribuyente && (is_null($tipoDocumentoIdentidad) || is_null($nroDocumentoIdentidad)))
      throw new \Exception("[Sifen] Si el receptor no es contribuyente, debe informarse el tipo y número de documento de identidad.");

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

    return self::RegistrarEventoUnico($gGroupTiEvt);
  }

  /**
   * Registra el evento de nominación de una factura electrónica emitida como innominada (GENFE001, NT-014).
   * El objeto RGEveNom debe conformarse previamente con los datos del receptor a nominar.
   *
   * @param RGEveNom $datosNominacion Datos del evento de nominación (CDC, motivo y datos del receptor).
   *
   * @return RRetEnviEventoDe Respuesta del SIFEN al registro del evento.
   */
  public static function NominarFE(RGEveNom $datosNominacion): RRetEnviEventoDe
  {
    $gGroupTiEvt = new GGroupTiEvt();
    $gGroupTiEvt->setRGeVeNom($datosNominacion);

    return self::RegistrarEventoUnico($gGroupTiEvt);
  }

  /**
   * Registra el evento de actualización de datos del transporte de una Nota de Remisión Electrónica (GET001).
   * El objeto RGeVeTr debe conformarse previamente con los datos del transporte a actualizar.
   *
   * @param RGeVeTr $datosTransporte Datos del evento de actualización del transporte (CDC, motivo y datos nuevos).
   *
   * @return RRetEnviEventoDe Respuesta del SIFEN al registro del evento.
   */
  public static function ActualizarDatosTransporte(RGeVeTr $datosTransporte): RRetEnviEventoDe
  {
    $gGroupTiEvt = new GGroupTiEvt();
    $gGroupTiEvt->setRGeVeTr($datosTransporte);

    return self::RegistrarEventoUnico($gGroupTiEvt);
  }

  /**
   * Conforma el sobre de un único evento (rGesEve -> rEve -> gGroupTiEvt) y lo registra en el SIFEN.
   *
   * @param GGroupTiEvt $gGroupTiEvt Grupo del tipo de evento ya conformado.
   *
   * @return RRetEnviEventoDe Respuesta del SIFEN al registro del evento.
   */
  private static function RegistrarEventoUnico(GGroupTiEvt $gGroupTiEvt): RRetEnviEventoDe
  {
    $rEve = new REve();
    $rEve->setId(1);
    $rEve->setDFecFirma(new DateTime());
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
   * @throws Exception Si el DE incumple la regla de la NT-024.
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
      throw new \Exception("[Sifen] NT-024: el receptor no puede ser innominado cuando el total general de la operación es mayor o igual a " . Constants::UMBRAL_INNOMINADO_PYG . " guaraníes (total de la operación: " . $totalGs . "). Identifique al receptor con su documento de identidad.");
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
      throw new \Exception("[Sifen] No se pudo abrir el archivo del dId: " . self::$config->dIdFilePath);
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
   * Genera un context SSL para certificados/clave en formato PKCS#12 (P12/PFX)
   * 
   */
  private static function createStreamContextFromPkcs12($pkcs12FilePath, $password)
  {
    $pkcs12Content = file_get_contents($pkcs12FilePath);
    $certs = Pkcs12Helper::read($pkcs12Content, $password);

    // Create temporary files for the certificate and private key
    $certFile = tempnam(sys_get_temp_dir(), 'cert_');
    $keyFile = tempnam(sys_get_temp_dir(), 'key_');

    // Write the extracted cert and key to temporary files
    file_put_contents($certFile, $certs['cert']);
    file_put_contents($keyFile, $certs['pkey']);

    // Create stream context
    $context = stream_context_create([
      'ssl' => [
        'local_cert' => $certFile,
        'local_pk' => $keyFile,
        'passphrase' => $password,
        'verify_peer' => true,
        'verify_peer_name' => true,
      ]
    ]);

    // Clean up temporary files
    register_shutdown_function(function () use ($certFile, $keyFile) {
      @unlink($certFile);
      @unlink($keyFile);
    });

    return $context;
  }
}
