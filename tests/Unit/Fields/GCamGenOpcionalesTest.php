<?php

namespace IonysDev\Pkuatia\Tests\Unit\Fields;

use DOMDocument;
use IonysDev\Pkuatia\Core\Fields\DE\G\GCamGen;
use PHPUnit\Framework\TestCase;

/**
 * Port a PHPUnit de test/GCamGenTest.php (script legado, Fase D, D11): los tres campos opcionales de gCamGen
 * (dOrdCompra, dOrdVta, dAsiento) se omiten cuando no se informan (gCamGen vacío se serializa autocerrado), se
 * emiten tal cual cuando sí, se truncan a los máximos del XSD (15, 15 y 10) y un setter con cadena vacía o null deja
 * el valor en null. Mismos literales y casos.
 */
final class GCamGenOpcionalesTest extends TestCase
{
    private static function xml(GCamGen $g): string
    {
        $doc = new DOMDocument('1.0', 'UTF-8');
        $doc->appendChild($g->toDOMElement($doc));
        return $doc->saveXML($doc->documentElement);
    }

    public function testVacioSeSerializaAutocerrado(): void
    {
        $xml = self::xml(new GCamGen());
        $this->assertStringNotContainsString('<dOrdCompra', $xml);
        $this->assertStringNotContainsString('<dOrdVta', $xml);
        $this->assertStringNotContainsString('<dAsiento', $xml);
        $this->assertSame('<gCamGen/>', $xml);
    }

    public function testCadaCampoSeEmiteSoloYTalCual(): void
    {
        $xml = self::xml((new GCamGen())->setDOrdCompra('PO-123'));
        $this->assertStringContainsString('<dOrdCompra>PO-123</dOrdCompra>', $xml);
        $this->assertStringNotContainsString('<dOrdVta', $xml);
        $this->assertStringNotContainsString('<dAsiento', $xml);

        $xml = self::xml((new GCamGen())->setDOrdVta('SO-456'));
        $this->assertStringNotContainsString('<dOrdCompra', $xml);
        $this->assertStringContainsString('<dOrdVta>SO-456</dOrdVta>', $xml);
        $this->assertStringNotContainsString('<dAsiento', $xml);

        $xml = self::xml((new GCamGen())->setDAsiento('AS-789'));
        $this->assertStringNotContainsString('<dOrdCompra', $xml);
        $this->assertStringNotContainsString('<dOrdVta', $xml);
        $this->assertStringContainsString('<dAsiento>AS-789</dAsiento>', $xml);
    }

    public function testLosTresJuntos(): void
    {
        $xml = self::xml((new GCamGen())->setDOrdCompra('PO-1')->setDOrdVta('SO-2')->setDAsiento('AS-3'));
        $this->assertStringContainsString('<dOrdCompra>PO-1</dOrdCompra>', $xml);
        $this->assertStringContainsString('<dOrdVta>SO-2</dOrdVta>', $xml);
        $this->assertStringContainsString('<dAsiento>AS-3</dAsiento>', $xml);
    }

    public function testSeTruncanALosMaximosDelXsd(): void
    {
        $g = (new GCamGen())->setDOrdCompra(str_repeat('A', 30))->setDOrdVta(str_repeat('B', 30))->setDAsiento(str_repeat('C', 30));
        $this->assertSame(15, strlen($g->getDOrdCompra()));
        $this->assertSame(15, strlen($g->getDOrdVta()));
        $this->assertSame(10, strlen($g->getDAsiento()));
    }

    public function testVacioYNullDejanNull(): void
    {
        $this->assertNull((new GCamGen())->setDOrdCompra('PO-123')->setDOrdCompra('')->getDOrdCompra(), 'la cadena vacía limpia el valor');
        $g = (new GCamGen())->setDOrdVta(null)->setDAsiento(null);
        $this->assertNull($g->getDOrdVta());
        $this->assertNull($g->getDAsiento());
    }
}
