<?php

namespace IonysDev\Pkuatia\Helpers;

use IonysDev\Pkuatia\Core\Config;
use IonysDev\Pkuatia\Core\Fields\DE\A\DE;
use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\GGroupGesEve;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\RGesEve;
use DateTime;
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use DOMDocument;
use RobRichards\XMLSecLibs\XMLSecurityKey;

/**
 * Clase que contiene los métodos para firmar los documentos XML según MT Sifen.
 */
class SignHelper
{
  public static XMLSecurityDSig $xmlSigner; // Se mantiene por compatibilidad; las firmas usan instancias frescas.
  public static XMLSecurityKey $xmlKey;
  private static string $x509Cert;          // Certificado X.509 (PEM) para construir firmadores frescos por firma.

  /**
   * Inicializa el firmador de XML.
   * 
   * @param String $keyFilePath Ruta del archivo de llave privada. 
   * @param String $passphrase Contraseña de la llave privada.
   * 
   * @return void
   */
  public static function Init(String $keyFilePath, String $passphrase, String $certificateFormat, ?String $certFilePath = null)
  {
    if (!file_exists($keyFilePath))
      throw new \Exception("[SignHelper] No se encontró el archivo de llave privada en la ruta especificada.");

    $format = Config::normalizeCertificateFormat($certificateFormat);
    $usesCombinedPem = $format === Config::CERT_FORMAT_PEM
      && PemHelper::usesCombinedFile($certFilePath, $keyFilePath);

    if (!$usesCombinedPem && !is_null($certFilePath) && !file_exists($certFilePath))
      throw new \Exception("[SignHelper] No se encontró el archivo de certificado en la ruta especificada.");

    self::$xmlKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA256, ['type' => 'private']);
    self::$xmlKey->passphrase = $passphrase;
    if ($format === Config::CERT_FORMAT_PEM) {
      if ($usesCombinedPem) {
        self::$x509Cert = PemHelper::extractCertificatePem(file_get_contents($keyFilePath));
      }
      else {
        self::$x509Cert = file_get_contents($certFilePath);
      }
      self::$xmlKey->loadKey($keyFilePath, true);
    }
    else if ($format === Config::CERT_FORMAT_PKCS12) {
      $keys = file_get_contents($keyFilePath);
      $clave = Pkcs12Helper::read($keys, $passphrase);
      $privateKey  = $clave['pkey'];
      self::$x509Cert = $clave['cert'];
      self::$xmlKey->passphrase = $passphrase;
      self::$xmlKey->loadKey($privateKey, false);
    }
    else {
      throw new \Exception("[SignHelper] Formato de certificado no soportado.");
    }

    // Se mantiene una instancia en la propiedad pública por compatibilidad hacia atrás,
    // pero cada firma usa un firmador fresco (ver createSigner) para evitar el sobrefirmado.
    self::$xmlSigner = self::createSigner();
  }

  /**
   * Crea un firmador XMLSecurityDSig nuevo y configurado (canonicalización exclusiva + certificado).
   *
   * Es obligatorio usar una instancia nueva por cada firma: XMLSecurityDSig acumula las referencias
   * y el estado de firma, por lo que reutilizar el mismo objeto para firmar varios documentos en el
   * mismo proceso (p. ej. un lote de DE o varios eventos) corrompe la firma del segundo en adelante.
   *
   * @return XMLSecurityDSig
   */
  private static function createSigner(): XMLSecurityDSig
  {
    $signer = new XMLSecurityDSig('');
    $signer->setCanonicalMethod(XMLSecurityDSig::EXC_C14N);
    $signer->add509Cert(self::$x509Cert);
    return $signer;
  }

  /**
   * Firma un documento DE contenido en un objeto RDE
   * 
   * @param RDE $rde Contenedor RDE del documento DE.
   * 
   * @return DOMDocument  Documento XML firmado.
   */
  public static function SignRDE(RDE $rde, DateTime $fechaFirma = new DateTime('now')): DOMDocument
  {
    if (!isset(self::$x509Cert))
      throw new \Exception("[SignHelper] No se ha inicializado el firmador de XML.");

    $rde->DE->setDFecFirma($fechaFirma);

    $xmlDocument = new DOMDocument('1.0', 'UTF-8');
    $xmlDocument->formatOutput = false;
    $xmlDocument->preserveWhiteSpace = false;
    $xmlDocument->loadXML($rde->toXMLString());
    $deNode = $xmlDocument->getElementsByTagName("DE")->item(0);

    $rdeNode = $xmlDocument->getElementsByTagName("rDE")->item(0);
    // Firmador fresco por documento para evitar el sobrefirmado al firmar varios DE en un mismo proceso.
    $signer = self::createSigner();
    $signer->addReference(
      $deNode,
      XMLSecurityDSig::SHA256,
      ['http://www.w3.org/2000/09/xmldsig#enveloped-signature', 'http://www.w3.org/2001/10/xml-exc-c14n#'],
      ['id_name' => 'Id', 'overwrite' => false],
    );
    $signer->sign(self::$xmlKey, $xmlDocument->documentElement);
    $signer->appendSignature($rdeNode);
    return $xmlDocument;
  }

  public static function SingEvents(GGroupGesEve $raiz, $config)
  {
    if (!isset(self::$x509Cert))
      throw new \Exception("[SignHelper] No se ha inicializado el firmador de XML.");

    $xmlDocument = new DOMDocument('1.0', 'UTF-8');
    $xmlDocument->formatOutput = false;
    $xmlDocument->preserveWhiteSpace = false;
    $xmlDocument->loadXML($raiz->toXMLString());

    // Cada evento (rGesEve) se firma con un firmador fresco: reutilizar el mismo objeto
    // corrompería la firma del segundo evento en adelante (sobrefirmado).
    $eventNodes = $xmlDocument->getElementsByTagName("rGesEve");
    foreach ($eventNodes as $eventNode) {
      $rEve = $eventNode->getElementsByTagName("rEve")->item(0);
      $signer = self::createSigner();
      $signer->addReference(
        $rEve,
        XMLSecurityDSig::SHA256,
        ['http://www.w3.org/2000/09/xmldsig#enveloped-signature', 'http://www.w3.org/2001/10/xml-exc-c14n#'],
        ['id_name' => 'Id', 'overwrite' => false],
      );
      $signer->sign(self::$xmlKey, $xmlDocument->documentElement);
      $signer->appendSignature($eventNode);
    }

    return $xmlDocument;
  }
}
