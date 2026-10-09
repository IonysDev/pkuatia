<?php

namespace IonysDev\Pkuatia\Tests\Unit\Conformidad;

use IonysDev\Pkuatia\Core\Constants\TipDocAso;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Tests\Support\XsdAssertions;
use PHPUnit\Framework\TestCase;

/**
 * PK-02 (F008 de la Autofactura sumaba solo el último ítem), PK-03 (literal `Constancia Electrónica`,
 * DE_Types_v150.xsd:1831-1842) y PK-10 (dTotIVA vacío en el QR; NT-010 exige 0).
 */
final class AutofacturaTest extends TestCase
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

  public function testElTotalDeLaOperacionSumaTodosLosItems(): void
  {
    $af = DocumentoFactory::autofactura(30, 2); // 5 × 20 000 + 1 × 30 000
    $this->assertSame('130000.00000000', $af->gTotSub->getDTotOpe(), 'F008 dTotOpe');
    $this->assertSame('130000', $af->gTotSub->getDTotGralOpe(), 'F014 dTotGralOpe');
  }

  public function testElLiteralDeLaConstanciaEsElDelXsd(): void
  {
    $this->assertSame('Constancia Electrónica', TipDocAso::ConstanciaElectronica->getDescription());
  }

  public function testAutofacturaFirmadaValidaContraElXsdYElQrLlevaIvaCero(): void
  {
    $xml = DocumentoFactory::firmar(DocumentoFactory::autofactura(31, 2)->autofacturaToRDE());
    XsdAssertions::assertRdeValido($xml, 'Autofactura con 2 ítems');
    $this->assertStringContainsString('<dDesTipDocAso>Constancia Electrónica</dDesTipDocAso>', $xml);
    $this->assertStringContainsString('<dTotOpe>130000.00000000</dTotOpe>', $xml);
    $this->assertMatchesRegularExpression('/dTotIVA=0&amp;cItems=2/', $xml, 'el QR debe informar dTotIVA=0 (NT-010)');
  }
}
