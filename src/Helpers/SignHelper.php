<?php

namespace Abiliomp\Pkuatia\Helpers;

use Abiliomp\Pkuatia\Core\Fields\DE\A\DE;
use Selective\XmlDSig\PrivateKeyStore;
use Selective\XmlDSig\Algorithm;
use Selective\XmlDSig\CryptoSigner;
use Selective\XmlDSig\XmlSigner;
use DOMDocument;

/**
 * Clase que contiene los métodos para firmar los documentos XML según MT Sifen.
 */
class SignHelper
{
    public static PrivateKeyStore $privateKeyStore;
    public static Algorithm $algorithm;
    public static CryptoSigner $cryptoSigner;
    public static XmlSigner $xmlSigner;

    public static function init(String $privateKey, String $password, KeyFormat $format = KeyFormat::P12, $pemCertificate = null)
    {
        self::$privateKeyStore = new PrivateKeyStore();

        if ($format === KeyFormat::P12)
            self::$privateKeyStore->loadFromPkcs12($privateKey, $password);
        else if ($format === KeyFormat::PEM)
            self::$privateKeyStore->loadFromPem($privateKey, $password);
        else
            throw new \Exception("Key format not supported.");

        if (isset($pemCertificate))
            self::$privateKeyStore->addCertificatesFromX509Pem($pemCertificate);
        self::$algorithm = new Algorithm(Algorithm::METHOD_SHA256);
        self::$cryptoSigner = new CryptoSigner(self::$privateKeyStore, self::$algorithm);
        self::$xmlSigner = new XmlSigner(self::$cryptoSigner);
    }

    public static function initFromFile(String $keyPath, String $password, String $pemCertificateFile = null)
    {
        if (!file_exists($keyPath))
            throw new \Exception("Private key file not found.");

        $fileContents = file_get_contents($keyPath);

        if ($fileContents === false)
            throw new \Exception("Private key file could not be read.");

        if (isset($pemCertificateFile)) {
            if (!file_exists($pemCertificateFile))
                throw new \Exception("Certificate file not found.");

            $pemCertificate = file_get_contents($pemCertificateFile);

            if ($pemCertificate === false)
                throw new \Exception("Certificate file could not be read.");
        } else
            $pemCertificate = null;


        // Verificar la extensión del archivo
        $extension = pathinfo($keyPath, PATHINFO_EXTENSION);

        if ($extension === "p12") {
            // Si se trata de un archivo PKCS12
            self::init($fileContents, $password, KeyFormat::P12, $pemCertificate);
        } else if ($extension === "pem") {
            // Si se trata de un archivo PEM
            self::init($fileContents, $password, KeyFormat::PEM, $pemCertificate);
        } else
            // Si no es ninguno de los dos
            throw new \Exception("File extension not supported.");
    }

    public static function Sign(String $xml, String $referenceUri = null)
    {
        if (!isset(self::$xmlSigner))
            throw new \Exception("SignHelper not initialized.");
        if (isset($referenceUri))
            self::$xmlSigner->setReferenceUri($referenceUri);
        $signedXml = self::$xmlSigner->signXml($xml);
        // Quitar KeyValue del campo KeyInfo
        $startPos = strpos($signedXml, "<KeyValue>");
        $endPos = strpos($signedXml, "</KeyValue>") + strlen("</KeyValue>");
        $signedXml = substr_replace($signedXml, "", $startPos, $endPos - $startPos);
        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = false;
        $dom->loadXML($signedXml);
        $canonicalXml = $dom->C14N(false, false, null, null);
        return $canonicalXml;
    }
}

enum KeyFormat
{
    case P12;
    case PEM;
}
