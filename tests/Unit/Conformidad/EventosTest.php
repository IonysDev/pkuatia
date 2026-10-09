<?php

namespace IonysDev\Pkuatia\Tests\Unit\Conformidad;

use DateTime;
use IonysDev\Pkuatia\Core\Constants\RecTiOpe;
use IonysDev\Pkuatia\Sifen;
use IonysDev\Pkuatia\Tests\Support\EventoFactory;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Tests\Support\XsdAssertions;
use PHPUnit\Framework\TestCase;

/**
 * PK-12 (RGeVeDescon emitía el tipo de receptor en dTipIDRec), PK-13 (dFecRecep de la conformidad es
 * fecHhmmss, Evento_v150.xsd:76), PK-14 (RGeVeTr fallaba sin campos ajenos al motivo y usaba el mapeo
 * de países para las descripciones geográficas), PK-15 (tiTiOpeEv es [1-2]|4, Evento_Types_v150.xsd:57-66;
 * rGeVeDescon.dTipIDRec es tiTipDoc [1-4], Evento_v150.xsd:106) y PK-24 (Ids de rEve repetidos).
 * Fuente: docs/sifen-ai/05-api-sifen/eventos.md.
 */
final class EventosTest extends TestCase
{
  /** @var callable */
  private $cleanup;

  protected function setUp(): void
  {
    $this->cleanup = SifenTestEnvironment::init()['cleanup'];
  }

  protected function tearDown(): void
  {
    ($this->cleanup)();
  }

  public function testCancelacionValida(): void
  {
    $xml = EventoFactory::firmar(EventoFactory::sobreDe(EventoFactory::cancelacion()));
    XsdAssertions::assertEventoValido($xml, 'cancelación');
  }

  public function testConformidadParcialInformaFechaYHoraDeRecepcion(): void
  {
    $xml = EventoFactory::firmar(EventoFactory::sobreDe(EventoFactory::conformidad(2, new DateTime('2026-01-16T09:30:00'))));
    $this->assertStringContainsString('<dFecRecep>2026-01-16T09:30:00</dFecRecep>', $xml);
    XsdAssertions::assertEventoValido($xml, 'conformidad parcial');
  }

  public function testConformidadTotalValida(): void
  {
    $xml = EventoFactory::firmar(EventoFactory::sobreDe(EventoFactory::conformidad(1)));
    XsdAssertions::assertEventoValido($xml, 'conformidad total');
  }

  public function testDesconocimientoDeNoContribuyenteInformaElTipoDeDocumento(): void
  {
    $xml = EventoFactory::firmar(EventoFactory::sobreDe(EventoFactory::desconocimientoNoContribuyente(1)));
    $this->assertStringContainsString('<iTipRec>2</iTipRec>', $xml);
    $this->assertStringContainsString('<dTipIDRec>1</dTipIDRec>', $xml, 'dTipIDRec debe ser el tipo de documento, no el tipo de receptor');
    XsdAssertions::assertEventoValido($xml, 'desconocimiento no contribuyente');
  }

  public function testDesconocimientoRechazaTiposDeDocumentoFueraDe1a4(): void
  {
    $this->expectException(\Exception::class);
    $this->expectExceptionMessageMatches('/dTipIDRec|tipo de documento/i');
    EventoFactory::firmar(EventoFactory::sobreDe(EventoFactory::desconocimientoNoContribuyente(5)));
  }

  public function testTransporteCambioDeLocalDeEntregaValidaConDescripcionesGeograficas(): void
  {
    $xml = EventoFactory::firmar(EventoFactory::sobreDe(EventoFactory::transporteCambioLocalEntrega()));
    $this->assertStringContainsString('<dDesDepEnt>CAPITAL</dDesDepEnt>', $xml);
    $this->assertStringNotContainsString('<iNatTrans>', $xml, 'sin cambio de transportista no se informa iNatTrans');
    XsdAssertions::assertEventoValido($xml, 'transporte motivo 1');
  }

  public function testTransporteCambioDeChoferValida(): void
  {
    $xml = EventoFactory::firmar(EventoFactory::sobreDe(EventoFactory::transporteCambioChofer()));
    $this->assertStringContainsString('<dNomChof>Chofer Nuevo Lopez</dNomChof>', $xml);
    XsdAssertions::assertEventoValido($xml, 'transporte motivo 2');
  }

  public function testTransporteCambioDeVehiculoPorMatriculaValida(): void
  {
    $xml = EventoFactory::firmar(EventoFactory::sobreDe(EventoFactory::transporteCambioVehiculo('ABC123')));
    $this->assertStringContainsString('<dNroMatVeh>ABC123</dNroMatVeh>', $xml);
    XsdAssertions::assertEventoValido($xml, 'transporte motivo 4');
  }

  public function testNominacionB2CValida(): void
  {
    $xml = EventoFactory::firmar(EventoFactory::sobreDe(EventoFactory::nominacion(RecTiOpe::B2C)));
    XsdAssertions::assertEventoValido($xml, 'nominación B2C');
  }

  public function testNominacionRechazaB2G(): void
  {
    $this->expectException(\Exception::class);
    $this->expectExceptionMessageMatches('/B2G|iTiOpe/i');
    EventoFactory::nominacion(RecTiOpe::B2G);
  }

  public function testRegistrarEventoRechazaIdsRepetidos(): void
  {
    $sobre = EventoFactory::sobre([
      EventoFactory::rGesEve(EventoFactory::cancelacion(), 1),
      EventoFactory::rGesEve(EventoFactory::cancelacion(), 1),
    ]);
    $this->expectException(\Exception::class);
    $this->expectExceptionMessageMatches('/Id/');
    Sifen::RegistrarEvento($sobre);
  }

  public function testDosEventosConIdsDistintosFirmanYValidan(): void
  {
    $xml = EventoFactory::firmar(EventoFactory::sobre([
      EventoFactory::rGesEve(EventoFactory::cancelacion(), 1),
      EventoFactory::rGesEve(EventoFactory::conformidad(1), 2),
    ]));
    XsdAssertions::assertEventoValido($xml, 'sobre con 2 eventos');
  }
}
