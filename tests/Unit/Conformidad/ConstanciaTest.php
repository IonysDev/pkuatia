<?php

namespace IonysDev\Pkuatia\Tests\Unit\Conformidad;

use IonysDev\Pkuatia\Core\Constants\TipDocAso;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\Autofactura;
use IonysDev\Pkuatia\Core\Fields\DE\H\GCamDEAsoc;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory as F;
use IonysDev\Pkuatia\Tests\Support\RoundTrip;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Tests\Support\XsdAssertions;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Fase B/B8b, PK-35 con la decisión Q-B11 (opción A). addConstanciaDeNoSerContribuyente() fija iTipCons = 1 y recibe el
 * número y el número de control de la constancia, pero GCamDEAsoc::toDOMElement() solo los emitía con iTipCons = 2
 * (microproductores): con la constancia de no ser contribuyente se perdían en silencio. Fuentes:
 * - tgCamDEAsoc (DE_v150.xsd:1688): dNumCons es xs:positiveInteger con patrón [0-9]{11} y dNumControl tiene el patrón
 *   [0-9A-Za-z\-]{8}, los dos opcionales;
 * - MT H016/H017 (ekuat-ia 03-estructura-xml/campos-obligatorios.md:443-444): obligatorios con H014 = 2;
 * - validaciones 2430-2433 (08-errores-y-respuestas/errores-validacion.md:459-462): rechazan su falta con H014 = 2 y su
 *   presencia con H002 = 1 o 2, pero no su presencia con H002 = 3 y H014 = 1;
 * - la constancia de no ser contribuyente de la DNIT (formulario 428-1) trae un número de 11 dígitos y un número de
 *   control de 8 caracteres alfanuméricos (evidencia aportada por Abilio el 10/10/2026; los valores de estos tests
 *   son inventados).
 */
final class ConstanciaTest extends TestCase
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

  public function testLaConstanciaDeNoSerContribuyenteLlevaNumeroYControlYValida(): void
  {
    $xml = F::firmar(F::rde(F::autofactura()));

    XsdAssertions::assertRdeValido($xml, 'AF con constancia de no ser contribuyente');
    $this->assertStringContainsString('<iTipCons>1</iTipCons><dDesTipCons>Constancia de no ser contribuyente</dDesTipCons>'
      . '<dNumCons>12345678901</dNumCons><dNumControl>A1B2C3D4</dNumControl>', $xml);
  }

  /** @return array<string, array{0: int}> */
  public static function tiposDeConstancia(): array
  {
    return ['no ser contribuyente' => [1], 'microproductores' => [2]];
  }

  #[DataProvider('tiposDeConstancia')]
  public function testElNumeroSeCompletaConCerosHastaOnceDigitosYHaceIdaYVuelta(int $tipo): void
  {
    $constancia = self::constancia($tipo)->setDNumCons(12345)->setDNumControl('a1-b2c3D');

    $this->assertStringContainsString('<dNumCons>00000012345</dNumCons><dNumControl>a1-b2c3D</dNumControl>', RoundTrip::serializar($constancia));
    foreach ([RoundTrip::VIA_DOM, RoundTrip::VIA_SIMPLEXML, RoundTrip::VIA_SOAP] as $via) {
      RoundTrip::assertIdaYVueltaIdentica($constancia, $via, GCamDEAsoc::class, $via);
    }
  }

  public function testSinNumeroNiControlLaConstanciaDeNoContribuyenteSaleComoAntes(): void
  {
    $xml = RoundTrip::serializar(self::constancia(1));

    $this->assertStringContainsString('<dDesTipCons>Constancia de no ser contribuyente</dDesTipCons></gCamDEAsoc>', $xml);
    $this->assertStringNotContainsString('dNumCons', $xml);
    $this->assertStringNotContainsString('dNumControl', $xml);
  }

  /** @return array<string, array{0: int}> */
  public static function numerosInvalidos(): array
  {
    return ['cero' => [0], 'negativo' => [-5], 'doce dígitos' => [123456789012]];
  }

  #[DataProvider('numerosInvalidos')]
  public function testUnNumeroInvalidoLanzaExcepcionAlCargarlo(int $numero): void
  {
    $this->expectException(\InvalidArgumentException::class);
    $this->expectExceptionMessage('dNumCons');

    (new GCamDEAsoc())->setDNumCons($numero);
  }

  /** @return array<string, array{0: string}> */
  public static function controlesInvalidos(): array
  {
    return [
      'siete caracteres' => ['A1B2C3D'],
      'nueve caracteres' => ['A1B2C3D45'],
      'con espacio' => ['A1B2 C3D'],
      'con guion bajo' => ['A1B2_C3D'],
      'con tilde' => ['Á1B2C3D4'],
      'con salto de línea final' => ["A1B2C3D4\n"],
    ];
  }

  #[DataProvider('controlesInvalidos')]
  public function testUnControlInvalidoLanzaExcepcionAlCargarlo(string $control): void
  {
    $this->expectException(\InvalidArgumentException::class);
    $this->expectExceptionMessage('dNumControl');

    (new GCamDEAsoc())->setDNumControl($control);
  }

  public function testElMetodoDeLaAutofacturaValidaAlCargar(): void
  {
    $this->expectException(\InvalidArgumentException::class);

    // Los valores que usaba la factory de pruebas hasta 0.2.0: el control tiene 10 caracteres.
    (new Autofactura(1))->addConstanciaDeNoSerContribuyente(12345, '1234567890');
  }

  private static function constancia(int $tipo): GCamDEAsoc
  {
    return (new GCamDEAsoc())->setITipDocAso(TipDocAso::ConstanciaElectronica)->setITipCons($tipo);
  }
}
