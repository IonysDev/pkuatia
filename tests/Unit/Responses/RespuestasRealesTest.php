<?php

namespace IonysDev\Pkuatia\Tests\Unit\Responses;

use DateTime;
use IonysDev\Pkuatia\Core\Constants\TimbTiDE;
use IonysDev\Pkuatia\Core\Fields\Response\DE\RContDe;
use IonysDev\Pkuatia\Core\Fields\Response\GResProc;
use IonysDev\Pkuatia\Core\Fields\Response\RProtDe;
use IonysDev\Pkuatia\Core\Responses\RRetEnviEventoDe;
use IonysDev\Pkuatia\Helpers\FechaHelper;
use IonysDev\Pkuatia\Sifen;
use IonysDev\Pkuatia\Tests\Support\RespuestasSifenFactory as R;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use PHPUnit\Framework\TestCase;

/**
 * Fase B/B4 (PK-29): las clases de respuesta frente a las respuestas reales de sifen-test (06 y 09/10/2026),
 * llamadas a través del facade con el objeto que entrega SoapClient. Para el formato de las respuestas las
 * capturas mandan sobre el Manual Técnico (ekuat-ia/06-ejemplos/respuestas-ws/README.md).
 */
final class RespuestasRealesTest extends TestCase
{
  private const CDC = '01800000005001001000011322026100915495718099';

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

  /** Observación 1: el CDC llega como Id (mayúscula); hasta 0.2.0 se leía "id" y getId() terminaba en Error. */
  public function testEnvioAprobado0260(): void
  {
    R::instalar(R::ENVIO_DE_0260);
    $prot = Sifen::EnviarDE('<rDE/>')->getRProtDe();
    $this->assertSame(self::CDC, $prot->getId());
    $this->assertSame('2026-10-09T17:07:15-03:00', $prot->getDFecProc()->format(DATE_ATOM));
    $this->assertSame('RElHRVNUX1ZBTFVFX0FOT05JTUlaQURP', $prot->getDDigVal());
    $this->assertSame('Aprobado', $prot->getDEstRes());
    $this->assertSame('50219661', $prot->getDProtAut());
    $this->assertSame('0260', $prot->getGResProc()[0]->getDCodRes());
    $this->assertSame('Autorización del DE satisfactoria', $prot->getGResProc()[0]->getDMsgRes());
  }

  /** Rechazo genérico del 06/10: sin Id, dDigVal ni dProtAut; los getters devuelven null en vez de Error. */
  public function testRechazoGenerico0160(): void
  {
    R::instalar(R::ENVIO_DE_0160);
    $prot = Sifen::EnviarDE('<rDE/>')->getRProtDe();
    $this->assertSame('Rechazado', $prot->getDEstRes());
    $this->assertSame('0160', $prot->getGResProc()[0]->getDCodRes());
    $this->assertSame('XML Mal Formado.', $prot->getGResProc()[0]->getDMsgRes());
    $this->assertNull($prot->getId());
    $this->assertNull($prot->getDDigVal());
    $this->assertNull($prot->getDProtAut());
  }

  /** dDesEstCons se descartaba; la propiedad conserva el literal del SIFEN y el getter sigue derivándolo del código. */
  public function testConsultaRuc0502(): void
  {
    R::instalar(R::RUC_0502);
    $res = Sifen::ConsultarRUC('80000000');
    $this->assertSame('502', $res->getDCodRes());
    $this->assertSame('ACTIVO', $res->getRContRUC()->dDesEstCons);
    $this->assertSame('Activo', $res->getRContRUC()->getDDesEstCons());
  }

  /** Observación 2 del 06/10: ante el rechazo genérico la consulta de RUC responde con un sobre rRetEnviDe. */
  public function testConsultaRucConRechazoGenerico(): void
  {
    R::instalar(R::RUC_0160);
    $res = Sifen::ConsultarRUC('80000000');
    $this->assertSame('160', $res->getDCodRes());
    $this->assertSame('XML Mal Formado.', $res->getDMsgRes());
  }

  /** Observación 8: 0420 sin xContenDE. */
  public function testConsultaDE0420(): void
  {
    R::instalar(R::CONSULTA_DE_0420);
    $res = Sifen::ConsultarDE(self::CDC);
    $this->assertSame(420, $res->getDCodRes());
    $this->assertSame('Documento No Existe en SIFEN o ha sido Rechazado', $res->getDMsgRes());
    $this->assertSame('2026-10-09T17:04:35-03:00', $res->getDFecProc()->format(DATE_ATOM));
    $this->assertNull($res->getRContDe());
    $this->assertNull($res->getXContenDE());
  }

  /** Observaciones 3 y 4: xContenDE es texto con el rDE, dProtAut y xContEv vacío. */
  public function testConsultaDE0422SinEventos(): void
  {
    R::instalar(R::CONSULTA_DE_0422);
    $res = Sifen::ConsultarDE(self::CDC);
    $this->assertSame(422, $res->getDCodRes());
    $cont = $res->getRContDe();
    $this->assertSame('50219661', $cont->getDProtAut());
    $this->assertSame(self::CDC, $cont->getRDe()->getDE()->getId());
    $this->assertSame([], $cont->getRContEvs());
    $this->assertNull($cont->getRContEv());
    $this->assertStringStartsWith('<rDE xmlns="http://ekuatia.set.gov.py/sifen/xsd"', $res->getRDEXml());
    $this->assertStringEndsWith('</gCamFuFD></rDE>', $res->getRDEXml());
  }

  /** Observación 5: xContEv con la cancelación; dentro, dFecProc sin zona y el literal "Se encontro el evento". */
  public function testConsultaDE0422ConCancelacion(): void
  {
    R::instalar(R::CONSULTA_DE_0422_CANCELADO);
    $cont = Sifen::ConsultarDE(self::CDC)->getRContDe();
    $this->assertCount(1, $cont->getRContEvs());
    $ev = $cont->getRContEvs()[0];
    $this->assertSame($ev, $cont->getRContEv());
    $this->assertSame(self::CDC, $ev->getXEvento()->getREve()->getGGroupTiEvt()->getRGeVeCan()->getId());
    $ret = $ev->getRResEnviEventoDe();
    $this->assertSame('2026-10-09T17:16:57', $ret->getDFecProc()->format('Y-m-d\TH:i:s'));
    $this->assertSame('America/Asuncion', $ret->getDFecProc()->getTimezone()->getName());
    $this->assertSame('1167531', $ret->getGResProcEVe()[0]->getDProtAut());
    $this->assertNull($ret->getGResProcEVe()[0]->getId());
    $this->assertSame('Se encontro el evento', $ret->getGResProcEVe()[0]->getGResProc()[0]->getDMsgRes());
  }

  /** ContDE04 es 0-n: con dos eventos se conservan los dos (antes, solo el primero). */
  public function testXContEvConDosEventos(): void
  {
    $x = R::xContenDE(R::CONSULTA_DE_0422_CANCELADO);
    preg_match('#<rContEv>.*</rContEv>#s', $x, $m);
    $segundo = str_replace(['<dProtAut>1167531</dProtAut>', '<rEve Id="1">'], ['<dProtAut>1167532</dProtAut>', '<rEve Id="2">'], $m[0]);
    $cont = RContDe::FromXContenDE(str_replace($m[0], $m[0] . "\n\t" . $segundo, $x));
    $this->assertCount(2, $cont->getRContEvs());
    $this->assertSame('1167532', $cont->getRContEvs()[1]->getRResEnviEventoDe()->getGResProcEVe()[0]->getDProtAut());
    $this->assertSame('50219661', $cont->getDProtAut());
  }

  /** Observación 2: rRetEnviEventoDe con dFecProc con zona e id en minúscula; 4009 y 0100 sin dProtAut. */
  public function testEventos0600Y4009Y0100(): void
  {
    R::instalar(R::EVENTO_0600);
    $r = Sifen::CancelarDE(self::CDC, 'Motivo de prueba');
    $this->assertSame('2026-10-09T17:16:57-03:00', $r->getDFecProc()->format(DATE_ATOM));
    $this->assertSame('1', $r->getGResProcEVe()[0]->getId());
    $this->assertSame('1167531', $r->getGResProcEVe()[0]->getDProtAut());

    R::instalar(R::EVENTO_4009);
    $r = Sifen::CancelarDE(self::CDC, 'Motivo de prueba');
    $this->assertNull($r->getGResProcEVe()[0]->getDProtAut());
    $this->assertSame('TEST - Plazo de solicitud de cancelación de una FE extemporáneo', $r->getGResProcEVe()[0]->getGResProc()[0]->getDMsgRes());

    R::instalar(R::EVENTO_0100);
    $this->assertSame('0', Sifen::CancelarDE(self::CDC, 'Motivo de prueba')->getGResProcEVe()[0]->getId());
  }

  /** RRetEnviEventoDe::FromSimpleXMLElement solo aceptaba fechas sin zona; la respuesta directa la trae. */
  public function testRetEnviEventoDeSimpleXmlConZona(): void
  {
    $xml = '<rRetEnviEventoDe><dFecProc>2026-10-09T17:16:57-03:00</dFecProc><gResProcEVe><dEstRes>Aprobado</dEstRes>'
      . '<dProtAut>1167531</dProtAut><id>1</id><gResProc><dCodRes>0600</dCodRes><dMsgRes>Evento registrado correctamente</dMsgRes></gResProc></gResProcEVe></rRetEnviEventoDe>';
    $r = RRetEnviEventoDe::FromSimpleXMLElement(simplexml_load_string($xml));
    $this->assertSame('2026-10-09T17:16:57-03:00', $r->getDFecProc()->format(DATE_ATOM));
  }

  /** RProtDe::setGResProc(GResProc) asignaba un objeto a la propiedad array (TypeError). */
  public function testSetGResProcAceptaUnoOVarios(): void
  {
    $g = (new GResProc())->setDCodRes('0260')->setDMsgRes('ok');
    $this->assertSame([$g], (new RProtDe())->setGResProc($g)->getGResProc());
    $this->assertSame([$g, $g], (new RProtDe())->setGResProc([$g, $g])->getGResProc());
  }

  public function testFechaSifenInvalidaLanzaExcepcionConElValor(): void
  {
    $this->expectException(\InvalidArgumentException::class);
    $this->expectExceptionMessage('2026-13-45');
    FechaHelper::FromSifen('2026-13-45T10:00:00', 'dFecProc');
  }

  /**
   * El sobre de rechazo genérico (rRetEnviDe > rProtDe) se capturó para recepción y consulta de RUC; para
   * consulta de DE, eventos y lote se asume igual [PENDIENTE DE VERIFICACIÓN]. Se reutiliza la captura 0160.
   * Con el WSDL real ese sobre llega como null (no es la respuesta que declara la operación): desde B13 el facade
   * lo decodifica de la respuesta cruda. CapturaSoapClient reproduce ese null.
   */
  public function testRechazoGenericoEnConsultaDEEventosYLote(): void
  {
    R::instalar(R::ENVIO_DE_0160);
    $de = Sifen::ConsultarDE(self::CDC);
    $this->assertSame(160, $de->getDCodRes());
    $this->assertSame('XML Mal Formado.', $de->getDMsgRes());
    $this->assertSame('2026-10-06T07:02:54-03:00', $de->getDFecProc()->format(DATE_ATOM));

    $ev = Sifen::InutilizarNumeros(12345678, 1, 1, 10, 20, TimbTiDE::Factura, 'Inutilizacion de prueba');
    $this->assertSame('Rechazado', $ev->getGResProcEVe()[0]->getDEstRes());
    $this->assertSame('0160', $ev->getGResProcEVe()[0]->getGResProc()[0]->getDCodRes());

    $lote = Sifen::ConsultaLote('123456789012345');
    $this->assertSame(160, $lote->getDCodResLot());
    $this->assertSame('XML Mal Formado.', $lote->getDMsgResLot());
  }

  /** B13: la recepción de lote también lee el rechazo genérico en lugar de terminar en "Error Processing Request: null". */
  public function testRechazoGenericoEnLaRecepcionDeLote(): void
  {
    R::instalar(R::ENVIO_DE_0160);

    $lote = Sifen::EnviarLoteDE(['<rDE><DE Id="01800000000001001000000122026011510123456781"><gTimb><iTiDE>1</iTiDE></gTimb>'
      . '<gEmis><dRucEm>80000000</dRucEm></gEmis></DE></rDE>']);

    $this->assertSame(160, $lote->getDCodRes());
    $this->assertSame('XML Mal Formado.', $lote->getDMsgRes());
    $this->assertNull($lote->getDProtConsLoteString());
  }
}
