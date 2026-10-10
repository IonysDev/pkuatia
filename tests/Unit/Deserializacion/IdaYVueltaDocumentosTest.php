<?php

namespace IonysDev\Pkuatia\Tests\Unit\Deserializacion;

use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory as F;
use IonysDev\Pkuatia\Tests\Support\RoundTrip;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Ida y vuelta de documentos completos (sin firma): RDE::toDOMElement -> RDE::From* -> toDOMElement
 * debe dar el mismo XML byte a byte, por DOM y por SimpleXML (la vía que usa Sifen::ConsultarDE).
 * B0 fijó la vía DOM; B1 sumó autofacturas y facturas sectoriales (PK-25); B2 la vía SimpleXML
 * (PK-26, PK-36). Código de seguridad fijo: ver DocumentoFactory::rde().
 */
final class IdaYVueltaDocumentosTest extends TestCase
{
  /** @return array<string, callable(): RDE> */
  public static function documentos(): array
  {
    $res = [
      'FE contado' => fn (): RDE => F::rde(F::facturaContado()),
      'FE crédito en cuotas' => fn (): RDE => F::rde(F::facturaCreditoCuotas()),
      'FE crédito con entrega inicial' => fn (): RDE => F::rde(F::facturaCreditoCuotas(4, '20000')),
      'FE en USD' => fn (): RDE => F::rde(F::facturaUsd()),
      'Nota de crédito' => fn (): RDE => F::rde(F::notaDeCredito()),
      'Nota de débito' => fn (): RDE => F::rde(F::notaDeDebito()),
      'Nota de remisión' => fn (): RDE => F::rde(F::notaDeRemision()),
      'Nota de remisión, vehículo por matrícula' => fn (): RDE => F::rde(F::notaDeRemision(21, true, true)),
      'Autofactura, 2 ítems' => fn (): RDE => F::rde(F::autofactura()),
      'Autofactura, 1 ítem' => fn (): RDE => F::rde(F::autofactura(31, 1)),
      'Autofactura, lugar sin distrito' => fn (): RDE => F::rde(F::autofacturaSinDistrito()),
    ];
    foreach (array_keys(F::sectores()) as $sector) {
      $res["FE sector $sector"] = fn (): RDE => F::rde(F::facturaSectorial($sector));
    }
    $res['FE con los cuatro grupos sectoriales'] = fn (): RDE => F::rde(F::facturaConTodosLosSectores());
    return $res;
  }

  /** @return array<string, array{0: callable(): RDE, 1: string}> */
  public static function documentosPorVia(): array
  {
    $res = [];
    foreach (self::documentos() as $nombre => $crear) {
      foreach (['DOM' => RoundTrip::VIA_DOM, 'SimpleXML' => RoundTrip::VIA_SIMPLEXML] as $nombreVia => $via) {
        $res["$nombre por $nombreVia"] = [$crear, $via];
      }
    }
    return $res;
  }

  #[DataProvider('documentosPorVia')]
  public function testIdaYVueltaEsIdentica(callable $crear, string $via): void
  {
    RoundTrip::assertIdaYVueltaIdentica($crear(), $via);
  }
}
