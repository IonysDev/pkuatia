<?php

namespace IonysDev\Pkuatia\Tests\Unit\Validacion;

use DOMDocument;
use IonysDev\Pkuatia\Core\Constants\CamCondOpe;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\DocumentoElectronico;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\Factura;
use IonysDev\Pkuatia\Core\Exceptions\DocumentoInvalidoException;
use IonysDev\Pkuatia\Core\Fields\DE\A\DE;
use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamFE;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamIVA;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamNRE;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamCond;
use IonysDev\Pkuatia\Core\Fields\DE\D\GOpeCom;
use IonysDev\Pkuatia\Core\Fields\DE\F\GTotSub;
use IonysDev\Pkuatia\Core\Fields\DE\G\GCamCarg;
use IonysDev\Pkuatia\Core\Fields\DE\G\GCamGen;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory as F;
use IonysDev\Pkuatia\Tests\Support\RespuestasSifenFactory as R;
use IonysDev\Pkuatia\Validacion\ErrorValidacion;
use IonysDev\Pkuatia\Validacion\OrigenError;
use IonysDev\Pkuatia\Validacion\ResultadoValidacion;
use IonysDev\Pkuatia\Validacion\ValidadorDE;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Paso C9 de la Fase C (Q-C1 = A): ValidadorDE y DocumentoElectronico::validarReglas(). Parte 1: completitud guiada
 * por el XSD (elementos con minOccurs = 1 de cada grupo presente, DE_v150.xsd vía el catálogo de C5; código 0160
 * porque es lo que responde el SIFEN ante un XML que no cumple el esquema) y presencia de los grupos por tipo de
 * documento (errores-validacion.md: 1200/1201, 1350/1351, 2550/2551, 1450/1451, 2600/2601, 1500/1501, 2350/2351,
 * 2100/2101, 2150/2151, 2200/2201, 2250/2251, 2300/2301, 2400, 1850/1851, 1900/1901/1902, 2390).
 * Lee las propiedades con isset, nunca getters: un documento a medio armar no termina en Error (deuda Q-B3).
 */
final class ValidadorCompletitudTest extends TestCase
{
  /** @return iterable<string, array{callable(): DocumentoElectronico}> */
  public static function documentosDeLaFabrica(): iterable
  {
    yield 'FE contado' => [fn () => F::facturaContado()];
    yield 'FE cuotas' => [fn () => F::facturaCreditoCuotas()];
    yield 'FE cuotas con entrega' => [fn () => F::facturaCreditoCuotas(4, '20000')];
    yield 'FE USD' => [fn () => F::facturaUsd()];
    yield 'NC' => [fn () => F::notaDeCredito()];
    yield 'ND' => [fn () => F::notaDeDebito()];
    yield 'NR' => [fn () => F::notaDeRemision()];
    yield 'NR por matrícula' => [fn () => F::notaDeRemision(21, true, true)];
    yield 'AF dos ítems' => [fn () => F::autofactura()];
    yield 'AF un ítem' => [fn () => F::autofactura(31, 1)];
    yield 'FE con todos los sectores' => [fn () => F::facturaConTodosLosSectores()];
    yield 'FE con todos los opcionales' => [fn () => F::facturaConTodosLosOpcionales()];
    foreach (array_keys(F::sectores()) as $sector) {
      yield "FE sector $sector" => [fn () => F::facturaSectorial($sector)];
    }
  }

  /** Control de falsos positivos: lo que la fábrica arma completo no tiene errores, ni como builder ni como DE. */
  #[DataProvider('documentosDeLaFabrica')]
  public function testLosDocumentosCompletosNoTienenErrores(callable $crear): void
  {
    $doc = $crear();
    $r = $doc->validarReglas();
    $this->assertInstanceOf(ResultadoValidacion::class, $r);
    $this->assertTrue($r->esValido(), "builder: $r");
    $this->assertCount(0, $r);

    $rde = self::aRde($doc);
    $this->assertTrue(ValidadorDE::validar($rde)->esValido(), 'RDE: ' . ValidadorDE::validar($rde));
    $this->assertTrue(ValidadorDE::validar($rde->getDE())->esValido(), 'DE');
  }

  /** @return iterable<string, array{string}> los rDE reales enviados a sifen-test (todos pasaron el esquema del SIFEN) */
  public static function capturasReales(): iterable
  {
    foreach (glob(R::DIR . '/*/*-firmada-anonimizada.xml') as $ruta) {
      yield basename(dirname($ruta)) . '/' . basename($ruta) => [$ruta];
    }
  }

  /** Control de falsos positivos sobre documentos reales: ninguno tiene errores de completitud ni de grupos. */
  #[DataProvider('capturasReales')]
  public function testLosDocumentosRealesNoTienenErrores(string $ruta): void
  {
    $doc = new DOMDocument();
    $doc->loadXML(file_get_contents($ruta));
    $rde = RDE::FromDOMElement($doc->documentElement);
    $r = ValidadorDE::validar($rde);
    $this->assertTrue($r->esValido(), (string) $r);
  }

  /** Deuda Q-B3: un documento a medio armar lista lo que falta, con campo del MT y sugerencia, sin ningún Error. */
  public function testUnaFacturaReciénCreadaListaLosFaltantes(): void
  {
    $r = (new Factura(CamCondOpe::Contado))->validarReglas();
    $this->assertFalse($r->esValido());
    $this->assertGreaterThan(10, count($r));
    $campos = array_map(fn (ErrorValidacion $e) => $e->campoMT, $r->getErrores());
    // E011 no figura: GCamFE arranca con iIndPres = 1 (presencial) por defecto.
    foreach (['C004', 'C005', 'C006', 'C007', 'C008', 'D002', 'D101', 'D102', 'D105', 'D107', 'D111', 'D118', 'D130', 'D200', 'E700'] as $campo) {
      $this->assertContains($campo, $campos, "falta $campo entre los faltantes");
    }
    foreach ($r->getErrores() as $e) {
      $this->assertContains($e->origen, [OrigenError::Completitud, OrigenError::Regla], (string) $e);
      $this->assertNotNull($e->codigoSifen, (string) $e);
      $this->assertStringStartsWith('DE', $e->ruta, (string) $e);
    }
    $timbrado = $r->porCampo('C004')[0];
    $this->assertSame(OrigenError::Completitud, $timbrado->origen);
    $this->assertSame('0160', $timbrado->codigoSifen);
    $this->assertSame('dNumTim', $timbrado->elemento);
    $this->assertSame('DE.gTimb', $timbrado->ruta);
    $this->assertStringContainsString('setTimbrado', $timbrado->sugerencia);
    $this->assertStringContainsString('DE_v150.xsd:', $timbrado->mensaje, 'cita la línea del XSD');
    // Los grupos ausentes se reportan una vez (gDatRec), no sus hijos.
    $this->assertCount(1, $r->porCampo('D200'));
    $this->assertSame([], $r->porCampo('D201'));
    // La presencia del grupo de totales es una regla con código del MT.
    $this->assertSame('2350', $r->porCampo('F001')[0]->codigoSifen);
    $this->assertSame(OrigenError::Regla, $r->porCampo('F001')[0]->origen);
  }

  /** @return iterable<string, array{callable(): (DocumentoElectronico|DE), string, string}> */
  public static function presenciaDeGrupos(): iterable
  {
    yield 'NR sin transporte → 2100' => [function () { $nr = F::notaDeRemision(); unset($nr->gTransp); return $nr; }, '2100', 'E900'];
    yield 'FE sin condición de la operación → 1500' => [function () { $fe = F::facturaContado(); unset($fe->gCamCond); return $fe; }, '1500', 'E600'];
    yield 'NC sin documento asociado → 2400' => [function () { $nc = F::notaDeCredito(); $nc->gCamDEAsoc = []; return $nc; }, '2400', 'H001'];
    yield 'FE sin gCamFE → 1350' => [function () { $fe = F::facturaContado(); unset($fe->gCamFE); return $fe; }, '1350', 'E010'];
    yield 'AF sin gCamAE → 2550' => [function () { $af = F::autofactura(); unset($af->gCamAE); return $af; }, '2550', 'E300'];
    yield 'NC sin gCamNCDE → 1450' => [function () { $nc = F::notaDeCredito(); unset($nc->gCamNCDE); return $nc; }, '1450', 'E400'];
    yield 'NR sin gCamNRE → 2600' => [function () { $nr = F::notaDeRemision(); unset($nr->gCamNRE); return $nr; }, '2600', 'E500'];
    yield 'FE sin totales → 2350' => [function () { $fe = F::facturaContado(); unset($fe->gTotSub); return $fe; }, '2350', 'F001'];
    yield 'FE sin gOpeCom (DE) → 1200' => [function () { $de = self::aRde(F::facturaContado())->getDE(); unset($de->gDatGralOpe->gOpeCom); return $de; }, '1200', 'D010'];
    yield 'NR con gOpeCom (DE) → 1201' => [function () { $de = self::aRde(F::notaDeRemision())->getDE(); $de->gDatGralOpe->gOpeCom = new GOpeCom(); return $de; }, '1201', 'D010'];
    yield 'NR con gCamFE (DE) → 1351' => [function () { $de = self::aRde(F::notaDeRemision())->getDE(); $de->gDtipDe->gCamFE = new GCamFE(); return $de; }, '1351', 'E010'];
    yield 'FE con gCamNRE (DE) → 2601' => [function () { $de = self::aRde(F::facturaContado())->getDE(); $de->gDtipDe->gCamNRE = new GCamNRE(); return $de; }, '2601', 'E500'];
    yield 'NR con gCamCond (DE) → 1501' => [function () { $de = self::aRde(F::notaDeRemision())->getDE(); $de->gDtipDe->gCamCond = new GCamCond(); return $de; }, '1501', 'E600'];
    yield 'NR con totales (DE) → 2351' => [function () { $de = self::aRde(F::notaDeRemision())->getDE(); $de->gTotSub = new GTotSub(); return $de; }, '2351', 'F001'];
    yield 'AF con transporte (DE) → 2101' => [function () { $de = self::aRde(F::autofactura())->getDE(); $de->gDtipDe->gTransp = self::aRde(F::notaDeRemision())->getDE()->gDtipDe->gTransp; return $de; }, '2101', 'E900'];
    yield 'NR con gValorItem en un ítem (DE) → 1851' => [function () { $de = self::aRde(F::notaDeRemision())->getDE(); $de->gDtipDe->gCamItem[0]->gValorItem = self::aRde(F::facturaContado())->getDE()->gDtipDe->gCamItem[0]->gValorItem; return $de; }, '1851', 'E720'];
    yield 'FE sin gValorItem en un ítem (DE) → 1850' => [function () { $de = self::aRde(F::facturaContado())->getDE(); unset($de->gDtipDe->gCamItem[0]->gValorItem); return $de; }, '1850', 'E720'];
    yield 'FE sin gCamIVA en un ítem (DE) → 1900' => [function () { $de = self::aRde(F::facturaContado())->getDE(); unset($de->gDtipDe->gCamItem[0]->gCamIVA); return $de; }, '1900', 'E730'];
    yield 'NR con gCamIVA en un ítem (DE) → 1901' => [function () { $de = self::aRde(F::notaDeRemision())->getDE(); $de->gDtipDe->gCamItem[0]->gCamIVA = new GCamIVA(); return $de; }, '1901', 'E730'];
    yield 'NC con carga (DE) → 2390' => [function () { $de = self::aRde(F::notaDeCredito())->getDE(); $g = new GCamGen(); $g->gCamCarg = new GCamCarg(); $de->gCamGen = $g; return $de; }, '2390', 'G050'];
  }

  #[DataProvider('presenciaDeGrupos')]
  public function testPresenciaDeGruposPorTipoDeDocumento(callable $crear, string $codigo, string $campo): void
  {
    $doc = $crear();
    $r = $doc instanceof DocumentoElectronico ? $doc->validarReglas() : ValidadorDE::validar($doc);
    $this->assertFalse($r->esValido());
    $encontrados = $r->porCodigo($codigo);
    $this->assertNotEmpty($encontrados, "se esperaba el código $codigo; errores: $r");
    $this->assertSame($campo, $encontrados[0]->campoMT);
    $this->assertSame(OrigenError::Regla, $encontrados[0]->origen);
    $this->assertSame($encontrados[0]->mensaje, $encontrados[0]->getInfoValidacion()->mensaje, 'el mensaje es el del MT');
  }

  public function testElResultadoSeCuentaSeRecorreYSeLanza(): void
  {
    $r = new ResultadoValidacion();
    $this->assertTrue($r->esValido());
    $this->assertSame('Válido', (string) $r);
    $r->lanzarSiInvalido();

    $r->agregar(new ErrorValidacion(OrigenError::Regla, 'advertencia', '1005', 'A004b', esAdvertencia: true));
    $this->assertTrue($r->esValido(), 'una advertencia no invalida');
    $this->assertCount(1, $r->getAdvertencias());
    $this->assertCount(0, $r);

    $r->agregar(new ErrorValidacion(OrigenError::Completitud, 'falta dNumTim', '0160', 'C004', 'dNumTim', 'DE.gTimb'));
    $r->agregar(new ErrorValidacion(OrigenError::Regla, 'total', '2365', 'F014', 'dTotGralOpe', 'DE.gTotSub'));
    $this->assertFalse($r->esValido());
    $this->assertCount(2, $r);
    $this->assertCount(3, $r->getTodos());
    $this->assertCount(1, $r->porCodigo('2365'));
    $this->assertCount(1, $r->porOrigen(OrigenError::Completitud));
    $this->assertCount(1, $r->porCampo('C004'));
    $this->assertSame(['falta dNumTim', 'total'], array_map(fn ($e) => $e->mensaje, iterator_to_array($r)));
    $this->assertStringContainsString('2 error', (string) $r);
    try {
      $r->lanzarSiInvalido('La factura no se puede enviar');
      $this->fail('Se esperaba DocumentoInvalidoException');
    } catch (DocumentoInvalidoException $e) {
      $this->assertSame($r, $e->getResultado());
      $this->assertStringStartsWith('La factura no se puede enviar', $e->getMessage());
      $this->assertInstanceOf(\InvalidArgumentException::class, $e);
    }
  }

  private static function aRde(DocumentoElectronico $doc): RDE
  {
    $doc->gOpeDE->setDCodSeg('123456789');
    return match (true) {
      $doc instanceof Factura => $doc->facturaToRDE(),
      $doc instanceof \IonysDev\Pkuatia\Core\DocumentosElectronicos\Autofactura => $doc->autofacturaToRDE(),
      $doc instanceof \IonysDev\Pkuatia\Core\DocumentosElectronicos\NotaDeCredito => $doc->notaDeCreditoToRDE(),
      $doc instanceof \IonysDev\Pkuatia\Core\DocumentosElectronicos\NotaDeDebito => $doc->notaDeDebitoToRDE(),
      $doc instanceof \IonysDev\Pkuatia\Core\DocumentosElectronicos\NotaDeRemision => $doc->notaDeRemisionToRDE(),
      default => $doc->documentoElectronicoToRDE(),
    };
  }
}
