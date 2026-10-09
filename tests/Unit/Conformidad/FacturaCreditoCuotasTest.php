<?php

namespace IonysDev\Pkuatia\Tests\Unit\Conformidad;

use IonysDev\Pkuatia\Tests\Support\DocumentoFactory;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Tests\Support\XsdAssertions;
use PHPUnit\Framework\TestCase;

/**
 * PK-04: `GPagCred::getDCuotas()` devolvía null cuando no había entrega inicial (dMonEnt), y la
 * FE a crédito en cuotas sin entrega inicial salía con `<dCuotas/>` vacío (grupo gPagCred, E640;
 * validación E643).
 */
final class FacturaCreditoCuotasTest extends TestCase
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

  public function testSinEntregaInicialInformaLaCantidadDeCuotasYValida(): void
  {
    $fe = DocumentoFactory::facturaCreditoCuotas(2, null);
    $this->assertSame(2, $fe->gCamCond->gPagCred->getDCuotas());

    $xml = DocumentoFactory::firmar($fe->facturaToRDE());
    $this->assertStringContainsString('<dCuotas>2</dCuotas>', $xml);
    $this->assertStringNotContainsString('<dMonEnt>', $xml, 'sin entrega inicial no se informa dMonEnt');
    XsdAssertions::assertRdeValido($xml, 'FE crédito en cuotas sin entrega inicial');
  }
}
