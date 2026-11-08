<?php

namespace IonysDev\Pkuatia\Tests\Unit\Utils;

use IonysDev\Pkuatia\Utils\ValueValidations;
use PHPUnit\Framework\TestCase;

/**
 * PK-16: isValidStringDecimal debe validar la longitud de la parte entera y la cantidad de decimales
 * tal como los tipos numéricos del XSD (tMontoBase 15/8, tMontoBase4 15/4, tdCRed 4/4, tPorcDesc8 3/8,
 * tTipoCambioBase 5/4, tdCantProSer 10/8, tLectura 11/2; DE_Types_v150.xsd). La regex anterior
 * `(\.{min,max})` contaba puntos: aceptaba '1000' con parte entera de 3 y rechazaba '100.50' con mínimo 2.
 */
final class ValueValidationsTest extends TestCase
{
    /**
     * @return array<string, array{string, int, int, int, bool}>
     */
    public static function casos(): array
    {
        return [
          // valor, enteros, mínDecimales, máxDecimales, esperado
          'entero dentro del límite'          => ['999', 3, 0, 8, true],
          'entero excede la parte entera'     => ['1000', 3, 0, 8, false],
          'entero largo excede'               => ['12345678901', 3, 0, 8, false],
          'decimales dentro del máximo'       => ['99.12345678', 3, 0, 8, true],
          'nueve decimales exceden'           => ['99.123456789', 3, 0, 8, false],
          'tdCRed cuatro decimales'           => ['0.1234', 4, 0, 4, true],
          'tdCRed cinco decimales'            => ['0.12345', 4, 0, 4, false],
          'mínimo de decimales cumplido'      => ['100.50', 15, 2, 4, true],
          'mínimo de decimales incumplido'    => ['100.5', 15, 2, 4, false],
          'sin decimales con mínimo'          => ['100', 15, 2, 4, false],
          'monto bcmath a escala 8'           => ['100000.00000000', 15, 0, 8, true],
          'cero'                              => ['0', 15, 0, 8, true],
          'cero con decimales'                => ['0.00000000', 15, 0, 8, true],
          'doble punto'                       => ['123..45', 3, 0, 8, false],
          'punto sin decimales'               => ['5.', 15, 0, 8, false],
          'coma decimal'                      => ['100,50', 15, 0, 8, false],
          'negativo'                          => ['-5', 3, 0, 8, false],
          'notación científica'               => ['1e5', 15, 0, 8, false],
          'espacio inicial'                   => [' 5', 15, 0, 8, false],
          'vacío'                             => ['', 15, 0, 8, false],
          'texto'                             => ['abc', 3, 0, 8, false],
          'quince enteros'                    => ['999999999999999.99999999', 15, 0, 8, true],
          'dieciséis enteros'                 => ['1999999999999999', 15, 0, 8, false],
        ];
    }

    /**
     * @dataProvider casos
     */
    public function testIsValidStringDecimal(string $valor, int $enteros, int $min, int $max, bool $esperado): void
    {
        $this->assertSame($esperado, ValueValidations::isValidStringDecimal($valor, $enteros, $min, $max), "valor '$valor' ($enteros, $min, $max)");
    }

    public function testDevuelveBoolParaQueLasComparacionesEstrictasFuncionen(): void
    {
        // Factura::setOperacionCreditoEnCuotas compara con `=== false`: con la implementación anterior
        // (que devolvía el int de preg_match) la validación nunca se disparaba.
        $this->assertFalse(ValueValidations::isValidStringDecimal('abc', 15, 0, 4));
        $this->assertTrue(ValueValidations::isValidStringDecimal('10', 15, 0, 4));
    }

    public function testParametrosInvalidosLanzanExcepcion(): void
    {
        $this->expectException(\Exception::class);
        ValueValidations::isValidStringDecimal('1', 3, 5, 2);
    }

    /**
     * Port de test/Utils/ValueValidationsTest.php (script legado que imprimía sin aserciones; Fase D, D11): los siete
     * valores de muestra con isValidStringDecimal($valor, 10, 1, 8) y el resultado que el script anotaba para cada uno.
     *
     * @return array<string, array{0: string, 1: bool}>
     */
    public static function valoresDelScriptLegado(): array
    {
        return [
            '13245.222 válido' => ['13245.222', true],
            '0x25551 hexadecimal' => ['0x25551', false],
            '12225 sin decimales (mínimo 1)' => ['12225', false],
            '122256 sin decimales' => ['122256', false],
            '1234567890123456.5555 parte entera larga' => ['1234567890123456.5555', false],
            '123456789.12345678 ocho decimales' => ['123456789.12345678', true],
            '123456789,123456789 coma decimal' => ['123456789,123456789', false],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('valoresDelScriptLegado')]
    public function testLosValoresDelScriptLegado(string $valor, bool $esperado): void
    {
        $this->assertSame($esperado, ValueValidations::isValidStringDecimal($valor, 10, 1, 8), $valor);
    }
}
