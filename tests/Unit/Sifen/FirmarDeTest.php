<?php

namespace IonysDev\Pkuatia\Tests\Unit\Sifen;

use DateTime;
use DateTimeZone;
use IonysDev\Pkuatia\Sifen;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Tests\Support\XsdAssertions;
use PHPUnit\Framework\TestCase;

/**
 * PK-21: FirmarDE ignoraba el parámetro $infoAdicionalEmisor (setDInfAdic se llamaba después de serializar
 * gCamFuFD), así que J003 dInfAdic nunca llegaba al XML.
 */
final class FirmarDeTest extends TestCase
{
  /** @var callable */
  private $cleanup;

  protected function setUp(): void
  {
    $this->cleanup = SifenTestEnvironment::init()['cleanup'];
  }

  protected function tearDown(): void
  {
    ($this->cleanup)();
  }

  public function testLaInformacionAdicionalDelEmisorLlegaAlXmlFueraDeLaFirma(): void
  {
    $rde = DocumentoFactory::facturaContado(80)->facturaToRDE();
    $xml = Sifen::FirmarDE($rde, new DateTime('2026-01-15T10:05:00', new DateTimeZone('America/Asuncion')), 'Pago con Tigo Money & Bancard');

    $this->assertStringContainsString('<gCamFuFD><dCarQR>', $xml);
    $this->assertStringContainsString('<dInfAdic>Pago con Tigo Money &amp; Bancard</dInfAdic></gCamFuFD>', $xml);
    XsdAssertions::assertRdeValido($xml, 'FE con dInfAdic');
  }

  public function testSinInformacionAdicionalNoSeEmiteDInfAdic(): void
  {
    $rde = DocumentoFactory::facturaContado(81)->facturaToRDE();
    $xml = Sifen::FirmarDE($rde, new DateTime('2026-01-15T10:05:00', new DateTimeZone('America/Asuncion')));
    $this->assertStringNotContainsString('<dInfAdic', $xml);
    XsdAssertions::assertRdeValido($xml, 'FE sin dInfAdic');
  }
}
