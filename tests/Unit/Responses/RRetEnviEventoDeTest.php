<?php

namespace IonysDev\Pkuatia\Tests\Unit\Responses;

use IonysDev\Pkuatia\Core\Responses\RRetEnviEventoDe;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

final class RRetEnviEventoDeTest extends TestCase
{
  public function testFromSimpleXMLElementParsesMultipleGResProcEVe(): void
  {
    $xml = <<<'XML'
<rRetEnviEventoDe>
  <dFecProc>2026-01-15T10:00:00</dFecProc>
  <gResProcEVe>
    <dEstRes>Aprobado</dEstRes>
    <id>1</id>
    <gResProc><dCodRes>0600</dCodRes><dMsgRes>OK primero</dMsgRes></gResProc>
  </gResProcEVe>
  <gResProcEVe>
    <dEstRes>Aprobado</dEstRes>
    <id>2</id>
    <gResProc><dCodRes>0600</dCodRes><dMsgRes>OK segundo</dMsgRes></gResProc>
  </gResProcEVe>
</rRetEnviEventoDe>
XML;

    $result = RRetEnviEventoDe::FromSimpleXMLElement(new SimpleXMLElement($xml));

    $this->assertCount(2, $result->getGResProcEVe());
    $this->assertSame('OK segundo', $result->getGResProcEVe()[1]->getGResProc()[0]->dMsgRes);
  }

  public function testCorrectAliasesDelegateToLegacyTypoMethods(): void
  {
    $legacy = new RRetEnviEventoDe();
    $legacy->seGResProcEVe([]);

    $this->assertSame([], $legacy->getGResProcEVe());
    $this->assertSame([], $legacy->geGResProcEVe());
  }
}
