<?php

namespace IonysDev\Pkuatia\Tests\Unit\Conformidad;

use IonysDev\Pkuatia\Tests\Support\DocumentoFactory;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Tests\Support\XsdAssertions;
use PHPUnit\Framework\TestCase;

/**
 * Documentos que ya eran conformes en v0.1.5 (evaluación del 02/10/2026, §4): fijan el
 * comportamiento para que las correcciones de la Fase A no lo alteren.
 */
final class DocumentosValidosTest extends TestCase
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

  public function testFacturaContadoFirmadaValida(): void
  {
    $xml = DocumentoFactory::firmar(DocumentoFactory::facturaContado(1)->facturaToRDE());
    XsdAssertions::assertRdeValido($xml, 'FE contado');
    $this->assertStringContainsString('<dTotGralOpe>100000</dTotGralOpe>', $xml);
  }

  public function testFacturaUsdConTipoDeCambioGlobalValida(): void
  {
    $xml = DocumentoFactory::firmar(DocumentoFactory::facturaUsd(3)->facturaToRDE());
    XsdAssertions::assertRdeValido($xml, 'FE USD');
    $this->assertStringContainsString('<cMoneOpe>USD</cMoneOpe>', $xml);
    $this->assertStringContainsString('<dTiCam>7300</dTiCam>', $xml);
  }

  public function testNotaDeCreditoValida(): void
  {
    $xml = DocumentoFactory::firmar(DocumentoFactory::notaDeCredito(10)->notaDeCreditoToRDE());
    XsdAssertions::assertRdeValido($xml, 'NC');
    $this->assertStringContainsString('<iTiDE>5</iTiDE>', $xml);
    $this->assertStringContainsString('<dCdCDERef>' . DocumentoFactory::CDC_ASOCIADO . '</dCdCDERef>', $xml);
  }

  public function testNotaDeDebitoValida(): void
  {
    $xml = DocumentoFactory::firmar(DocumentoFactory::notaDeDebito(11)->notaDeDebitoToRDE());
    XsdAssertions::assertRdeValido($xml, 'ND');
    $this->assertStringContainsString('<iTiDE>6</iTiDE>', $xml);
  }

  public function testFacturaCreditoEnCuotasConEntregaInicialValida(): void
  {
    $xml = DocumentoFactory::firmar(DocumentoFactory::facturaCreditoCuotas(2, '0')->facturaToRDE());
    XsdAssertions::assertRdeValido($xml, 'FE crédito en cuotas con entrega inicial');
    $this->assertStringContainsString('<dCuotas>2</dCuotas>', $xml);
  }
}
