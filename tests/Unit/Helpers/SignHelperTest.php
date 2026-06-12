<?php

namespace IonysDev\Pkuatia\Tests\Unit\Helpers;

use DateTime;
use IonysDev\Pkuatia\Core\Config;
use IonysDev\Pkuatia\Helpers\SignHelper;
use IonysDev\Pkuatia\Tests\Support\MinimalRdeFactory;
use IonysDev\Pkuatia\Tests\Support\SignatureAssertions;
use IonysDev\Pkuatia\Tests\Support\TestCertFactory;
use PHPUnit\Framework\TestCase;

final class SignHelperTest extends TestCase
{
  private string $pemPath;
  private string $passphrase;
  private $certCleanup;

  protected function setUp(): void
  {
    $cert = TestCertFactory::createSelfSignedPem();
    $this->pemPath = $cert['pemPath'];
    $this->passphrase = $cert['passphrase'];
    $this->certCleanup = $cert['cleanup'];

    SignHelper::Init($this->pemPath, $this->passphrase, Config::CERT_FORMAT_PEM);
  }

  protected function tearDown(): void
  {
    if ($this->certCleanup) {
      ($this->certCleanup)();
    }
  }

  public function testSignRdeTwiceProducesOneReferenceEach(): void
  {
    $fecha = new DateTime('2026-01-15T10:00:00');

    $doc1 = SignHelper::SignRDE(MinimalRdeFactory::createRde(1), $fecha);
    SignatureAssertions::assertEachSignatureWellFormed($doc1, 'RDE #1');

    $doc2 = SignHelper::SignRDE(MinimalRdeFactory::createRde(2), $fecha);
    SignatureAssertions::assertEachSignatureWellFormed($doc2, 'RDE #2');

    $this->assertEquals(1, $doc1->getElementsByTagName('Signature')->length);
    $this->assertEquals(1, $doc2->getElementsByTagName('Signature')->length);
  }

  public function testSingEventsTwoEventsReferenceCorrectIds(): void
  {
    $config = new Config();
    $doc = SignHelper::SingEvents(MinimalRdeFactory::createCancellationEventsEnvelope(), $config);

    $signatures = $doc->getElementsByTagName('Signature');
    $this->assertEquals(2, $signatures->length);
    SignatureAssertions::assertEachSignatureWellFormed($doc, 'Eventos');

    SignatureAssertions::assertReferenceUri($signatures->item(0), '#1');
    SignatureAssertions::assertReferenceUri($signatures->item(1), '#2');
  }
}
