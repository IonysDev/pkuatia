<?php

namespace IonysDev\Pkuatia\Helpers;

use IonysDev\Pkuatia\Core\Config;
use IonysDev\Pkuatia\Core\Fields\DE\A\DE;
use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\GGroupGesEve;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\RGesEve;
use DateTime;
use DateTimeZone;
use IonysDev\Pkuatia\Core\Constants;
use IonysDev\Pkuatia\Core\Constants\MotivoCertificado;
use IonysDev\Pkuatia\Core\Exceptions\CertificadoException;
use IonysDev\Pkuatia\Core\Exceptions\FirmaException;
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use DOMDocument;
use RobRichards\XMLSecLibs\XMLSecurityKey;

/**
 * Clase que contiene los métodos para firmar los documentos XML según MT Sifen.
 */
class SignHelper
{
  /**
   * @deprecated 0.3.0 Solo por compatibilidad: Init() la puebla, pero cada firma usa un firmador fresco (createSigner).
   *             Se retira en la 1.0 (Fase C, decisión Q-C4).
   */
  public static XMLSecurityDSig $xmlSigner;
  /**
   * @deprecated 0.3.0 Solo por compatibilidad: Init() la puebla con la clave y la passphrase, pero la firma usa una
   *             copia privada, así que modificarla no cambia nada y leerla expone secretos. Shutdown() la deja vacía.
   *             Se retira en la 1.0 (Fase C, decisión Q-C4).
   */
  public static XMLSecurityKey $xmlKey;
  private static ?string $x509Cert = null;    // Certificado X.509 (PEM) para construir firmadores frescos por firma.
  /** Clave privada que realmente firma (PK-39, Q-C4): independiente de la propiedad pública; Shutdown() la olvida. */
  private static ?XMLSecurityKey $clave = null;

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
      throw CertificadoException::porMotivo(MotivoCertificado::NoEncontrado, "[SignHelper] No se encontró el archivo de llave privada en la ruta especificada.");

    $format = Config::normalizeCertificateFormat($certificateFormat);
    $usesCombinedPem = $format === Config::CERT_FORMAT_PEM
      && PemHelper::usesCombinedFile($certFilePath, $keyFilePath);

    if (!$usesCombinedPem && !is_null($certFilePath) && !file_exists($certFilePath))
      throw CertificadoException::porMotivo(MotivoCertificado::NoEncontrado, "[SignHelper] No se encontró el archivo de certificado en la ruta especificada.");

    $clave = new XMLSecurityKey(XMLSecurityKey::RSA_SHA256, ['type' => 'private']);
    $clave->passphrase = $passphrase;

    // Un archivo que existe pero no se puede leer (permisos, una carpeta) termina en excepción, no en un firmador con
    // certificado vacío que el SIFEN rechazaría con 0120 (QA de la Fase C).
    $leer = static function (string $ruta): string {
      // En Linux leer una carpeta devuelve '' (no false, como en Windows); un archivo vacío tampoco sirve.
      $contenido = is_dir($ruta) ? false : @file_get_contents($ruta);
      if ($contenido === false || $contenido === '')
        throw CertificadoException::porMotivo(MotivoCertificado::PemInvalido, "[SignHelper] No se pudo leer el archivo del certificado o de la clave (vacío, carpeta o sin permisos): $ruta");
      return $contenido;
    };
    if ($format === Config::CERT_FORMAT_PEM) {
      if ($usesCombinedPem) {
        $x509Cert = PemHelper::extractCertificatePem($leer($keyFilePath));
      }
      else {
        $x509Cert = $leer((string) $certFilePath);
      }
      $clave->loadKey($keyFilePath, true);
    }
    else if ($format === Config::CERT_FORMAT_PKCS12) {
      $keys = $leer($keyFilePath);
      $componentes = Pkcs12Helper::read($keys, $passphrase);
      $x509Cert = $componentes['cert'];
      $clave->loadKey($componentes['pkey'], false);
    }
    else {
      throw CertificadoException::porMotivo(MotivoCertificado::NoSoportado, "[SignHelper] Formato de certificado no soportado.");
    }

    // La firma usa la copia privada (PK-39, Q-C4). La propiedad pública obsoleta se puebla con un clon por
    // compatibilidad hacia atrás, y cada firma usa un firmador fresco (ver createSigner) para evitar el sobrefirmado.
    self::$x509Cert = $x509Cert;
    self::$clave = $clave;
    self::$xmlKey = clone $clave;
    self::$xmlSigner = self::createSigner();
  }

  /**
   * Olvida la clave privada y el certificado que cargó Init(): la copia privada se descarta y la propiedad pública
   * obsoleta queda con una clave vacía, así que una firma posterior lanza FirmaException hasta el próximo Init().
   * La invoca Sifen::Shutdown(). Nuevo en 0.3.0 (Fase C, C12, decisión Q-C4).
   */
  public static function Shutdown(): void
  {
    self::$clave = null;
    self::$x509Cert = null;
    self::$xmlKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA256, ['type' => 'private']);
    self::$xmlSigner = new XMLSecurityDSig('');
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
    $signer->add509Cert((string) self::$x509Cert);
    return $signer;
  }

  /**
   * Firma un documento DE contenido en un objeto RDE
   * 
   * @param RDE $rde Contenedor RDE del documento DE.
   * 
   * @return DOMDocument  Documento XML firmado.
   */
  public static function SignRDE(RDE $rde, DateTime $fechaFirma = new DateTime('now', new DateTimeZone(Constants::SIFEN_TIMEZONE))): DOMDocument
  {
    if (self::$clave === null || self::$x509Cert === null)
      throw new FirmaException("[SignHelper] No se ha inicializado el firmador de XML.");

    $rde->DE->setDFecFirma($fechaFirma);

    $xmlDocument = new DOMDocument('1.0', 'UTF-8');
    $xmlDocument->formatOutput = false;
    $xmlDocument->preserveWhiteSpace = false;
    $xmlDocument->loadXML($rde->toXMLString());
    // Un rDE leído de un XML ya firmado reemite su Signature y su gCamFuFD (PK-32, 0.2.1): se quitan para firmar
    // de nuevo; FirmarDE() agrega después el gCamFuFD con el QR nuevo. En un rDE armado a mano no hay nada que quitar.
    $rdeLeido = $xmlDocument->getElementsByTagName("rDE")->item(0);
    foreach (iterator_to_array($rdeLeido->childNodes) as $hijo) {
      if ($hijo instanceof \DOMElement && in_array($hijo->localName, ['Signature', 'gCamFuFD'], true))
        $rdeLeido->removeChild($hijo);
    }
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
    $signer->sign(self::$clave, $xmlDocument->documentElement);
    $signer->appendSignature($rdeNode);
    return $xmlDocument;
  }

  public static function SingEvents(GGroupGesEve $raiz, $config)
  {
    if (self::$clave === null || self::$x509Cert === null)
      throw new FirmaException("[SignHelper] No se ha inicializado el firmador de XML.");

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
      $signer->sign(self::$clave, $xmlDocument->documentElement);
      $signer->appendSignature($eventNode);
    }

    return $xmlDocument;
  }
}
