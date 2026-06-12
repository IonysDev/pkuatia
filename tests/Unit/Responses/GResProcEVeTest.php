<?php

namespace IonysDev\Pkuatia\Tests\Unit\Responses;

use IonysDev\Pkuatia\Core\Fields\Response\Event\GResProcEVe;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

final class GResProcEVeTest extends TestCase
{
  public function testFromSimpleXMLElementParsesMultipleGResProc(): void
  {
    $xml = <<<'XML'
<gResProcEVe>
  <dEstRes>Aprobado</dEstRes>
  <id>1</id>
  <gResProc><dCodRes>0600</dCodRes><dMsgRes>OK primero</dMsgRes></gResProc>
  <gResProc><dCodRes>0601</dCodRes><dMsgRes>OK segundo</dMsgRes></gResProc>
</gResProcEVe>
XML;

    $node = new SimpleXMLElement($xml);
    $result = GResProcEVe::FromSimpleXMLElement($node);

    $this->assertCount(2, $result->getGResProc());
    $this->assertSame('0600', (string) $result->getGResProc()[0]->dCodRes);
    $this->assertSame('OK segundo', $result->getGResProc()[1]->dMsgRes);
  }
}
