<?php

namespace IonysDev\Pkuatia\Tests\Unit\Fields;

use DOMDocument;
use IonysDev\Pkuatia\Core\Constants\PaConEIniTiPago;
use IonysDev\Pkuatia\Core\Fields\DE\E\GPaConEIni;
use PHPUnit\Framework\TestCase;
use stdClass;

final class GPaConEIniTest extends TestCase
{
  public function testFromSifenResponseObjectRoundTripPopulatesDDesTiPag(): void
  {
    $object = new stdClass();
    $object->iTiPago = PaConEIniTiPago::Efectivo->value;
    $object->dMonTiPag = '100000';
    $object->cMoneTiPag = 'PYG';

    $field = GPaConEIni::FromSifenResponseObject($object);
    $this->assertSame(PaConEIniTiPago::Efectivo->value, $field->iTiPago);
    $this->assertNotEmpty($field->dDesTiPag);
    $this->assertSame(PaConEIniTiPago::Efectivo->getDescription(), $field->dDesTiPag);

    $doc = new DOMDocument('1.0', 'UTF-8');
    $node = $field->toDOMElement($doc);
    $doc->appendChild($node);
    $xml = $doc->saveXML($node);

    $this->assertStringContainsString('<dDesTiPag>', $xml);
    $this->assertStringContainsString($field->dDesTiPag, $xml);
  }
}
