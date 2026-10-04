<?php

namespace IonysDev\Pkuatia\Tests\Support;

use DateTime;
use DateTimeZone;
use IonysDev\Pkuatia\Core\Constants\CamCondOpe;
use IonysDev\Pkuatia\Core\Constants\CamFEIndPres;
use IonysDev\Pkuatia\Core\Constants\CamIVAAfecIVA;
use IonysDev\Pkuatia\Core\Constants\CamIVATasaIVA;
use IonysDev\Pkuatia\Core\Constants\EmisRecTipCont;
use IonysDev\Pkuatia\Core\Constants\OpeComTipTrans;
use IonysDev\Pkuatia\Core\Constants\PaConEIniTiPago;
use IonysDev\Pkuatia\Core\Constants\RecTiOpe;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\DocumentoElectronico;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\Factura;
use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;
use IonysDev\Pkuatia\Sifen;

/**
 * Documentos de prueba completos con datos ficticios (RUC 80000000-5, timbrado 12345678),
 * pensados para validarse contra los XSD de producción. No usar datos reales aquí.
 */
final class DocumentoFactory
{
  public const RUC_EMISOR = '80000000';
  public const DV_EMISOR = 5;
  public const TIMBRADO = 12345678;

  public static function fechaEmision(): DateTime
  {
    return new DateTime('2026-01-15T10:00:00', new DateTimeZone('America/Asuncion'));
  }

  /** Timbrado, fecha de emisión y emisor comunes a todos los documentos. */
  public static function configurarBase(DocumentoElectronico $doc, int $numDoc): void
  {
    $doc->setTimbrado(self::TIMBRADO, new DateTime('2024-01-01'), 1, 1, $numDoc);
    $doc->setFechaEmision(self::fechaEmision());
    $doc->setEmisor(
      self::RUC_EMISOR,
      self::DV_EMISOR,
      EmisRecTipCont::PersonaJuridica,
      null,
      'Empresa Emisora de Ejemplo SA',
      null,
      'Av. Principal',
      '100',
      null,
      null,
      1,
      null,
      1,
      '021000000',
      'emisor@example.com',
      null
    );
    $doc->addEmisorActividadEconomica(47190, 'Comercio al por menor');
  }

  /** Receptor contribuyente B2B. */
  public static function receptorContribuyente(DocumentoElectronico $doc, string $nombre = 'Cliente Receptor SA'): void
  {
    $doc->setReceptor(
      $nombre,
      true,
      RecTiOpe::B2B,
      'PRY',
      EmisRecTipCont::PersonaJuridica,
      '80012345',
      0,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null
    );
  }

  /** FE al contado, un ítem gravado 10 %, pago en efectivo (equivale al ejemplo del README). */
  public static function facturaContado(int $numDoc = 1): Factura
  {
    $fe = new Factura(CamCondOpe::Contado);
    self::configurarBase($fe, $numDoc);
    self::receptorContribuyente($fe);
    $fe->setTipoDeTransaccion(OpeComTipTrans::VentaMercaderia);
    $fe->setIndicadorPresencia(CamFEIndPres::Presencial);
    $fe->addItem('PROD001', 'Producto de ejemplo', 77, '1', 0, '100000', null, CamIVAAfecIVA::Gravado, '100', CamIVATasaIVA::IVA10);
    $fe->calcTotSub(0);
    $fe->addPago(PaConEIniTiPago::Efectivo, '100000', 'PYG');
    return $fe;
  }

  /** Firma un RDE con el entorno de prueba ya inicializado (SifenTestEnvironment::init()). */
  public static function firmar(RDE $rde): string
  {
    return Sifen::FirmarDE($rde, new DateTime('2026-01-15T10:05:00', new DateTimeZone('America/Asuncion')));
  }
}
