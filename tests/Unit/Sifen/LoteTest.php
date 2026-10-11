<?php

namespace IonysDev\Pkuatia\Tests\Unit\Sifen;

use IonysDev\Pkuatia\Core\Config;
use IonysDev\Pkuatia\Core\Responses\RResEnviConsLoteDe;
use IonysDev\Pkuatia\Core\Responses\RResEnviLoteDe;
use IonysDev\Pkuatia\Sifen;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Tests\Support\StubSoapClient;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Fase B/B10, PK-41. Guía de mejores prácticas de envío de la DNIT (ekuat-ia 10-guias/mejores-practicas-envio-de.md):
 * - §4: el lote se rechaza (0301) si trae RUC emisores distintos, tipos de DE distintos, más de 50 DE o un mensaje
 *   de más de 1000 KB.
 * - §5: un CDC repetido en el mismo lote, o un lote vacío o con contenido no válido, bloquea la recepción del RUC
 *   emisor de 10 a 60 minutos.
 * - §3.4 y §7: consultar el lote pasados 10 minutos de la recepción y luego a intervalos no menores a 10 minutos;
 *   0361 = en procesamiento, 0362 = concluido, 0364 = consulta extemporánea (más de 48 horas).
 * dProtConsLote llega con 17 dígitos en la práctica (guía §6) y el WS admite hasta 20 (CSch03).
 */
final class LoteTest extends TestCase
{
  private const CDC_1 = '01800000000001001000000122026011510123456781';
  private const CDC_2 = '01800000000001001000000222026011510123456782';
  private const LOTE = '11158097383597290';

  /** @var array{config: Config, cleanup: callable} */
  private array $entorno;

  protected function setUp(): void
  {
    $this->entorno = SifenTestEnvironment::init();
  }

  protected function tearDown(): void
  {
    ($this->entorno['cleanup'])();
  }

  public function testLoteConDosRucEmisoresSeRechazaAntesDeLaRed(): void
  {
    $mensaje = $this->rechazoAntesDeLaRed([self::rde(self::CDC_1), self::rde(self::CDC_2, '80000001')]);

    $this->assertStringContainsString('RUC emisor', $mensaje);
    $this->assertStringContainsString('80000000', $mensaje);
    $this->assertStringContainsString('80000001', $mensaje);
  }

  public function testLoteConUnCdcRepetidoSeRechazaAntesDeLaRed(): void
  {
    $mensaje = $this->rechazoAntesDeLaRed([self::rde(self::CDC_1), self::rde(self::CDC_2), self::rde(self::CDC_1)]);

    $this->assertStringContainsString(self::CDC_1, $mensaje);
    $this->assertStringContainsString('repetido', $mensaje);
  }

  /** @return array<string, array{0: string, 1: string}> */
  public static function documentosIncompletos(): array
  {
    return [
      'sin CDC' => ['<rDE><DE><gTimb><iTiDE>1</iTiDE></gTimb><gEmis><dRucEm>80000000</dRucEm></gEmis></DE></rDE>', 'CDC'],
      'sin RUC emisor' => ['<rDE><DE Id="' . self::CDC_1 . '"><gTimb><iTiDE>1</iTiDE></gTimb></DE></rDE>', 'RUC emisor'],
      'sin tipo de documento' => ['<rDE><DE Id="' . self::CDC_1 . '"><gEmis><dRucEm>80000000</dRucEm></gEmis></DE></rDE>', 'tipo de documento'],
    ];
  }

  #[DataProvider('documentosIncompletos')]
  public function testDocumentoIncompletoSeRechazaAntesDeLaRed(string $rde, string $falta): void
  {
    $this->assertStringContainsString($falta, $this->rechazoAntesDeLaRed([$rde]));
  }

  public function testLoteDeMasDe1000KBSeRechazaAntesDeLaRed(): void
  {
    // Texto que casi no se comprime: el ZIP en Base64 supera el límite del mensaje del WS.
    $mensaje = $this->rechazoAntesDeLaRed([self::rde(self::CDC_1, '80000000', bin2hex(random_bytes(800000)))]);

    $this->assertStringContainsString('1000 KB', $mensaje);
  }

  public function testLoteValidoLlegaAlSifenYConservaElNumeroDeLoteComoTexto(): void
  {
    StubSoapClient::instalar(['rEnvioLote' => fn () => self::respuestaRecepcion('0300', self::LOTE)]);

    $respuesta = Sifen::EnviarLoteDE([self::rde(self::CDC_1), self::rde(self::CDC_2)]);

    $this->assertCount(1, StubSoapClient::$llamadas);
    $this->assertSame(RResEnviLoteDe::COD_RES_ACEPTADO, $respuesta->getDCodRes());
    $this->assertSame(self::LOTE, $respuesta->getDProtConsLoteString());
  }

  public function testNumeroDeLoteDeVeinteDigitosYLoteRechazadoSinNumero(): void
  {
    $aceptado = RResEnviLoteDe::FromSifenResponseObject(self::respuestaRecepcion('0300', '12345678901234567890'));
    $rechazado = RResEnviLoteDe::FromSifenResponseObject(self::respuestaRecepcion('0301', null));

    $this->assertSame('12345678901234567890', $aceptado->getDProtConsLoteString());
    $this->assertNull($rechazado->getDProtConsLoteString());
  }

  public function testConsultaLoteAceptaElNumeroComoEnteroOTexto(): void
  {
    self::instalarConsultas(['0362', '0362']);

    Sifen::ConsultaLote((int) self::LOTE);
    $this->assertSame(self::LOTE, StubSoapClient::ultimoRequest()->dProtConsLote);
    Sifen::ConsultaLote(self::LOTE);
    $this->assertSame(self::LOTE, StubSoapClient::ultimoRequest()->dProtConsLote);
  }

  public function testEsperaDiezMinutosAntesDeCadaConsultaHastaQueElLoteConcluye(): void
  {
    self::instalarConsultas(['0361', '0361', '0362']);
    $esperas = [];
    $intentos = [];

    $respuesta = Sifen::EsperarResultadoLote(
      self::LOTE,
      onIntento: function (int $intento, RResEnviConsLoteDe $r) use (&$intentos): void {
        $intentos[] = [$intento, $r->getDCodResLot()];
      },
      esperar: function (int $segundos) use (&$esperas): void {
        $esperas[] = [$segundos, count(StubSoapClient::$llamadas)];
      },
    );

    $this->assertSame(RResEnviConsLoteDe::COD_RES_ACEPTADO, $respuesta->getDCodResLot());
    // [segundos, consultas hechas hasta ese momento]: cada consulta va precedida de una espera de 600 s.
    $this->assertSame([[600, 0], [600, 1], [600, 2]], $esperas);
    $this->assertSame([[1, 361], [2, 361], [3, 362]], $intentos);
    $this->assertSame(self::LOTE, StubSoapClient::ultimoRequest()->dProtConsLote);
  }

  public function testDevuelveLaUltimaRespuestaSiSigueEnProcesamientoTrasElUltimoIntento(): void
  {
    self::instalarConsultas(['0361', '0361', '0361']);
    $esperas = [];

    $respuesta = Sifen::EsperarResultadoLote(self::LOTE, 600, 900, 3, null, function (int $segundos) use (&$esperas): void {
      $esperas[] = $segundos;
    });

    $this->assertSame(RResEnviConsLoteDe::COD_RES_EN_PROCESAMIENTO, $respuesta->getDCodResLot());
    $this->assertCount(3, StubSoapClient::$llamadas);
    $this->assertSame([600, 900, 900], $esperas);
  }

  public function testLaConsultaExtemporaneaTerminaLaEspera(): void
  {
    self::instalarConsultas(['0364']);

    $respuesta = Sifen::EsperarResultadoLote(self::LOTE, esperar: function (int $segundos): void {
    });

    $this->assertSame(364, RResEnviConsLoteDe::COD_RES_CONSULTA_EXTEMPORANEA);
    $this->assertSame(RResEnviConsLoteDe::COD_RES_CONSULTA_EXTEMPORANEA, $respuesta->getDCodResLot());
    $this->assertCount(1, StubSoapClient::$llamadas);
  }

  /** @return array<string, array{0: int, 1: int, 2: int}> */
  public static function esperasInvalidas(): array
  {
    return [
      'espera inicial de 5 minutos' => [300, 600, 6],
      'intervalo de 1 minuto' => [600, 60, 6],
      'sin intentos' => [600, 600, 0],
    ];
  }

  #[DataProvider('esperasInvalidas')]
  public function testRechazaEsperasMenoresADiezMinutosSinConsultar(int $inicial, int $intervalo, int $intentos): void
  {
    self::instalarConsultas([]);
    $esperas = 0;

    try {
      Sifen::EsperarResultadoLote(self::LOTE, $inicial, $intervalo, $intentos, null, function (int $segundos) use (&$esperas): void {
        $esperas++;
      });
      $this->fail('Se esperaba InvalidArgumentException.');
    } catch (\InvalidArgumentException $e) {
      $this->assertSame([], StubSoapClient::$llamadas);
      $this->assertSame(0, $esperas);
    }
  }

  /** rDE mínimo con lo que EnviarLoteDE inspecciona: CDC, tipo de documento y RUC emisor. */
  private static function rde(string $cdc, string $ruc = '80000000', string $relleno = ''): string
  {
    return '<rDE xmlns="http://ekuatia.set.gov.py/sifen/xsd"><dVerFor>150</dVerFor><DE Id="' . $cdc . '">'
      . ($relleno === '' ? '' : '<gOpeDE><dInfoEmi>' . $relleno . '</dInfoEmi></gOpeDE>')
      . '<gTimb><iTiDE>1</iTiDE></gTimb><gDatGralOpe><gEmis><dRucEm>' . $ruc . '</dRucEm></gEmis></gDatGralOpe></DE></rDE>';
  }

  /** @param list<string> $lote Envía el lote esperando una excepción sin llamar al SIFEN; devuelve el mensaje. */
  private function rechazoAntesDeLaRed(array $lote): string
  {
    StubSoapClient::instalar([]);
    try {
      Sifen::EnviarLoteDE($lote);
    } catch (\Exception $e) {
      $this->assertSame([], StubSoapClient::$llamadas, 'El lote no debía llegar al SIFEN: ' . $e->getMessage());
      return $e->getMessage();
    }
    $this->fail('Se esperaba una excepción antes de enviar el lote.');
  }

  private static function respuestaRecepcion(string $codigo, ?string $lote): \stdClass
  {
    $r = new \stdClass();
    $r->dFecProc = '2026-10-10T10:00:00-03:00';
    $r->dCodRes = $codigo;
    $r->dMsgRes = $codigo === '0300' ? 'Lote recibido con éxito' : 'Lote no encolado para procesamiento';
    if ($lote !== null) {
      $r->dProtConsLote = $lote;
    }
    $r->dTpoProces = '0';
    return $r;
  }

  /** @param list<string> $codigos Códigos que devuelve la consulta de lote, en orden. */
  private static function instalarConsultas(array $codigos): void
  {
    StubSoapClient::instalar(['rEnviConsLoteDe' => function () use (&$codigos): \stdClass {
      $codigo = array_shift($codigos) ?? throw new \LogicException('Consulta de lote no prevista por el test.');
      return (object) ['dFecProc' => '2026-10-10T10:10:00-03:00', 'dCodResLot' => $codigo, 'dMsgResLot' => "Respuesta $codigo"];
    }]);
  }
}
