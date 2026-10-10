<?php

namespace IonysDev\Pkuatia\Tests\Unit\Deserializacion;

use DateTime;
use IonysDev\Pkuatia\Core\Constants\CamCondOpe;
use IonysDev\Pkuatia\Core\Constants\CamFEIndPres;
use IonysDev\Pkuatia\Core\Constants\CamIVAAfecIVA;
use IonysDev\Pkuatia\Core\Constants\CamIVATasaIVA;
use IonysDev\Pkuatia\Core\Constants\OpeComTipTrans;
use IonysDev\Pkuatia\Core\Constants\TipIDRec;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\Factura;
use IonysDev\Pkuatia\Core\Fields\DE\B\GOpeDE;
use IonysDev\Pkuatia\Core\Fields\DE\D\GDatRec;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory as F;
use IonysDev\Pkuatia\Tests\Support\RoundTrip;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Fase B/B2: textos que la lectura convertía en números (PK-26), rellenos y datos espurios (PK-36) y
 * subtotales sumados como float (PK-37).
 */
final class CadenasYRellenosTest extends TestCase
{
  /** @return array<string, array{0: string}> */
  public static function vias(): array
  {
    return ['DOM' => [RoundTrip::VIA_DOM], 'SimpleXML' => [RoundTrip::VIA_SIMPLEXML]];
  }

  /**
   * B004 dCodSeg: tiCodSe, 9 dígitos con ceros a la izquierda (DE_Types_v150.xsd); entra en el CDC.
   * Hasta 0.2.0 los tres lectores hacían intval() y un código como 012345678 volvía con 8 dígitos.
   */
  #[DataProvider('vias')]
  public function testCodigoDeSeguridadConCeroInicial(string $via): void
  {
    [$ida, $vuelta] = RoundTrip::idaYVuelta(F::rde(F::facturaContado(5), '012345678'), $via);
    $this->assertStringContainsString('<dCodSeg>012345678</dCodSeg>', $ida);
    $this->assertSame($ida, $vuelta);
  }

  /** tiCodSe deriva de xs:integer: con el WSDL, SoapClient podría entregarlo como entero sin el cero inicial. */
  public function testCodigoDeSeguridadDesdeObjetoSoap(): void
  {
    $gOpeDE = F::rde(F::facturaContado(5), '012345678')->getDE()->getGOpeDe();
    $objeto = RoundTrip::objetoSoap(RoundTrip::serializar($gOpeDE));
    $this->assertSame('012345678', GOpeDE::FromSifenResponseObject($objeto)->getDCodSeg());
    $objeto->dCodSeg = 12345678;
    $this->assertSame('012345678', GOpeDE::FromSifenResponseObject($objeto)->getDCodSeg());
  }

  /**
   * D210 dNumIDRec: tdNumDocId, alfanumérico de 1 a 20 (DE_Types_v150.xsd). Hasta 0.2.0 la lectura por
   * SimpleXML hacía intval() (un pasaporte quedaba en 0) y copiaba el número en dNomFanRec.
   */
  #[DataProvider('vias')]
  public function testDocumentoDelReceptorAlfanumerico(string $via): void
  {
    $fe = F::facturaContado(6);
    F::receptorNoContribuyente($fe, TipIDRec::Pasaporte, 'AB0012345');
    [$ida, $vuelta] = RoundTrip::idaYVuelta(F::rde($fe), $via);
    $this->assertStringContainsString('<dNumIDRec>AB0012345</dNumIDRec>', $ida);
    $this->assertStringNotContainsString('<dNomFanRec>', $vuelta);
    $this->assertSame($ida, $vuelta);
  }

  public function testDocumentoDelReceptorDesdeObjetoSoap(): void
  {
    $fe = F::facturaContado(6);
    F::receptorNoContribuyente($fe, TipIDRec::Pasaporte, 'AB0012345');
    RoundTrip::assertIdaYVueltaIdentica(F::rde($fe)->getDE()->getGDatGralOpe()->getGDatRec(), RoundTrip::VIA_SOAP, GDatRec::class);
  }

  /**
   * C010 dSerieNum: tdSerieNum [A-Z]{2}, 0-1 (DE_v150.xsd:46). Hasta 0.2.0 la lectura por SimpleXML
   * agregaba un dSerieNum "00" a todo documento sin serie, y la serialización rellenaba con ceros.
   */
  #[DataProvider('vias')]
  public function testSerieDelTimbrado(string $via): void
  {
    $conSerie = F::facturaContado(7);
    $conSerie->setTimbrado(F::TIMBRADO, new DateTime('2024-01-01'), 1, 1, 7, 'AB');
    [$ida, $vuelta] = RoundTrip::idaYVuelta(F::rde($conSerie), $via);
    $this->assertStringContainsString('<dSerieNum>AB</dSerieNum>', $ida);
    $this->assertSame($ida, $vuelta);

    [, $vuelta] = RoundTrip::idaYVuelta(F::rde(F::facturaContado(8)), $via);
    $this->assertStringNotContainsString('<dSerieNum>', $vuelta);
  }

  public function testLaSerieNoSeRellenaConCeros(): void
  {
    $gTimb = F::rde(F::facturaContado(9))->getDE()->getGTimb()->setDSerieNum('A');
    $this->assertStringContainsString('<dSerieNum>A</dSerieNum>', RoundTrip::serializar($gTimb));
  }

  /**
   * E704 dDncpG: tdDncpG [0-9]{8} (DE_Types_v150.xsd); el MT manda "completar con 0 (cero) a la
   * izquierda" (ekuat-ia 03-estructura-xml/campos-obligatorios.md:308). Hasta 0.2.0 se rellenaba a la
   * derecha y el código cambiaba (1234567 -> 12345670).
   */
  public function testCodigoDncpGeneralSeCompletaConCerosALaIzquierda(): void
  {
    $fe = new Factura(CamCondOpe::Contado);
    F::configurarBase($fe, 10);
    F::receptorContribuyente($fe);
    $fe->setTipoDeTransaccion(OpeComTipTrans::VentaMercaderia);
    $fe->setIndicadorPresencia(CamFEIndPres::Presencial);
    $fe->addItem('PROD001', 'Producto', 77, '1', 0, '100000', null, CamIVAAfecIVA::Gravado, '100', CamIVATasaIVA::IVA10,
      dncpCodigoGeneral: '1234567', dncpCodigoEspecifico: '001');
    $fe->calcTotSub(0);
    $xml = RoundTrip::serializar(F::rde($fe));
    $this->assertStringContainsString('<dDncpG>01234567</dDncpG>', $xml);
    RoundTrip::assertIdaYVueltaIdentica(F::rde($fe), RoundTrip::VIA_DOM);
  }

  /**
   * PK-37: calcSubt05/calcSubt10 sumaban dos montos BCMath con "+" (float). Con 15 cifras significativas
   * el resultado perdía el último decimal. Para montos normales el formato no cambia.
   */
  public function testSubtotalesPorTasaSonExactos(): void
  {
    $item = F::facturaContado(11)->items[0];
    $this->assertSame('100.000', $item->getFormattedSubt10());

    $item->getGCamIVA()->setDBasGravIVA('1234567890123.40909091');
    $item->getGCamIVA()->setDLiqIVAItem('123456789012.34090909');
    $this->assertSame('1358024679135.75', $item->calcSubt10());
    $this->assertSame('1.358.024.679.135,75', $item->getFormattedSubt10());
  }
}
