<?php

namespace IonysDev\Pkuatia\Tests\Unit\Core;

use IonysDev\Pkuatia\Core\Config;
use IonysDev\Pkuatia\Sifen;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use PHPUnit\Framework\TestCase;

/**
 * Fase C, C12 (evaluación §4 PK-39 y §9): Config::__debugInfo() oculta la passphrase y el CSC en var_dump() y
 * print_r(), y Config::$soapTrace controla la opción trace de SoapClient (GetLastRequest()/GetLastResponse()).
 */
final class ConfigSecretosYTraceTest extends TestCase
{
  private function config(): Config
  {
    $config = new Config();
    $config->env = Config::ENV_DEV;
    $config->certificateFormat = Config::CERT_FORMAT_PEM;
    $config->privateKeyFilePath = 'clave.pem';
    $config->privateKeyPassphrase = 'frase-super-secreta';
    $config->csc = 'CSC0SECRETO000000000000000000000';
    return $config;
  }

  public function testPrintRYVarDumpNoMuestranLaPassphraseNiElCsc(): void
  {
    $config = $this->config();
    $printR = print_r($config, true);
    ob_start();
    var_dump($config);
    $varDump = (string) ob_get_clean();
    foreach ([$printR, $varDump] as $salida) {
      $this->assertStringNotContainsString('frase-super-secreta', $salida);
      $this->assertStringNotContainsString('CSC0SECRETO', $salida);
      $this->assertStringContainsString('[redactado]', $salida);
      $this->assertStringContainsString('clave.pem', $salida, 'lo que no es secreto se sigue mostrando');
    }
    $this->assertSame('frase-super-secreta', $config->privateKeyPassphrase, 'la propiedad conserva el valor real');
    $this->assertSame('CSC0SECRETO000000000000000000000', $config->getCsc());
    $this->assertSame('[redactado]', $config->__debugInfo()['privateKeyPassphrase']);
    $this->assertSame('[redactado]', $config->__debugInfo()['csc']);
  }

  public function testDebugInfoNoFallaConPropiedadesSinInicializar(): void
  {
    $info = (new Config())->__debugInfo();
    $this->assertArrayNotHasKey('privateKeyPassphrase', $info);
    $this->assertSame('[redactado]', $info['csc'], 'el CSC tiene valor por defecto y se redacta igual');
  }

  public function testSoapTraceSeConfiguraPorPropiedadSetterYJson(): void
  {
    $config = new Config();
    $this->assertTrue($config->soapTrace, 'por defecto se guardan la última solicitud y respuesta, como hasta 0.2.1');
    $this->assertSame($config, $config->setSoapTrace(false));
    $this->assertFalse($config->soapTrace);
    $desdeJson = Config::ParseObject((object) ['privateKeyFilePath' => 'x.pem', 'privateKeyPassphrase' => 'x', 'soapTrace' => false]);
    $this->assertFalse($desdeJson->soapTrace);
    $this->assertTrue(Config::ParseObject((object) ['privateKeyFilePath' => 'x.pem', 'privateKeyPassphrase' => 'x'])->soapTrace);
  }

  public function testSoapTraceLlegaAlSoapClient(): void
  {
    $env = SifenTestEnvironment::init();
    try {
      $this->assertSame(true, $this->opcionTrace());
      $env['config']->soapTrace = false;
      Sifen::Init($env['config']);
      $this->assertSame(false, $this->opcionTrace());
      $this->assertNull(Sifen::GetLastRequest());
    } finally {
      ($env['cleanup'])();
    }
  }

  private function opcionTrace(): mixed
  {
    $capturada = 'sin capturar';
    Sifen::SetSoapClientFactory(function (string $wsdl, array $options) use (&$capturada): \SoapClient {
      $capturada = $options['trace'] ?? null;
      throw new \RuntimeException('sin red');
    });
    try {
      Sifen::ConsultarRUC('80012345');
    } catch (\Throwable) {
    }
    return $capturada;
  }
}
