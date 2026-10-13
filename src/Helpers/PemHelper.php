<?php

namespace IonysDev\Pkuatia\Helpers;

use IonysDev\Pkuatia\Core\Constants\MotivoCertificado;
use IonysDev\Pkuatia\Core\Exceptions\CertificadoException;

/**
 * Utilidades para archivos PEM (certificado y/o clave privada).
 */
class PemHelper
{
  /**
   * Indica si certificado y clave provienen del mismo archivo (o no se especificó certificado aparte).
   */
  public static function usesCombinedFile(?string $certificateFilePath, string $privateKeyFilePath): bool
  {
    if ($certificateFilePath === null || $certificateFilePath === '') {
      return true;
    }

    $certPath = realpath($certificateFilePath);
    $keyPath = realpath($privateKeyFilePath);

    return $certPath !== false && $keyPath !== false && $certPath === $keyPath;
  }

  /**
   * Extrae uno o más bloques de certificado X.509 de un contenido PEM.
   *
   * @throws CertificadoException Desde 0.3.0; antes \Exception, de la que hereda.
   */
  public static function extractCertificatePem(string $pemContent): string
  {
    if (!preg_match_all('/-----BEGIN CERTIFICATE-----.*?-----END CERTIFICATE-----/s', $pemContent, $matches)) {
      throw CertificadoException::porMotivo(MotivoCertificado::PemInvalido, "[PemHelper] No se encontró un certificado PEM en el archivo.");
    }

    return implode("\n", $matches[0]);
  }

  public static function pemContainsPrivateKey(string $pemContent): bool
  {
    return (bool) preg_match('/-----BEGIN (?:RSA |EC |ENCRYPTED )?PRIVATE KEY-----/s', $pemContent);
  }

  public static function pemContainsCertificate(string $pemContent): bool
  {
    return (bool) preg_match('/-----BEGIN CERTIFICATE-----/s', $pemContent);
  }

  /**
   * @throws CertificadoException Desde 0.3.0; antes \Exception, de la que hereda.
   */
  public static function validateCombinedPemFile(string $filePath): void
  {
    $pemContent = file_get_contents($filePath);
    if ($pemContent === false) {
      throw CertificadoException::porMotivo(MotivoCertificado::NoEncontrado, "[PemHelper] No se pudo leer el archivo PEM: $filePath");
    }
    if (!self::pemContainsCertificate($pemContent)) {
      throw CertificadoException::porMotivo(MotivoCertificado::PemInvalido, "[PemHelper] El archivo PEM no contiene un certificado: $filePath");
    }
    if (!self::pemContainsPrivateKey($pemContent)) {
      throw CertificadoException::porMotivo(MotivoCertificado::PemInvalido, "[PemHelper] El archivo PEM no contiene una clave privada: $filePath");
    }
  }
}
