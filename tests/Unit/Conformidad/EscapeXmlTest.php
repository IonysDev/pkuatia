<?php

namespace IonysDev\Pkuatia\Tests\Unit\Conformidad;

use DateTime;
use DOMDocument;
use IonysDev\Pkuatia\Core\Constants\CamIVAAfecIVA;
use IonysDev\Pkuatia\Core\Constants\CamIVATasaIVA;
use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\GGroupGesEve;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\GGroupTiEvt;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\REve;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\RGesEve;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\RGeVeCan;
use IonysDev\Pkuatia\Helpers\SignHelper;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Tests\Support\XsdAssertions;
use PHPUnit\Framework\TestCase;

/**
 * PK-01: un `&` (o `<`) en cualquier texto libre debe llegar al XML escapado y recuperarse intacto.
 * Antes de la corrección, `new DOMElement($n, $v)` dejaba el elemento vacío con un warning de PHP.
 * Fuente: AGENTS.md §3.2 de ekuat-ia (literales byte a byte); tipos noEmptyString/minLength del XSD.
 */
final class EscapeXmlTest extends TestCase
{
  /** @var callable */
  private $cleanup;

  protected function setUp(): void
  {
    $env = SifenTestEnvironment::init();
    $this->cleanup = $env['cleanup'];
  }

  protected function tearDown(): void
  {
    ($this->cleanup)();
  }

  public function testTextosLibresConAmpersandYMenorLleganEscapadosYValidanXsd(): void
  {
    $fe = DocumentoFactory::facturaContado(7);
    // Texto libre en emisor (dNomEmi se reemplaza en dev por FirmarDE, por eso se usan los demás campos)
    $fe->setEmisorNombreFantasia('Pérez & Hijos <Mayorista>');
    $fe->setEmisorDireccionLocal('Av. España & Brasil');
    $fe->setInformacionDeInteresEmisor('Pago con Tigo Money & Bancard');
    $fe->setInfoDeInteresFiscal('Régimen <general> & RG 90');
    // Receptor y segundo ítem
    DocumentoFactory::receptorContribuyente($fe, 'Cliente & Socios S.A.');
    $fe->addItem('T&T', 'Tornillos & tuercas <3mm>', 77, '1', 0, '1000', null, CamIVAAfecIVA::Gravado, '100', CamIVATasaIVA::IVA10);
    $fe->calcTotSub(0);

    $xml = DocumentoFactory::firmar($fe->facturaToRDE());

    $this->assertStringContainsString('<dNomFanEmi>Pérez &amp; Hijos &lt;Mayorista&gt;</dNomFanEmi>', $xml);
    $this->assertStringContainsString('<dDirEmi>Av. España &amp; Brasil</dDirEmi>', $xml);
    $this->assertStringContainsString('<dInfoEmi>Pago con Tigo Money &amp; Bancard</dInfoEmi>', $xml);
    $this->assertStringContainsString('<dInfoFisc>Régimen &lt;general&gt; &amp; RG 90</dInfoFisc>', $xml);
    $this->assertStringContainsString('<dNomRec>Cliente &amp; Socios S.A.</dNomRec>', $xml);
    $this->assertStringContainsString('<dCodInt>T&amp;T</dCodInt>', $xml);
    $this->assertStringContainsString('<dDesProSer>Tornillos &amp; tuercas &lt;3mm&gt;</dDesProSer>', $xml);
    $this->assertStringNotContainsString('&amp;amp;', $xml, 'no debe haber doble escape');
    XsdAssertions::assertRdeValido($xml, 'FE con & y < en textos libres');

    // Round-trip: lo que se lee es exactamente lo que se escribió
    $dom = new DOMDocument();
    $dom->loadXML($xml);
    $rde = RDE::FromDOMElement($dom->documentElement);
    $this->assertSame('Pérez & Hijos <Mayorista>', $rde->getDE()->getGDatGralOpe()->getGEmis()->getDNomFanEmi());
    $this->assertSame('Cliente & Socios S.A.', $rde->getDE()->getGDatGralOpe()->getGDatRec()->getDNomRec());
  }

  public function testMotivoDeEventoConAmpersandLlegaEscapadoYValidaXsd(): void
  {
    $cancel = new RGeVeCan();
    $cancel->setId(str_repeat('1', 44));
    $cancel->setMOtEve('Error en datos & precios <mayorista>');
    $gti = new GGroupTiEvt();
    $gti->setRGeVeCan($cancel);
    $rEve = new REve();
    $rEve->setId(1);
    $rEve->setDFecFirma(new DateTime('2026-01-15T10:00:00'));
    $rEve->setDVerFor(150);
    $rEve->setGGroupTiEvt($gti);
    $rGesEve = new RGesEve();
    $rGesEve->setREve($rEve);
    $raiz = new GGroupGesEve();
    $raiz->setRGesEve([$rGesEve]);

    $doc = SignHelper::SingEvents($raiz, null);
    $xml = $doc->saveXML($doc->documentElement);

    $this->assertStringContainsString('<mOtEve>Error en datos &amp; precios &lt;mayorista&gt;</mOtEve>', $xml);
    XsdAssertions::assertEventoValido($xml, 'cancelación con & en el motivo');
  }
}
