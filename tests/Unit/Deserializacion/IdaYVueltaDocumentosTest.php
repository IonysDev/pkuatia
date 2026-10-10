<?php

namespace IonysDev\Pkuatia\Tests\Unit\Deserializacion;

use DateTime;
use DateTimeZone;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\DocumentoElectronico;
use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory as F;
use IonysDev\Pkuatia\Tests\Support\RoundTrip;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Ida y vuelta de documentos completos (sin firma): RDE::toDOMElement -> RDE::From* -> toDOMElement
 * debe dar el mismo XML byte a byte. B0 fija lo que ya funciona por la vía DOM; los pasos B1 y B2
 * agregan la autofactura y la vía SimpleXML cuando corrigen PK-25, PK-26 y PK-36.
 */
final class IdaYVueltaDocumentosTest extends TestCase
{
  /** Sin cero inicial a propósito: el cero inicial (PK-26) se prueba en B2. */
  public const COD_SEG = '123456789';

  /** @return array<string, array{0: callable(): RDE}> */
  public static function documentos(): array
  {
    return [
      'FE contado' => [fn (): RDE => self::rde(F::facturaContado(), 'facturaToRDE')],
      'FE crédito en cuotas' => [fn (): RDE => self::rde(F::facturaCreditoCuotas(), 'facturaToRDE')],
      'FE crédito con entrega inicial' => [fn (): RDE => self::rde(F::facturaCreditoCuotas(4, '20000'), 'facturaToRDE')],
      'FE en USD' => [fn (): RDE => self::rde(F::facturaUsd(), 'facturaToRDE')],
      'Nota de crédito' => [fn (): RDE => self::rde(F::notaDeCredito(), 'notaDeCreditoToRDE')],
      'Nota de débito' => [fn (): RDE => self::rde(F::notaDeDebito(), 'notaDeDebitoToRDE')],
      'Nota de remisión' => [fn (): RDE => self::rde(F::notaDeRemision(), 'notaDeRemisionToRDE')],
      'Nota de remisión, vehículo por matrícula' => [fn (): RDE => self::rde(F::notaDeRemision(21, true, true), 'notaDeRemisionToRDE')],
    ];
  }

  #[DataProvider('documentos')]
  public function testIdaYVueltaPorDomEsIdentica(callable $crear): void
  {
    RoundTrip::assertIdaYVueltaIdentica($crear(), RoundTrip::VIA_DOM);
  }

  /** RDE determinista: código de seguridad y fecha de firma fijos. */
  public static function rde(DocumentoElectronico $doc, string $conversor): RDE
  {
    $doc->gOpeDE->setDCodSeg(self::COD_SEG);
    $rde = $doc->$conversor();
    $rde->getDE()->setDFecFirma(new DateTime('2026-01-15T10:05:00', new DateTimeZone('America/Asuncion')));
    return $rde;
  }
}
