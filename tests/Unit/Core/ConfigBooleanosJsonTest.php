<?php

namespace IonysDev\Pkuatia\Tests\Unit\Core;

use IonysDev\Pkuatia\Core\Config;
use PHPUnit\Framework\TestCase;

/**
 * QA final de la Fase C: las opciones booleanas del JSON se leían con boolval(), que convierte las cadenas "false" y
 * "0" en true. Se interpretan como booleanos de verdad (filter_var con FILTER_VALIDATE_BOOLEAN).
 */
final class ConfigBooleanosJsonTest extends TestCase
{
  private static function config(array $extra): Config
  {
    return Config::ParseObject((object) (['privateKeyFilePath' => 'x.pem', 'privateKeyPassphrase' => 'x'] + $extra));
  }

  public function testLasCadenasFalseYCeroSonFalso(): void
  {
    $c = self::config(['soapTrace' => 'false', 'validarXsdAntesDeEnviar' => '0', 'wsdlCacheEnabled' => 'no']);
    $this->assertFalse($c->soapTrace);
    $this->assertFalse($c->validarXsdAntesDeEnviar);
    $this->assertFalse($c->wsdlCacheEnabled);
  }

  public function testLosVerdaderosSiguenSiendoVerdaderos(): void
  {
    $c = self::config(['soapTrace' => true, 'validarXsdAntesDeEnviar' => 'true', 'wsdlCacheEnabled' => 1]);
    $this->assertTrue($c->soapTrace);
    $this->assertTrue($c->validarXsdAntesDeEnviar);
    $this->assertTrue($c->wsdlCacheEnabled);
    $this->assertTrue(self::config([])->soapTrace, 'sin la clave queda el valor por defecto');
    $this->assertFalse(self::config([])->validarXsdAntesDeEnviar);
  }
}
