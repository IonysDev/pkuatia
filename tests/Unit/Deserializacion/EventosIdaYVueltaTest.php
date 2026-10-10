<?php

namespace IonysDev\Pkuatia\Tests\Unit\Deserializacion;

use DateTime;
use IonysDev\Pkuatia\Core\Constants\TimbTiDE;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\GGroupTiEvt;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\RGEveNom;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\RGeVeInu;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GEA\RGeDevCCFFCue;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GEA\RGeDevCCFFDev;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GEA\RGeVeAnt;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GEA\RGeVeCCFF;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GEA\RGeVeRem;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GEA\RGeVeRetAce;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GEA\RGeVeRetAnu;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GER\RGeVeDisconf;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GER\RGeVeNotRec;
use IonysDev\Pkuatia\Sifen;
use IonysDev\Pkuatia\Tests\Support\EventoFactory as E;
use IonysDev\Pkuatia\Tests\Support\RespuestasSifenFactory as R;
use IonysDev\Pkuatia\Tests\Support\RoundTrip;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Tests\Support\StubSoapClient;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Fase B/B3: deserialización de eventos (PK-27, PK-28 y PK-42). La vía es SimpleXML, la que usa
 * Sifen::ConsultarDE para leer xContEv. Fuente: Evento_v150.xsd (tgGroupEvt :363-380; trGeVeRetAce y
 * trGeVeRetAnu :112-150, con dRuc y dMonRet obligatorios).
 */
final class EventosIdaYVueltaTest extends TestCase
{
  private const CDC = E::CDC;

  private static function fecha(string $valor): DateTime
  {
    return new DateTime($valor);
  }

  /** @return array<string, array{0: callable(): GGroupTiEvt}> Los 15 eventos que modela GGroupTiEvt. */
  public static function eventos(): array
  {
    return [
      'cancelación' => [fn () => E::cancelacion()],
      'inutilización' => [fn () => (new GGroupTiEvt())->setRGeVeInu((new RGeVeInu())->setDNumTim(12345678)->setDEst('001')
        ->setDPunExp('001')->setDNumIn('0000010')->setDNumFin('0000020')->setITiDE(1)->setMOtEve('Inutilizacion de prueba')->setDSerieNum('AB'))],
      'notificación de recepción' => [fn () => (new GGroupTiEvt())->setRGeVeNotRec((new RGeVeNotRec())->setId(self::CDC)
        ->setDFecEmi(self::fecha('2026-01-15T10:00:00'))->setDFecRecep(self::fecha('2026-01-16T08:00:00'))->setITipRec(1)
        ->setDNomRec('Cliente Receptor SA')->setDRucRec('80012345')->setDDVRec(0)->setDTotalGs(100000))],
      'conformidad total' => [fn () => E::conformidad(1)],
      'conformidad parcial' => [fn () => E::conformidad(2, self::fecha('2026-01-17T10:00:00'))],
      'disconformidad' => [fn () => (new GGroupTiEvt())->setRGeVeDisconf((new RGeVeDisconf())->setId(self::CDC)->setMOtEve('Mercaderia con fallas'))],
      'desconocimiento' => [fn () => E::desconocimientoNoContribuyente()],
      'transporte, local de entrega' => [fn () => E::transporteCambioLocalEntrega()],
      'transporte, chofer' => [fn () => E::transporteCambioChofer()],
      'transporte, vehículo' => [fn () => E::transporteCambioVehiculo()],
      'nominación' => [fn () => E::nominacion()],
      'retención aceptada' => [fn () => (new GGroupTiEvt())->setrGeVeRetAce((new RGeVeRetAce())->setId(self::CDC)->setDNumTimRet(12345678)
        ->setDEstRet('001')->setDPunExpRet('002')->setDNumDocRet('0000123')->setDCodConRet('a1b2c3d4')->setDFeEmiRet(self::fecha('2026-01-20T00:00:00')))],
      'retención anulada' => [fn () => (new GGroupTiEvt())->setrGeVeRetAnu((new RGeVeRetAnu())->setId(self::CDC)->setDNumTimRet(12345678)
        ->setDEstRet('001')->setDPunExpRet('002')->setDNumDocRet('0000123')->setDCodConRet('a1b2c3d4')->setDFeEmiRet(self::fecha('2026-01-20T00:00:00'))
        ->setDFecAnRet(self::fecha('2026-01-21T09:15:00')))],
      'crédito fiscal' => [fn () => (new GGroupTiEvt())->setrGeVeCCFF((new RGeVeCCFF())->setId(self::CDC)->setDNumTraCCFF('123456')
        ->setDFeAceTraCCFF(self::fecha('2026-01-22T10:00:00')))],
      'devolución de crédito fiscal, cuestionado' => [fn () => (new GGroupTiEvt())->setGeDevCCFFCue(self::devolucion(new RGeDevCCFFCue()))],
      'devolución de crédito fiscal, devuelto' => [fn () => (new GGroupTiEvt())->setGeDevCCFFDev(self::devolucion(new RGeDevCCFFDev()))],
      'anticipo' => [fn () => (new GGroupTiEvt())->setRGeVeAnt((new RGeVeAnt())->setId(self::CDC))],
      'remisión' => [fn () => (new GGroupTiEvt())->setRGeVeRem((new RGeVeRem())->setId(self::CDC))],
    ];
  }

  private static function devolucion(RGeDevCCFFCue|RGeDevCCFFDev $g): RGeDevCCFFCue|RGeDevCCFFDev
  {
    return $g->setId(self::CDC)->setDNumDevSol('S-1')->setDNumDevInf('I-1')->setDNumDevRes('R-1')
      ->setDFeEmiSol(self::fecha('2026-01-10T10:00:00'))->setDFeEmiInf(self::fecha('2026-01-11T10:00:00'))->setDFeEmiRes(self::fecha('2026-01-12T10:00:00'));
  }

  #[DataProvider('eventos')]
  public function testIdaYVueltaPorSimpleXml(callable $crear): void
  {
    RoundTrip::assertIdaYVueltaIdentica($crear(), RoundTrip::VIA_SIMPLEXML, GGroupTiEvt::class);
  }

  /**
   * PK-27: GGroupTiEvt buscaba el nodo rGeVeNom (el XSD dice rGEveNom, Evento_v150.xsd:379) y declaraba
   * la clase RGeVeNom (la real es RGEveNom): en Linux, con la clase sin cargar, "Class not found".
   */
  public function testLaNominacionSeLeeYUsaElNombreExactoDeLaClase(): void
  {
    $xml = RoundTrip::serializar(E::nominacion());
    $this->assertStringContainsString('<rGEveNom>', $xml);
    $leido = GGroupTiEvt::FromSimpleXMLElement(simplexml_load_string($xml));
    $this->assertInstanceOf(RGEveNom::class, $leido->getRGeVeNom());
    $this->assertSame(RGEveNom::class, (new \ReflectionProperty(GGroupTiEvt::class, 'rGeVeNom'))->getType()->getName());
    $this->assertSame(RGEveNom::class, (new \ReflectionMethod(GGroupTiEvt::class, 'setRGeVeNom'))->getParameters()[0]->getType()->getName());
    $this->assertSame(RGEveNom::class, (new \ReflectionMethod(GGroupTiEvt::class, 'getRGeVeNom'))->getReturnType()->getName());
  }

  /** PK-42: getGeDevCCFFCue() devolvía el grupo "devuelto"; los getters nuevos tienen el nombre y el tipo correctos. */
  public function testGettersDeDevolucionDeCreditosFiscales(): void
  {
    $cue = self::devolucion(new RGeDevCCFFCue());
    $dev = self::devolucion(new RGeDevCCFFDev());
    $this->assertSame($cue, (new GGroupTiEvt())->setGeDevCCFFCue($cue)->getRGeDevCCFFCue());
    $this->assertSame($dev, (new GGroupTiEvt())->setGeDevCCFFDev($dev)->getRGeDevCCFFDev());
  }

  /**
   * PK-42: dRuc y dMonRet son obligatorios en trGeVeRetAce y trGeVeRetAnu (Evento_v150.xsd:112-150) y la
   * clase no los modelaba: se perdían al consultar un DE con retenciones.
   */
  public function testLasRetencionesConservanRucYMonto(): void
  {
    $base = '<Id>' . self::CDC . '</Id><dRuc>80000000</dRuc><dNumTimRet>12345678</dNumTimRet><dEstRet>001</dEstRet>'
      . '<dPunExpRet>002</dPunExpRet><dNumDocRet>0000123</dNumDocRet><dCodConRet>a1b2c3d4</dCodConRet>'
      . '<dFeEmiRet>2026-01-20T00:00:00</dFeEmiRet>';
    foreach (['rGeVeRetAce' => '', 'rGeVeRetAnu' => '<dFecAnRet>2026-01-21T09:15:00</dFecAnRet>'] as $nodo => $extra) {
      $xml = "<gGroupTiEvt><$nodo>$base$extra<dMonRet>100000.5</dMonRet></$nodo></gGroupTiEvt>";
      $gti = GGroupTiEvt::FromSimpleXMLElement(simplexml_load_string($xml));
      $evento = $nodo === 'rGeVeRetAce' ? $gti->getrGeVeRetAce() : $gti->getrGeVeRetAnu();
      $this->assertSame('80000000', $evento->getDRuc(), $nodo);
      $this->assertSame('100000.5', $evento->getDMonRet(), $nodo);
      $this->assertSame($xml, RoundTrip::serializar($gti), "$nodo: orden de Evento_v150.xsd");
    }
  }

  /** Captura real del 09/10/2026: la cancelación aprobada dentro de xContEv de una consulta 0422. */
  public function testCancelacionRealDentroDeXContEv(): void
  {
    $cleanup = SifenTestEnvironment::init()['cleanup'];
    try {
      R::instalar(R::CONSULTA_DE_0422_CANCELADO);
      $res = Sifen::ConsultarDE('01800000005001001000011322026100915495718099');
      $cancelacion = $res->getRContDe()->getRContEv()->getXEvento()->getREve()->getGGroupTiEvt()->getRGeVeCan();
      $this->assertSame('01800000005001001000011322026100915495718099', $cancelacion->getId());
      $this->assertSame('Anulacion de prueba - captura de respuestas reales Fase A', $cancelacion->getMOtEve());
    } finally {
      $cleanup();
    }
  }

  /** PK-42: InutilizarNumeros admite la serie (dSerieNum 0-1, tserieNum [A-Z][A-Z]) y acota el tipo a tiTiDEEv (1-9). */
  public function testInutilizacionConSerieYTipoAcotado(): void
  {
    $cleanup = SifenTestEnvironment::init()['cleanup'];
    try {
      StubSoapClient::instalar(['rEnviEventoDe' => fn () => StubSoapClient::respuestaEventoAprobado()]);
      Sifen::InutilizarNumeros(12345678, 1, 1, 10, 20, TimbTiDE::Factura, 'Inutilizacion de prueba', null, 'AB');
      $this->assertStringContainsString('<dSerieNum>AB</dSerieNum>', StubSoapClient::ultimoRequest()->dEvReg->enc_value);

      $this->expectException(\InvalidArgumentException::class);
      $this->expectExceptionMessage('tiTiDEEv');
      Sifen::InutilizarNumeros(12345678, 1, 1, 10, 20, TimbTiDE::BoletaResimple, 'Inutilizacion de prueba');
    } finally {
      $cleanup();
    }
  }
}
