<?php

namespace IonysDev\Pkuatia\Tests\Unit\Sifen;

use IonysDev\Pkuatia\Core\Config;
use IonysDev\Pkuatia\Core\Responses\RResEnviConsRUC;
use IonysDev\Pkuatia\Sifen;
use IonysDev\Pkuatia\Tests\Support\TestCertFactory;
use PHPUnit\Framework\TestCase;
use SoapClient;
use stdClass;

final class ConsultarRUCTest extends TestCase
{
  private string $pemPath;
  private $certCleanup;

  protected function setUp(): void
  {
    $cert = TestCertFactory::createSelfSignedPem();
    $this->pemPath = $cert['pemPath'];
    $this->certCleanup = $cert['cleanup'];

    $config = new Config();
    $config->certificateFormat = Config::CERT_FORMAT_PEM;
    $config->privateKeyFilePath = $this->pemPath;
    $config->privateKeyPassphrase = $cert['passphrase'];
    $config->dIdFilePath = sys_get_temp_dir() . '/pkuatia_did_phpunit_' . uniqid('', true) . '.json';

    Sifen::Init($config);
  }

  protected function tearDown(): void
  {
    Sifen::SetSoapClientFactory(null);
    if ($this->certCleanup) {
      ($this->certCleanup)();
    }
  }

  public function testConsultarRucParsesStubResponseWithoutNetwork(): void
  {
    Sifen::SetSoapClientFactory(function (string $wsdl, array $options): SoapClient {
      return new class($wsdl) extends SoapClient {
        public function __construct(string $wsdl)
        {
          // Sin llamada de red: el stub no usa el WSDL real.
        }

        public function rEnviConsRUC($request): stdClass
        {
          $ruc = new stdClass();
          $ruc->dRUCCons = '80000000';
          $ruc->dRazCons = 'Empresa de Prueba SA';
          $ruc->dCodEstCons = 'ACT';
          $ruc->dDesEstCons = 'ACTIVO';
          $ruc->dRUCFactElec = 'N';

          $response = new stdClass();
          $response->dCodRes = '0502';
          $response->dMsgRes = 'RUC encontrado';
          $response->xContRUC = $ruc;

          return $response;
        }
      };
    });

    $result = Sifen::ConsultarRUC('80000000');

    $this->assertInstanceOf(RResEnviConsRUC::class, $result);
    $this->assertSame(502, (int) $result->dCodRes);
    $this->assertSame('RUC encontrado', $result->dMsgRes);
    $this->assertSame('80000000', $result->getRContRuc()->dRUCCons);
    $this->assertSame('Empresa de Prueba SA', $result->getRContRuc()->dRazCons);
  }
}
