<?php

namespace IonysDev\Pkuatia\Tests\Unit\Deserializacion;

use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory as F;
use IonysDev\Pkuatia\Tests\Support\RoundTrip;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Fase B/B12: ida y vuelta de los 46 grupos del DE (cada clase de src/Core/Fields/DE) por las tres vías de lectura:
 * FromDOMElement, FromSimpleXMLElement (la que usa Sifen::ConsultarDE) y FromSifenResponseObject (el objeto de
 * SoapClient). Las instancias salen de los documentos de DocumentoFactory (FE contado, en cuotas, en USD, NC, ND, NR,
 * AF, FE de cada sector, FE con todos los opcionales) y de una FE firmada leída de XML (Signature y gCamFuFD). Cada
 * instancia distinta se serializa, se lee y se vuelve a serializar: el XML tiene que ser el mismo byte a byte.
 *
 * Exclusiones: rDE y DE no van por la vía SOAP porque tienen atributos, que ext/soap descarta; Signature no tiene
 * lector SOAP y sus serializadores tipados están rotos (Reference llama a Transform::toDOMElement() sin el documento),
 * así que no se prueba como grupo suelto: un rDE leído la reemite desde el XML original (PK-32, B7,
 * IdaYVueltaFirmadoTest) y los serializadores quedan para la Fase D.
 */
final class IdaYVueltaGruposTest extends TestCase
{
  /** @var array<class-string, array<string, object>>|null clase => [XML de ida => instancia] */
  private static ?array $instancias = null;

  /** @var callable|null */
  private static $cleanup = null;

  public static function setUpBeforeClass(): void
  {
    self::$cleanup = SifenTestEnvironment::init()['cleanup'];
  }

  public static function tearDownAfterClass(): void
  {
    if (self::$cleanup !== null) {
      (self::$cleanup)();
      self::$cleanup = null;
    }
    self::$instancias = null;
  }

  public function testCadaGrupoDelDETieneInstanciasEnLosDocumentosDePrueba(): void
  {
    $sinInstancias = array_values(array_filter(self::clasesDelDE(), fn (string $clase) => empty(self::instancias()[$clase])));

    $this->assertCount(46, self::clasesDelDE());
    $this->assertSame([], $sinInstancias);
  }

  /** @return array<string, array{0: class-string, 1: string}> */
  public static function gruposYVias(): array
  {
    $res = [];
    foreach (self::clasesDelDE() as $clase) {
      $corto = substr($clase, strrpos($clase, '\\') + 1);
      if ($corto === 'Signature') {
        continue;
      }
      foreach (['DOM' => RoundTrip::VIA_DOM, 'SimpleXML' => RoundTrip::VIA_SIMPLEXML, 'objeto SOAP' => RoundTrip::VIA_SOAP] as $nombre => $via) {
        if ($via === RoundTrip::VIA_SOAP && in_array($corto, ['RDE', 'DE'], true)) {
          continue;
        }
        $res["$corto por $nombre"] = [$clase, $via];
      }
    }
    return $res;
  }

  /** @param class-string $clase */
  #[DataProvider('gruposYVias')]
  public function testIdaYVueltaIdentica(string $clase, string $via): void
  {
    $instancias = self::instancias()[$clase] ?? [];
    $this->assertNotEmpty($instancias, "Sin instancias de $clase.");
    foreach ($instancias as $xml => $grupo) {
      RoundTrip::assertIdaYVueltaIdentica($grupo, $via, $clase, substr($xml, 0, 120));
    }
  }

  /** @return list<class-string> Las clases de src/Core/Fields/DE. */
  private static function clasesDelDE(): array
  {
    $raiz = dirname(__DIR__, 3) . '/src/';
    $res = [];
    $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($raiz . 'Core/Fields/DE', \FilesystemIterator::SKIP_DOTS));
    foreach ($it as $archivo) {
      if ($archivo->getExtension() === 'php') {
        $relativa = substr(str_replace('\\', '/', $archivo->getPathname()), strlen(str_replace('\\', '/', $raiz)), -4);
        $res[] = 'IonysDev\\Pkuatia\\' . str_replace('/', '\\', $relativa);
      }
    }
    sort($res);
    return $res;
  }

  /** @return array<class-string, array<string, object>> */
  private static function instancias(): array
  {
    if (self::$instancias !== null) {
      return self::$instancias;
    }
    $documentos = [
      F::facturaContado(), F::facturaCreditoCuotas(), F::facturaCreditoCuotas(4, '50000'), F::facturaUsd(),
      F::notaDeCredito(), F::notaDeDebito(), F::notaDeRemision(), F::notaDeRemision(21, true, true),
      F::autofactura(), F::autofacturaSinDistrito(), F::facturaConTodosLosSectores(), F::facturaConTodosLosOpcionales(),
    ];
    foreach (array_keys(F::sectores()) as $sector) {
      $documentos[] = F::facturaSectorial($sector);
    }
    $rdes = array_map(fn ($doc) => F::rde($doc), $documentos);
    $rdes[] = RDE::FromSimpleXMLElement(simplexml_load_string(F::firmar(F::rde(F::facturaContado(80)))));

    $res = [];
    $vistos = new \SplObjectStorage();
    $recorrer = function (mixed $valor) use (&$recorrer, &$res, $vistos): void {
      if (is_array($valor)) {
        foreach ($valor as $item) {
          $recorrer($item);
        }
        return;
      }
      if (!is_object($valor) || $vistos->contains($valor) || !str_starts_with(get_class($valor), 'IonysDev\\Pkuatia\\Core\\Fields\\DE\\')) {
        return;
      }
      $vistos->attach($valor);
      $clave = get_class($valor) === 'IonysDev\\Pkuatia\\Core\\Fields\\DE\\I\\Signature' ? spl_object_hash($valor) : RoundTrip::serializar($valor);
      $res[get_class($valor)][$clave] = $valor;
      foreach ((new \ReflectionObject($valor))->getProperties() as $propiedad) {
        $propiedad->setAccessible(true);
        if ($propiedad->isInitialized($valor)) {
          $recorrer($propiedad->getValue($valor));
        }
      }
    };
    foreach ($rdes as $rde) {
      $recorrer($rde);
    }
    return self::$instancias = $res;
  }
}
