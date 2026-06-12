<?php

namespace IonysDev\Pkuatia\Tests\Support;

/**
 * Genera certificados autofirmados temporales para pruebas offline (sin red ni .p12 legacy).
 */
final class TestCertFactory
{
  /**
   * @return array{pemPath: string, passphrase: string, cleanup: callable}
   */
  public static function createSelfSignedPem(string $passphrase = 'test-pass'): array
  {
    $opensslConfig = self::opensslConfigArgs();
    $key = openssl_pkey_new([
      'private_key_bits' => 2048,
      'private_key_type' => OPENSSL_KEYTYPE_RSA,
      'digest_alg' => 'sha256',
    ] + $opensslConfig);

    if ($key === false) {
      throw new \RuntimeException('No se pudo generar la clave privada de prueba. ¿Falta openssl.cnf en Windows?');
    }

    $dn = ['countryName' => 'PY', 'commonName' => 'PKuatia Unit Test'];
    $csr = openssl_csr_new($dn, $key, $opensslConfig + ['digest_alg' => 'sha256']);
    if ($csr === false) {
      throw new \RuntimeException('No se pudo generar el CSR de prueba.');
    }

    $cert = openssl_csr_sign($csr, null, $key, 365, $opensslConfig + ['digest_alg' => 'sha256']);
    if ($cert === false) {
      throw new \RuntimeException('No se pudo firmar el certificado de prueba.');
    }

    $pemPath = tempnam(sys_get_temp_dir(), 'pkuatia_test_') . '.pem';
    $certPem = '';
    $keyPem = '';
    openssl_x509_export($cert, $certPem);
    openssl_pkey_export($key, $keyPem, $passphrase);

    file_put_contents($pemPath, $certPem . "\n" . $keyPem);

    return [
      'pemPath' => $pemPath,
      'passphrase' => $passphrase,
      'cleanup' => static function () use ($pemPath): void {
        @unlink($pemPath);
      },
    ];
  }

  /**
   * @return array{p12Path: string, passphrase: string, cleanup: callable}
   */
  public static function createModernPkcs12(string $passphrase = 'correct-pass'): array
  {
    $opensslConfig = self::opensslConfigArgs();
    $key = openssl_pkey_new([
      'private_key_bits' => 2048,
      'private_key_type' => OPENSSL_KEYTYPE_RSA,
      'digest_alg' => 'sha256',
    ] + $opensslConfig);
    if ($key === false) {
      throw new \RuntimeException('No se pudo generar la clave privada de prueba.');
    }

    $csr = openssl_csr_new(['countryName' => 'PY', 'commonName' => 'PKuatia PKCS12 Test'], $key, $opensslConfig + ['digest_alg' => 'sha256']);
    $cert = openssl_csr_sign($csr, null, $key, 365, $opensslConfig + ['digest_alg' => 'sha256']);

    $p12Path = tempnam(sys_get_temp_dir(), 'pkuatia_test_') . '.p12';
    $p12Content = '';
    if (!openssl_pkcs12_export($cert, $p12Content, $key, $passphrase)) {
      throw new \RuntimeException('No se pudo exportar el PKCS#12 de prueba.');
    }
    file_put_contents($p12Path, $p12Content);

    return [
      'p12Path' => $p12Path,
      'passphrase' => $passphrase,
      'cleanup' => static function () use ($p12Path): void {
        @unlink($p12Path);
      },
    ];
  }

  /**
   * @return array<string, string>
   */
  private static function opensslConfigArgs(): array
  {
    $candidates = array_filter([
      getenv('OPENSSL_CONF') ?: null,
      dirname(PHP_BINARY) . DIRECTORY_SEPARATOR . 'extras' . DIRECTORY_SEPARATOR . 'ssl' . DIRECTORY_SEPARATOR . 'openssl.cnf',
      'C:\\php\\extras\\ssl\\openssl.cnf',
    ]);

    foreach ($candidates as $path) {
      if (is_string($path) && $path !== '' && file_exists($path)) {
        return ['config' => $path];
      }
    }

    return [];
  }
}
