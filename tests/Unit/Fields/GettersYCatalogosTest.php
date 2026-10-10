<?php

namespace IonysDev\Pkuatia\Tests\Unit\Fields;

use IonysDev\Pkuatia\Core\Fields\DE\D\GDatRec;
use IonysDev\Pkuatia\Core\Fields\DE\D\GEmis;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamAE;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamEnt;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamItem;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamSal;
use IonysDev\Pkuatia\Core\Fields\DE\E\GGrupAdi;
use IonysDev\Pkuatia\Core\Fields\DE\E\GTransp;
use IonysDev\Pkuatia\Core\Fields\DE\E\GVehNuevo;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\RGEveNom;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\RGeVeTr;
use IonysDev\Pkuatia\Core\Fields\Response\DE\TxContenEv;
use IonysDev\Pkuatia\Core\Fields\Response\RUC\RContRUC;
use IonysDev\Pkuatia\DataMappings\CountryMapping;
use IonysDev\Pkuatia\DataMappings\DepartamentoMapping;
use IonysDev\Pkuatia\DataMappings\PyGeoCodesMapping;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Fase B/B5, PK-30 con el alcance de la decisión Q-B3: getters que declaraban un tipo no anulable y podían
 * devolver null o leer una propiedad opcional sin cargar (antes, TypeError o Error), y setters de catálogo que
 * ante un código inexistente terminaban en TypeError en lugar de un mensaje. Catálogos: Departamentos_v141.xsd,
 * Paises_v100.xsd y src/DataMappings/Sources/PyGeoCodes.xml.
 */
final class GettersYCatalogosTest extends TestCase
{
  /** @return array<string, array{0: callable(): mixed}> */
  public static function gettersSinDato(): array
  {
    $res = [
      'DepartamentoMapping::getDepName(99)' => [fn () => DepartamentoMapping::getDepName('99')],
      'PyGeoCodesMapping::getDistName(9999)' => [fn () => PyGeoCodesMapping::getDistName('9999')],
      'PyGeoCodesMapping::getCiudName(99999)' => [fn () => PyGeoCodesMapping::getCiudName('99999')],
      'PyGeoCodesMapping::getBarrName(99999)' => [fn () => PyGeoCodesMapping::getBarrName('99999')],
      'CountryMapping::getCountryDesc(XXX)' => [fn () => CountryMapping::getCountryDesc('XXX')],
      'RContRUC::getDDesEstCons sin código' => [fn () => (new RContRUC())->getDDesEstCons()],
      'RContRUC::getDDesEstCons con código desconocido' => [fn () => (new RContRUC())->setDCodEstCons('XXX')->getDDesEstCons()],
      'RContRUC::getDRUCFactElecDesc sin dato' => [fn () => (new RContRUC())->getDRUCFactElecDesc()],
      'RGeVeTr::getDDesTipTrans sin dato' => [fn () => (new RGeVeTr())->getDDesTipTrans()],
      'RGeVeTr::getDDesModTrans sin dato' => [fn () => (new RGeVeTr())->getDDesModTrans()],
      'TxContenEv::getRContEv sin dato' => [fn () => (new TxContenEv())->getRContEv()],
    ];
    $propiedades = [
      GCamEnt::class => ['getDNumCasEnt', 'getCDepEnt', 'getCDisEnt', 'getCCiuEnt'],
      GCamSal::class => ['getDNumCasSal', 'getCDepSal', 'getCDisSal', 'getCCiuSal'],
      GGrupAdi::class => ['getDCiclo', 'getDContrato'],
      GTransp::class => ['getGCamSal', 'getGVehTras', 'getGCamTrans', 'getGCamEnt'],
      GVehNuevo::class => ['getITipOpVN', 'getDDesTipOpVN', 'getDChasis', 'getDColor', 'getDPotencia', 'getDCapMot', 'getDPNet',
        'getDPBruto', 'getITipCom', 'getDDesTipCom', 'getDCapTracc', 'getDAnoFab', 'getDCapac'],
    ];
    foreach ($propiedades as $clase => $getters) {
      foreach ($getters as $getter) {
        $corto = substr($clase, strrpos($clase, '\\') + 1);
        $res["$corto::$getter sin dato"] = [fn () => (new $clase())->$getter()];
      }
    }
    return $res;
  }

  #[DataProvider('gettersSinDato')]
  public function testElGetterDevuelveNullSinDato(callable $leer): void
  {
    $this->assertNull($leer());
  }

  /** Con dato, los getters devuelven lo de siempre. */
  public function testConDatoNoCambiaNada(): void
  {
    $this->assertSame('CAPITAL', DepartamentoMapping::getDepName('1'));
    $this->assertSame('Paraguay', CountryMapping::getCountryDesc('PRY'));
    $this->assertSame('Activo', (new RContRUC())->setDCodEstCons('ACT')->getDDesEstCons());
  }

  /** @return array<string, array{0: callable(): mixed, 1: string}> */
  public static function codigosInexistentes(): array
  {
    return [
      'GDatRec::setCPaisRec' => [fn () => (new GDatRec())->setCPaisRec('XXX'), 'XXX'],
      'GDatRec::setCDepRec' => [fn () => (new GDatRec())->setCDepRec(99), '99'],
      'GDatRec::setCDisRec' => [fn () => (new GDatRec())->setCDisRec(9999), '9999'],
      'GDatRec::setCCiuRec' => [fn () => (new GDatRec())->setCCiuRec(99999), '99999'],
      'GEmis::setCDepEmi' => [fn () => (new GEmis())->setCDepEmi(99), '99'],
      'GEmis::setCDisEmi' => [fn () => (new GEmis())->setCDisEmi(9999), '9999'],
      'GEmis::setCCiuEmi' => [fn () => (new GEmis())->setCCiuEmi(99999), '99999'],
      'GCamAE::setCDepVen' => [fn () => (new GCamAE())->setCDepVen(99), '99'],
      'GCamAE::setCDisVen' => [fn () => (new GCamAE())->setCDisVen(9999), '9999'],
      'GCamAE::setCCiuVen' => [fn () => (new GCamAE())->setCCiuVen(99999), '99999'],
      'GCamAE::setCDepProv' => [fn () => (new GCamAE())->setCDepProv(99), '99'],
      'GCamAE::setCDisProv' => [fn () => (new GCamAE())->setCDisProv(9999), '9999'],
      'GCamAE::setCCiuProv' => [fn () => (new GCamAE())->setCCiuProv(99999), '99999'],
      'GCamItem::setCPaisOrig' => [fn () => (new GCamItem())->setCPaisOrig('XXX'), 'XXX'],
      'RGEveNom::setCPaisRec' => [fn () => (new RGEveNom())->setCPaisRec('XXX'), 'XXX'],
      'RGEveNom::setCDepRec' => [fn () => (new RGEveNom())->setCDepRec(99), '99'],
      'RGEveNom::setCDisRec' => [fn () => (new RGEveNom())->setCDisRec(9999), '9999'],
      'RGEveNom::setCCiuRec' => [fn () => (new RGEveNom())->setCCiuRec(99999), '99999'],
    ];
  }

  /** Antes: TypeError (o, en RGEveNom::setCPaisRec con los catálogos anulables, aceptación silenciosa). */
  #[DataProvider('codigosInexistentes')]
  public function testUnCodigoInexistenteLanzaUnaExcepcionConMensaje(callable $asignar, string $codigo): void
  {
    $this->expectException(\InvalidArgumentException::class);
    $this->expectExceptionMessage($codigo);
    $asignar();
  }

  /** Con un código válido el setter completa la descripción, como siempre. */
  public function testUnCodigoValidoCompletaLaDescripcion(): void
  {
    $rec = new GDatRec();
    $rec->setCDepRec(1);
    $this->assertSame('CAPITAL', $rec->dDesDepRec);
    $this->assertSame('Paraguay', (new RGEveNom())->setCPaisRec('PRY')->dDesPaisRe);
  }
}
