<?php

namespace Abiliomp\Pkuatia;

use Abiliomp\Pkuatia\Core\Config;
use Abiliomp\Pkuatia\Core\Constants;
use Abiliomp\Pkuatia\Core\Requests\REnviConsRUC;
use Abiliomp\Pkuatia\Core\Requests\REnviConsDe;
use Abiliomp\Pkuatia\Core\Responses\RResEnviConsRUC;
use Abiliomp\Pkuatia\Core\DocumentosElectronicos\DocumentoElectronico;
use Abiliomp\Pkuatia\Core\Fields\DE\A\DE;
use Abiliomp\Pkuatia\Core\Fields\DE\AA\RDE;
use Abiliomp\Pkuatia\Core\Fields\DE\I\Signature;
use Abiliomp\Pkuatia\Core\Fields\DE\J\GCamFuFD;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GDE\GGroupGesEve;
use Abiliomp\Pkuatia\Core\Requests\REnviConsLoteDe;
use Abiliomp\Pkuatia\Core\Requests\REnviDe;
use Abiliomp\Pkuatia\Core\Requests\REnviEventoDe;
use Abiliomp\Pkuatia\Core\Requests\REnvioLote;
use Abiliomp\Pkuatia\Core\Responses\RResEnviConsDe;
use Abiliomp\Pkuatia\Core\Responses\RResEnviConsLoteDe;
use Abiliomp\Pkuatia\Core\Responses\RResEnviLoteDe;
use Abiliomp\Pkuatia\Core\Responses\RRetEnviDe;
use Abiliomp\Pkuatia\Helpers\QRHelper;
use Abiliomp\Pkuatia\Helpers\SignHelper;
use SimpleXMLElement;
use SoapClient;
use SoapVar;
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
   * Realiza el envío de un Documento Electrónico al SIFEN.
   * 
   * @param DocumentoElectronico $de Documento Electrónico a enviar.
   * 
   * @return RRetEnviDe
   */
  public static function EnviarDE(RDE $rde): RRetEnviDe
  {
    // Firma el documento electrónico
    $xmlDocument = SignHelper::SignRDE($rde);
    // Extrae la firma del documento electrónico
    $signatureNode = $xmlDocument->getElementsByTagName("Signature")->item(0);
    $Signature = Signature::FromDOMElement($signatureNode);

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
    $signedXML = $xmlDocument->saveXML($xmlDocument->getElementsByTagName("rDE")->item(0));

    // Realiza el envío del documento electrónico al SIFEN
    self::$client = new SoapClient(self::GetSifenUrlBase() . Constants::SIFEN_PATH_RECIBE . "?wsdl", self::$options);
    $rEnviDe = new REnviDe(self::GetDId(), new SoapVar(
      '<ns1:xDE>' . $signedXML . '</ns1:xDE>',
      XSD_ANYXML
    ));
    $object = self::$client->rEnviDe($rEnviDe);
    return RRetEnviDe::FromSifenResponseObject($object);
  }

  /**
   * Realiza el envío de un lote de Documentos Electrónicos al SIFEN.
   * De acuerdo a la versión 150 del MT, este WS soporta hasta 50 documentos electrónicos por lote.
   * 
   * @param array $lote Lote de Documentos Electrónicos a enviar.
   * 
   * @return RResEnviLoteDe
   */
  public static function EnviarLoteDE(array $lote): RResEnviLoteDe
  {

    //Cabecera del rLoteDE
    $rLotDe = '<rLoteDE>';

    foreach ($lote as $key => $value) {
      SignHelper::Init(self::$config->privateKeyFilePath, self::$config->privateKeyPassphrase, self::$config->certificateFilePath);
      // Firma el documento electrónico
      $xmlDocument = SignHelper::SignRDE($value);
      // Extrae la firma del documento electrónico
      $signatureNode = $xmlDocument->getElementsByTagName("Signature")->item(0);
      $signature = Signature::FromDOMElement($signatureNode);

      // Verifica si en los campos fuera de la firma hay datos
      $gCamFuFD = $value->getGCamFuFD();
      if (is_null($gCamFuFD)) {
        $gCamFuFD = new GCamFuFD();
      } else {
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
      $gCamFuFD->setDCarQR(QRHelper::GenerateQRContent(self::$config, $value->getDE(), $signature));
      $gCamFuFDNode = $gCamFuFD->toDOMElement($xmlDocument);

      // Agrega el nodo del QR al documento electrónico
      $xmlDocument->getElementsByTagName("rDE")->item(0)->appendChild($gCamFuFDNode);

      $signedXML = $xmlDocument->saveXML($xmlDocument->getElementsByTagName("rDE")->item(0));

      //concatenar los documentos electrónicos
      $rLotDe .= $signedXML;
    }

    //cerrar etiqueta rLoteDE
    $rLotDe .= '</rLoteDE>';

    ///CREATE ZIP FILE
    $zip = new ZipArchive();
    $zip->open("rLoteDE.zip", ZipArchive::CREATE);

    ///ADD rLoteDe.xml to ZIP FILE
    $zip->addFromString("rLoteDE.xml", $rLotDe);

    ///CLOSE ZIP FILE
    $zip->close();

    ///GET ZIP FILE CONTENT
    $zipcontent = file_get_contents("rLoteDE.zip");

    //delete zip file
    unlink("rLoteDE.zip");

    //send zip file to Sifen
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
  public static function consultaLote($nroLote): RResEnviConsLoteDe
  {
    self::$client = new SoapClient(self::GetSifenUrlBase() . Constants::SIFEN_PATH_CONSULTA_LOTE . "?wsdl", self::$options);
    $rEnviConsLoteDe = new REnviConsLoteDe(self::GetDId(), $nroLote);
    $object = self::$client->rEnviConsLoteDe($rEnviConsLoteDe);
    return RResEnviConsLoteDe::FromSifenResponseObject($object);
  }

  public static function RegistrarEvento(GGroupGesEve $raiz, $config)
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

    $object = self::$client->rEnviEventoDe($rEnviEventoDe);
    file_put_contents('request.xml', self::$client->__getLastRequest());
    file_put_contents('response.xml', self::$client->__getLastResponse());
  }

  /**
   * Maneja los entornos de desarrollo y producción.
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
   * Maneja el incremento del dId.
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
