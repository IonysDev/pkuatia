<?php

namespace IonysDev\Pkuatia\Tests\Unit\Helpers;

use DateTime;
use IonysDev\Pkuatia\Core\Config;
use IonysDev\Pkuatia\Core\Constants;
use IonysDev\Pkuatia\Core\Fields\DE\I\Signature;
use IonysDev\Pkuatia\Helpers\QRHelper;
use IonysDev\Pkuatia\Helpers\SignHelper;
use IonysDev\Pkuatia\Tests\Support\MinimalRdeFactory;
use IonysDev\Pkuatia\Tests\Support\TestCertFactory;
use PHPUnit\Framework\TestCase;

final class QRHelperTest extends TestCase
{
  private $certCleanup;

  protected function tearDown(): void
  {
    if ($this->certCleanup) {
      ($this->certCleanup)();
    }
  }

  public function testGenerateQrContentIncludesRequiredFieldsAndHostByEnv(): void
  {
    $cert = TestCertFactory::createSelfSignedPem();
    $this->certCleanup = $cert['cleanup'];
    SignHelper::Init($cert['pemPath'], $cert['passphrase'], Config::CERT_FORMAT_PEM);

    $rde = MinimalRdeFactory::createRde(9);
    $fecha = new DateTime('2026-01-15T10:00:00');
    $signed = SignHelper::SignRDE($rde, $fecha);
    $signature = Signature::FromDOMElement($signed->getElementsByTagName('Signature')->item(0));
    $de = $rde->getDE();

    $configDev = new Config();
    $configDev->env = Config::ENV_DEV;
    $configDev->setIdCsc('42');
    $configDev->setCsc('ABCD0000000000000000000000000000');

    $qrDev = QRHelper::GenerateQRContent($configDev, $de, $signature);
    $this->assertStringStartsWith(Constants::SIFEN_URL_CONSULTA_QR_DEV, $qrDev);
    $this->assertStringContainsString('nVersion=' . Constants::SIFEN_VERSION, $qrDev);
    $this->assertStringContainsString('Id=' . $de->getId(), $qrDev);
    $this->assertStringContainsString('dFeEmiDE=', $qrDev);
    $this->assertStringContainsString('cHashQR=', $qrDev);
    $this->assertStringContainsString('IdCSC=0042', $qrDev);

    $configProd = new Config();
    $configProd->env = Config::ENV_PROD;
    $configProd->setIdCsc('42');
    $configProd->setCsc('ABCD0000000000000000000000000000');

    $qrProd = QRHelper::GenerateQRContent($configProd, $de, $signature);
    $this->assertStringStartsWith(Constants::SIFEN_URL_CONSULTA_QR_PROD, $qrProd);
    $this->assertStringContainsString('cHashQR=', $qrProd);
  }
}
