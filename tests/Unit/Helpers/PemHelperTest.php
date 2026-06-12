<?php

namespace IonysDev\Pkuatia\Tests\Unit\Helpers;

use IonysDev\Pkuatia\Helpers\PemHelper;
use IonysDev\Pkuatia\Tests\Support\TestCertFactory;
use PHPUnit\Framework\TestCase;

final class PemHelperTest extends TestCase
{
  private $cleanup;

  protected function tearDown(): void
  {
    if ($this->cleanup) {
      ($this->cleanup)();
    }
  }

  public function testCombinedFileDetectionAndCertificateExtraction(): void
  {
    $cert = TestCertFactory::createSelfSignedPem();
    $this->cleanup = $cert['cleanup'];
    $pemContent = file_get_contents($cert['pemPath']);

    $this->assertTrue(PemHelper::usesCombinedFile(null, $cert['pemPath']));
    $this->assertTrue(PemHelper::usesCombinedFile($cert['pemPath'], $cert['pemPath']));
    $this->assertTrue(PemHelper::pemContainsCertificate($pemContent));
    $this->assertTrue(PemHelper::pemContainsPrivateKey($pemContent));

    $extracted = PemHelper::extractCertificatePem($pemContent);
    $this->assertStringContainsString('BEGIN CERTIFICATE', $extracted);
    $this->assertStringNotContainsString('BEGIN PRIVATE KEY', $extracted);
  }
}
