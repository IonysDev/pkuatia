<?php

namespace IonysDev\Pkuatia;

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
    if (!file_exists($config->certificateFilePath))
      throw new \Exception("[Sifen] El archivo de certificado no ha sido encontrado en: " . $config->certificateFilePath . ".");
    if (!file_exists($config->privateKeyFilePath))
      throw new \Exception("[Sifen] El archivo de clave privada no ha sido encontrado en: " . $config->privateKeyFilePath . ".");
    self::$config = $config;
    self::$options = [
      'soap_version' => SOAP_1_2,
      'trace' => true,
      'exceptions' => true,
      'cache_wsdl' => WSDL_CACHE_NONE,
      'stream_context' => stream_context_create([
        'ssl' => [
          'local_cert' => $config->certificateFilePath,
          'local_pk' => $config->privateKeyFilePath,
          'passphrase' => $config->privateKeyPassphrase,
          'verify_peer' => true,
          'verify_peer_name' => true,
        ]
      ])
    ];
    SignHelper::Init($config->privateKeyFilePath, $config->privateKeyPassphrase, $config->certificateFilePath);
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
  public static function FirmarDE(RDE $rde): String
  {
    // Firma el documento electrónico
    $xmlDocument = SignHelper::SignRDE($rde);

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
    self::$client = new SoapClient(self::GetSifenUrlBase() . Constants::SIFEN_PATH_RECIBE . "?wsdl", self::$options);
    $rEnviDe = new REnviDe(self::GetDId(), new SoapVar(
      '<ns1:xDE>' . $rdeXML . '</ns1:xDE>',
      XSD_ANYXML
    ));
    $object = self::$client->rEnviDe($rEnviDe);
    return RRetEnviDe::FromSifenResponseObject($object);
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
    if(!is_array($lote))
      throw new \Exception("[Sifen] El parámetro lote debe ser un array de documentos electrónicos.");
    if(count($lote) > 50)
      throw new \Exception("[Sifen] El lote no puede contener más de 50 documentos electrónicos.");
    
    // Cabecera del rLoteDE
    $rLotDe = '<rLoteDE>';

    foreach ($lote as $rde) {
      if(!is_string($rde))
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
    self::$client = new SoapClient(self::GetSifenUrlBase() . Constants::SIFEN_PATH_RECIBE_LOTE . "?wsdl", self::$options);
    $rEnvioLote = new REnvioLote(self::GetDId(), $zipcontent);
    $object = self::$client->rEnvioLote($rEnvioLote);
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
    self::$client = new SoapClient(self::GetSifenUrlBase() . Constants::SIFEN_PATH_CONSULTA_LOTE . "?wsdl", self::$options);
    $rEnviConsLoteDe = new REnviConsLoteDe(self::GetDId(), $nroLote);
    $object = self::$client->rEnviConsLoteDe($rEnviConsLoteDe);
    return RResEnviConsLoteDe::FromSifenResponseObject($object);
  }
  
  /**
   * RegistrarEvento
   *
   * @param  mixed $raiz
   * @param  mixed $config
   * @return RRetEnviEventoDe
   */
  public static function RegistrarEvento(GGroupGesEve $raiz, $config):RRetEnviEventoDe
  {
    // Firma el documento electrónico
    $xmlDocument = SignHelper::SingEvents($raiz, $config);
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
}
