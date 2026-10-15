<?php

namespace IonysDev\Pkuatia\Tests\Unit\Helpers;

use IonysDev\Pkuatia\Core\Config;
use IonysDev\Pkuatia\Core\Constants\MotivoCertificado;
use IonysDev\Pkuatia\Core\Exceptions\CertificadoException;
use IonysDev\Pkuatia\Helpers\SignHelper;
use IonysDev\Pkuatia\Tests\Support\TestCertFactory;
use PHPUnit\Framework\TestCase;

/**
 * QA final de la Fase C: un certificado o clave que existe pero no se puede leer (p. ej. una carpeta) debe terminar en
 * CertificadoException, no en un firmador con certificado vacío que el SIFEN rechazaría con 0120.
 */
final class SignHelperArchivoIlegibleTest extends TestCase
{
  public function testUnCertificadoIlegibleLanzaCertificadoException(): void
  {
    $cert = TestCertFactory::createSelfSignedPem();
    try {
      $this->expectException(CertificadoException::class);
      $this->expectExceptionMessageMatches('/No se pudo leer/');
      // sys_get_temp_dir() existe y no es un archivo: file_get_contents() devuelve false
      SignHelper::Init($cert['pemPath'], $cert['passphrase'], Config::CERT_FORMAT_PEM, sys_get_temp_dir());
    } finally {
      ($cert['cleanup'])();
    }
  }

  public function testUnPkcs12IlegibleLanzaCertificadoException(): void
  {
    try {
      SignHelper::Init(sys_get_temp_dir(), 'x', Config::CERT_FORMAT_PKCS12);
      $this->fail('debe lanzar CertificadoException');
    } catch (CertificadoException $e) {
      $this->assertSame(MotivoCertificado::PemInvalido, $e->getMotivo());
    }
  }
}
