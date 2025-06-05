<?php

namespace IonysDev\Pkuatia;

use DateTime;
use Exception;
use IonysDev\Pkuatia\Core\Config;
use IonysDev\Pkuatia\Core\Constants;
use IonysDev\Pkuatia\Core\Requests\REnviConsRUC;
use IonysDev\Pkuatia\Core\Requests\REnviConsDe;
use IonysDev\Pkuatia\Core\Responses\RResEnviConsRUC;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\DocumentoElectronico;
use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;
use IonysDev\Pkuatia\Core\Fields\DE\I\Signature;
use IonysDev\Pkuatia\Core\Fields\DE\J\GCamFuFD;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\GGroupGesEve;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\GGroupTiEvt;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\REve;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\RGesEve;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\RGeVeCan;
use IonysDev\Pkuatia\Core\Requests\REnviConsLoteDe;
use IonysDev\Pkuatia\Core\Requests\REnviDe;
use IonysDev\Pkuatia\Core\Requests\REnviEventoDe;
use IonysDev\Pkuatia\Core\Requests\REnvioLote;
use IonysDev\Pkuatia\Core\Responses\RResEnviConsDe;
use IonysDev\Pkuatia\Core\Responses\RResEnviConsLoteDe;
use IonysDev\Pkuatia\Core\Responses\RResEnviLoteDe;
use IonysDev\Pkuatia\Core\Responses\RRetEnviDe;
use IonysDev\Pkuatia\Core\Responses\RRetEnviEventoDe;
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
    if ($config->certificateFilePath && !file_exists($config->certificateFilePath))
      throw new \Exception("[Sifen] El archivo de certificado no ha sido encontrado en: " . $config->certificateFilePath . ".");
    if (!file_exists($config->privateKeyFilePath))
      throw new \Exception("[Sifen] El archivo de clave privada no ha sido encontrado en: " . $config->privateKeyFilePath . ".");
    self::$config = $config;

    $sslContext = null;
    if(strcmp($config->certificateFormat, "pem") == 0){
      $sslContext = stream_context_create([
        'ssl' => [
          'local_cert' => $config->certificateFilePath,
          'local_pk' => $config->privateKeyFilePath,
          'passphrase' => $config->privateKeyPassphrase,
          'verify_peer' => true,
          'verify_peer_name' => true,
        ]
        ]);
    }
    else if(strcmp($config->certificateFormat, "p12") == 0){
      $sslContext = self::createStreamContextFromP12($config->privateKeyFilePath, $config->privateKeyPassphrase);
    }

    self::$options = [
      'soap_version' => SOAP_1_2,
      'trace' => true,
      'exceptions' => true,
      'cache_wsdl' => WSDL_CACHE_NONE,
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
   * De acuerdo a la versión 150 del MT, este WS soporta hasta 50 documentos electrónicos por lote.
   * 
   * @param array $lote Lote de DEs (contenidos en sus RDE respectivos) firmados en formato de cadena XML
   * 
   * @return RResEnviLoteDe
   */
  public static function EnviarLoteDE(array $lote): RResEnviLoteDe
  {
    if (!is_array($lote))
      throw new \Exception("[Sifen] El parámetro lote debe ser un array de documentos electrónicos.");
    if (count($lote) > 50)
      throw new \Exception("[Sifen] El lote no puede contener más de 50 documentos electrónicos.");

    // Cabecera del rLoteDE
    $rLotDe = '<rLoteDE>';

    foreach ($lote as $rde) {
      if (!is_string($rde))
        throw new \Exception("[Sifen] El lote debe contener documentos electrónicos en formato de cadena XML.");
      // Concatenar los documentos electrónicos
      $rLotDe .= $rde;
    }

    //Cerrar etiqueta rLoteDE
    $rLotDe .= '</rLoteDE>';

    // Crea el comprimido ZIP que contendrá el lote de documentos electrónicos
    $zip = new ZipArchive();
    $zip->open("rLoteDE.zip", ZipArchive::CREATE);

    // Agrega el lote de documentos electrónicos al comprimido
    $zip->addFromString("rLoteDE.xml", $rLotDe);

    // Cierra el comprimido
    $zip->close();

    // Lee el contenido del comprimido
    $zipcontent = file_get_contents("rLoteDE.zip");

    // Elimina el comprimido
    unlink("rLoteDE.zip");

    // Realiza el envío del lote de documentos electrónicos al SIFEN
    try {
      self::$client = new SoapClient(self::GetSifenUrlBase() . Constants::SIFEN_PATH_RECIBE_LOTE . "?wsdl", self::$options);
      $rEnvioLote = new REnvioLote(self::GetDId(), $zipcontent);
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
   * RegistrarEvento
   *
   * @param  mixed $raiz
   * @param  mixed $config
   * @return RRetEnviEventoDe
   */
  public static function RegistrarEvento(GGroupGesEve $raiz): RRetEnviEventoDe
  {
    // Firma el documento electrónico
    try {
      $xmlDocument = SignHelper::SingEvents($raiz, self::$config);
      $signedXML = $xmlDocument->saveXML($xmlDocument->getElementsByTagName("gGroupGesEve")->item(0));

      // Realiza el envío del documento electrónico al SIFEN
      self::$client = new SoapClient(self::GetSifenUrlBase() . Constants::SIFEN_PATH_EVENTO . "?wsdl", self::$options);
      $rEnviEventoDe = new REnviEventoDe(self::GetDId(), new SoapVar(
        '<ns1:dEvReg>' . $signedXML . '</ns1:dEvReg>',
        XSD_ANYXML
      ));
      file_put_contents('rEnviEventoDe.xml', $signedXML);
      $object = self::$client->rEnviEventoDe($rEnviEventoDe);
      return RRetEnviEventoDe::FromSifenResponseObject($object);
    } catch (\Exception $e) {
      throw new \Exception("[Sifen] Error al registrar el evento: " . $e->getMessage());
    }
  }

  public static function CancelarDE(String $cdc, String $motivo): RRetEnviEventoDe
  {
    $evento = new GGroupGesEve();
    // creamos un array para la raiz de gestion de eventos
    $rGesEve = [];
    // creamos una raiz de gestion de eventos
    $trGesEve = new RGesEve();
    // creamos el grupo de campos generales del evento
    $rEve = new REve();
    $rEve->setId(1);
    $rEve->setDFecFirma(new DateTime());
    $rEve->setDVerFor(150);
    // se crea el grupo de campos del tipo de evento
    $gGroupTiEvt = new GGroupTiEvt();

    ///////////////////////////////////////////////////////////////
    ///EVENTO DE CANCELACION
    ///////////////////////////////////////////////////////////////

    // creamos una raiz de evento de cancelacion
    $rGeVeCan = new RGeVeCan();
    $rGeVeCan->setId($cdc); ///poner un cdc
    $rGeVeCan->setMOtEve($motivo);
    $gGroupTiEvt->setRGeVeCan($rGeVeCan);
    // se asigna el grupo de campos  de tipo evento al grupo de campos generales del evento
    $rEve->setGGroupTiEvt($gGroupTiEvt);
    // se asigna el grupo de campos generales del evento a la raiz de gestion de eventos
    $trGesEve->setREve($rEve);
    // $trGesEve2->setREve($rEve2);
    ////se asigna la raiz de gestion de eventos al array de raices de gestion de eventos
    $rGesEve[] = $trGesEve;
    // $rGesEve[] = $trGesEve2;
    // se asigna el array al grupo de eventos
    $evento->setRGesEve($rGesEve);

    $res = Sifen::RegistrarEvento($evento);
    return $res;
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
   * Devuelve los valores del dID generados por la librería.
   *
   * @return int
   */
  private static function GetDId(): int
  {
    $dId = 1;
    if (file_exists(self::$config->dIdFilePath)) {
      $json = file_get_contents(self::$config->dIdFilePath);
      $data = json_decode($json);
      $dId = $data->dId;
      if ($dId == Constants::MAX_DID)
        $dId = 1;
      else
        $dId++;
    }
    $data = array(
      'dId' => $dId
    );
    $json = json_encode($data);
    file_put_contents(self::$config->dIdFilePath, $json);
    return $dId;
  }

  /**
   * Genera un context SSL para certificados/clave en formato PKCS12 (P12)
   * 
   */
  private static function createStreamContextFromP12($p12FilePath, $password)
  {
    // Read PKCS12 file
    $p12Content = file_get_contents($p12FilePath);
    $certs = [];

    // Extract certificate and private key from P12
    if (!openssl_pkcs12_read($p12Content, $certs, $password)) {
      throw new \Exception("Error reading P12 file: " . openssl_error_string());
    }

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
