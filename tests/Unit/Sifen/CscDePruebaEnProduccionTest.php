<?php

namespace IonysDev\Pkuatia\Tests\Unit\Sifen;

use IonysDev\Pkuatia\Core\Config;
use IonysDev\Pkuatia\Core\Exceptions\ConfiguracionException;
use IonysDev\Pkuatia\Sifen;
use IonysDev\Pkuatia\Tests\Support\TestCertFactory;
use PHPUnit\Framework\TestCase;

/**
 * Fase C, C12 (evaluación §9, decisión Q-C6 = A): Config trae de fábrica el CSC del ambiente de pruebas. En
 * producción el SIFEN rechaza con 2501 (J002a) todo DE cuyo QR se firme con él, así que Init() se niega a arrancar
 * con env = prod y ese CSC, con un mensaje que dice qué configurar. En desarrollo nada cambia.
 */
final class CscDePruebaEnProduccionTest extends TestCase
{
  /** @var array{pemPath: string, passphrase: string, cleanup: callable} */
  private array $cert;

  protected function setUp(): void
  {
    $this->cert = TestCertFactory::createSelfSignedPem();
  }

  protected function tearDown(): void
  {
    Sifen::Shutdown();
    ($this->cert['cleanup'])();
  }

  private function config(string $env): Config
  {
    $config = new Config();
    $config->env = $env;
    $config->certificateFormat = Config::CERT_FORMAT_PEM;
    $config->privateKeyFilePath = $this->cert['pemPath'];
    $config->privateKeyPassphrase = $this->cert['passphrase'];
    $config->dIdFilePath = tempnam(sys_get_temp_dir(), 'pkuatia_did_') . '.json';
    return $config;
  }

  public function testElCscDeFabricaEsElDePrueba(): void
  {
    $this->assertSame(Config::CSC_DE_PRUEBA, (new Config())->csc);
    $this->assertTrue((new Config())->usaCscDePrueba());
    $this->assertFalse((new Config())->setCsc('1234ABCD5678EF9012345678901234AB')->usaCscDePrueba());
  }

  public function testInitEnProduccionConElCscDePruebaLanzaConfiguracionException(): void
  {
    $config = $this->config(Config::ENV_PROD);
    try {
      Sifen::Init($config);
      $this->fail('Init() debe rechazar el CSC de prueba en producción');
    } catch (ConfiguracionException $e) {
      $this->assertStringContainsString('CSC', $e->getMessage());
      $this->assertStringContainsString('2501', $e->getMessage());
      $this->assertStringContainsString('idCsc', $e->getMessage());
      $this->assertStringNotContainsString($this->cert['passphrase'], $e->getMessage());
    }
  }

  public function testInitEnProduccionConOtroCscYEnDesarrolloConElDePruebaSiguenFuncionando(): void
  {
    $prod = $this->config(Config::ENV_PROD);
    $prod->setCsc('1234ABCD5678EF9012345678901234AB')->setIdCsc('0001');
    Sifen::Init($prod);
    $this->assertSame(Config::ENV_PROD, $prod->getEnv());
    Sifen::Init($this->config(Config::ENV_DEV));
    $this->addToAssertionCount(1); // sin excepción
  }
}
