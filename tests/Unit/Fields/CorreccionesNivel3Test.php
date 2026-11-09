<?php

namespace IonysDev\Pkuatia\Tests\Unit\Fields;

use IonysDev\Pkuatia\Core\Constants\CamCondOpe;
use IonysDev\Pkuatia\Core\Constants\OpeComCondTipCam;
use IonysDev\Pkuatia\Core\Constants\TimbTiDE;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\Factura;
use IonysDev\Pkuatia\Core\Exceptions\ValidacionException;
use IonysDev\Pkuatia\Core\Fields\DE\D\GOpeCom;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamItem;
use IonysDev\Pkuatia\Core\Fields\DE\E\GGrupAdi;
use IonysDev\Pkuatia\Core\Fields\Response\Batch\GResProcLote;
use IonysDev\Pkuatia\Core\Fields\Response\Event\GResProcEVe;
use IonysDev\Pkuatia\Core\Responses\RResEnviConsRUC;
use PHPUnit\Framework\TestCase;

/**
 * Fase D, D10: lo que PHPStan nivel 3 señalaba (assign.propertyType, return.type) y que D1 no cubrió. Dos familias:
 * conversiones implícitas que pasan a casts explícitos con el mismo resultado (sin cambio de comportamiento), y dos
 * correcciones de comportamiento: calcTotSub() sin timbrado terminaba en TypeError (asignaba null a GTotSub $gTotSub)
 * y setDCanQuiMer()/setDPorQuiMer() (E717/E718, decimales) truncaban por recibir `int`, como dMonEnt en D1.
 */
final class CorreccionesNivel3Test extends TestCase
{
    /**
     * El constructor de DocumentoElectronico siempre crea el gTimb, así que la rama se alcanza cuando el timbrado
     * declara una nota de remisión (C002 = 7) en un documento con ítems valorados: hasta 0.3.0, TypeError al asignar
     * null a GTotSub $gTotSub.
     */
    public function testCalcTotSubConTimbradoDeNotaDeRemisionAvisaEnVezDeTypeError(): void
    {
        $fe = new Factura(CamCondOpe::Contado);
        $fe->gTimb->setITiDE(TimbTiDE::NotaDeRemision);
        $this->expectException(ValidacionException::class);
        $this->expectExceptionMessageMatches('/timbrado|nota de remisión/');
        $fe->calcTotSub();
    }

    public function testLaQuiebraOMermaConservaLosDecimales(): void
    {
        $item = (new GCamItem())->setDCanQuiMer('1.5')->setDPorQuiMer('0.12345678');
        $this->assertSame('1.5', $item->dCanQuiMer);
        $this->assertSame('0.12345678', $item->dPorQuiMer);
        $entero = (new GCamItem())->setDCanQuiMer(2)->setDPorQuiMer(5);
        $this->assertSame('2', $entero->dCanQuiMer);
        $this->assertSame('5', $entero->dPorQuiMer);
    }

    public function testLosCastsExplicitosDanLoMismoQueLaConversionImplicita(): void
    {
        $ope = (new GOpeCom())->setDCondTiCam(OpeComCondTipCam::Global);
        $this->assertSame('1', $ope->getDCondTiCam());

        $lote = (new GResProcLote())->setDProtAut('49523783');
        $this->assertSame(49523783, $lote->dProtAut);
        $this->assertSame('49523783', $lote->getDProtAut());

        $eve = (new GResProcEVe())->setId('2')->setDProtAut('49523784');
        $this->assertSame(2, $eve->id);
        $this->assertSame(49523784, $eve->dProtAut);

        $ruc = (new RResEnviConsRUC())->setDCodRes(502);
        $this->assertSame('502', $ruc->getDCodRes());

        // QA de la Fase D: el cast no convierte en 0 un valor no numérico (hasta 0.3.0 era TypeError; ahora excepción
        // de la librería, y getProtocolo() nunca informa un protocolo "0" inventado).
        foreach ([fn () => (new GResProcLote())->setDProtAut(''), fn () => (new GResProcEVe())->setDProtAut('abc'), fn () => (new GResProcEVe())->setId('')] as $i => $llamada) {
            try {
                $llamada();
                $this->fail("caso $i: debía lanzar");
            } catch (\IonysDev\Pkuatia\Core\Exceptions\RespuestaException $e) {
                $this->assertStringContainsString('no numérico', $e->getMessage());
            }
        }

        $adi = (new GGrupAdi())->setDSalAnt('1500.50');
        $this->assertSame(1500.5, $adi->getDSalAnt());
        $this->assertNull((new GGrupAdi())->setDSalAnt(null)->getDSalAnt());
    }
}
