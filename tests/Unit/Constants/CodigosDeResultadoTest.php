<?php

namespace IonysDev\Pkuatia\Tests\Unit\Constants;

use IonysDev\Pkuatia\Core\Constants\CategoriaCodigoWS;
use IonysDev\Pkuatia\Core\Constants\CodigoResultadoWS;
use IonysDev\Pkuatia\Core\Constants\EstadoResultado;
use IonysDev\Pkuatia\Core\Constants\EstadoRuc;
use IonysDev\Pkuatia\Core\Fields\Response\RUC\RContRUC;
use IonysDev\Pkuatia\Core\Responses\RResEnviConsArchivoRUC;
use IonysDev\Pkuatia\Core\Responses\RResEnviConsLoteDe;
use IonysDev\Pkuatia\Core\Responses\RResEnviConsRUC;
use IonysDev\Pkuatia\Core\Responses\RResEnviLoteDe;
use IonysDev\Pkuatia\Tests\Support\RespuestasSifenFactory as R;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Paso C4 de la Fase C. Fuentes: ekuat-ia 08-errores-y-respuestas/respuestas-ws.md (MT 12.2 y 12.3, con la
 * resolución 0420/0421/0422 del 03/10/2026) y estructura-codigos.md (rangos); 05-api-sifen/consulta-ruc.md (NT-011
 * Tabla L, 0520-0523) y envio-lote.md (0364, guía de la DNIT §7); capturas reales: 0100 "Error Inesperado"
 * (2026-10-09/06) y 0143 (2026-10-11/15), que no figuran en las tablas; dEstRes "Aprobado"/"Rechazado" (todas).
 */
final class CodigosDeResultadoTest extends TestCase
{
  public function testLosCodigosSonTextoDeCuatroDigitosYSeResuelvenEnCualquierForma(): void
  {
    $this->assertSame('0260', CodigoResultadoWS::AutorizacionDeSatisfactoria->value);
    foreach ([260, '260', '0260', ' 0260 '] as $forma) {
      $this->assertSame(CodigoResultadoWS::AutorizacionDeSatisfactoria, CodigoResultadoWS::fromAny($forma), var_export($forma, true));
    }
    $this->assertNull(CodigoResultadoWS::fromAny('1321'), 'las validaciones del DE no son códigos de WS');
    $this->assertNull(CodigoResultadoWS::fromAny('abc'));
    $this->assertNull(CodigoResultadoWS::fromAny(''));
    foreach (CodigoResultadoWS::cases() as $caso) {
      $this->assertMatchesRegularExpression('/^0[0-6][0-9]{2}$/', $caso->value, $caso->name);
      $this->assertSame($caso->value, $caso->codigo());
      $this->assertNotSame('', $caso->descripcion(), $caso->name);
    }
  }

  /** Resolución del 03/10/2026: la tabla 12.3.4.3 del MT escribe 0421 para "CDC encontrado" por error. */
  public function testConsultaDe0420A0422(): void
  {
    $this->assertSame('CDC inexistente', CodigoResultadoWS::CdcInexistente->descripcion());
    $this->assertSame('0421', CodigoResultadoWS::RucSinPermisoParaConsultar->value);
    $this->assertStringContainsStringIgnoringCase('sin permiso', CodigoResultadoWS::RucSinPermisoParaConsultar->descripcion());
    $this->assertSame('0422', CodigoResultadoWS::CdcEncontrado->value);
    $this->assertSame('CDC encontrado', CodigoResultadoWS::CdcEncontrado->descripcion());
    $this->assertTrue(CodigoResultadoWS::CdcEncontrado->esAprobacion());
    $this->assertFalse(CodigoResultadoWS::RucSinPermisoParaConsultar->esAprobacion());
  }

  public function testAprobacionesTransitoriosYVigencia(): void
  {
    $aprobaciones = array_map(fn (CodigoResultadoWS $c) => $c->value, array_filter(CodigoResultadoWS::cases(), fn ($c) => $c->esAprobacion()));
    $this->assertSame(['0260', '0300', '0362', '0422', '0502', '0520', '0600'], array_values($aprobaciones));

    $transitorios = array_map(fn (CodigoResultadoWS $c) => $c->value, array_filter(CodigoResultadoWS::cases(), fn ($c) => $c->esTransitorio()));
    $this->assertSame(['0100', '0161', '0162', '0361'], array_values($transitorios));

    $noVigentes = array_map(fn (CodigoResultadoWS $c) => $c->value, array_filter(CodigoResultadoWS::cases(), fn ($c) => !$c->vigente()));
    $this->assertSame(['0101', '0102', '0104', '0105', '0106', '0107', '0123', '0124', '0125', '0126'], array_values($noVigentes), 'AB02-AB08 y AC04-AC07, eliminados en v150');

    $observados = array_map(fn (CodigoResultadoWS $c) => $c->value, array_filter(CodigoResultadoWS::cases(), fn ($c) => $c->esObservado()));
    $this->assertSame(['0100', '0143'], array_values($observados), 'solo en capturas reales, no en las tablas del MT');
    $this->assertCount(57, CodigoResultadoWS::cases(), '40 vigentes del MT + 0364 + 0520-0523 + 2 observados + 10 eliminados');
  }

  public function testIdDelMtYCategoria(): void
  {
    $this->assertSame('BC01', CodigoResultadoWS::AutorizacionDeSatisfactoria->idMT());
    $this->assertSame('AE01', CodigoResultadoWS::XmlMalFormado->idMT());
    $this->assertSame('BO04', CodigoResultadoWS::ArchivoRucEncontrado->idMT());
    $this->assertNull(CodigoResultadoWS::ConsultaLoteExtemporanea->idMT(), '0364 viene de la guía de la DNIT, sin ID');
    $this->assertNull(CodigoResultadoWS::FirmaDelEventoNoEsDelReceptor->idMT());

    $this->assertSame(CategoriaCodigoWS::CertificadoTransmision, CodigoResultadoWS::fromAny('0001')->categoria());
    $this->assertSame(CategoriaCodigoWS::FirmaDigital, CodigoResultadoWS::FirmaDelEventoNoEsDelReceptor->categoria());
    $this->assertSame(CategoriaCodigoWS::GenericaMensajes, CodigoResultadoWS::XmlMalFormado->categoria());
    $this->assertSame(CategoriaCodigoWS::RecepcionDe, CodigoResultadoWS::AutorizacionDeSatisfactoria->categoria());
    $this->assertSame(CategoriaCodigoWS::ResultadoLote, CodigoResultadoWS::ConsultaLoteExtemporanea->categoria());
    $this->assertSame(CategoriaCodigoWS::ConsultaDe, CodigoResultadoWS::CdcEncontrado->categoria());
    $this->assertSame(CategoriaCodigoWS::ConsultaRuc, CodigoResultadoWS::RucEncontrado->categoria());
    $this->assertSame(CategoriaCodigoWS::ConsultaArchivoRuc, CodigoResultadoWS::ArchivoRucLimiteDeDescargas->categoria());
    $this->assertSame(CategoriaCodigoWS::RecepcionEvento, CodigoResultadoWS::EventoRegistrado->categoria());
    $this->assertSame(CategoriaCodigoWS::FormaAreaDatos, CodigoResultadoWS::ErrorInesperado->categoria());
    foreach (CategoriaCodigoWS::cases() as $categoria) {
      $this->assertNotSame('', $categoria->descripcion(), $categoria->name);
    }
  }

  /** Las constantes enteras existentes siguen valiendo y coinciden con el enum. */
  public function testCoincideConLasConstantesExistentes(): void
  {
    $pares = [
      [RResEnviConsRUC::COD_RES_RUC_NOT_FOUND, CodigoResultadoWS::RucInexistente],
      [RResEnviConsRUC::COD_RES_RUC_FOUND, CodigoResultadoWS::RucEncontrado],
      [RResEnviLoteDe::COD_RES_ACEPTADO, CodigoResultadoWS::LoteRecibido],
      [RResEnviLoteDe::COD_RES_RECHAZADO, CodigoResultadoWS::LoteNoEncolado],
      [RResEnviConsLoteDe::COD_RES_EN_PROCESAMIENTO, CodigoResultadoWS::LoteEnProcesamiento],
      [RResEnviConsLoteDe::COD_RES_CONSULTA_EXTEMPORANEA, CodigoResultadoWS::ConsultaLoteExtemporanea],
      [RResEnviConsArchivoRUC::COD_RES_LIMITE_DESCARGAS, CodigoResultadoWS::ArchivoRucLimiteDeDescargas],
    ];
    foreach ($pares as [$entero, $caso]) {
      $this->assertSame($caso, CodigoResultadoWS::fromAny($entero));
    }
  }

  /** @return iterable<string, array{string, string|null}> captura → caso esperado (null: código de validación del DE o de evento, catálogo de C5) */
  public static function codigosCapturados(): iterable
  {
    yield 'RUC 0502' => [R::RUC_0502, 'RucEncontrado'];
    yield 'consulta 0420' => [R::CONSULTA_DE_0420, 'CdcInexistente'];
    yield 'envío 0260' => [R::ENVIO_DE_0260, 'AutorizacionDeSatisfactoria'];
    yield 'evento 4009' => [R::EVENTO_4009, null];
    yield 'consulta 0422' => [R::CONSULTA_DE_0422, 'CdcEncontrado'];
    yield 'evento 0100' => [R::EVENTO_0100, 'ErrorInesperado'];
    yield 'evento 0600' => [R::EVENTO_0600, 'EventoRegistrado'];
    yield 'envío 0160' => [R::ENVIO_DE_0160, 'XmlMalFormado'];
    yield 'AF 2562' => [R::ENVIO_AF_2562, null];
    yield 'ANG 1206' => [R::ENVIO_FE_ANG_1206, null];
    yield 'lote 0300' => [R::LOTE_0300, 'LoteRecibido'];
    yield 'consulta de lote 0362' => [R::CONSULTA_LOTE_0362, 'LoteConcluido'];
    yield 'eventos 0143' => [R::EVENTOS_RECEPTOR_0143, 'FirmaDelEventoNoEsDelReceptor'];
  }

  #[DataProvider('codigosCapturados')]
  public function testLosCodigosDeLasCapturasResuelven(string $captura, ?string $caso): void
  {
    $codigo = self::primerCodigo($captura);
    $resuelto = CodigoResultadoWS::fromAny($codigo);
    if ($caso === null) {
      $this->assertNull($resuelto, "$codigo no es un código de WS");
      $this->assertGreaterThanOrEqual(1000, (int) $codigo);
    } else {
      $this->assertSame(CodigoResultadoWS::{$caso}, $resuelto, $codigo);
      $this->assertTrue($resuelto->vigente());
    }
  }

  /** Primer dCodRes (o dCodResLot) que aparece en el sobre capturado. */
  private static function primerCodigo(string $captura): string
  {
    $xml = R::crudo($captura);
    preg_match('/<ns2:dCodRes(?:Lot)?>(\d{4})</', $xml, $m);
    return $m[1];
  }

  public function testEstadoResultadoTolerante(): void
  {
    $this->assertSame(EstadoResultado::Aprobado, EstadoResultado::fromTexto('Aprobado'));
    $this->assertSame(EstadoResultado::Aprobado, EstadoResultado::fromTexto(' APROBADO '));
    $this->assertSame(EstadoResultado::Rechazado, EstadoResultado::fromTexto('Rechazado'));
    $this->assertSame(EstadoResultado::AprobadoConObservacion, EstadoResultado::fromTexto('Aprobado con observación'));
    $this->assertSame(EstadoResultado::AprobadoConObservacion, EstadoResultado::fromTexto('aprobado con observacion'));
    $this->assertNull(EstadoResultado::fromTexto('otro'));
    $this->assertNull(EstadoResultado::fromTexto(null));
    $this->assertTrue(EstadoResultado::Aprobado->esAprobado());
    $this->assertTrue(EstadoResultado::AprobadoConObservacion->esAprobado());
    $this->assertFalse(EstadoResultado::Rechazado->esAprobado());
    $this->assertSame(['A', 'AO', 'R'], array_map(fn ($e) => $e->letra(), EstadoResultado::cases()));
    // Literales reales de las capturas (dEstRes).
    foreach ([R::ENVIO_DE_0260 => 'Aprobado', R::ENVIO_DE_0160 => 'Rechazado'] as $captura => $literal) {
      preg_match('/<ns2:dEstRes>([^<]+)</', R::crudo($captura), $m);
      $this->assertSame($literal, $m[1]);
      $this->assertNotNull(EstadoResultado::fromTexto($m[1]));
    }
  }

  public function testEstadoRucCoincideConLasDescripcionesDeRContRUC(): void
  {
    $this->assertSame(EstadoRuc::Activo, EstadoRuc::from('ACT'));
    $this->assertTrue(EstadoRuc::Activo->esActivo());
    $this->assertFalse(EstadoRuc::Cancelado->esActivo());
    $this->assertNull(EstadoRuc::tryFrom('XXX'));
    foreach (EstadoRuc::cases() as $estado) {
      $r = new RContRUC();
      $r->dCodEstCons = $estado->value;
      $this->assertSame(preg_replace('/\s+/', ' ', $r->getDDesEstCons()), $estado->descripcion(), $estado->name);
    }
  }
}
