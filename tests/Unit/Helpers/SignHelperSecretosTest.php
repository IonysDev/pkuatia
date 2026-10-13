<?php

namespace IonysDev\Pkuatia\Tests\Unit\Helpers;

use DateTime;
use DateTimeZone;
use IonysDev\Pkuatia\Core\Config;
use IonysDev\Pkuatia\Core\Exceptions\FirmaException;
use IonysDev\Pkuatia\Helpers\SignHelper;
use IonysDev\Pkuatia\Sifen;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory as F;
use IonysDev\Pkuatia\Tests\Support\MinimalRdeFactory;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Tests\Support\SignatureAssertions;
use IonysDev\Pkuatia\Tests\Support\TestCertFactory;
use PHPUnit\Framework\TestCase;
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecurityKey;

/**
 * Fase C, C12 (PK-39, decisión Q-C4 = A): SignHelper::$xmlKey y $xmlSigner siguen públicas y pobladas por
 * compatibilidad (obsoletas desde 0.3.0), pero la firma usa una copia privada de la clave, y Shutdown() la olvida.
 */
final class SignHelperSecretosTest extends TestCase
{
  /** @var array{pemPath: string, passphrase: string, cleanup: callable} */
  private array $cert;

  protected function setUp(): void
  {
    $this->cert = TestCertFactory::createSelfSignedPem();
    SignHelper::Init($this->cert['pemPath'], $this->cert['passphrase'], Config::CERT_FORMAT_PEM);
  }

  protected function tearDown(): void
  {
    ($this->cert['cleanup'])();
  }

  private static function fecha(): DateTime
  {
    return new DateTime('2026-01-15T10:00:00', new DateTimeZone('America/Asuncion'));
  }

  public function testLasPropiedadesPublicasSiguenPobladasPeroLaFirmaUsaUnaCopiaPrivada(): void
  {
    $this->assertInstanceOf(XMLSecurityKey::class, SignHelper::$xmlKey, 'compatibilidad: sigue poblada (Q-C4 = A)');
    $this->assertNotNull(SignHelper::$xmlKey->key);
    $this->assertSame($this->cert['passphrase'], SignHelper::$xmlKey->passphrase);
    $this->assertInstanceOf(XMLSecurityDSig::class, SignHelper::$xmlSigner);

    // Quien pise la propiedad pública no afecta la firma: hay una copia privada.
    SignHelper::$xmlKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA256, ['type' => 'private']);
    $doc = SignHelper::SignRDE(MinimalRdeFactory::createRde(1), self::fecha());
    SignatureAssertions::assertEachSignatureWellFormed($doc, 'con la propiedad pública vacía');
    $this->assertSame(1, $doc->getElementsByTagName('Signature')->length);
  }

  public function testShutdownOlvidaLaClaveYLaFirmaPosteriorLanzaFirmaException(): void
  {
    SignHelper::Shutdown();
    $this->assertNull(SignHelper::$xmlKey->key, 'la propiedad pública obsoleta queda sin clave');
    $this->assertSame('', SignHelper::$xmlKey->passphrase, 'y sin passphrase');
    $this->assertInstanceOf(XMLSecurityDSig::class, SignHelper::$xmlSigner, 'sigue siendo un objeto, para no romper a quien la lea');
    try {
      SignHelper::SignRDE(MinimalRdeFactory::createRde(1), self::fecha());
      $this->fail('debe lanzar FirmaException');
    } catch (FirmaException $e) {
      $this->assertStringContainsString('No se ha inicializado', $e->getMessage());
    }
    $this->expectException(FirmaException::class);
    SignHelper::SingEvents(MinimalRdeFactory::createCancellationEventsEnvelope(), new Config());
  }

  public function testInitDespuesDeShutdownVuelveAFirmar(): void
  {
    SignHelper::Shutdown();
    SignHelper::Shutdown(); // idempotente
    SignHelper::Init($this->cert['pemPath'], $this->cert['passphrase'], Config::CERT_FORMAT_PEM);
    $doc = SignHelper::SignRDE(MinimalRdeFactory::createRde(2), self::fecha());
    SignatureAssertions::assertEachSignatureWellFormed($doc, 'tras Shutdown() e Init()');
  }

  public function testSifenShutdownTambienOlvidaElFirmador(): void
  {
    $env = SifenTestEnvironment::init();
    try {
      $this->assertStringContainsString('<Signature', F::firmar(F::rde(F::facturaContado())));
      Sifen::Shutdown();
      $this->expectException(FirmaException::class);
      F::firmar(F::rde(F::facturaContado()));
    } finally {
      ($env['cleanup'])();
    }
  }
}
