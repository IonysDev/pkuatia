<?php

namespace IonysDev\Pkuatia\Tests\Unit\Core;

use IonysDev\Pkuatia\Core\Config;
use PHPUnit\Framework\TestCase;

final class ConfigTest extends TestCase
{
  public function testNormalizeCertificateFormatIsIdempotent(): void
  {
    $this->assertSame(Config::CERT_FORMAT_PKCS12, Config::normalizeCertificateFormat('p12'));
    $this->assertSame(Config::CERT_FORMAT_PKCS12, Config::normalizeCertificateFormat('pkcs12'));
    $this->assertSame(Config::CERT_FORMAT_PKCS12, Config::normalizeCertificateFormat('pfx'));
    $this->assertSame(Config::CERT_FORMAT_PEM, Config::normalizeCertificateFormat('pem'));
    $this->assertSame(Config::CERT_FORMAT_PKCS12, Config::normalizeCertificateFormat('pkcs12'));
    $this->assertSame(Config::CERT_FORMAT_PEM, Config::normalizeCertificateFormat('pem'));
  }
}
