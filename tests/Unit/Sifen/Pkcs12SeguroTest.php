<?php

namespace IonysDev\Pkuatia\Tests\Unit\Sifen;

use IonysDev\Pkuatia\Core\Config;
use IonysDev\Pkuatia\Sifen;
use IonysDev\Pkuatia\Tests\Support\TestCertFactory;
use PHPUnit\Framework\TestCase;

/**
 * PK-39 (evaluación §4, Fase C, C12): con un certificado PKCS#12, Init() extrae el certificado y la clave a archivos
 * temporales para el contexto SSL de SoapClient. Hasta 0.2.1 iban a sys_get_temp_dir() con nombres predecibles
 * (cert_*, key_*), la clave quedaba en claro y solo se borraban al terminar el script. Desde 0.3.0 van a una carpeta
 * propia de nombre impredecible, la clave se exporta cifrada con la misma passphrase, Shutdown() los borra y un
 * segundo Init() borra los del anterior.
 */
final class Pkcs12SeguroTest extends TestCase
{
  /** @var array{p12Path: string, passphrase: string, cleanup: callable} */
  private array $cert;
  private string $dIdPath;

  protected function setUp(): void
  {
    $this->cert = TestCertFactory::createModernPkcs12('clave-p12');
    $this->dIdPath = tempnam(sys_get_temp_dir(), 'pkuatia_did_') . '.json';
  }

  protected function tearDown(): void
  {
    Sifen::Shutdown();
    Sifen::SetSoapClientFactory(null);
    ($this->cert['cleanup'])();
    @unlink($this->dIdPath);
  }

  private function init(): void
  {
    $config = new Config();
    $config->env = Config::ENV_DEV;
    $config->certificateFormat = 'p12';
    $config->privateKeyFilePath = $this->cert['p12Path'];
    $config->privateKeyPassphrase = $this->cert['passphrase'];
    $config->dIdFilePath = $this->dIdPath;
    Sifen::Init($config);
  }

  /** @return array{local_cert: string, local_pk: string, passphrase: string} Opciones SSL del contexto que Init() armó. */
  private function ssl(): array
  {
    $capturadas = null;
    Sifen::SetSoapClientFactory(function (string $wsdl, array $options) use (&$capturadas): \SoapClient {
      $capturadas = stream_context_get_options($options['stream_context'])['ssl'];
      throw new \RuntimeException('sin red');
    });
    try {
      Sifen::ConsultarRUC('80012345');
    } catch (\Throwable) {
    }
    $this->assertIsArray($capturadas, 'la factoría debe recibir el contexto SSL');
    return $capturadas;
  }

  public function testLosArchivosVanAUnaCarpetaPropiaYLaClaveQuedaCifrada(): void
  {
    $this->init();
    $ssl = $this->ssl();
    $carpeta = dirname($ssl['local_cert']);
    $this->assertSame($carpeta, dirname($ssl['local_pk']), 'certificado y clave en la misma carpeta');
    $this->assertMatchesRegularExpression('/^pkuatia-[0-9a-f]{16}$/', basename($carpeta), 'carpeta propia de nombre impredecible');
    $this->assertSame(rtrim(sys_get_temp_dir(), '/\\'), dirname($carpeta), 'dentro de la carpeta temporal del sistema');
    $this->assertStringNotContainsString('cert_', basename($ssl['local_cert']), 'ya no se usan los nombres predecibles de 0.2.1');
    $this->assertFileExists($ssl['local_cert']);
    $this->assertFileExists($ssl['local_pk']);
    $this->assertStringContainsString('BEGIN CERTIFICATE', (string) file_get_contents($ssl['local_cert']));
    $clave = (string) file_get_contents($ssl['local_pk']);
    $this->assertStringContainsString('ENCRYPTED', $clave, 'la clave privada se exporta cifrada');
    $this->assertStringNotContainsString("BEGIN PRIVATE KEY", $clave, 'no queda la clave en claro');
    $this->assertNotFalse(openssl_pkey_get_private($clave, $this->cert['passphrase']), 'la clave se abre con la passphrase del PKCS#12');
    $this->assertFalse(openssl_pkey_get_private($clave, 'otra'), 'y no sin ella');
    $this->assertSame($this->cert['passphrase'], $ssl['passphrase'], 'el contexto lleva la passphrase para descifrarla');
    if (DIRECTORY_SEPARATOR === '/') {
      $this->assertSame(0700, fileperms($carpeta) & 0777, 'carpeta solo para el usuario');
    }
  }

  public function testShutdownBorraLosTemporalesYOlvidaElCliente(): void
  {
    $this->init();
    $ssl = $this->ssl();
    Sifen::Shutdown();
    $this->assertFileDoesNotExist($ssl['local_cert']);
    $this->assertFileDoesNotExist($ssl['local_pk']);
    $this->assertDirectoryDoesNotExist(dirname($ssl['local_cert']));
    $this->assertNull(Sifen::GetLastRequest());
    $this->assertNull(Sifen::GetLastResponse());
    Sifen::Shutdown(); // idempotente
    $this->init(); // y se puede volver a inicializar
    $this->assertFileExists($this->ssl()['local_pk']);
  }

  public function testInitDosVecesDejaUnSoloJuegoDeArchivos(): void
  {
    $this->init();
    $primero = $this->ssl();
    $this->init();
    $segundo = $this->ssl();
    $this->assertNotSame(dirname($primero['local_cert']), dirname($segundo['local_cert']));
    $this->assertDirectoryDoesNotExist(dirname($primero['local_cert']), 'el segundo Init() borra los temporales del primero');
    $this->assertFileExists($segundo['local_cert']);
    $this->assertFileExists($segundo['local_pk']);
  }
}
