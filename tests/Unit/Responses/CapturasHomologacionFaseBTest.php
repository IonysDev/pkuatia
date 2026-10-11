<?php

namespace IonysDev\Pkuatia\Tests\Unit\Responses;

use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;
use IonysDev\Pkuatia\Core\Responses\RResEnviConsLoteDe;
use IonysDev\Pkuatia\Core\Responses\RResEnviLoteDe;
use IonysDev\Pkuatia\Sifen;
use IonysDev\Pkuatia\Tests\Support\RespuestasSifenFactory as R;
use IonysDev\Pkuatia\Tests\Support\RoundTrip;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Tests\Support\XsdAssertions;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Capturas reales de sifen-test del 11/10/2026, de la homologación de la Fase B (B13), copiadas de
 * ekuat-ia/06-ejemplos/respuestas-ws/2026-10-11/ (commit cf55702; ver el README de esa carpeta). Las respuestas
 * se leen a través del facade con CapturaSoapClient, que reproduce el modo WSDL, incluido el null del rechazo
 * genérico. Los documentos firmados son los que se enviaron, anonimizados: su firma ya no verifica, pero su
 * estructura es la real.
 */
final class CapturasHomologacionFaseBTest extends TestCase
{
  /** CDC anonimizado de la FE en cuotas aprobada, sobre la que se mandaron los eventos del receptor. */
  private const CDC_FE_CUOTAS = '01800000005001001000011522026101117739149814';
  private const LOTE = '85929997107567388';

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

  /** @return array<string, array{0: string, 1: string, 2: string, 3: string}> captura, dEstRes, dCodRes, texto de dMsgRes */
  public static function envios(): array
  {
    return [
      'FE en cuotas' => [R::ENVIO_FE_CUOTAS_0260, 'Aprobado', '0260', 'Autorización del DE satisfactoria'],
      'NR' => [R::ENVIO_NR_0260, 'Aprobado', '0260', 'Autorización del DE satisfactoria'],
      'AF con vendedor contribuyente' => [R::ENVIO_AF_2562, 'Rechazado', '2562', 'El vendedor no debe ser contribuyente'],
      'AF con constancia' => [R::ENVIO_AF_0260, 'Aprobado', '0260', 'Autorización del DE satisfactoria'],
      'FE en ANG' => [R::ENVIO_FE_ANG_1206, 'Rechazado', '1206', 'Descripción de la moneda de la operación no corresponde al código'],
      'FE con cuatro sectores' => [R::ENVIO_FE_SECTORES_0260, 'Aprobado', '0260', 'Autorización del DE satisfactoria'],
      'FE con vehículo nuevo' => [R::ENVIO_FE_VEHICULO_0260, 'Aprobado', '0260', 'Autorización del DE satisfactoria'],
    ];
  }

  #[DataProvider('envios')]
  public function testRespuestasDelEnvio(string $captura, string $estado, string $codigo, string $mensaje): void
  {
    R::instalar($captura);

    $protocolo = Sifen::EnviarDE('<rDE/>')->getRProtDe();

    $this->assertSame($estado, $protocolo->getDEstRes());
    $this->assertSame($codigo, $protocolo->getGResProc()[0]->getDCodRes());
    $this->assertStringContainsString($mensaje, $protocolo->getGResProc()[0]->getDMsgRes());
    $estado === 'Aprobado' ? $this->assertNotNull($protocolo->getDProtAut()) : $this->assertNull($protocolo->getDProtAut());
  }

  /** PK-35 y Q-B11: la constancia de no ser contribuyente vuelve del SIFEN con su número y su control. */
  public function testLaConsultaDeLaAutofacturaDevuelveLaConstancia(): void
  {
    R::instalar(R::CONSULTA_AF_0422);

    $respuesta = Sifen::ConsultarDE('04800000005001001000011822026101114905441108');
    $constancias = array_values(array_filter($respuesta->getRContDe()->getRDe()->getDE()->getGCamDEAsoc(), fn ($a) => $a->getITipDocAso() == 3));

    $this->assertSame(422, $respuesta->getDCodRes());
    $this->assertCount(1, $constancias);
    $this->assertSame(1, $constancias[0]->getITipCons());
    $this->assertSame(12345678901, $constancias[0]->getDNumCons());
    $this->assertSame('A1B2C3D4', $constancias[0]->getDNumControl());
  }

  /** B12 y Q-B12: el vehículo nuevo vuelve con el código de operación y las medidas con decimales. */
  public function testLaConsultaDeLaFeDelVehiculoDevuelveLasMedidas(): void
  {
    R::instalar(R::CONSULTA_FE_VEHICULO_0422);

    $respuesta = Sifen::ConsultarDE('01800000005001001000012122026101117948210816');
    $vehiculo = $respuesta->getRContDe()->getRDe()->getDE()->getGDtipDE()->getGCamItem()[0]->getGVehNuevo();

    $this->assertSame(2, $vehiculo->getITipOpVN());
    $this->assertSame('Venta al Consumidor final', $vehiculo->getDDesTipOpVN());
    $this->assertSame(['1200.5', '1500.25', '1500.75'], [$vehiculo->getDPNetDecimal(), $vehiculo->getDPBrutoDecimal(), $vehiculo->getDCapTraccDecimal()]);
  }

  /** La consulta del CDC de un envío cortado por SSL: el SIFEN no lo registró. */
  public function testConsultaDeUnEnvioCortado(): void
  {
    R::instalar(R::CONSULTA_DE_0420_1110);

    $respuesta = Sifen::ConsultarDE(self::CDC_FE_CUOTAS);

    $this->assertSame(420, $respuesta->getDCodRes());
    $this->assertSame('Documento No Existe en SIFEN o ha sido Rechazado', $respuesta->getDMsgRes());
    $this->assertNull($respuesta->getRContDe());
  }

  /** B13b: el rechazo genérico de la consulta de RUC llega como null con el WSDL y se lee de la respuesta cruda. */
  public function testRechazoGenericoEnLaConsultaDeRuc(): void
  {
    R::instalar(R::RUC_0160_1145);

    $respuesta = Sifen::ConsultarRUC('9999991');

    $this->assertSame('160', $respuesta->getDCodRes());
    $this->assertSame('XML Mal Formado.', $respuesta->getDMsgRes());
  }

  /** PK-41: la recepción del lote con los dos rDE que se enviaron, y su número de 17 dígitos como texto. */
  public function testRecepcionDelLote(): void
  {
    R::instalar(R::LOTE_0300);

    $recepcion = Sifen::EnviarLoteDE([self::rde('13-lote-FE1-firmada-anonimizada.xml'), self::rde('13-lote-FE2-firmada-anonimizada.xml')]);

    $this->assertSame(RResEnviLoteDe::COD_RES_ACEPTADO, $recepcion->getDCodRes());
    $this->assertSame('Lote recibido con éxito', $recepcion->getDMsgRes());
    $this->assertSame(self::LOTE, $recepcion->getDProtConsLoteString());
  }

  /** PK-41: la consulta a los 10 minutos ya da 0362 con los dos documentos; dFecProc es la hora de recepción. */
  public function testConsultaDelLoteConcluido(): void
  {
    R::instalar(R::CONSULTA_LOTE_0362);

    $lote = Sifen::ConsultaLote(self::LOTE);

    $this->assertSame(RResEnviConsLoteDe::COD_RES_ACEPTADO, $lote->getDCodResLot());
    $this->assertSame('Procesamiento de lote {' . self::LOTE . '} concluido', $lote->getDMsgResLot());
    $this->assertSame('2026-10-11T11:49:59-03:00', $lote->getdFecProc()->format(DATE_ATOM));
    $this->assertCount(2, $lote->getGResProcLote());
    foreach ($lote->getGResProcLote() as $documento) {
      $this->assertSame('Aprobado', $documento->getDEstRes());
      $this->assertNotSame('', $documento->getDProtAut());
      $this->assertSame('0260', $documento->getGResProc()[0]->getDCodRes());
      $this->assertSame('Aprobado', $documento->getGResProc()[0]->getDMsgRes());
    }
  }

  /** PK-29: cinco eventos en un sobre vuelven en cinco gResProcEVe, en orden, cada uno con su resultado. */
  public function testCincoEventosDelReceptorEnUnaRespuesta(): void
  {
    R::instalar(R::EVENTOS_RECEPTOR_0143);

    $eventos = Sifen::ConformarDE(self::CDC_FE_CUOTAS)->getGResProcEVe();

    $this->assertSame(['1', '2', '3', '4', '5'], array_map(fn ($e) => $e->getId(), $eventos));
    foreach ($eventos as $evento) {
      $this->assertSame('Rechazado', $evento->getDEstRes());
      $this->assertSame('0143', $evento->getGResProc()[0]->getDCodRes());
      $this->assertStringContainsString('La firma digital del evento debe corresponder al receptor', $evento->getGResProc()[0]->getDMsgRes());
    }
  }

  /** @return array<string, array{0: string, 1: string}> */
  public static function firmadosYVias(): array
  {
    $res = [];
    foreach (glob(R::DIR . '/2026-10-11/*-firmada-anonimizada.xml') as $ruta) {
      foreach (['DOM' => RoundTrip::VIA_DOM, 'SimpleXML' => RoundTrip::VIA_SIMPLEXML] as $nombre => $via) {
        $res[basename($ruta, '-firmada-anonimizada.xml') . " por $nombre"] = [basename($ruta), $via];
      }
    }
    return $res;
  }

  /** Los nueve rDE que se enviaron validan contra el XSD de producción y hacen ida y vuelta byte a byte (PK-32). */
  #[DataProvider('firmadosYVias')]
  public function testLosDocumentosEnviadosValidanYHacenIdaYVuelta(string $archivo, string $via): void
  {
    $rde = self::rde($archivo);

    XsdAssertions::assertRdeValido($rde, $archivo);
    $this->assertSame($rde, RoundTrip::serializar(RoundTrip::leer($rde, RDE::class, $via)));
  }

  /** El rDE de un archivo firmado de la carpeta del 11/10, sin la declaración XML. */
  private static function rde(string $archivo): string
  {
    return preg_replace('/^<\?xml[^>]*\?>\s*/', '', rtrim(R::crudo('2026-10-11/' . $archivo)));
  }
}
