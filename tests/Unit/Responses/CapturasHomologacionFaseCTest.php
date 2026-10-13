<?php

namespace IonysDev\Pkuatia\Tests\Unit\Responses;

use DateTime;
use DateTimeZone;
use IonysDev\Pkuatia\Core\Constants;
use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;
use IonysDev\Pkuatia\Sifen;
use IonysDev\Pkuatia\Tests\Support\RespuestasSifenFactory as R;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Validacion\ValidadorDE;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Capturas reales de sifen-test del 13/10/2026, de la homologación del validador de reglas (Fase C, C14), copiadas de
 * ekuat-ia/06-ejemplos/respuestas-ws/2026-10-13/ (ver el README de esa carpeta). Cada documento se envió con una sola
 * violación (o una característica a confirmar): la respuesta del SIFEN se lee a través del facade y el documento
 * firmado anonimizado se pasa por el validador, que debe predecir el mismo código. Es el control de que el validador
 * dice lo que el SIFEN dice.
 */
final class CapturasHomologacionFaseCTest extends TestCase
{
  private const DIR = __DIR__ . '/../../Resources/sifen/respuestas-ws/2026-10-13';
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

  /** Momento de referencia para las reglas de fechas: dentro de la ventana de envíos (05:57 a 06:12 de Asunción). */
  private static function ahora(): DateTime
  {
    return new DateTime('2026-10-13T06:15:00', new DateTimeZone(Constants::SIFEN_TIMEZONE));
  }

  /**
   * @return array<string, array{0: string, 1: string, 2: string, 3: string, 4: string, 5: list<string>, 6: ?string}>
   *   captura, dEstRes, dCodRes, fragmento de dMsgRes, documento firmado, códigos que el validador debe predecir, campo del MT
   */
  public static function envios(): array
  {
    $aprobado = 'Autorización del DE satisfactoria';
    return [
      'DV del receptor' => [R::C14_1309, 'Rechazado', '1309', 'Dígito Verificador del RUC del receptor incorrecto', '02-1309-firmada-anonimizada.xml', ['1309'], 'D207'],
      'total general' => [R::C14_2365, 'Rechazado', '2365', 'Cálculo del total general de la operación incorrecto', '03-2365-firmada-anonimizada.xml', ['2365'], 'F014'],
      'contado sin pagos' => [R::C14_1550, 'Rechazado', '1550', 'forma de pago de la operación al contado', '04-1550-firmada-anonimizada.xml', ['1550'], 'E605'],
      'innominado en B2B' => [R::C14_1300, 'Rechazado', '1300', 'tipo de operación no compatible con la naturaleza del receptor', '05-1319-firmada-anonimizada.xml', ['1300', '1319'], 'D202'],
      'NC sin asociado' => [R::C14_2400, 'Rechazado', '2400', 'Documento asociado es obligatorio', '06-2400-firmada-anonimizada.xml', ['2400'], 'H001'],
      'firma adelantada' => [R::C14_1004, 'Rechazado', '1004', 'firma digital es adelantada', '07-1004-firmada-anonimizada.xml', ['1004'], 'A004'],
      'dInfAdic (J003)' => [R::C14_2503, 'Rechazado', '2503', 'Información adicional de interés para el emisor fue incluida', '10-2503-firmada-anonimizada.xml', ['2503'], 'J003'],
      'base gravada 0,01 mayor' => [R::C14_1911_0260, 'Aprobado', '0260', $aprobado, '11-1911-firmada-anonimizada.xml', [], null],
      'B2G con compras públicas (PK-44)' => [R::C14_B2G_0260, 'Aprobado', '0260', $aprobado, '12-b2g-firmada-anonimizada.xml', [], null],
      'dCilin numérico' => [R::C14_CILIN_0160, 'Rechazado', '0160', 'dCilin es invalido', '13-cilin-firmada-anonimizada.xml', ['0160'], null],
      'USD por ítem con fracción (Q-C8)' => [R::C14_USD_ITEM_0260, 'Aprobado', '0260', $aprobado, '14-usd-item-firmada-anonimizada.xml', [], null],
      'redondeo de EA008 a la unidad' => [R::C14_REDONDEO_0260, 'Aprobado', '0260', $aprobado, '15-redondeo-firmada-anonimizada.xml', [], null],
    ];
  }

  #[DataProvider('envios')]
  public function testLaRespuestaDelSifenYLaPrediccionDelValidadorCoinciden(string $captura, string $estado, string $codigo, string $mensaje, string $firmado, array $predichos, ?string $campo): void
  {
    R::instalar($captura);
    $respuesta = Sifen::EnviarDE('<rDE/>');
    $this->assertSame($estado, $respuesta->getRProtDe()->getDEstRes());
    $this->assertSame($codigo, $respuesta->getCodigo());
    $this->assertSame($estado === 'Aprobado', $respuesta->esAprobado());
    $this->assertStringContainsString($mensaje, (string) $respuesta->getMensaje());
    $estado === 'Aprobado' ? $this->assertNotNull($respuesta->getProtocolo()) : $this->assertNull($respuesta->getProtocolo());
    if ($campo !== null) {
      $info = $respuesta->getMotivos()[0]->getInfoValidacion();
      $this->assertNotNull($info, "el catálogo describe el $codigo");
      $this->assertStringStartsWith($campo, (string) $info->id);
    }

    $xml = (string) file_get_contents(self::DIR . '/' . $firmado);
    $resultado = ValidadorDE::validar(RDE::FromSimpleXMLElement(simplexml_load_string($xml)), self::ahora());
    if ($predichos === []) {
      $this->assertTrue($resultado->esValido(), "$firmado: el SIFEN lo aprobó y el validador no debe objetarlo: $resultado");
      $this->assertTrue(Sifen::ValidarXSD($xml)->esValido());
    } else {
      $this->assertContains($codigo, $predichos, 'el código del SIFEN está entre los que el validador predice');
      foreach ($predichos as $predicho) {
        $this->assertNotEmpty($resultado->porCodigo($predicho), "$firmado: el validador debía predecir $predicho: $resultado");
      }
    }
  }

  /** Los rechazos por regla traen Id y dDigVal (a diferencia del 0160 genérico del ambiente degradado) y ningún dProtAut. */
  public function testLosRechazosPorReglaTraenIdYDigestPeroNoProtocolo(): void
  {
    $cuerpo = R::elementoRespuesta(R::C14_1309);
    $this->assertSame(1, $cuerpo->getElementsByTagNameNS('*', 'Id')->length);
    $this->assertSame(1, $cuerpo->getElementsByTagNameNS('*', 'dDigVal')->length);
    $this->assertSame(0, $cuerpo->getElementsByTagNameNS('*', 'dProtAut')->length);
    $this->assertStringStartsWith('TEST - ', $cuerpo->getElementsByTagNameNS('*', 'dMsgRes')->item(0)->textContent, 'el ambiente de pruebas antepone "TEST - " a los mensajes de las validaciones');
  }

  /** El canario de la ventana 2 recibió el 0160 genérico del ambiente degradado y, un minuto después, el 0502 normal. */
  public function testElCanarioRechazadoConEl0160GenericoSeLeeComoHastaAhora(): void
  {
    R::instalar(R::C14_RUC_0160_GENERICO);
    $respuesta = Sifen::ConsultarRUC('9999991');
    $this->assertSame('0160', $respuesta->getCodigo());
    $this->assertSame('XML Mal Formado.', $respuesta->getMensaje());
    $this->assertFalse($respuesta->esExitosa());
  }

  public function testElDocumentoConDCilinNoCumpleElXsdDeProduccion(): void
  {
    $r = Sifen::ValidarXSD((string) file_get_contents(self::DIR . '/13-cilin-firmada-anonimizada.xml'));
    $this->assertFalse($r->esValido());
    $this->assertSame('dCilin', $r->getErrores()[0]->elemento);
    $this->assertStringContainsString("'/d'", $r->getErrores()[0]->mensaje);
  }
}
