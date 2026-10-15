<?php

namespace IonysDev\Pkuatia\Tests\Unit\Validacion;

use DateTime;
use DateTimeZone;
use IonysDev\Pkuatia\Core\Constants;
use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory as F;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Validacion\ValidadorDE;
use PHPUnit\Framework\TestCase;

/**
 * Hallazgo de C14 (ensayo en seco del 13/10/2026): las fechas del DE van sin zona en el XML y son hora de Asunción
 * por convención del MT, pero al leer un rDE el modelo las crea con la zona por defecto de PHP (UTC en el harness y
 * en muchos servidores), así que el validador comparaba una firma 30 minutos adelantada como si fuera 2,5 horas
 * atrasada y no predecía 1004 (ni corría bien las ventanas de 1150/1151). El validador toma ahora la hora de pared
 * del DE como hora de Asunción, que es lo que ve el SIFEN.
 */
final class FechasEnZonaDelSifenTest extends TestCase
{
  private string $zonaPrevia;
  /** @var array{config: mixed, cleanup: callable} */
  private array $entorno;

  protected function setUp(): void
  {
    $this->zonaPrevia = date_default_timezone_get();
    date_default_timezone_set('UTC');
    $this->entorno = SifenTestEnvironment::init();
  }

  protected function tearDown(): void
  {
    ($this->entorno['cleanup'])();
    date_default_timezone_set($this->zonaPrevia);
  }

  private static function rdeLeido(DateTime $emision, DateTime $firma): RDE
  {
    $fe = F::facturaContado();
    $fe->setFechaEmision($emision);
    $xml = \IonysDev\Pkuatia\Sifen::FirmarDE(F::rde($fe), $firma);
    return RDE::FromSimpleXMLElement(simplexml_load_string($xml));
  }

  public function testUnaFirmaAdelantadaSePredicaAunqueElXmlSeLeaConZonaUtc(): void
  {
    $ahora = new DateTime('now', new DateTimeZone(Constants::SIFEN_TIMEZONE));
    $rde = self::rdeLeido((clone $ahora)->modify('-5 minutes'), (clone $ahora)->modify('+30 minutes'));
    $this->assertSame('UTC', $rde->getDE()->getDFecFirma()->getTimezone()->getName(), 'el modelo lee la fecha con la zona por defecto de PHP');
    $r = ValidadorDE::validar($rde, $ahora);
    $this->assertCount(1, $r->porCodigo('1004'), (string) $r);
  }

  public function testUnaFirmaRecienteNoDisparaNada(): void
  {
    $ahora = new DateTime('now', new DateTimeZone(Constants::SIFEN_TIMEZONE));
    $rde = self::rdeLeido((clone $ahora)->modify('-10 minutes'), (clone $ahora)->modify('-5 minutes'));
    $r = ValidadorDE::validar($rde, $ahora);
    $this->assertCount(0, $r->porCodigo('1004'), (string) $r);
    $this->assertCount(0, $r->porCodigo('1150'), (string) $r);
    $this->assertCount(0, $r->porCodigo('1151'), (string) $r);
    $this->assertTrue($r->esValido(), (string) $r);
  }

  public function testElBuilderConOtraZonaSeEvaluaPorSuHoraDePared(): void
  {
    // Una emisión "ahora" expresada en UTC se escribe en el XML con su hora de pared (3 h adelantada respecto de
    // Asunción): el SIFEN la leería como 3 h en el futuro, por encima del margen de 120 h no, pero la firma sí.
    $ahora = new DateTime('now', new DateTimeZone(Constants::SIFEN_TIMEZONE));
    $fe = F::facturaContado();
    $fe->setFechaEmision((clone $ahora)->setTimezone(new DateTimeZone('UTC')));
    $this->assertCount(0, $fe->validarReglas($ahora)->porCodigo('1151'), 'tres horas de adelanto entran en la ventana de 120 h');
    $rde = F::rde($fe);
    $xml = \IonysDev\Pkuatia\Sifen::FirmarDE($rde, (clone $ahora)->setTimezone(new DateTimeZone('UTC')));
    $this->assertStringContainsString('<dFecFirma>' . (clone $ahora)->setTimezone(new DateTimeZone('UTC'))->format('Y-m-d\TH:i'), $xml, 'la hora de pared UTC va al XML tal cual');
    $this->assertCount(1, ValidadorDE::validar($rde, $ahora)->porCodigo('1004'), 'y el SIFEN la ve 3 h adelantada');
  }
}
