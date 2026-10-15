<?php

namespace IonysDev\Pkuatia\Tests\Unit\Exceptions;

use IonysDev\Pkuatia\Core\Constants\MotivoCertificado;
use IonysDev\Pkuatia\Core\Constants\TipoFallaTransporte;
use IonysDev\Pkuatia\Core\Exceptions\CampoInvalidoException;
use IonysDev\Pkuatia\Core\Exceptions\CertificadoException;
use IonysDev\Pkuatia\Core\Exceptions\ConfiguracionException;
use IonysDev\Pkuatia\Core\Exceptions\FirmaException;
use IonysDev\Pkuatia\Core\Exceptions\PkuatiaException;
use IonysDev\Pkuatia\Core\Exceptions\PkuatiaExceptionInterface;
use IonysDev\Pkuatia\Core\Exceptions\RespuestaException;
use IonysDev\Pkuatia\Core\Exceptions\SifenNoDisponibleException;
use IonysDev\Pkuatia\Core\Exceptions\TransporteException;
use IonysDev\Pkuatia\Core\Exceptions\ValidacionException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SoapFault;

/**
 * Jerarquía de excepciones de la Fase C (paso C2; evaluación §7.2 con las decisiones Q-C2 y Q-C3). Cada clase nueva
 * extiende la que se lanzaba hasta 0.2.1 en ese lugar (\Exception, \InvalidArgumentException o \SoapFault), así que
 * todo catch existente sigue funcionando, y todas comparten PkuatiaExceptionInterface. Los patrones de falla de
 * transporte salen de lo observado contra sifen-test (memoria de rutas y rate limit; capturas del 06, 09 y 11/10/2026).
 */
final class JerarquiaExcepcionesTest extends TestCase
{
  /** @return iterable<string, array{class-string<\Throwable>, class-string<\Throwable>}> */
  public static function basesHistoricas(): iterable
  {
    yield 'PkuatiaException' => [PkuatiaException::class, \Exception::class];
    yield 'ConfiguracionException' => [ConfiguracionException::class, PkuatiaException::class];
    yield 'CertificadoException' => [CertificadoException::class, ConfiguracionException::class];
    yield 'FirmaException' => [FirmaException::class, PkuatiaException::class];
    yield 'RespuestaException' => [RespuestaException::class, PkuatiaException::class];
    yield 'ValidacionException' => [ValidacionException::class, \InvalidArgumentException::class];
    yield 'CampoInvalidoException' => [CampoInvalidoException::class, ValidacionException::class];
    yield 'TransporteException' => [TransporteException::class, SoapFault::class];
    yield 'SifenNoDisponibleException' => [SifenNoDisponibleException::class, TransporteException::class];
  }

  #[DataProvider('basesHistoricas')]
  public function testCadaClaseConservaSuBaseHistoricaYLaInterfazComun(string $clase, string $base): void
  {
    $e = new $clase('mensaje');
    $this->assertInstanceOf($base, $e);
    $this->assertInstanceOf(\Exception::class, $e, 'toda excepción de la librería sigue siendo una \Exception');
    $this->assertInstanceOf(PkuatiaExceptionInterface::class, $e);
    $this->assertSame('mensaje', $e->getMessage());
  }

  public function testLaTransporteExceptionConservaElSoapFaultOriginalComoCausa(): void
  {
    $original = new SoapFault('HTTP', 'Could not connect to host');
    $e = TransporteException::desde($original, 'EnviarDE', '[Sifen] Error al enviar el documento electrónico al SIFEN');

    $this->assertNotInstanceOf(SifenNoDisponibleException::class, $e);
    $this->assertSame('[Sifen] Error al enviar el documento electrónico al SIFEN: Could not connect to host', $e->getMessage());
    $this->assertSame('HTTP', $e->faultcode, 'faultcode del SoapFault original');
    $this->assertSame($e->getMessage(), $e->faultstring);
    $this->assertSame($original, $e->getPrevious(), 'SoapFault::__construct no acepta la causa; se fija aparte');
    $this->assertSame('EnviarDE', $e->getOperacion());
    $this->assertSame(TipoFallaTransporte::Conexion, $e->getTipo());
    $this->assertFalse($e->esPosibleSaturacion());

    try {
      throw $e;
    } catch (SoapFault $f) {
      $this->assertSame($e, $f, 'catch (\SoapFault) sigue atrapando las fallas de las consultas (Q-C3, opción C)');
    }
  }

  /** @return iterable<string, array{string|null, string, TipoFallaTransporte, bool}> */
  public static function fallasObservadas(): iterable
  {
    yield 'WSDL que no carga (bloqueo o caída)' => ['WSDL', "SOAP-ERROR: Parsing WSDL: Couldn't load from 'https://sifen-test.set.gov.py/de/ws/sync/recibe.wsdl' : failed to load external entity \"https://sifen-test.set.gov.py/de/ws/sync/recibe.wsdl\"", TipoFallaTransporte::Wsdl, true];
    yield 'esquema del WSDL a medias (rate limit 2026-10-04)' => ['WSDL', "SOAP-ERROR: Parsing Schema: can't import schema from 'https://sifen-test.set.gov.py/de/ws/sync/recibe.wsdl.xsd1.xsd'", TipoFallaTransporte::Wsdl, true];
    yield 'cuerpo vacío' => ['Client', 'looks like we got no XML document', TipoFallaTransporte::RespuestaVaciaONoXml, true];
    yield 'documento vacío (rate limit)' => ['Client', 'Document is empty', TipoFallaTransporte::RespuestaVaciaONoXml, true];
    yield 'sin conexión' => ['HTTP', 'Could not connect to host', TipoFallaTransporte::Conexion, false];
    yield 'lectura agotada' => ['HTTP', 'Error Fetching http headers', TipoFallaTransporte::TiempoAgotado, false];
    yield 'corte TLS' => ['HTTP', 'SSL: Connection reset by peer', TipoFallaTransporte::Tls, false];
    yield 'falla SOAP del servidor' => ['Receiver', 'Servicio no disponible', TipoFallaTransporte::SoapFault, false];
    yield 'falla SOAP del cliente' => ['Client', 'Function ("x") is not a valid method for this service', TipoFallaTransporte::SoapFault, false];
    yield 'desconocida' => ['HTTP', 'algo raro', TipoFallaTransporte::Desconocida, false];
  }

  #[DataProvider('fallasObservadas')]
  public function testElTipoDeFallaSeDeduceDelSoapFault(?string $faultcode, string $faultstring, TipoFallaTransporte $tipo, bool $saturacion): void
  {
    $e = TransporteException::desde(new SoapFault($faultcode, $faultstring), 'ConsultarRUC', '[Sifen] Error al consultar el RUC en el SIFEN');
    $this->assertSame($tipo, $e->getTipo());
    $this->assertSame($saturacion, $e->esPosibleSaturacion());
    $this->assertSame($saturacion, $e instanceof SifenNoDisponibleException, 'el patrón de saturación llega como SifenNoDisponibleException');
    $this->assertNotSame('', $tipo->descripcion());
  }

  public function testCertificadoExceptionLlevaElMotivo(): void
  {
    $causa = new \RuntimeException('openssl');
    $e = CertificadoException::porMotivo(MotivoCertificado::PassphraseIncorrecta, '[Pkcs12Helper] contraseña incorrecta', $causa);
    $this->assertSame(MotivoCertificado::PassphraseIncorrecta, $e->getMotivo());
    $this->assertSame($causa, $e->getPrevious());
    $this->assertInstanceOf(ConfiguracionException::class, $e);
    $this->assertNull((new CertificadoException('sin motivo'))->getMotivo());
    foreach (MotivoCertificado::cases() as $motivo) {
      $this->assertNotSame('', $motivo->descripcion(), $motivo->name);
    }
  }

  public function testRespuestaExceptionConservaOperacionYRespuestaCruda(): void
  {
    $causa = new \TypeError('tipo');
    $e = RespuestaException::desde($causa, 'ConsultarDE', '[Sifen] Error al consultar: tipo', '<env:Envelope/>');
    $this->assertSame('ConsultarDE', $e->getOperacion());
    $this->assertSame('<env:Envelope/>', $e->getRespuestaCruda());
    $this->assertSame($causa, $e->getPrevious());
    $this->assertNull($e->getCampoFaltante());

    $f = RespuestaException::porCampoFaltante('[RResEnviLoteDe] falta dProtConsLote', 'dProtConsLote', 'EnviarLoteDE');
    $this->assertSame('dProtConsLote', $f->getCampoFaltante());
    $this->assertSame('EnviarLoteDE', $f->getOperacion());
    $this->assertNull($f->getRespuestaCruda());
  }

  public function testCampoInvalidoExceptionDescribeElCampo(): void
  {
    $e = CampoInvalidoException::deCampo('[Sifen] NT-024', 'D208', 'iTipIDRec', 5, 'D208 ≠ 5 cuando F014 ≥ 7.000.000', '1321');
    $this->assertSame('D208', $e->getCampoMT());
    $this->assertSame('iTipIDRec', $e->getElemento());
    $this->assertSame(5, $e->getValorRecibido());
    $this->assertSame('D208 ≠ 5 cuando F014 ≥ 7.000.000', $e->getReglaEsperada());
    $this->assertSame('1321', $e->getCodigoSifen());
    $this->assertInstanceOf(\InvalidArgumentException::class, $e, 'compatible con los catch de los 83 InvalidArgumentException actuales');
    $this->assertSame(['campoMT' => 'D208', 'elemento' => 'iTipIDRec', 'valorRecibido' => 5, 'reglaEsperada' => 'D208 ≠ 5 cuando F014 ≥ 7.000.000', 'codigoSifen' => '1321'], $e->getContexto());
  }

  public function testElContextoSeAgregaSinSecretos(): void
  {
    $this->assertSame([], (new PkuatiaException('x'))->getContexto());
    $e = (new ValidacionException('x'))->conContexto(['campo' => 'dNumTim']);
    $this->assertSame(['campo' => 'dNumTim'], $e->getContexto());
    $t = TransporteException::desde(new SoapFault('HTTP', 'Could not connect to host'), 'EnviarDE', 'p');
    $this->assertSame(['operacion' => 'EnviarDE', 'tipo' => 'conexion', 'faultcode' => 'HTTP'], $t->getContexto());
  }
}
