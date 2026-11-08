<?php

namespace IonysDev\Pkuatia\Tests\Unit\Conformidad;

use IonysDev\Pkuatia\Core\Fields\DE\A\DE;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamEsp;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamFE;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamItem;
use IonysDev\Pkuatia\Core\Fields\DE\E\GGrupAdi;
use IonysDev\Pkuatia\Core\Fields\DE\E\GGrupPolSeg;
use IonysDev\Pkuatia\Core\Fields\DE\E\GGrupSeg;
use IonysDev\Pkuatia\Core\Fields\DE\G\GCamCarg;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\GGroupTiEvt;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\RGeVeCan;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\RGeVeInu;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\RGEveNom;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\RGeVeTr;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GEA\RGeVeCCFF;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GER\RGeVeDescon;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GER\RGeVeDisconf;
use IonysDev\Pkuatia\Core\Fields\Response\DE\RContDe;
use IonysDev\Pkuatia\Core\Fields\Response\Event\GResProcEVe;
use IonysDev\Pkuatia\Core\Fields\Response\RUC\RContRUC;
use IonysDev\Pkuatia\Core\Requests\REnviDe;
use IonysDev\Pkuatia\Core\Responses\RResEnviConsLoteDe;
use IonysDev\Pkuatia\Core\Responses\RResEnviConsRUC;
use IonysDev\Pkuatia\Core\Responses\RResEnviLoteDe;
use IonysDev\Pkuatia\Core\Responses\RRetEnviEventoDe;
use IonysDev\Pkuatia\DataMappings\MonedaMapping;
use IonysDev\Pkuatia\DataMappings\UnidadMedidaMapping;
use IonysDev\Pkuatia\Helpers\SignHelper;
use IonysDev\Pkuatia\Tests\Support\MinimalRdeFactory;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Utils\NumberStringFormatter;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;
use stdClass;

/**
 * Fase D, D5 (evaluación §8, tabla de typos; decisión Q-D2 = C). Dos familias:
 *  - nombres que solo diferían del correcto en mayúsculas: PHP no distingue mayúsculas en los nombres de método, así
 *    que no admiten alias ni @deprecated; se corrigió la declaración y la grafía vieja sigue funcionando;
 *  - nombres con letras distintas: el correcto tiene el cuerpo y el viejo queda como alias @deprecated que delega.
 */
final class NombresCorregidosTest extends TestCase
{
    /** @return array<string, array{0: class-string, 1: string, 2: string}> */
    public static function soloMayusculas(): array
    {
        $casos = [
            [DE::class, 'getGDtipDe', 'getGDtipDE'], [DE::class, 'getGOpeDe', 'getGOpeDE'],
            [GCamEsp::class, 'getgGrupEner', 'getGGrupEner'], [GCamEsp::class, 'setgGrupEner', 'setGGrupEner'],
            [GCamFE::class, 'getgCompPub', 'getGCompPub'], [GCamFE::class, 'setgCompPub', 'setGCompPub'],
            [GCamItem::class, 'getGCamIVa', 'getGCamIVA'], [GCamItem::class, 'setGCamIVa', 'setGCamIVA'],
            [GGrupAdi::class, 'getdCodConDncp', 'getDCodConDncp'], [GGrupAdi::class, 'setdCodConDncp', 'setDCodConDncp'],
            [GCamCarg::class, 'getdDesUniMedTotPes', 'getDDesUniMedTotPes'],
            [GGroupTiEvt::class, 'getrGeVeRetAce', 'getRGeVeRetAce'], [GGroupTiEvt::class, 'setrGeVeRetAce', 'setRGeVeRetAce'],
            [GGroupTiEvt::class, 'getrGeVeRetAnu', 'getRGeVeRetAnu'], [GGroupTiEvt::class, 'setrGeVeRetAnu', 'setRGeVeRetAnu'],
            [GGroupTiEvt::class, 'setrGeVeCCFF', 'setRGeVeCCFF'],
            [RGEveNom::class, 'getMOtEve', 'getMotEve'], [RGEveNom::class, 'setMOtEve', 'setMotEve'],
            [RGeVeCan::class, 'getMOtEve', 'getMotEve'], [RGeVeCan::class, 'setMOtEve', 'setMotEve'],
            [RGeVeInu::class, 'getMOtEve', 'getMotEve'], [RGeVeInu::class, 'setMOtEve', 'setMotEve'],
            [RGeVeDescon::class, 'getMOtEve', 'getMotEve'], [RGeVeDescon::class, 'setMOtEve', 'setMotEve'],
            [RGeVeDisconf::class, 'getMOtEve', 'getMotEve'], [RGeVeDisconf::class, 'setMOtEve', 'setMotEve'],
            [RGeVeTr::class, 'getdDTipIDTrans', 'getDDTipIDTrans'],
            [RContDe::class, 'getRDe', 'getRDE'],
            [REnviDe::class, 'setXDe', 'setXDE'],
            [RResEnviConsLoteDe::class, 'getdFecProc', 'getDFecProc'], [RResEnviConsLoteDe::class, 'setdFecProc', 'setDFecProc'],
            [RResEnviLoteDe::class, 'getdProtConsLote', 'getDProtConsLote'], [RResEnviLoteDe::class, 'setdProtConsLote', 'setDProtConsLote'],
            [MonedaMapping::class, 'GetArray', 'getArray'], [MonedaMapping::class, 'GetCodeName', 'getCodeName'],
            [MonedaMapping::class, 'GetDescription', 'getDescription'],
            [UnidadMedidaMapping::class, 'GetArray', 'getArray'], [UnidadMedidaMapping::class, 'GetDesc', 'getDesc'],
            [NumberStringFormatter::class, 'FormatBCMAthNumber', 'FormatBCMathNumber'],
        ];
        $res = [];
        foreach ($casos as $c) {
            $res[substr(strrchr($c[0], '\\'), 1) . '::' . $c[1]] = $c;
        }
        return $res;
    }

    #[DataProvider('soloMayusculas')]
    public function testLaDeclaracionUsaLaGrafiaCorrectaYLaViejaSigueResolviendo(string $clase, string $vieja, string $nueva): void
    {
        $this->assertTrue(method_exists($clase, $vieja), "$clase::$vieja ya no resuelve");
        $this->assertTrue(method_exists($clase, $nueva));
        $this->assertSame($nueva, (new ReflectionMethod($clase, $vieja))->getName(), 'la declaración lleva la grafía corregida');
        $this->assertNotSame($vieja, $nueva);
        $this->assertSame(0, strcasecmp($vieja, $nueva), 'solo difieren en mayúsculas');
    }

    public function testLaGrafiaViejaDaElMismoResultado(): void
    {
        $this->assertSame(MonedaMapping::getArray(), MonedaMapping::GetArray());
        $this->assertSame(MonedaMapping::getDescription('PYG'), MonedaMapping::GetDescription('PYG'));
        $this->assertSame(UnidadMedidaMapping::getDesc(77), UnidadMedidaMapping::GetDesc(77));
        $this->assertSame(NumberStringFormatter::FormatBCMathNumber('1234.5', ',', '.'), NumberStringFormatter::FormatBCMAthNumber('1234.5', ',', '.'));
        $can = (new RGeVeCan())->setMOtEve('Motivo de prueba de la errata');
        $this->assertSame('Motivo de prueba de la errata', $can->getMotEve());
        $this->assertSame($can->getMotEve(), $can->getMOtEve());
    }

    /** @return array<string, array{0: class-string, 1: string, 2: string}> */
    public static function aliasConLetrasDistintas(): array
    {
        return [
            'SignHelper::SingEvents' => [SignHelper::class, 'SingEvents', 'SignEvents'],
            'GGrupSeg::setGGrupoPolSeg' => [GGrupSeg::class, 'setGGrupoPolSeg', 'setGGrupPolSeg'],
            'GGroupTiEvt::getGeVeCCFF' => [GGroupTiEvt::class, 'getGeVeCCFF', 'getRGeVeCCFF'],
            'RContRUC::fromStdClassObject' => [RContRUC::class, 'fromStdClassObject', 'FromSifenResponseObject'],
            'RResEnviConsRUC::fromStdClassObject' => [RResEnviConsRUC::class, 'fromStdClassObject', 'FromSifenResponseObject'],
            'RRetEnviEventoDe::seGResProcEVe' => [RRetEnviEventoDe::class, 'seGResProcEVe', 'setGResProcEVe'],
            'RRetEnviEventoDe::geGResProcEVe' => [RRetEnviEventoDe::class, 'geGResProcEVe', 'getGResProcEVe'],
            'GCamEsp::getGGrupoSeg' => [GCamEsp::class, 'getGGrupoSeg', 'getGGrupSeg'],
        ];
    }

    #[DataProvider('aliasConLetrasDistintas')]
    public function testElNombreViejoEsUnAliasObsoletoDelCorrecto(string $clase, string $viejo, string $nuevo): void
    {
        $this->assertNotSame(0, strcasecmp($viejo, $nuevo), 'tienen letras distintas: el alias es posible');
        $this->assertTrue(method_exists($clase, $viejo));
        $this->assertTrue(method_exists($clase, $nuevo));
        $docViejo = (string) (new ReflectionMethod($clase, $viejo))->getDocComment();
        $docNuevo = (string) (new ReflectionMethod($clase, $nuevo))->getDocComment();
        $this->assertStringContainsString('@deprecated', $docViejo, "$clase::$viejo debe estar marcado obsoleto");
        $this->assertStringContainsString($nuevo, $docViejo, 'el docblock del obsoleto nombra el reemplazo');
        $this->assertStringNotContainsString('@deprecated', $docNuevo, "$clase::$nuevo no es obsoleto");
    }

    public function testLosAliasDelModeloDelegan(): void
    {
        $poliza = new GGrupPolSeg();
        $seg = (new GGrupSeg())->setGGrupoPolSeg([$poliza]);
        $this->assertSame([$poliza], $seg->getGGrupPolSeg());

        $ccff = new RGeVeCCFF();
        $gti = (new GGroupTiEvt())->setRGeVeCCFF($ccff);
        $this->assertSame($ccff, $gti->getGeVeCCFF());
        $this->assertSame($ccff, $gti->getRGeVeCCFF());

        $objeto = new stdClass();
        $objeto->dRUCCons = '80000000';
        $objeto->dRazCons = 'EMPRESA DE PRUEBA S.A.';
        $objeto->dCodEstCons = 'ACT';
        $this->assertEquals(RContRUC::FromSifenResponseObject($objeto), RContRUC::fromStdClassObject($objeto));

        $respuesta = new stdClass();
        $respuesta->dCodRes = '0500';
        $respuesta->dMsgRes = 'RUC inexistente';
        $this->assertEquals(RResEnviConsRUC::FromSifenResponseObject($respuesta), RResEnviConsRUC::fromStdClassObject($respuesta));

        $r = new RRetEnviEventoDe();
        $eve = (new GResProcEVe())->setId('1')->setDEstRes('Aprobado');
        $r->seGResProcEVe([$eve]);
        $this->assertSame([$eve], $r->getGResProcEVe());
        $this->assertSame([$eve], $r->geGResProcEVe());
    }

    public function testSingEventsYSignEventsFirmanIgual(): void
    {
        $entorno = SifenTestEnvironment::init();
        try {
            $sobre = MinimalRdeFactory::createCancellationEventsEnvelope();
            $a = SignHelper::SignEvents($sobre, $entorno['config'])->saveXML();
            $b = SignHelper::SingEvents($sobre, $entorno['config'])->saveXML();
            $this->assertSame($a, $b, 'RSA PKCS#1 v1.5 es determinista: el alias produce los mismos bytes');
            $this->assertStringContainsString('<Signature', $a);
        } finally {
            ($entorno['cleanup'])();
        }
    }

    public function testNingunaDeclaracionConservaLaGrafiaVieja(): void
    {
        $viejas = array_unique(array_map(fn (array $c) => $c[1], self::soloMayusculas()));
        $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(__DIR__ . '/../../../src', \FilesystemIterator::SKIP_DOTS));
        $halladas = [];
        foreach ($it as $f) {
            if ($f->getExtension() !== 'php') {
                continue;
            }
            $c = file_get_contents($f->getPathname());
            foreach ($viejas as $v) {
                if (preg_match('/function\s+' . $v . '\s*\(/', $c)) {
                    $halladas[] = basename($f->getPathname()) . '::' . $v;
                }
            }
        }
        $this->assertSame([], $halladas);
    }
}
