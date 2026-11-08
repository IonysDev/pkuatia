<?php

namespace IonysDev\Pkuatia\Tests\Unit\Utils;

use IonysDev\Pkuatia\DataMappings\CountryMapping;
use IonysDev\Pkuatia\DataMappings\DepartamentoMapping;
use IonysDev\Pkuatia\DataMappings\MonedaMapping;
use IonysDev\Pkuatia\DataMappings\PyGeoCodesMapping;
use IonysDev\Pkuatia\DataMappings\UnidadMedidaMapping;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Fase D, D7 (deuda D-B4): CountryMapping, DepartamentoMapping y PyGeoCodesMapping releían y reparseaban su XML en
 * cada llamada a getArray(); ahora cachean el catálogo en una estática, como MonedaMapping y UnidadMedidaMapping
 * desde la Fase B. El arreglo se devuelve por valor: quien lo recibe no puede alterar la caché.
 */
final class CacheCatalogosTest extends TestCase
{
    /** @return array<string, array{0: class-string}> */
    public static function catalogos(): array
    {
        return [
            'CountryMapping' => [CountryMapping::class],
            'DepartamentoMapping' => [DepartamentoMapping::class],
            'PyGeoCodesMapping' => [PyGeoCodesMapping::class],
            'MonedaMapping' => [MonedaMapping::class],
            'UnidadMedidaMapping' => [UnidadMedidaMapping::class],
        ];
    }

    #[DataProvider('catalogos')]
    public function testGetArrayCacheaYDevuelvePorValor(string $clase): void
    {
        $prop = (new ReflectionClass($clase))->getProperty('catalogo');
        $prop->setAccessible(true);
        $prop->setValue(null, null);
        $this->assertNull($prop->getValue());

        $primera = $clase::getArray();
        $this->assertIsArray($primera);
        $this->assertNotEmpty($primera);
        $this->assertSame($primera, $prop->getValue(), 'la primera llamada llena la caché');

        $copia = $primera;
        $copia['manipulado'] = true;
        $this->assertSame($primera, $clase::getArray(), 'la segunda llamada devuelve lo mismo y la caché no se alteró');
        $this->assertArrayNotHasKey('manipulado', $prop->getValue());
    }

    public function testLosLectoresSiguenRespondiendoIgual(): void
    {
        $this->assertSame('Paraguay', CountryMapping::getCountryDesc('PRY'));
        $this->assertSame('CAPITAL', DepartamentoMapping::getDepName(1));
        $this->assertSame('ASUNCION (DISTRITO)', PyGeoCodesMapping::getDistName(1));
        $this->assertTrue(PyGeoCodesMapping::estanRelacionados(1, 1, 1));
    }
}
