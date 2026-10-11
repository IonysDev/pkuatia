<?php

namespace IonysDev\Pkuatia\Tests\Unit\Deserializacion;

use DOMDocument;
use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamAE;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamEsp;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamNRE;
use IonysDev\Pkuatia\Core\Fields\Response\GResProc;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory as F;
use IonysDev\Pkuatia\Tests\Support\RespuestasSifenFactory as R;
use IonysDev\Pkuatia\Tests\Support\RoundTrip;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * PK-25 (Fase B/B1): lectores inexistentes o rotos de los campos específicos por tipo de documento.
 * Hasta 0.2.0 la autofactura, la nota de remisión y todo DE con gCamEsp no se podían deserializar
 * (Error: Call to undefined method; 9 entradas staticMethod.notFound en phpstan-baseline.neon).
 * Fuentes: DE_v150.xsd tgCamAE, tgCamNRE (dKmR minOccurs=1), tgGrupSup (:663), tgGrupAdi (:811),
 * tgCamEsp (:794, orden gGrupEner, gGrupSeg, gGrupSup, gGrupAdi). La ida y vuelta de documentos
 * completos por las dos vías está en IdaYVueltaDocumentosTest.
 */
final class CamposEspecificosIdaYVueltaTest extends TestCase
{
  /** @return array<string, array{0: string}> */
  public static function vias(): array
  {
    return [
      'DOM' => [RoundTrip::VIA_DOM],
      'SimpleXML' => [RoundTrip::VIA_SIMPLEXML],
      'objeto SOAP' => [RoundTrip::VIA_SOAP],
    ];
  }

  /**
   * gCamEsp con los cuatro grupos, armado a mano para probar la clase sola. Desde la decisión Q-B8 los
   * builders también emiten los cuatro juntos (ver GruposSectorialesTest).
   */
  public static function gCamEspCompleto(): GCamEsp
  {
    $esp = fn (string $sector): GCamEsp => F::rde(F::facturaSectorial($sector))->getDE()->getGDtipDe()->getGCamEsp();
    return (new GCamEsp())
      ->setgGrupEner($esp('energía')->getgGrupEner())
      ->setGGrupSeg($esp('seguros')->getGGrupSeg())
      ->setGGrupSup($esp('supermercados')->getGGrupSup())
      ->setGGrupAdi($esp('datos adicionales')->getGGrupAdi());
  }

  #[DataProvider('vias')]
  public function testGCamEspConLosCuatroGruposSectoriales(string $via): void
  {
    RoundTrip::assertIdaYVueltaIdentica(self::gCamEspCompleto(), $via, GCamEsp::class);
  }

  /** @return array<string, array{0: string, 1: string, 2: string}> */
  public static function gruposPorVia(): array
  {
    $res = [];
    $grupos = ['energía' => 'getgGrupEner', 'seguros' => 'getGGrupSeg', 'supermercados' => 'getGGrupSup', 'datos adicionales' => 'getGGrupAdi'];
    foreach ($grupos as $sector => $getter) {
      foreach (self::vias() as $nombre => [$via]) {
        $res[substr($getter, 3) . " por $nombre"] = [$sector, $getter, $via];
      }
    }
    return $res;
  }

  #[DataProvider('gruposPorVia')]
  public function testCadaGrupoSectorialHaceIdaYVuelta(string $sector, string $getter, string $via): void
  {
    $grupo = F::rde(F::facturaSectorial($sector))->getDE()->getGDtipDe()->getGCamEsp()->$getter();
    RoundTrip::assertIdaYVueltaIdentica($grupo, $via);
  }

  /** @return array<string, array{0: callable(): RDE}> */
  public static function documentosConCamposEspecificos(): array
  {
    return [
      'FE sector energía' => [fn (): RDE => F::rde(F::facturaSectorial('energía'))],
      'FE sector seguros' => [fn (): RDE => F::rde(F::facturaSectorial('seguros'))],
      'FE sector supermercados' => [fn (): RDE => F::rde(F::facturaSectorial('supermercados'))],
      'FE con datos adicionales de uso comercial' => [fn (): RDE => F::rde(F::facturaSectorial('datos adicionales'))],
      'Autofactura, 2 ítems' => [fn (): RDE => F::rde(F::autofactura())],
      'Autofactura, 1 ítem' => [fn (): RDE => F::rde(F::autofactura(31, 1))],
      'Autofactura, lugar sin distrito' => [fn (): RDE => F::rde(F::autofacturaSinDistrito())],
      'Nota de remisión' => [fn (): RDE => F::rde(F::notaDeRemision())],
    ];
  }

  #[DataProvider('documentosConCamposEspecificos')]
  public function testDocumentoCompletoPorDomEsIdentico(callable $crear): void
  {
    RoundTrip::assertIdaYVueltaIdentica($crear(), RoundTrip::VIA_DOM);
  }

  /** Por SimpleXML el documento se puede leer y cada grupo específico vuelve idéntico. */
  #[DataProvider('documentosConCamposEspecificos')]
  public function testDocumentoCompletoPorSimpleXmlConservaLosCamposEspecificos(callable $crear): void
  {
    $ida = RoundTrip::serializar($crear());
    $vuelta = RoundTrip::serializar(RoundTrip::leer($ida, RDE::class, RoundTrip::VIA_SIMPLEXML));
    foreach (['gCamFE', 'gCamAE', 'gCamNRE', 'gCamEsp', 'gCamItem', 'gTransp'] as $grupo) {
      $this->assertSame(self::subarbol($ida, $grupo), self::subarbol($vuelta, $grupo), $grupo);
    }
  }

  /** @return array<string, array{0: callable(): object, 1: string, 2: class-string}> */
  public static function camposPorVia(): array
  {
    $res = [];
    $casos = [
      'gCamAE' => [fn () => F::rde(F::autofactura())->getDE()->getGDtipDe()->getGCamAE(), GCamAE::class],
      'gCamAE sin distrito' => [fn () => F::rde(F::autofacturaSinDistrito())->getDE()->getGDtipDe()->getGCamAE(), GCamAE::class],
      'gCamNRE' => [fn () => F::rde(F::notaDeRemision())->getDE()->getGDtipDe()->getGCamNRE(), GCamNRE::class],
    ];
    foreach ($casos as $nombre => [$crear, $clase]) {
      foreach (self::vias() as $nombreVia => [$via]) {
        $res["$nombre por $nombreVia"] = [$crear, $via, $clase];
      }
    }
    return $res;
  }

  #[DataProvider('camposPorVia')]
  public function testCamposDeAutofacturaYRemisionPorLasTresVias(callable $crear, string $via, string $clase): void
  {
    RoundTrip::assertIdaYVueltaIdentica($crear(), $via, $clase);
  }

  public function testGCamNREExigeLosCamposObligatoriosAlLeer(): void
  {
    $this->expectException(\InvalidArgumentException::class);
    $this->expectExceptionMessage('dKmR');
    GCamNRE::FromSimpleXMLElement(simplexml_load_string(
      '<gCamNRE><iMotEmiNR>1</iMotEmiNR><dDesMotEmiNR>Traslado por venta</dDesMotEmiNR><iRespEmiNR>1</iRespEmiNR><dDesRespEmiNR>Emisor de la factura</dDesRespEmiNR></gCamNRE>'
    ));
  }

  /**
   * RProtDe::FromSimpleXMLElement llamaba a GResProc::fromSimpleXMLElement, que no existía. Sobre la
   * respuesta interna de un evento tal como la devuelve el SIFEN en xContEv (captura real del 09/10).
   */
  public function testGResProcSeLeeDesdeSimpleXml(): void
  {
    preg_match('#<gResProc>.*?</gResProc>#s', R::xContenDE(R::CONSULTA_DE_0422_CANCELADO), $m);
    $gResProc = GResProc::FromSimpleXMLElement(simplexml_load_string($m[0]));
    $this->assertSame('0600', $gResProc->getDCodRes());
    $this->assertSame('Se encontro el evento', $gResProc->getDMsgRes());
  }

  private static function subarbol(string $xml, string $grupo): string
  {
    $doc = new DOMDocument();
    $doc->loadXML($xml);
    $res = '';
    foreach ($doc->getElementsByTagName($grupo) as $nodo) {
      $res .= $doc->saveXML($nodo);
    }
    return $res;
  }
}
