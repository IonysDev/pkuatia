<?php

namespace IonysDev\Pkuatia\Tests\Unit\Fields;

use DOMDocument;
use IonysDev\Pkuatia\Core\Fields\DE\G\GCamCarg;
use PHPUnit\Framework\TestCase;

/**
 * Port a PHPUnit de test/GCamCargTest.php (script legado, Fase D, D11): las descripciones opcionales de gCamCarg
 * (dDesUniMedTotVol, dDesUniMedTotPes, dDesCarCarga) se omiten cuando no se informan, se emiten tal cual cuando sí,
 * se truncan a los máximos del XSD (10, 10 y 50) y un setter con cadena vacía o null deja el valor en null. Caso 6:
 * cUniMedTotVol emite su propio valor y no copia el de cUniMedTotPes (defecto histórico). Mismos literales y casos.
 */
final class GCamCargDescripcionesTest extends TestCase
{
    private static function conEnteros(): GCamCarg
    {
        // Setea los enteros directamente: los setters dependen de UnidadMedidaMapping y mezclarían su autopoblado de
        // descripciones con los casos del test (igual que el script legado).
        $g = new GCamCarg();
        $g->cUniMedTotVol = 87;
        $g->dTotVolMerc = 100;
        $g->cUniMedTotPes = 99;
        $g->dTotPesMerc = 50;
        $g->iCarCarga = 1;
        return $g;
    }

    private static function xml(GCamCarg $g): string
    {
        $doc = new DOMDocument('1.0', 'UTF-8');
        $doc->appendChild($g->toDOMElement($doc));
        return $doc->saveXML($doc->documentElement);
    }

    public function testSinDescripcionesNoSeEmiten(): void
    {
        $xml = self::xml(self::conEnteros());
        $this->assertStringNotContainsString('<dDesUniMedTotVol', $xml);
        $this->assertStringNotContainsString('<dDesUniMedTotPes', $xml);
        $this->assertStringNotContainsString('<dDesCarCarga', $xml);
    }

    public function testCadaDescripcionSeEmiteSolaYTalCual(): void
    {
        $xml = self::xml(self::conEnteros()->setDDesUniMedTotVol('m3'));
        $this->assertStringContainsString('<dDesUniMedTotVol>m3</dDesUniMedTotVol>', $xml);
        $this->assertStringNotContainsString('<dDesUniMedTotPes', $xml);
        $this->assertStringNotContainsString('<dDesCarCarga', $xml);

        $xml = self::xml(self::conEnteros()->setDDesUniMedTotPes('KG'));
        $this->assertStringNotContainsString('<dDesUniMedTotVol', $xml);
        $this->assertStringContainsString('<dDesUniMedTotPes>KG</dDesUniMedTotPes>', $xml, 'descripción real, no el código');
        $this->assertStringNotContainsString('<dDesCarCarga', $xml);

        $xml = self::xml(self::conEnteros()->setDDesCarCarga('Mercaderias con cadena de frio'));
        $this->assertStringNotContainsString('<dDesUniMedTotVol', $xml);
        $this->assertStringNotContainsString('<dDesUniMedTotPes', $xml);
        $this->assertStringContainsString('<dDesCarCarga>Mercaderias con cadena de frio</dDesCarCarga>', $xml);
    }

    public function testLasTresJuntas(): void
    {
        $xml = self::xml(self::conEnteros()->setDDesUniMedTotVol('m3')->setDDesUniMedTotPes('KG')->setDDesCarCarga('Carga peligrosa'));
        $this->assertStringContainsString('<dDesUniMedTotVol>m3</dDesUniMedTotVol>', $xml);
        $this->assertStringContainsString('<dDesUniMedTotPes>KG</dDesUniMedTotPes>', $xml);
        $this->assertStringContainsString('<dDesCarCarga>Carga peligrosa</dDesCarCarga>', $xml);
    }

    public function testCUniMedTotVolEmiteSuPropioValor(): void
    {
        $xml = self::xml(self::conEnteros()); // cUniMedTotVol = 87, cUniMedTotPes = 99
        $this->assertStringContainsString('<cUniMedTotVol>87</cUniMedTotVol>', $xml, 'no copia el de cUniMedTotPes');
        $this->assertStringContainsString('<cUniMedTotPes>99</cUniMedTotPes>', $xml);
    }

    public function testSeTruncanALosMaximosDelXsd(): void
    {
        $g = (new GCamCarg())
            ->setDDesUniMedTotVol(str_repeat('A', 30))
            ->setDDesUniMedTotPes(str_repeat('B', 30))
            ->setDDesCarCarga(str_repeat('C', 80));
        $this->assertSame(10, strlen($g->getDDesUniMedTotVol()));
        $this->assertSame(10, strlen($g->getDDesUniMedTotPes()));
        $this->assertSame(50, strlen($g->getDDesCarCarga()));
    }

    public function testVacioYNullDejanNull(): void
    {
        $g = (new GCamCarg())->setDDesCarCarga('algo')->setDDesCarCarga('');
        $this->assertNull($g->getDDesCarCarga(), 'la cadena vacía limpia el valor');

        $g = (new GCamCarg())->setDDesUniMedTotVol(null)->setDDesUniMedTotPes(null)->setDDesCarCarga(null);
        $this->assertNull($g->getDDesUniMedTotVol());
        $this->assertNull($g->getDDesUniMedTotPes());
        $this->assertNull($g->getDDesCarCarga());
    }
}
