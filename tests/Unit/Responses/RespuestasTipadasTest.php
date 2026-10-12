<?php

namespace IonysDev\Pkuatia\Tests\Unit\Responses;

use IonysDev\Pkuatia\Core\Constants\CodigoResultadoWS;
use IonysDev\Pkuatia\Core\Constants\EstadoResultado;
use IonysDev\Pkuatia\Core\Constants\EstadoRuc;
use IonysDev\Pkuatia\Core\Fields\Response\Batch\GResProcLote;
use IonysDev\Pkuatia\Core\Fields\Response\GResProc;
use IonysDev\Pkuatia\Core\Responses\RespuestaSifen;
use IonysDev\Pkuatia\Core\Responses\RResEnviConsArchivoRUC;
use IonysDev\Pkuatia\Sifen;
use IonysDev\Pkuatia\Tests\Support\EventoFactory as E;
use IonysDev\Pkuatia\Tests\Support\RespuestasSifenFactory as R;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use PHPUnit\Framework\TestCase;

/**
 * Paso C6 de la Fase C (evaluación §7.2): esAprobado() y afines en las respuestas e interfaz RespuestaSifen, probados
 * sobre las capturas reales de sifen-test (2026-10-06, 09 y 11) leídas a través del facade. Los getters históricos
 * (getDCodRes() como int o String según la clase) no cambian; lo nuevo expone el código como texto de cuatro dígitos.
 */
final class RespuestasTipadasTest extends TestCase
{
  private const RDE_MINIMO = '<rDE><DE Id="01800000000001001000000122026011510123456781"><gTimb><iTiDE>1</iTiDE></gTimb><gEmis><dRucEm>80000000</dRucEm></gEmis></DE></rDE>';

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

  public function testLasSieteRespuestasImplementanLaInterfaz(): void
  {
    $respuestas = [
      [R::ENVIO_DE_0260, fn () => Sifen::EnviarDE('<rDE/>')],
      [R::RUC_0502, fn () => Sifen::ConsultarRUC('80000000')],
      [R::CONSULTA_DE_0422, fn () => Sifen::ConsultarDE(E::CDC)],
      [R::LOTE_0300, fn () => Sifen::EnviarLoteDE([self::RDE_MINIMO])],
      [R::CONSULTA_LOTE_0362, fn () => Sifen::ConsultaLote('85929997107567388')],
      [R::EVENTO_0600, fn () => Sifen::CancelarDE(E::CDC, 'Motivo de prueba')],
      [R::RUC_0160, fn () => Sifen::ConsultarArchivoRUC('80000000')],
    ];
    foreach ($respuestas as [$captura, $llamar]) {
      R::instalar($captura);
      $r = $llamar();
      $this->assertInstanceOf(RespuestaSifen::class, $r, $captura);
      $this->assertMatchesRegularExpression('/^\d{4}$/', $r->getCodigo(), $captura);
      $this->assertNotSame('', $r->getMensaje(), $captura);
      $a = $r->toArray();
      $this->assertSame($r->getCodigo(), $a['codigo'], $captura);
      $this->assertSame($r->getMensaje(), $a['mensaje'], $captura);
      $this->assertSame($r->esExitosa(), $a['exitosa'], $captura);
    }
  }

  public function testEnvioAprobado(): void
  {
    R::instalar(R::ENVIO_DE_0260);
    $r = Sifen::EnviarDE('<rDE/>');
    $this->assertTrue($r->esAprobado());
    $this->assertTrue($r->esExitosa());
    $this->assertFalse($r->esRechazado());
    $this->assertSame('0260', $r->getCodigo());
    $this->assertSame('Autorización del DE satisfactoria', $r->getMensaje());
    $this->assertSame(EstadoResultado::Aprobado, $r->getEstado());
    $this->assertSame('50219661', $r->getProtocolo());
    $this->assertSame('01800000005001001000011322026100915495718099', $r->getCdc());
    $this->assertSame(CodigoResultadoWS::AutorizacionDeSatisfactoria, $r->getCodigoResultado());
    $this->assertSame('BC01', $r->getInfoValidacion()->id);
    $this->assertSame('2026-10-09T17:07:15-03:00', $r->getFechaProceso()->format(DATE_ATOM));
    $this->assertCount(1, $r->getMotivos());
    $this->assertInstanceOf(GResProc::class, $r->getMotivos()[0]);
    $a = $r->toArray();
    $this->assertSame('50219661', $a['protocolo']);
    $this->assertSame('Aprobado', $a['estado']);
    $this->assertSame('2026-10-09T17:07:15-03:00', $a['fechaProceso']);
  }

  public function testEnvioRechazado(): void
  {
    R::instalar(R::ENVIO_DE_0160);
    $r = Sifen::EnviarDE('<rDE/>');
    $this->assertTrue($r->esRechazado());
    $this->assertFalse($r->esAprobado());
    $this->assertFalse($r->esExitosa());
    $this->assertSame('0160', $r->getCodigo());
    $this->assertSame(EstadoResultado::Rechazado, $r->getEstado());
    $this->assertNull($r->getProtocolo(), 'el rechazo genérico no trae dProtAut');
    $this->assertNull($r->getCdc(), 'ni Id');
    $this->assertSame('AE01', $r->getInfoValidacion()->id);

    R::instalar(R::ENVIO_AF_2562);
    $r = Sifen::EnviarDE('<rDE/>');
    $this->assertTrue($r->esRechazado());
    $this->assertSame('2562', $r->getCodigo());
    $this->assertNull($r->getCodigoResultado(), 'una validación del DE no es un código de WS');
    $this->assertSame('E304', $r->getInfoValidacion()->id);
    $this->assertSame('El vendedor no debe ser contribuyente', $r->getInfoValidacion()->mensaje);
    $this->assertNotNull($r->getCdc(), 'el rechazo de negocio sí trae Id');
    $this->assertTrue($r->getMotivos()[0]->esValidacionDE());

    R::instalar(R::ENVIO_FE_ANG_1206);
    $this->assertSame('D016', Sifen::EnviarDE('<rDE/>')->getInfoValidacion()->id);
  }

  public function testGResProcDescribeSuCodigo(): void
  {
    $p = (new GResProc())->setDCodRes('0260')->setDMsgRes('x');
    $this->assertSame('0260', $p->getCodigo());
    $this->assertTrue($p->esAprobacion());
    $this->assertFalse($p->esValidacionDE());
    $this->assertFalse($p->esValidacionEvento());
    $this->assertSame(CodigoResultadoWS::AutorizacionDeSatisfactoria, $p->getCodigoResultado());

    $q = (new GResProc())->setDCodRes('2562')->setDMsgRes('x');
    $this->assertFalse($q->esAprobacion());
    $this->assertTrue($q->esValidacionDE());
    $this->assertNull($q->getCodigoResultado());
    $this->assertSame('E304', $q->getInfoValidacion()->id);

    $e = (new GResProc())->setDCodRes('4009')->setDMsgRes('x');
    $this->assertTrue($e->esValidacionEvento());
    $this->assertFalse($e->esValidacionDE());
    $this->assertSame('GDE004a', $e->getInfoValidacion()->id);

    $this->assertSame('0260', (new GResProc())->setDCodRes('260')->setDMsgRes('x')->getCodigo(), 'se normaliza a cuatro dígitos');
  }

  public function testConsultaDeRuc(): void
  {
    R::instalar(R::RUC_0502);
    $r = Sifen::ConsultarRUC('80000000');
    $this->assertTrue($r->fueEncontrado());
    $this->assertTrue($r->esExitosa());
    $this->assertSame('0502', $r->getCodigo());
    $this->assertSame('RUC encontrado', $r->getMensaje());
    $this->assertSame(EstadoRuc::Activo, $r->getEstadoRuc());
    $this->assertFalse($r->esFacturadorElectronico(), 'dRUCFactElec N en la captura');
    $this->assertSame('EMPRESA DE PRUEBA S.A.', $r->getRazonSocial());
    $this->assertNull($r->getFechaProceso(), 'la consulta de RUC no trae dFecProc');
    $this->assertSame('BO03', $r->getInfoValidacion()->id);
    $this->assertSame('ACT', $r->toArray()['estadoRuc']);

    R::instalar(R::RUC_0160);
    $r = Sifen::ConsultarRUC('80000000');
    $this->assertFalse($r->fueEncontrado());
    $this->assertFalse($r->esExitosa());
    $this->assertSame('0160', $r->getCodigo());
    $this->assertNull($r->getEstadoRuc());
    $this->assertNull($r->esFacturadorElectronico());
    $this->assertNull($r->getRazonSocial());
  }

  public function testConsultaDeDocumento(): void
  {
    R::instalar(R::CONSULTA_DE_0420);
    $r = Sifen::ConsultarDE(E::CDC);
    $this->assertFalse($r->fueEncontrado());
    $this->assertFalse($r->esExitosa());
    $this->assertSame('0420', $r->getCodigo());
    $this->assertSame('BL01', $r->getInfoValidacion()->id);
    $this->assertNotNull($r->getFechaProceso());

    R::instalar(R::CONSULTA_DE_0422);
    $r = Sifen::ConsultarDE(E::CDC);
    $this->assertTrue($r->fueEncontrado());
    $this->assertTrue($r->esExitosa());
    $this->assertSame('0422', $r->getCodigo());
    $this->assertSame('BL03', $r->getInfoValidacion()->id);
    $this->assertSame('CDC encontrado', $r->getMensaje());
  }

  public function testLote(): void
  {
    R::instalar(R::LOTE_0300);
    $r = Sifen::EnviarLoteDE([self::RDE_MINIMO]);
    $this->assertTrue($r->fueEncolado());
    $this->assertTrue($r->esExitosa());
    $this->assertSame('0300', $r->getCodigo());
    $this->assertMatchesRegularExpression('/^\d{17}$/', $r->getNumeroLote());
    $this->assertSame($r->getNumeroLote(), $r->toArray()['numeroLote']);

    R::instalar(R::CONSULTA_LOTE_0362);
    $c = Sifen::ConsultaLote('85929997107567388');
    $this->assertTrue($c->estaConcluido());
    $this->assertFalse($c->estaEnProcesamiento());
    $this->assertFalse($c->esExtemporaneo());
    $this->assertTrue($c->esResultadoDefinitivo());
    $this->assertTrue($c->esExitosa());
    $this->assertSame('0362', $c->getCodigo());
    $this->assertTrue($c->todosAprobados());
    $this->assertSame([], $c->getRechazados());
    $de = $c->getResultadoDe('01800000005001001000012222026101119201069504');
    $this->assertInstanceOf(GResProcLote::class, $de);
    $this->assertTrue($de->esAprobado());
    $this->assertSame(EstadoResultado::Aprobado, $de->getEstado());
    $this->assertSame('0260', $de->getCodigo());
    $this->assertSame('Aprobado', $de->getMensaje());
    $this->assertSame('50222136', $de->getProtocolo());
    $this->assertNull($c->getResultadoDe('x'));
    $this->assertCount(2, $c->toArray()['documentos']);
  }

  public function testEventos(): void
  {
    R::instalar(R::EVENTO_0600);
    $r = Sifen::CancelarDE(E::CDC, 'Motivo de prueba');
    $this->assertTrue($r->todosAprobados());
    $this->assertTrue($r->esExitosa());
    $this->assertSame('0600', $r->getCodigo());
    $this->assertSame([], $r->getRechazados());
    $this->assertTrue($r->getResultadoDelEvento(1)->esAprobado());
    $this->assertSame('1167531', $r->getResultadoDelEvento(1)->getProtocolo());
    $this->assertNull($r->getResultadoDelEvento(2));

    R::instalar(R::EVENTO_4009);
    $r = Sifen::CancelarDE(E::CDC, 'Motivo de prueba');
    $this->assertFalse($r->todosAprobados());
    $this->assertFalse($r->esExitosa());
    $this->assertCount(1, $r->getRechazados());
    $this->assertSame('GDE004a', $r->getInfoValidacion()->id);
    $this->assertSame(EstadoResultado::Rechazado, $r->getResultadoDelEvento(1)->getEstado());
    $this->assertNull($r->getResultadoDelEvento(1)->getProtocolo());

    R::instalar(R::EVENTOS_RECEPTOR_0143);
    $r = Sifen::CancelarDE(E::CDC, 'Motivo de prueba');
    $this->assertCount(5, $r->getRechazados());
    $this->assertSame('0143', $r->getResultadoDelEvento(3)->getCodigo());
    $this->assertSame('0143', $r->getResultadoDelEvento('3')->getCodigo(), 'el id se compara como texto');
    $this->assertStringContainsString('receptor', $r->getInfoValidacion()->mensaje);
    $this->assertCount(5, $r->toArray()['eventos']);
  }

  public function testArchivoDeRuc(): void
  {
    R::instalar(R::RUC_0160);
    $r = Sifen::ConsultarArchivoRUC('80000000');
    $this->assertFalse($r->fueEncontrado());
    $this->assertFalse($r->esExitosa());
    $this->assertSame('0160', $r->getCodigo());

    $ok = RResEnviConsArchivoRUC::FromSifenResponseObject((object) ['dFecProc' => '2026-10-11T10:00:00', 'dCodRes' => '0520', 'dMsgRes' => 'Archivo encontrado', 'rConsDte' => base64_encode('zip')]);
    $this->assertTrue($ok->fueEncontrado());
    $this->assertTrue($ok->esExitosa());
    $this->assertSame('0520', $ok->getCodigo());
    $this->assertSame('BO04', $ok->getInfoValidacion()->id);
  }
}
