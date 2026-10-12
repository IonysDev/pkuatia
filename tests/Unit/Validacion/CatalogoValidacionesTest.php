<?php

namespace IonysDev\Pkuatia\Tests\Unit\Validacion;

use IonysDev\Pkuatia\Core\Constants\CodigoResultadoWS;
use IonysDev\Pkuatia\Core\Constants\EstadoResultado;
use IonysDev\Pkuatia\Core\Responses\RResEnviConsArchivoRUC;
use IonysDev\Pkuatia\Core\Responses\RResEnviConsLoteDe;
use IonysDev\Pkuatia\Core\Responses\RResEnviConsRUC;
use IonysDev\Pkuatia\Core\Responses\RResEnviLoteDe;
use IonysDev\Pkuatia\Validacion\CatalogoValidaciones;
use IonysDev\Pkuatia\Validacion\InfoElemento;
use IonysDev\Pkuatia\Validacion\InfoValidacion;
use PHPUnit\Framework\TestCase;

/**
 * Paso C5 de la Fase C: catálogo de validaciones del SIFEN generado desde ekuat-ia (tools/generar-catalogos.php) a
 * src/Resources/codigos/. Fuentes: 08-errores-y-respuestas/errores-validacion.md (MT §12.4, 282 validaciones
 * vigentes del DE y 18 eliminadas), eventos-respuesta.md (MT §11.6, validaciones de eventos), respuestas-ws.md
 * (MT §12.2-12.3) y 03-estructura-xml/campos-obligatorios.md (ID del MT por elemento) más DE_v150.xsd fiel
 * (ocurrencias y líneas). Las pruebas de sincronía con ekuat-ia están en CatalogosSincroniaTest.
 */
final class CatalogoValidacionesTest extends TestCase
{
  public function testDescribeUnaValidacionDelDe(): void
  {
    $info = CatalogoValidaciones::describir('1004');
    $this->assertInstanceOf(InfoValidacion::class, $info);
    $this->assertSame('1004', $info->codigo);
    $this->assertSame('A004a', $info->id);
    $this->assertSame('La fecha y hora de la firma digital es adelantada', $info->mensaje);
    $this->assertSame('R', $info->estado);
    $this->assertSame(EstadoResultado::Rechazado, $info->getEstadoResultado());
    $this->assertTrue($info->vigente);
    $this->assertSame('de', $info->origen);
    $this->assertStringStartsWith('errores-validacion.md:', $info->fuente);
    $this->assertStringContainsString('no debe ser posterior', $info->observacion);
    $this->assertSame('1004 (A004a): La fecha y hora de la firma digital es adelantada', (string) $info);

    $this->assertSame('D208c', CatalogoValidaciones::describir(1321)->id, 'acepta entero');
    $this->assertSame('E304', CatalogoValidaciones::describir('2562')->id);
    $this->assertSame('D016', CatalogoValidaciones::describir('1206')->id);
    $this->assertSame('AO', CatalogoValidaciones::describir('1005')->estado, 'extemporaneidad: aprobado con observaciones');
    $this->assertSame(EstadoResultado::AprobadoConObservacion, CatalogoValidaciones::describir('1005')->getEstadoResultado());
    $this->assertNull(CatalogoValidaciones::describir('9999'));
    $this->assertNull(CatalogoValidaciones::describir('abc'));
  }

  public function testDescribeEventosYCodigosDeWs(): void
  {
    $evento = CatalogoValidaciones::describir('4009');
    $this->assertSame('GDE004a', $evento->id);
    $this->assertSame('evento', $evento->origen);
    $this->assertStringContainsString('extemporáneo', $evento->mensaje);

    $ws = CatalogoValidaciones::describir('0422');
    $this->assertSame('ws', $ws->origen);
    $this->assertSame('BL03', $ws->id, 'resolución 0420/0421/0422 del 03/10/2026');
    $this->assertSame('CDC encontrado', $ws->mensaje);
    $this->assertSame('A', $ws->estado);
    $this->assertSame('BL02', CatalogoValidaciones::describir('0421')->id);

    // Los códigos que no están en las tablas de ekuat-ia se describen desde el enum (observados, NT-011, guía).
    $this->assertSame('La firma digital del evento debe corresponder al receptor del DE/DTE', CatalogoValidaciones::describir('0143')->mensaje);
    $this->assertSame('Error Inesperado', CatalogoValidaciones::describir('0100')->mensaje);
    $this->assertNotNull(CatalogoValidaciones::describir('0364'));
  }

  public function testLosCodigosRepetidosSeConservanTodos(): void
  {
    $todos = CatalogoValidaciones::describirTodos('4313');
    $this->assertCount(2, $todos, 'GET015 y GET022 comparten el 4313 en la tabla 11.6.7 (devolución a ekuat-ia)');
    $this->assertSame(['GET015', 'GET022'], array_map(fn (InfoValidacion $i) => $i->id, $todos));
    $this->assertSame('GET015', CatalogoValidaciones::describir('4313')->id, 'describir() devuelve la primera');
  }

  public function testBuscaPorCampoDelMt(): void
  {
    $d208 = CatalogoValidaciones::porCampo('D208');
    $this->assertSame(['D208', 'D208a', 'D208b', 'D208c', 'D208d'], array_map(fn (InfoValidacion $i) => $i->id, $d208));
    $this->assertSame(['1310', '1311', '1319', '1321', '1322'], array_map(fn (InfoValidacion $i) => $i->codigo, $d208));
    $this->assertSame([], CatalogoValidaciones::porCampo('Z999'));
  }

  public function testConservaLasEliminadasYLasCuenta(): void
  {
    $c009 = CatalogoValidaciones::describir('1108');
    $this->assertSame('C009', $c009->id);
    $this->assertFalse($c009->vigente, 'eliminada en v150, se conserva para describir un código inesperado');

    $de = CatalogoValidaciones::todas('de');
    $this->assertCount(300, $de, '282 vigentes + 18 eliminadas');
    $this->assertCount(282, array_filter($de, fn (InfoValidacion $i) => $i->vigente));
    $this->assertGreaterThanOrEqual(88, count(array_filter(CatalogoValidaciones::todas('evento'), fn (InfoValidacion $i) => $i->vigente)));
    $this->assertGreaterThanOrEqual(40, count(array_filter(CatalogoValidaciones::todas('ws'), fn (InfoValidacion $i) => $i->vigente)));
    foreach (CatalogoValidaciones::todas() as $info) {
      $this->assertMatchesRegularExpression('/^\d{4}$/', $info->codigo, $info->fuente);
      $this->assertContains($info->estado, ['A', 'AO', 'R'], $info->fuente);
      $this->assertNotSame('', $info->mensaje, $info->fuente);
    }
  }

  public function testTodoCodigoQueUsaLaLibreriaEstaEnElCatalogo(): void
  {
    foreach (CodigoResultadoWS::cases() as $caso) {
      $this->assertNotNull(CatalogoValidaciones::describir($caso->value), $caso->name);
    }
    foreach ([RResEnviConsRUC::class, RResEnviLoteDe::class, RResEnviConsLoteDe::class, RResEnviConsArchivoRUC::class] as $clase) {
      foreach ((new \ReflectionClass($clase))->getConstants() as $nombre => $valor) {
        if (str_starts_with($nombre, 'COD_RES_')) {
          $this->assertNotNull(CatalogoValidaciones::describir($valor), "$clase::$nombre");
        }
      }
    }
  }

  public function testElCatalogoDeElementosDelXsd(): void
  {
    $numTim = CatalogoValidaciones::elemento('dNumTim');
    $this->assertInstanceOf(InfoElemento::class, $numTim);
    $this->assertSame('C004', $numTim->campoMT);
    $this->assertSame(1, $numTim->minOccurs);
    $this->assertSame(1, $numTim->maxOccurs);
    $this->assertSame('tgDTim', $numTim->padre);
    $this->assertGreaterThan(0, $numTim->linea, 'línea del XSD fiel, para citar');

    $serie = CatalogoValidaciones::elemento('dSerieNum');
    $this->assertSame('C010', $serie->campoMT);
    $this->assertSame(0, $serie->minOccurs);

    $entCont = CatalogoValidaciones::elemento('dEntCont');
    $this->assertSame('E022', $entCont->campoMT);
    $this->assertSame('dEntCont ', $entCont->nombreOriginal, 'el XSD oficial lo declara con un espacio final (PK-44)');
    $this->assertSame(327, $entCont->linea);

    $this->assertNull(CatalogoValidaciones::elemento('noExiste'));
    $this->assertSame('C004', CatalogoValidaciones::campoMT('dNumTim'));

    $this->assertSame(['iTiDE', 'dDesTiDE', 'dNumTim', 'dEst', 'dPunExp', 'dNumDoc', 'dSerieNum', 'dFeIniT'],
      array_map(fn (InfoElemento $e) => $e->nombre, CatalogoValidaciones::hijosDe('gTimb')), 'por nombre de elemento');
    $this->assertSame(['dModCont', 'dEntCont', 'dAnoCont', 'dSecCont', 'dFeCodCont'],
      array_map(fn (InfoElemento $e) => $e->nombre, CatalogoValidaciones::hijosDe('tgCompPub')), 'por nombre de tipo');
    $items = CatalogoValidaciones::elemento('gCamItem');
    $this->assertSame(999, $items->maxOccurs);
    $this->assertNull(CatalogoValidaciones::elemento('gActEco')->padre === 'tgEmis' ? null : 'x');
    $this->assertSame(9, CatalogoValidaciones::elemento('gActEco')->maxOccurs);
  }

  public function testElMapaDeMetodosOrientaAlProgramador(): void
  {
    $this->assertStringContainsString('setTimbrado', CatalogoValidaciones::metodoPkuatia('C004'));
    $this->assertStringContainsString('setReceptor', CatalogoValidaciones::metodoPkuatia('D208'));
    $this->assertStringContainsString('calcTotSub', CatalogoValidaciones::metodoPkuatia('F014'));
    $this->assertStringContainsString('addItem', CatalogoValidaciones::metodoPkuatia('E734'));
    $this->assertNull(CatalogoValidaciones::metodoPkuatia('Z999'));
    $this->assertStringContainsString('setReceptor', CatalogoValidaciones::describir('1321')->metodoPkuatia);
  }
}
