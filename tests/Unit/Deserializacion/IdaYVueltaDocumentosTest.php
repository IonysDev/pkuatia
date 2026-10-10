<?php

namespace IonysDev\Pkuatia\Tests\Unit\Deserializacion;

use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory as F;
use IonysDev\Pkuatia\Tests\Support\RoundTrip;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Ida y vuelta de documentos completos (sin firma): RDE::toDOMElement -> RDE::From* -> toDOMElement
 * debe dar el mismo XML byte a byte. B0 fija lo que ya funcionaba por la vía DOM; B1 agrega la
 * autofactura (PK-25) y B2 la vía SimpleXML (PK-26, PK-36). Código de seguridad fijo: ver
 * DocumentoFactory::rde().
 */
final class IdaYVueltaDocumentosTest extends TestCase
{
  /** @return array<string, array{0: callable(): RDE}> */
  public static function documentos(): array
  {
    return [
      'FE contado' => [fn (): RDE => F::rde(F::facturaContado())],
      'FE crédito en cuotas' => [fn (): RDE => F::rde(F::facturaCreditoCuotas())],
      'FE crédito con entrega inicial' => [fn (): RDE => F::rde(F::facturaCreditoCuotas(4, '20000'))],
      'FE en USD' => [fn (): RDE => F::rde(F::facturaUsd())],
      'Nota de crédito' => [fn (): RDE => F::rde(F::notaDeCredito())],
      'Nota de débito' => [fn (): RDE => F::rde(F::notaDeDebito())],
      'Nota de remisión' => [fn (): RDE => F::rde(F::notaDeRemision())],
      'Nota de remisión, vehículo por matrícula' => [fn (): RDE => F::rde(F::notaDeRemision(21, true, true))],
    ];
  }

  #[DataProvider('documentos')]
  public function testIdaYVueltaPorDomEsIdentica(callable $crear): void
  {
    RoundTrip::assertIdaYVueltaIdentica($crear(), RoundTrip::VIA_DOM);
  }
}
