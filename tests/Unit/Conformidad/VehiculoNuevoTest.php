<?php

namespace IonysDev\Pkuatia\Tests\Unit\Conformidad;

use IonysDev\Pkuatia\Core\Fields\DE\E\GVehNuevo;
use IonysDev\Pkuatia\Tests\Support\RoundTrip;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Fase B/B12b, decisión Q-B12 (opción A, como Q-B10). En tgVehNuevo (DE_v150.xsd) el peso neto (E777, dPNet), el peso
 * bruto (E778, dPBruto) y la capacidad máxima de tracción (E782, dCapTracc) son tMontoBase6: xs:decimal de hasta 10
 * dígitos, 4 de ellos decimales (DE_Types_v150.xsd:1308-1314). GVehNuevo los guardaba como int: no se podía informar un
 * valor con decimales y al leerlo se truncaba. Desde 0.2.1 los setters aceptan int|String, el XML lleva el valor exacto,
 * get*Decimal() lo devuelve y los getters y propiedades enteros quedan obsoletos con la parte entera.
 */
final class VehiculoNuevoTest extends TestCase
{
  public function testLasMedidasConDecimalesSeEmitenExactas(): void
  {
    $vehiculo = self::vehiculo()->setDPNet('1450.75')->setDPBruto('1600.5')->setDCapTracc('2500.1234');

    $xml = RoundTrip::serializar($vehiculo);

    $this->assertStringContainsString('<dPNet>1450.75</dPNet><dPBruto>1600.5</dPBruto>', $xml);
    $this->assertStringContainsString('<dCapTracc>2500.1234</dCapTracc>', $xml);
    $this->assertSame(['1450.75', '1600.5', '2500.1234'], [$vehiculo->getDPNetDecimal(), $vehiculo->getDPBrutoDecimal(), $vehiculo->getDCapTraccDecimal()]);
    $this->assertSame([1450, 1600, 2500], [$vehiculo->getDPNet(), $vehiculo->getDPBruto(), $vehiculo->getDCapTracc()]);
  }

  public function testLosEnterosSeEmitenComoAntes(): void
  {
    $vehiculo = self::vehiculo()->setDPNet(1200)->setDPBruto(1500)->setDCapTracc(1500);

    $this->assertStringContainsString('<dPNet>1200</dPNet><dPBruto>1500</dPBruto>', RoundTrip::serializar($vehiculo));
    $this->assertSame('1200', $vehiculo->getDPNetDecimal());
    $this->assertSame(1200, $vehiculo->getDPNet());
  }

  public function testSinMedidasLosGettersDevuelvenNull(): void
  {
    $vehiculo = self::vehiculo();

    $this->assertNull($vehiculo->getDPNetDecimal());
    $this->assertNull($vehiculo->getDPBrutoDecimal());
    $this->assertNull($vehiculo->getDCapTraccDecimal());
    $this->assertStringNotContainsString('dPNet', RoundTrip::serializar($vehiculo));
  }

  /** @return array<string, array{0: string}> */
  public static function vias(): array
  {
    return ['DOM' => [RoundTrip::VIA_DOM], 'SimpleXML' => [RoundTrip::VIA_SIMPLEXML], 'objeto SOAP' => [RoundTrip::VIA_SOAP]];
  }

  #[DataProvider('vias')]
  public function testLaLecturaConservaLosDecimales(string $via): void
  {
    $vehiculo = self::vehiculo()->setDPNet('1450.75')->setDPBruto('1600.5')->setDCapTracc('2500.1234');

    RoundTrip::assertIdaYVueltaIdentica($vehiculo, $via, GVehNuevo::class);
    $leido = RoundTrip::leer(RoundTrip::serializar($vehiculo), GVehNuevo::class, $via);
    $this->assertSame('1450.75', $leido->getDPNetDecimal());
  }

  /** @return array<string, array{0: string, 1: int|string}> */
  public static function valoresInvalidos(): array
  {
    return [
      'cinco decimales' => ['setDPNet', '12.34567'],
      'once dígitos' => ['setDPBruto', '12345678901'],
      'texto' => ['setDCapTracc', 'abc'],
      'coma decimal' => ['setDPNet', '1450,75'],
    ];
  }

  #[DataProvider('valoresInvalidos')]
  public function testUnValorInvalidoLanzaExcepcion(string $setter, int|string $valor): void
  {
    $this->expectException(\InvalidArgumentException::class);
    $this->expectExceptionMessage(lcfirst(substr($setter, 3)));

    self::vehiculo()->$setter($valor);
  }

  private static function vehiculo(): GVehNuevo
  {
    return (new GVehNuevo())->setITipOpVN(2)->setDChasis('9BWZZZ377VT004251')->setITipCom(1);
  }
}
