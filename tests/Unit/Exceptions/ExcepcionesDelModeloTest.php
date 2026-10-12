<?php

namespace IonysDev\Pkuatia\Tests\Unit\Exceptions;

use IonysDev\Pkuatia\Core\Exceptions\PkuatiaExceptionInterface;
use IonysDev\Pkuatia\Core\Exceptions\RespuestaException;
use IonysDev\Pkuatia\Core\Exceptions\ValidacionException;
use IonysDev\Pkuatia\Core\Fields\DE\D\GDatRec;
use IonysDev\Pkuatia\Core\Fields\Response\GResProc;
use IonysDev\Pkuatia\Core\Responses\RResEnviLoteDe;
use IonysDev\Pkuatia\Core\Responses\RRetEnviDe;
use IonysDev\Pkuatia\Helpers\FechaHelper;
use IonysDev\Pkuatia\Sifen;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Tests\Support\StubSoapClient;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

/**
 * Paso C3 de la Fase C: los throw genéricos del modelo pasan a las excepciones tipadas sin cambiar mensajes.
 * Regla de compatibilidad: lo que era \InvalidArgumentException sigue siéndolo (ValidacionException) y lo que era
 * \Exception sigue siéndolo (ValidacionException, RespuestaException o PkuatiaException según el caso).
 */
final class ExcepcionesDelModeloTest extends TestCase
{
  private const SRC = __DIR__ . '/../../../src';

  /** Invariante de la fase: ningún throw genérico queda en src/ (fuera de los comentarios). */
  public function testNoQuedanThrowGenericosEnSrc(): void
  {
    $restantes = [];
    $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(self::SRC, \FilesystemIterator::SKIP_DOTS));
    foreach ($it as $archivo) {
      if ($archivo->getExtension() !== 'php') {
        continue;
      }
      foreach (file($archivo->getPathname()) as $n => $linea) {
        if (preg_match('~^\s*(//|\*|/\*)~', $linea)) {
          continue;
        }
        if (preg_match('/throw new \\\\?(Exception|InvalidArgumentException)\(/', $linea)) {
          $restantes[] = str_replace('\\', '/', substr($archivo->getPathname(), strlen(self::SRC) + 1)) . ':' . ($n + 1);
        }
      }
    }
    $this->assertSame([], $restantes, 'throw genéricos que faltan migrar');
  }

  public function testLasValidacionesDelModeloSonValidacionException(): void
  {
    $casos = [
      'DocumentoElectronico::setNumeroEstablecimiento (era \Exception)' => fn () => DocumentoFactory::facturaContado()->setNumeroEstablecimiento(0),
      'GDatRec::setCDepRec (era \InvalidArgumentException)' => fn () => (new GDatRec())->setCDepRec(99),
      'FechaHelper::FromSifen (era \InvalidArgumentException)' => fn () => FechaHelper::FromSifen('no es fecha', 'dFecProc'),
      'GResProc::FromSimpleXMLElement (era \InvalidArgumentException)' => fn () => GResProc::FromSimpleXMLElement(new SimpleXMLElement('<otro/>')),
    ];
    foreach ($casos as $nombre => $llamar) {
      try {
        $llamar();
        $this->fail("$nombre debía lanzar");
      } catch (ValidacionException $e) {
        $this->assertInstanceOf(\InvalidArgumentException::class, $e, $nombre);
        $this->assertInstanceOf(\Exception::class, $e, $nombre);
        $this->assertInstanceOf(PkuatiaExceptionInterface::class, $e, $nombre);
      }
    }
  }

  public function testLasRespuestasIncompletasSonRespuestaException(): void
  {
    try {
      RRetEnviDe::FromSifenResponseObject(null);
      $this->fail('Se esperaba RespuestaException');
    } catch (RespuestaException $e) {
      $this->assertSame('Error Processing Request: null', $e->getMessage(), 'el mensaje no cambia');
      $this->assertInstanceOf(\Exception::class, $e);
    }
    try {
      RResEnviLoteDe::FromSifenResponseObject((object) ['dFecProc' => '2026-10-11T11:49:59-03:00', 'dCodRes' => '0300', 'dMsgRes' => 'Lote recibido con éxito']);
      $this->fail('Se esperaba RespuestaException');
    } catch (RespuestaException $e) {
      $this->assertSame('dProtConsLote', $e->getCampoFaltante());
      $this->assertStringContainsString('falta parametro: dProtConsLote', $e->getMessage());
    }
  }

  /** El facade completa la RespuestaException de una clase de respuesta con la operación y la respuesta cruda. */
  public function testElFacadeCompletaLaRespuestaExceptionConLaOperacion(): void
  {
    $entorno = SifenTestEnvironment::init();
    try {
      StubSoapClient::instalar(['rEnvioLote' => fn () => (object) ['dFecProc' => '2026-10-11T11:49:59-03:00', 'dCodRes' => '0300', 'dMsgRes' => 'Lote recibido con éxito']]);
      try {
        Sifen::EnviarLoteDE(['<rDE><DE Id="01800000000001001000000122026011510123456781"><gTimb><iTiDE>1</iTiDE></gTimb><gEmis><dRucEm>80000000</dRucEm></gEmis></DE></rDE>']);
        $this->fail('Se esperaba RespuestaException');
      } catch (RespuestaException $e) {
        $this->assertSame('EnviarLoteDE', $e->getOperacion());
        $this->assertSame('dProtConsLote', $e->getCampoFaltante());
        $this->assertStringStartsWith('[Sifen] Error al enviar el lote', $e->getMessage());
        $this->assertInstanceOf(RespuestaException::class, $e->getPrevious());
      }
    } finally {
      ($entorno['cleanup'])();
    }
  }
}
