<?php

namespace IonysDev\Pkuatia\Tests\Unit\Conformidad;

use DOMDocument;
use IonysDev\Pkuatia\Core\Constants\PaConEIniTiPago;
use IonysDev\Pkuatia\Core\Fields\DE\E\GPaConEIni;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Tests\Support\XsdAssertions;
use PHPUnit\Framework\TestCase;

/**
 * PK-09: `GPaConEIni::getDMonTiPag(): int` truncaba el monto de pago E606 (tMontoBase4, hasta 4 decimales,
 * DE_Types_v150.xsd:1290-1300) y `toDOMElement` emitía `<dMonTiPag>1500</dMonTiPag>` para '1500.50'.
 */
final class PagosTest extends TestCase
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

  public function testElMontoDelPagoConservaLosDecimalesSinAvisosDeDeprecacion(): void
  {
    $avisos = [];
    set_error_handler(static function (int $no, string $msg) use (&$avisos): bool {
      $avisos[] = $msg;
      return true;
    });
    try {
      $pago = new GPaConEIni();
      $pago->setITiPago(PaConEIniTiPago::Efectivo);
      $pago->setDMonTiPag('1500.50');
      $pago->setCMoneTiPag('USD');
      $doc = new DOMDocument();
      $xml = $doc->saveXML($pago->toDOMElement($doc));
    } finally {
      restore_error_handler();
    }
    $this->assertStringContainsString('<dMonTiPag>1500.50</dMonTiPag>', $xml);
    $this->assertSame([], $avisos, 'no debe haber avisos de PHP al serializar el pago');
    $this->assertSame('1500.50', $pago->getDMonTiPagDecimal());
  }

  public function testFacturaEnDolaresConPagoConCentavosValida(): void
  {
    $fe = DocumentoFactory::facturaUsd(60); // 2 × 150.50 USD
    $total = $fe->gTotSub->getDTotGralOpe();
    $xml = DocumentoFactory::firmar($fe->facturaToRDE());
    $this->assertStringContainsString("<dMonTiPag>$total</dMonTiPag>", $xml, 'el pago debe emitirse tal como se estableció, sin truncar');
    $this->assertStringContainsString('<dTiCamTiPag>7300</dTiCamTiPag>', $xml);
    XsdAssertions::assertRdeValido($xml, 'FE USD con pago');
  }

  public function testPagoConCentavosSeEmiteSinTruncarEnLaFactura(): void
  {
    $fe = DocumentoFactory::facturaUsd(61);
    $fe->addPago(PaConEIniTiPago::Cheque, '0.75', 'USD', '7300');
    $xml = DocumentoFactory::firmar($fe->facturaToRDE());
    $this->assertStringContainsString('<dMonTiPag>0.75</dMonTiPag>', $xml);
    XsdAssertions::assertRdeValido($xml, 'FE USD con pago con centavos');
  }
}
