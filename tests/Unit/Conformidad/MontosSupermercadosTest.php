<?php

namespace IonysDev\Pkuatia\Tests\Unit\Conformidad;

use IonysDev\Pkuatia\Core\DocumentosElectronicos\Factura;
use IonysDev\Pkuatia\Core\Fields\DE\E\GGrupSup;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory;
use IonysDev\Pkuatia\Tests\Support\RoundTrip;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Tests\Support\XsdAssertions;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Q-B10 (decisión del 10/10/2026): los montos de gGrupSup admiten hasta 4 decimales (dEfectivo es
 * tMontoBase4, 19 dígitos; dVuelto y dDonac son tMontoBase6, 10 dígitos; DE_Types_v150.xsd) y la librería
 * los guardaba como int: 150.75 se truncaba a 150 al emitir y al leer. Mismo criterio que PK-09
 * (GPaConEIni::getDMonTiPagDecimal()).
 */
final class MontosSupermercadosTest extends TestCase
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

  private static function facturaUsdSupermercado(): Factura
  {
    $fe = DocumentoFactory::facturaUsd(80);
    $fe->setDatosComplementariosSectorSupermercados('Cajero 1', '150.75', '0.25', '0.50', 'Donacion de prueba');
    return $fe;
  }

  public function testLosMontosConCentavosSeEmitenExactosYValidan(): void
  {
    $xml = DocumentoFactory::firmar(self::facturaUsdSupermercado()->facturaToRDE());
    $this->assertStringContainsString('<dEfectivo>150.75</dEfectivo><dVuelto>0.25</dVuelto><dDonac>0.50</dDonac>', $xml);
    XsdAssertions::assertRdeValido($xml, 'FE en USD con montos de supermercado con centavos');
  }

  /** Los getters nuevos devuelven el monto exacto; los de siempre, la parte entera. */
  public function testGettersDecimalesYEnterosCompatibles(): void
  {
    $g = (new GGrupSup())->setDEfectivo('150.75')->setDVuelto('0.25')->setDDonac(3);
    $this->assertSame('150.75', $g->getDEfectivoDecimal());
    $this->assertSame('0.25', $g->getDVueltoDecimal());
    $this->assertSame('3', $g->getDDonacDecimal());
    $this->assertSame(150, $g->getDEfectivo());
    $this->assertSame(0, $g->getDVuelto());
    $this->assertSame(150, $g->dEfectivo);
  }

  /** Si se asigna directamente la propiedad pública entera, manda ella (como hasta 0.2.0). */
  public function testLaPropiedadEnteraAsignadaDirectamenteManda(): void
  {
    $g = (new GGrupSup())->setDEfectivo('150.75');
    $g->dEfectivo = 7;
    $this->assertSame('7', $g->getDEfectivoDecimal());
    $this->assertStringContainsString('<dEfectivo>7</dEfectivo>', RoundTrip::serializar($g));
  }

  public function testLosMontosEnterosNoCambian(): void
  {
    $xml = RoundTrip::serializar(DocumentoFactory::rde(DocumentoFactory::facturaSectorial('supermercados', 81)));
    $this->assertStringContainsString('<dEfectivo>100000</dEfectivo><dVuelto>0</dVuelto>', $xml);
  }

  /** @return array<string, array{0: string}> */
  public static function vias(): array
  {
    return ['DOM' => [RoundTrip::VIA_DOM], 'SimpleXML' => [RoundTrip::VIA_SIMPLEXML], 'objeto SOAP' => [RoundTrip::VIA_SOAP]];
  }

  #[DataProvider('vias')]
  public function testIdaYVueltaConCentavos(string $via): void
  {
    $gGrupSup = DocumentoFactory::rde(self::facturaUsdSupermercado())->getDE()->getGDtipDe()->getGCamEsp()->getGGrupSup();
    RoundTrip::assertIdaYVueltaIdentica($gGrupSup, $via);
  }

  /** @return array<string, array{0: string, 1: string}> */
  public static function montosInvalidos(): array
  {
    return [
      'cinco decimales' => ['setDEfectivo', '1.23456'],
      'no numérico' => ['setDVuelto', 'abc'],
      'vuelto con 11 dígitos' => ['setDVuelto', '12345678901'],
      'donación con 7 enteros y 4 decimales' => ['setDDonac', '1234567.1234'],
    ];
  }

  #[DataProvider('montosInvalidos')]
  public function testMontosFueraDelXsdSeRechazan(string $setter, string $valor): void
  {
    $this->expectException(\InvalidArgumentException::class);
    (new GGrupSup())->$setter($valor);
  }

  /** xs:decimal: los ceros finales de la parte decimal no cuentan (1.23450 tiene 4 decimales) y el signo se admite. */
  public function testLimitesDelXsd(): void
  {
    $g = (new GGrupSup())->setDEfectivo('1.23450')->setDVuelto('123456.1234')->setDDonac('-1');
    $this->assertSame('1.23450', $g->getDEfectivoDecimal());
    $this->assertSame('123456.1234', $g->getDVueltoDecimal());
    $this->assertSame('-1', $g->getDDonacDecimal());
  }
}
