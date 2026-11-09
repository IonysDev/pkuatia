<?php

namespace IonysDev\Pkuatia\Tests\Unit\Constants;

use IonysDev\Pkuatia\Core\Constants\CamCondOpe;
use IonysDev\Pkuatia\Core\Constants\EnumDescripcion;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionEnum;

/**
 * Fase D, D6 (evaluación §8: los 36 enums repetían literalmente getDescriptionFromValue(), getValueDescriptionMap() y
 * toIdNameList()). El trait EnumDescripcion los reúne; cada enum debe conservar los tres métodos con el mismo
 * resultado que antes y ninguna firma cambia (volcado de la API por reflexión).
 */
final class EnumDescripcionTest extends TestCase
{
    /** @return array<string, array{0: class-string}> */
    public static function enumsConDescripcion(): array
    {
        $res = [];
        foreach (glob(__DIR__ . '/../../../src/Core/Constants/*.php') as $f) {
            $nombre = basename($f, '.php');
            $fqcn = 'IonysDev\\Pkuatia\\Core\\Constants\\' . $nombre;
            if (!enum_exists($fqcn) || !method_exists($fqcn, 'getDescription')) {
                continue;
            }
            $res[$nombre] = [$fqcn];
        }
        return $res;
    }

    public function testSonTreintaYSeisYLosDeLaFaseCNo(): void
    {
        $this->assertCount(36, self::enumsConDescripcion());
        foreach (['CodigoResultadoWS', 'CategoriaCodigoWS', 'EstadoResultado', 'EstadoRuc', 'MotivoCertificado', 'TipoFallaTransporte'] as $enum) {
            $fqcn = 'IonysDev\\Pkuatia\\Core\\Constants\\' . $enum;
            $this->assertNotContains(EnumDescripcion::class, class_uses($fqcn), "$enum no modela código → descripción del MT");
        }
    }

    #[DataProvider('enumsConDescripcion')]
    public function testUsaElTraitYLosTresMetodosDanLoMismoQueLosCasos(string $enum): void
    {
        $this->assertContains(EnumDescripcion::class, class_uses($enum));
        $re = new ReflectionEnum($enum);
        $this->assertTrue($re->isBacked(), "$enum debe ser respaldado para tryFrom()");

        $mapa = [];
        $lista = [];
        foreach ($enum::cases() as $caso) {
            $mapa[$caso->value] = $caso->getDescription();
            $lista[] = ['id' => $caso->value, 'name' => $caso->getDescription()];
            $this->assertSame($caso->getDescription(), $enum::getDescriptionFromValue($caso->value));
            $this->assertSame($caso->getDescription(), $enum::getDescriptionFromValue((string) $caso->value), 'acepta el valor como texto');
        }
        $this->assertSame($mapa, $enum::getValueDescriptionMap());
        $this->assertSame($lista, $enum::toIdNameList());
        $inexistente = (string) $re->getBackingType() === 'int' ? 999999 : 'ZZZ_INEXISTENTE';
        $this->assertNull($enum::getDescriptionFromValue($inexistente));
    }

    public function testEjemploConcreto(): void
    {
        $this->assertSame('Crédito', CamCondOpe::getDescriptionFromValue(2));
        $this->assertSame([1 => 'Contado', 2 => 'Crédito'], CamCondOpe::getValueDescriptionMap());
        $this->assertSame([['id' => 1, 'name' => 'Contado'], ['id' => 2, 'name' => 'Crédito']], CamCondOpe::toIdNameList());
    }
}
