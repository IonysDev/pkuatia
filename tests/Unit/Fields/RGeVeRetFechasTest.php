<?php

namespace IonysDev\Pkuatia\Tests\Unit\Fields;

use DateTime;
use DOMDocument;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GEA\RGeVeRetAce;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GEA\RGeVeRetAnu;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

/**
 * Eventos de retención (GER001) y de anulación de retención (GERA001).
 *
 * En el XSD (Evento_v150.xsd) dFeEmiRet y dFecAnRet son de tipo fecHhmmss:
 * AAAA-MM-DDThh:mm:ss. Así los devuelve el SIFEN dentro de xContEv al consultar
 * un DE, y así deben generarse.
 */
final class RGeVeRetFechasTest extends TestCase
{
  private const CDC = '01800000005001001000000122026012010000000015';

  public function testRGeVeRetAceLeeLaFechaConHoraDelSifen(): void
  {
    $evento = RGeVeRetAce::FromSimpleXMLElement(new SimpleXMLElement(
      '<rGeVeRetAce>'
      . '<Id>' . self::CDC . '</Id>'
      . '<dRuc>80000000</dRuc>'
      . '<dNumTimRet>12345678</dNumTimRet>'
      . '<dEstRet>001</dEstRet>'
      . '<dPunExpRet>002</dPunExpRet>'
      . '<dNumDocRet>0000123</dNumDocRet>'
      . '<dCodConRet>a1b2c3d4</dCodConRet>'
      . '<dFeEmiRet>2026-01-20T00:00:00</dFeEmiRet>'
      . '<dMonRet>100000.0</dMonRet>'
      . '</rGeVeRetAce>'
    ));

    $this->assertSame(12345678, $evento->getDNumTimRet());
    $this->assertSame('0000123', $evento->getDNumDocRet());
    $this->assertSame('2026-01-20T00:00:00', $evento->getDFeEmiRet()->format('Y-m-d\TH:i:s'));
  }

  public function testRGeVeRetAnuLeeLasFechasConHoraDelSifen(): void
  {
    $evento = RGeVeRetAnu::FromSimpleXMLElement(new SimpleXMLElement(
      '<rGeVeRetAnu>'
      . '<Id>' . self::CDC . '</Id>'
      . '<dRuc>80000000</dRuc>'
      . '<dNumTimRet>12345678</dNumTimRet>'
      . '<dEstRet>001</dEstRet>'
      . '<dPunExpRet>002</dPunExpRet>'
      . '<dNumDocRet>0000123</dNumDocRet>'
      . '<dCodConRet>a1b2c3d4</dCodConRet>'
      . '<dFeEmiRet>2026-01-20T00:00:00</dFeEmiRet>'
      . '<dFecAnRet>2026-01-21T09:15:00</dFecAnRet>'
      . '<dMonRet>100000.0</dMonRet>'
      . '</rGeVeRetAnu>'
    ));

    $this->assertSame(12345678, $evento->getDNumTimRet());
    $this->assertSame('2026-01-20T00:00:00', $evento->getDFeEmiRet()->format('Y-m-d\TH:i:s'));
    $this->assertSame('2026-01-21T09:15:00', $evento->getDFecAnRet()->format('Y-m-d\TH:i:s'));
  }

  public function testRGeVeRetAceGeneraLaFechaConHora(): void
  {
    $evento = (new RGeVeRetAce())
      ->setId(self::CDC)
      ->setDNumTimRet(12345678)
      ->setDEstRet('001')
      ->setDPunExpRet('002')
      ->setDNumDocRet('0000123')
      ->setDCodConRet('a1b2c3d4')
      ->setDFeEmiRet(new DateTime('2026-01-20T10:30:00'));

    $xml = $this->toXml($evento);

    $this->assertStringContainsString('<dFeEmiRet>2026-01-20T10:30:00</dFeEmiRet>', $xml);
  }

  public function testRGeVeRetAnuGeneraLasFechasConHora(): void
  {
    $evento = (new RGeVeRetAnu())
      ->setId(self::CDC)
      ->setDNumTimRet(12345678)
      ->setDEstRet('001')
      ->setDPunExpRet('002')
      ->setDNumDocRet('0000123')
      ->setDCodConRet('a1b2c3d4')
      ->setDFeEmiRet(new DateTime('2026-01-20T10:30:00'))
      ->setDFecAnRet(new DateTime('2026-01-21T09:15:00'));

    $xml = $this->toXml($evento);

    $this->assertStringContainsString('<dFeEmiRet>2026-01-20T10:30:00</dFeEmiRet>', $xml);
    $this->assertStringContainsString('<dFecAnRet>2026-01-21T09:15:00</dFecAnRet>', $xml);
  }

  public function testRGeVeRetAnuIdaYVueltaConservaLasFechas(): void
  {
    $original = (new RGeVeRetAnu())
      ->setId(self::CDC)
      ->setDNumTimRet(12345678)
      ->setDEstRet('001')
      ->setDPunExpRet('002')
      ->setDNumDocRet('0000123')
      ->setDCodConRet('a1b2c3d4')
      ->setDFeEmiRet(new DateTime('2026-01-20T10:30:00'))
      ->setDFecAnRet(new DateTime('2026-01-21T09:15:00'));

    $leido = RGeVeRetAnu::FromSimpleXMLElement(new SimpleXMLElement($this->toXml($original)));

    $this->assertEquals($original->getDFeEmiRet(), $leido->getDFeEmiRet());
    $this->assertEquals($original->getDFecAnRet(), $leido->getDFecAnRet());
  }

  public function testRGeVeRetAceIdaYVueltaConservaLaFecha(): void
  {
    $original = (new RGeVeRetAce())
      ->setId(self::CDC)
      ->setDNumTimRet(12345678)
      ->setDEstRet('001')
      ->setDPunExpRet('002')
      ->setDNumDocRet('0000123')
      ->setDCodConRet('a1b2c3d4')
      ->setDFeEmiRet(new DateTime('2026-01-20T10:30:00'));

    $leido = RGeVeRetAce::FromSimpleXMLElement(new SimpleXMLElement($this->toXml($original)));

    $this->assertEquals($original->getDFeEmiRet(), $leido->getDFeEmiRet());
  }

  private function toXml(RGeVeRetAce|RGeVeRetAnu $evento): string
  {
    $doc = new DOMDocument('1.0', 'UTF-8');
    $node = $evento->toDOMElement($doc);
    $doc->appendChild($node);
    return $doc->saveXML($node);
  }
}
