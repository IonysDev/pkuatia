<?php

namespace IonysDev\Pkuatia\Tests\Unit\Sifen;

use DateTime;
use DateTimeZone;
use IonysDev\Pkuatia\Core\Constants\TipIDRec;
use IonysDev\Pkuatia\Sifen;
use IonysDev\Pkuatia\Tests\Support\EventoFactory;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Tests\Support\StubSoapClient;
use IonysDev\Pkuatia\Tests\Support\XsdAssertions;
use PHPUnit\Framework\TestCase;

/**
 * Wrappers de eventos del facade: PK-22 (la fecha de firma interna se generaba con la zona horaria
 * del servidor; el SIFEN compara contra la hora de Asunción, validación 1004) y PK-42 (CancelarDE no
 * validaba el motivo de 5 a 500 caracteres, tmotEve, ni el CDC de 44 dígitos, tId).
 */
final class EventosFacadeTest extends TestCase
{
  /** @var callable */
  private $cleanup;
  private string $tzPrevia;

  protected function setUp(): void
  {
    $this->cleanup = SifenTestEnvironment::init()['cleanup'];
    $this->tzPrevia = date_default_timezone_get();
  }

  protected function tearDown(): void
  {
    date_default_timezone_set($this->tzPrevia);
    ($this->cleanup)();
  }

  public function testLaFechaDeFirmaDeUnEventoEstaEnHoraDeAsuncionAunqueElServidorEsteEnUtc(): void
  {
    date_default_timezone_set('UTC');
    StubSoapClient::instalar(['rEnviEventoDe' => static fn () => StubSoapClient::respuestaEventoAprobado()]);
    $antes = new DateTime('now', new DateTimeZone('America/Asuncion'));

    $res = Sifen::CancelarDE(EventoFactory::CDC, 'Cancelación de prueba de zona horaria');

    $this->assertSame('Aprobado', $res->getGResProcEVe()[0]->getDEstRes());
    $xml = StubSoapClient::ultimoRequest()->dEvReg->enc_value;
    $this->assertSame(1, preg_match('#<dFecFirma>([^<]+)</dFecFirma>#', $xml, $m));
    $firma = new DateTime($m[1], new DateTimeZone('America/Asuncion'));
    $this->assertLessThan(120, abs($firma->getTimestamp() - $antes->getTimestamp()),
      "dFecFirma {$m[1]} debe ser la hora actual de Asunción (servidor en UTC)");
  }

  public function testSePuedeIndicarLaFechaDeFirmaDelEvento(): void
  {
    StubSoapClient::instalar(['rEnviEventoDe' => static fn () => StubSoapClient::respuestaEventoAprobado()]);
    $fecha = new DateTime('2026-01-16T09:00:00', new DateTimeZone('America/Asuncion'));

    Sifen::CancelarDE(EventoFactory::CDC, 'Cancelación con fecha de firma explícita', $fecha);

    $xml = StubSoapClient::ultimoRequest()->dEvReg->enc_value;
    $this->assertStringContainsString('<dFecFirma>2026-01-16T09:00:00</dFecFirma>', $xml);
    $gGroup = substr($xml, strpos($xml, '<gGroupGesEve'), strrpos($xml, '</gGroupGesEve>') + 15 - strpos($xml, '<gGroupGesEve'));
    XsdAssertions::assertEventoValido($gGroup, 'sobre enviado por CancelarDE');
  }

  public function testCancelarDERechazaUnMotivoCortoAntesDeLlegarALaRed(): void
  {
    StubSoapClient::instalar([]);
    $this->expectException(\Exception::class);
    $this->expectExceptionMessageMatches('/motivo/i');
    Sifen::CancelarDE(EventoFactory::CDC, 'abc');
    $this->assertSame([], StubSoapClient::$llamadas);
  }

  public function testCancelarDERechazaUnCdcQueNoTiene44Digitos(): void
  {
    StubSoapClient::instalar([]);
    $this->expectException(\Exception::class);
    $this->expectExceptionMessageMatches('/CDC/');
    Sifen::CancelarDE('123', 'Cancelación con CDC inválido');
  }

  public function testDesconocerDERechazaTiposDeDocumentoQueElXsdNoAdmite(): void
  {
    StubSoapClient::instalar([]);
    $this->expectException(\Exception::class);
    $this->expectExceptionMessageMatches('/tipo de documento|dTipIDRec/i');
    Sifen::DesconocerDE(EventoFactory::CDC, new DateTime('2026-01-15T10:00:00'), new DateTime('2026-01-15T18:00:00'),
      'Juan Perez', 'No reconozco esta operación', null, null, TipIDRec::Innominado, '0');
  }
}
