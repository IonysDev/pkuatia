<?php

namespace IonysDev\Pkuatia\Tests\Unit\DocumentosElectronicos;

use IonysDev\Pkuatia\Core\Constants\CamIVAAfecIVA;
use IonysDev\Pkuatia\Core\Constants\CamIVATasaIVA;
use IonysDev\Pkuatia\Core\Constants\MotEmi;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\NotaDeCredito;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\NotaDeDebito;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory as F;
use PHPUnit\Framework\TestCase;

/**
 * Hallazgo de C14 (ensayo en seco del 13/10/2026): una nota de crédito o de débito sin documento asociado terminaba
 * en Error ("$gCamDEAsoc must not be accessed before initialization") al pasarla a RDE, en vez de serializarse y de
 * que el validador la rechace con 2400 (H001 obligatorio). La propiedad arranca ahora como lista vacía.
 */
final class NotaSinAsociadoTest extends TestCase
{
  public function testLaNotaDeCreditoSinAsociadoSeSerializaYElValidadorAvisa2400(): void
  {
    $nc = new NotaDeCredito(MotEmi::Devolucion);
    F::configurarBase($nc, 40);
    F::receptorContribuyente($nc);
    $nc->addItem('PROD001', 'Devolucion producto gravado 10%', 77, '1', 0, '55000', null, CamIVAAfecIVA::Gravado, '100', CamIVATasaIVA::IVA10);
    $nc->calcTotSub(0);
    $this->assertSame([], $nc->gCamDEAsoc);
    $this->assertCount(1, $nc->validarReglas(F::fechaEmision()->modify('+2 hours'))->porCodigo('2400'));
    $rde = F::rde($nc);
    $this->assertSame([], $rde->getDE()->getGCamDEAsoc());
    $this->assertStringNotContainsString('<gCamDEAsoc>', $rde->toXMLString());
  }

  public function testLaNotaDeDebitoSinAsociadoTambien(): void
  {
    $nd = new NotaDeDebito(MotEmi::Devolucion);
    F::configurarBase($nd, 41);
    F::receptorContribuyente($nd);
    $nd->addItem('PROD001', 'Ajuste gravado 10%', 77, '1', 0, '5000', null, CamIVAAfecIVA::Gravado, '100', CamIVATasaIVA::IVA10);
    $nd->calcTotSub(0);
    $this->assertStringNotContainsString('<gCamDEAsoc>', F::rde($nd)->toXMLString());
  }
}
