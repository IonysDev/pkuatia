<?php

namespace IonysDev\Pkuatia\Tests\Unit\Utils;

use InvalidArgumentException;
use IonysDev\Pkuatia\Core\Fields\DE\E\GGrupSup;
use IonysDev\Pkuatia\Core\Fields\DE\E\GVehNuevo;
use IonysDev\Pkuatia\Utils\DecimalXsd;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Helper común de montos y medidas xs:decimal (paso C1 de la Fase C). Fuente: DE_Types_v150.xsd:1290-1314
 * (tMontoBase4: totalDigits 19, fractionDigits 4; tMontoBase6: totalDigits 10, fractionDigits 4). Mismo criterio y
 * mismos mensajes que GGrupSup::monto() (Q-B10) y GVehNuevo::monto() (Q-B12), que pasan a delegar en él.
 */
final class DecimalXsdTest extends TestCase
{
  /** @return iterable<string, array{string, string}> */
  public static function textosNormalizados(): iterable
  {
    yield 'entero' => ['5', '5'];
    yield 'signo más' => ['+5', '5'];
    yield 'punto final' => ['5.', '5'];
    yield 'punto inicial' => ['.5', '0.5'];
    yield 'exponencial' => ['1e3', '1000'];
    yield 'negativo' => ['-1.5', '-1.5'];
    yield 'ceros que no cuentan para los límites' => ['0001.2500', '0001.2500'];
    yield 'espacios alrededor' => [' 12.25 ', '12.25'];
  }

  #[DataProvider('textosNormalizados')]
  public function testNormalizaLosTextosNumericos(string $valor, string $esperado): void
  {
    $this->assertSame($esperado, DecimalXsd::normalizar($valor, 'campo', 10));
  }

  public function testAceptaEnteros(): void
  {
    $this->assertSame('1234567890', DecimalXsd::normalizar(1234567890, 'campo', 10));
  }

  /** @return iterable<string, array{string, int, int, string}> */
  public static function fueraDeLimites(): iterable
  {
    yield 'once enteros con total 10' => ['12345678901', 10, 4, 'admite hasta 10 dígitos, de los cuales hasta 4 decimales'];
    yield 'cinco decimales' => ['1.12345', 10, 4, 'hasta 4 decimales'];
    yield 'suma de enteros y decimales' => ['1234567.1234', 10, 4, 'admite hasta 10 dígitos'];
    yield 'dos decimales permitidos' => ['1.123', 10, 2, 'hasta 2 decimales'];
  }

  #[DataProvider('fueraDeLimites')]
  public function testRechazaLosValoresFueraDelTipo(string $valor, int $total, int $decimales, string $mensaje): void
  {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage($mensaje);
    DecimalXsd::normalizar($valor, 'campo', $total, $decimales);
  }

  public function testRechazaLoQueNoEsNumero(): void
  {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage("[GGrupSup] dEfectivo debe ser un número decimal: 'abc'");
    DecimalXsd::normalizar('abc', 'dEfectivo', 19, 4, '[GGrupSup]');
  }

  public function testElMensajeDeLimiteCitaElTipo(): void
  {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage("[GVehNuevo] dPNet admite hasta 10 dígitos, de los cuales hasta 4 decimales (tMontoBase6): '1.12345'");
    DecimalXsd::normalizar('1.12345', 'dPNet', 10, 4, '[GVehNuevo]', 'tMontoBase6');
  }

  public function testExactoRespetaLaPropiedadEnteraAsignadaDirectamente(): void
  {
    $this->assertSame('5.25', DecimalXsd::exacto('5.25', 5));
    $this->assertSame('6', DecimalXsd::exacto('5.25', 6));
    $this->assertSame('7', DecimalXsd::exacto(null, 7));
  }

  public function testEsValidoNoLanza(): void
  {
    $this->assertTrue(DecimalXsd::esValido('1.1234', 10));
    $this->assertTrue(DecimalXsd::esValido(1000, 10));
    $this->assertFalse(DecimalXsd::esValido('1.12345', 10));
    $this->assertFalse(DecimalXsd::esValido('abc', 10));
    $this->assertFalse(DecimalXsd::esValido('12345678901', 10));
    $this->assertFalse(DecimalXsd::esValido(null, 10));
  }

  /** Los grupos que ya validaban decimales conservan sus mensajes al delegar en el helper. */
  public function testLosGruposConservanSusMensajes(): void
  {
    try {
      (new GGrupSup())->setDVuelto('12345678901');
      $this->fail('GGrupSup debía rechazar el monto');
    } catch (InvalidArgumentException $e) {
      $this->assertSame("[GGrupSup] dVuelto admite hasta 10 dígitos, de los cuales hasta 4 decimales (DE_Types_v150.xsd): '12345678901'", $e->getMessage());
    }
    try {
      (new GVehNuevo())->setDPNet('x');
      $this->fail('GVehNuevo debía rechazar la medida');
    } catch (InvalidArgumentException $e) {
      $this->assertSame("[GVehNuevo] dPNet debe ser un número decimal: 'x'", $e->getMessage());
    }
  }
}
