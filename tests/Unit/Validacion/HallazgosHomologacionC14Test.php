<?php

namespace IonysDev\Pkuatia\Tests\Unit\Validacion;

use DateTime;
use DateTimeZone;
use IonysDev\Pkuatia\Core\Constants;
use IonysDev\Pkuatia\Core\Constants\CamIVAAfecIVA;
use IonysDev\Pkuatia\Core\Constants\CamIVATasaIVA;
use IonysDev\Pkuatia\Core\Fields\DE\E\GVehNuevo;
use IonysDev\Pkuatia\Core\Fields\DE\J\GCamFuFD;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory as F;
use IonysDev\Pkuatia\Validacion\OrigenError;
use IonysDev\Pkuatia\Validacion\ValidadorDE;
use PHPUnit\Framework\TestCase;

/**
 * Lo que la homologación de la Fase C en sifen-test (C14, 13/10/2026, capturas en tests/Resources/sifen/respuestas-ws/
 * 2026-10-13/) cambió en el validador: 2503 es un rechazo real (el SIFEN rechaza J003 dInfAdic), una base gravada
 * 0,01 mayor que la exacta se aprueba (tolerancia de 1910/1911/1913), y dCilin numérico se rechaza con 0160 porque
 * el SIFEN aplica el patrón "/d" del XSD tal como está publicado.
 */
final class HallazgosHomologacionC14Test extends TestCase
{
  private static function ahora(): DateTime
  {
    return (clone F::fechaEmision())->setTimezone(new DateTimeZone(Constants::SIFEN_TIMEZONE))->modify('+2 hours');
  }

  public function testDInfAdicEsUnRechazo2503(): void
  {
    $rde = F::rde(F::facturaContado());
    $fuera = new GCamFuFD();
    $fuera->setDInfAdic('Texto adicional del emisor');
    $rde->setGCamFuFD($fuera);
    $r = ValidadorDE::validar($rde, self::ahora());
    $this->assertFalse($r->esValido(), (string) $r);
    $this->assertCount(1, $r->porCodigo('2503'));
    $e = $r->porCodigo('2503')[0];
    $this->assertFalse($e->esAdvertencia, 'sifen-test lo rechazó el 13/10/2026');
    $this->assertSame('J003', $e->campoMT);
    $this->assertStringContainsString('FirmarDE', (string) $e->sugerencia);
  }

  public function testUnaBaseGravadaConUnCentavoDeMasNoEsError(): void
  {
    $fe = F::facturaContado();
    $iva = $fe->items[0]->gCamIVA;
    $base = bcadd($iva->getDBasGravIVA(), '0.01', 8);
    $iva->setDBasGravIVA($base);
    $iva->setDLiqIVAItem(bcdiv(bcmul($base, '10', 8), '100', 8));
    $fe->gTotSub->setDBaseGrav10($base);
    $fe->gTotSub->setDTBasGraIVA($base);
    $fe->gTotSub->setDIVA10($iva->getDLiqIVAItem());
    $fe->gTotSub->setDTotIVA($iva->getDLiqIVAItem());
    $r = $fe->validarReglas(self::ahora());
    $this->assertTrue($r->esValido(), "aprobado por sifen-test el 13/10/2026 (0260): $r");

    $iva->setDBasGravIVA(bcadd($iva->getDBasGravIVA(), '0.1', 8)); // 0,11 de más: fuera de lo verificado
    $this->assertCount(1, $fe->validarReglas(self::ahora())->porCodigo('1911'));
  }

  public function testLaLiquidacionDelIvaTieneLaMismaTolerancia(): void
  {
    $fe = F::facturaContado();
    $iva = $fe->items[0]->gCamIVA;
    $iva->setDLiqIVAItem(bcadd($iva->getDLiqIVAItem(), '0.01', 8));
    $fe->gTotSub->setDIVA10($iva->getDLiqIVAItem());
    $fe->gTotSub->setDTotIVA($iva->getDLiqIVAItem());
    $this->assertCount(0, $fe->validarReglas(self::ahora())->porCodigo('1913'));
  }

  public function testDCilinNumericoSeRechazaCon0160(): void
  {
    $vehiculo = (new GVehNuevo())->setITipOpVN(2)->setDChasis('9BWZZZ377VT004251')->setDColor('Blanco')
      ->setDPotencia(150)->setDCapMot(1600)->setDCilin('1600')->setDPNet('1200.5')->setDPBruto('1500.25')->setITipCom(1)
      ->setDNroMotor('MOT-0001')->setDCapTracc('1500.75')->setDAnoFab(2026)->setCTipVeh('SEDAN')->setDCapac(5);
    $fe = F::facturaContado();
    $fe->addItem('VEH001', 'Automóvil nuevo', 77, '1', 0, '150000000', null, CamIVAAfecIVA::Gravado, '100', CamIVATasaIVA::IVA10, detalleVehiculoNuevo: $vehiculo);
    $fe->calcTotSub(0);
    $fe->addPago(\IonysDev\Pkuatia\Core\Constants\PaConEIniTiPago::Efectivo, $fe->gTotSub->getDTotGralOpe(), 'PYG');
    $r = $fe->validarReglas(self::ahora());
    $errores = $r->porCodigo('0160');
    $this->assertCount(1, $errores, (string) $r);
    $this->assertSame(OrigenError::Regla, $errores[0]->origen);
    $this->assertSame('dCilin', $errores[0]->elemento);
    $this->assertStringContainsString('/d', $errores[0]->mensaje);
    $this->assertStringContainsString('13/10/2026', (string) $errores[0]->sugerencia);
    $this->assertStringContainsString('DE.gDtipDE.gCamItem[2].gVehNuevo', (string) $errores[0]->ruta);
  }
}
