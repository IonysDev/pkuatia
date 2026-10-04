<?php

namespace IonysDev\Pkuatia\Tests\Support;

use IonysDev\Pkuatia\Core\Config;
use IonysDev\Pkuatia\Sifen;

/**
 * Inicializa Sifen para pruebas offline: certificado autofirmado temporal, ambiente dev,
 * CSC genérico de pruebas y archivo de dId temporal. No toca la red.
 */
final class SifenTestEnvironment
{
  /**
   * @return array{config: Config, cleanup: callable}
   */
  public static function init(): array
  {
    $cert = TestCertFactory::createSelfSignedPem();
    $dIdPath = tempnam(sys_get_temp_dir(), 'pkuatia_did_') . '.json';

    $config = new Config();
    $config->env = Config::ENV_DEV;
    $config->certificateFormat = Config::CERT_FORMAT_PEM;
    $config->privateKeyFilePath = $cert['pemPath'];
    $config->privateKeyPassphrase = $cert['passphrase'];
    $config->idCsc = '0001';
    $config->csc = 'ABCD0000000000000000000000000000';
    $config->dIdFilePath = $dIdPath;
    $config->wsdlCacheEnabled = false;

    Sifen::Init($config);
    // Ninguna prueba debe llegar a la red: una factoría que falla deja el error a la vista.
    Sifen::SetSoapClientFactory(static function (): \SoapClient {
      throw new \RuntimeException('Las pruebas unitarias no deben crear un SoapClient real.');
    });

    return [
      'config' => $config,
      'cleanup' => static function () use ($cert, $dIdPath): void {
        ($cert['cleanup'])();
        @unlink($dIdPath);
        Sifen::SetSoapClientFactory(null);
      },
    ];
  }
}
