<?php

namespace IonysDev\Pkuatia\Tests\Support;

use DateTime;
use DateTimeZone;
use IonysDev\Pkuatia\Core\Constants\CamAENatVen;
use IonysDev\Pkuatia\Core\Constants\CamAETipIDVen;
use IonysDev\Pkuatia\Core\Constants\CamCondOpe;
use IonysDev\Pkuatia\Core\Constants\CamFEIndPres;
use IonysDev\Pkuatia\Core\Constants\CamIVAAfecIVA;
use IonysDev\Pkuatia\Core\Constants\CamIVATasaIVA;
use IonysDev\Pkuatia\Core\Constants\COblAfe;
use IonysDev\Pkuatia\Core\Constants\EmisRecTipCont;
use IonysDev\Pkuatia\Core\Constants\GTranspModTrans;
use IonysDev\Pkuatia\Core\Constants\GTranspRespFlete;
use IonysDev\Pkuatia\Core\Constants\GTranspTipTrans;
use IonysDev\Pkuatia\Core\Constants\MotEmi;
use IonysDev\Pkuatia\Core\Constants\MotEmiNR;
use IonysDev\Pkuatia\Core\Constants\OpeComCondTipCam;
use IonysDev\Pkuatia\Core\Constants\OpeComTipTrans;
use IonysDev\Pkuatia\Core\Constants\PaConEIniTiPago;
use IonysDev\Pkuatia\Core\Constants\PagTarCDDenTarj;
use IonysDev\Pkuatia\Core\Constants\PagTarCDForProPa;
use IonysDev\Pkuatia\Core\Constants\RecTiOpe;
use IonysDev\Pkuatia\Core\Constants\RespEmiNR;
use IonysDev\Pkuatia\Core\Constants\TipIDRec;
use IonysDev\Pkuatia\Core\Constants\TipIDRespDE;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\Autofactura;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\DocumentoElectronico;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\Factura;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\NotaDeCredito;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\NotaDeDebito;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\NotaDeRemision;
use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;
use IonysDev\Pkuatia\Core\Fields\DE\E\GVehNuevo;
use IonysDev\Pkuatia\Core\Fields\DE\G\GCamCarg;
use IonysDev\Pkuatia\Sifen;

/**
 * Documentos de prueba completos con datos ficticios (RUC 80000000-5, timbrado 12345678),
 * pensados para validarse contra los XSD de producción. No usar datos reales aquí.
 * Portados de los builders de la evaluación del 02/10/2026 (evidencia/qa_common.php).
 */
final class DocumentoFactory
{
  public const RUC_EMISOR = '80000000';
  public const DV_EMISOR = 5;
  public const TIMBRADO = 12345678;
  /** CDC ficticio sintácticamente válido (44 dígitos) para documentos asociados. */
  public const CDC_ASOCIADO = '01800000005001001000000122026011517391544291';

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
      self::RUC_EMISOR, self::DV_EMISOR, EmisRecTipCont::PersonaJuridica, null,
      'Empresa Emisora de Ejemplo SA', null, 'Av. Principal', '100', null, null,
      1, null, 1, '021000000', 'emisor@example.com', null
    );
    $doc->addEmisorActividadEconomica(47190, 'Comercio al por menor');
  }

  /** Receptor contribuyente B2B (RUC ficticio 80012345-0). */
  public static function receptorContribuyente(DocumentoElectronico $doc, string $nombre = 'Cliente Receptor SA', bool $conDireccion = false, RecTiOpe $tipoOperacion = RecTiOpe::B2B): void
  {
    $doc->setReceptor(
      $nombre, true, $tipoOperacion, 'PRY', EmisRecTipCont::PersonaJuridica, '80012345', 0,
      null, null, null,
      $conDireccion ? 'Calle Entrega' : null, $conDireccion ? 123 : null, $conDireccion ? 1 : null, $conDireccion ? 1 : null, $conDireccion ? 1 : null,
      null, null, null, null
    );
  }

  /** Receptor no contribuyente B2C con cédula. */
  public static function receptorNoContribuyente(DocumentoElectronico $doc, int|TipIDRec $tipoId = TipIDRec::CedulaParaguaya, string $nro = '1234567'): void
  {
    $doc->setReceptor('Juan Perez', false, RecTiOpe::B2C, 'PRY', null, null, null, $tipoId, $nro,
      null, null, null, null, null, null, null, null, null, null);
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

  /** FE a crédito en dos cuotas, ítems exento y gravado 5 %, con o sin entrega inicial (E645). */
  public static function facturaCreditoCuotas(int $numDoc = 2, ?string $entregaInicial = null): Factura
  {
    $fe = new Factura(CamCondOpe::Credito);
    self::configurarBase($fe, $numDoc);
    self::receptorNoContribuyente($fe);
    $fe->setTipoDeTransaccion(OpeComTipTrans::MixtoMercaderiaServicios);
    $fe->setIndicadorPresencia(CamFEIndPres::Presencial);
    $fe->addItem('SRV001', 'Servicio exento', 77, '1', 0, '100000', null, CamIVAAfecIVA::Exento, '0', CamIVATasaIVA::ExentoExonerado);
    $fe->addItem('PROD005', 'Producto gravado 5%', 77, '3', 0, '21000', null, CamIVAAfecIVA::Gravado, '100', CamIVATasaIVA::IVA5);
    $fe->calcTotSub(0);
    $fe->setOperacionCreditoEnCuotas(['81500', '81500'], [new DateTime('2026-11-01'), new DateTime('2026-12-01')], $entregaInicial);
    if ($entregaInicial !== null) {
      // E605a (validación 1551): con entrega inicial (E645) hay que informar cómo se pagó (Fase C, C10).
      $fe->addPago(PaConEIniTiPago::Efectivo, $entregaInicial, 'PYG');
    }
    return $fe;
  }

  /** FE en moneda extranjera (USD por defecto) con tipo de cambio global. */
  public static function facturaUsd(int $numDoc = 3, string $moneda = 'USD'): Factura
  {
    $fe = new Factura(CamCondOpe::Contado);
    self::configurarBase($fe, $numDoc);
    self::receptorContribuyente($fe);
    $fe->setTipoDeTransaccion(OpeComTipTrans::VentaMercaderia);
    $fe->setIndicadorPresencia(CamFEIndPres::Electronica);
    $fe->setMoneda($moneda);
    $fe->setCondicionTipoDeCambio(OpeComCondTipCam::Global);
    $fe->setTipoDeCambio('7300');
    $fe->addItem('EXP001', 'Producto en moneda extranjera', 77, '2', 2, '150.50', null, CamIVAAfecIVA::Gravado, '100', CamIVATasaIVA::IVA10);
    $fe->calcTotSub(2);
    $fe->addPago(PaConEIniTiPago::Efectivo, $fe->gTotSub->getDTotGralOpe(), $moneda, '7300');
    return $fe;
  }

  public static function notaDeCredito(int $numDoc = 10, string $cdcAsociado = self::CDC_ASOCIADO): NotaDeCredito
  {
    $nc = new NotaDeCredito(MotEmi::Devolucion);
    self::configurarBase($nc, $numDoc);
    self::receptorContribuyente($nc);
    $nc->addItem('PROD001', 'Devolucion producto gravado 10%', 77, '1', 0, '55000', null, CamIVAAfecIVA::Gravado, '100', CamIVATasaIVA::IVA10);
    $nc->calcTotSub(0);
    $nc->addDocumentoElectronicoAsociado($cdcAsociado);
    return $nc;
  }

  public static function notaDeDebito(int $numDoc = 11, string $cdcAsociado = self::CDC_ASOCIADO): NotaDeDebito
  {
    $nd = new NotaDeDebito(MotEmi::AjusteDePrecio);
    self::configurarBase($nd, $numDoc);
    self::receptorContribuyente($nd);
    $nd->addItem('AJU001', 'Ajuste de precio', 77, '1', 0, '10000', null, CamIVAAfecIVA::Gravado, '100', CamIVATasaIVA::IVA10);
    $nd->calcTotSub(0);
    $nd->addDocumentoElectronicoAsociado($cdcAsociado);
    return $nd;
  }

  /**
   * NR con transporte terrestre propio. Con $completa = true informa dDomFisc y dDirChof (obligatorios
   * en el XSD de producción, DE_v150.xsd:973 y :986); con false reproduce el uso "mínimo" anterior.
   */
  public static function notaDeRemision(int $numDoc = 20, bool $completa = true, bool $vehiculoPorMatricula = false): NotaDeRemision
  {
    $nr = new NotaDeRemision(MotEmiNR::TrasladoPorVentas, RespEmiNR::EmisorFactura, GTranspTipTrans::Propio,
      GTranspModTrans::Terrestre, GTranspRespFlete::EmisorFactura, new DateTime('2026-01-16'));
    self::configurarBase($nr, $numDoc);
    self::receptorContribuyente($nr, 'Cliente Receptor SA', true); // D213 obligatorio en NRE
    $nr->setInfoDeInteresFiscal('Mercaderias sin cadena de frio ni carga peligrosa'); // B006
    $nr->setKilometrosRecorrido(25); // E505 (NT-010)
    $nr->setTransporteFechasTraslado(new DateTime('2026-01-16'), new DateTime('2026-01-17'));
    $nr->setTransporteLocalSalida('Av. Principal', 100, 1, 1, null, null, 1);
    $nr->addTransporteLocalEntrega('Calle Entrega', 123, 1, 1, null, null, 1);
    if ($vehiculoPorMatricula) {
      $nr->addTransporteVehiculo('Camion', 'Mercedes', 2, null, 'ABC123');
    } else {
      $nr->addTransporteVehiculo('Camion', 'Mercedes', 1, 'CHASIS00012345', null);
    }
    $nr->setTransporteTransportista(
      false, 'Transportista Juan', '4123456', 'Chofer Pedro Gomez', null, null, 1, '4123456', 'PRY',
      $completa ? 'Domicilio fiscal del transportista 123' : null,
      $completa ? 'Direccion del chofer 456' : null
    );
    $nr->addItem('PROD001', 'Producto a trasladar', 77, '10');
    $nr->addDocumentoElectronicoAsociado(self::CDC_ASOCIADO);
    return $nr;
  }

  /** Autofactura con $items ítems (5 × 20 000 y, si hay segundo, 1 × 30 000) y constancia de no contribuyente. */
  public static function autofactura(int $numDoc = 30, int $items = 2): Autofactura
  {
    $af = new Autofactura(CamCondOpe::Contado);
    self::configurarBase($af, $numDoc);
    // D206e: en AFE el receptor es el propio emisor; D202a: tipo de operación B2C
    $af->setReceptor('Empresa Emisora de Ejemplo SA', true, RecTiOpe::B2C, 'PRY', EmisRecTipCont::PersonaJuridica, self::RUC_EMISOR, self::DV_EMISOR,
      null, null, null, null, null, null, null, null, null, null, null, null);
    $af->setTipoDeTransaccion(OpeComTipTrans::CompraProductos);
    $af->setDatosVendedor(CamAENatVen::NoContribuyente, CamAETipIDVen::CedulaParaguaya, '1234567', 'Vendedor Prueba', 'Calle Vendedor', 100, 1, 1, 1);
    $af->setLugarTransaccion('Lugar de la transaccion', 1, 1, 1);
    $af->addItem('COMP001', 'Compra a no contribuyente 1', 77, '5', 0, '20000', null, null, null, null);
    if ($items >= 2) {
      $af->addItem('COMP002', 'Compra a no contribuyente 2', 77, '1', 0, '30000', null, null, null, null);
    }
    $af->calcTotSub(0);
    $af->addPago(PaConEIniTiPago::Efectivo, $af->gTotSub->getDTotGralOpe(), 'PYG');
    // Valores inventados con el formato de la constancia real (Q-B11): número de 11 dígitos y control de 8 caracteres.
    $af->addConstanciaDeNoSerContribuyente(12345678901, 'A1B2C3D4');
    return $af;
  }

  /** @return array<string, callable(Factura): mixed> Un builder por grupo de tgCamEsp (DE_v150.xsd:794-806). */
  public static function sectores(): array
  {
    return [
      'energía' => fn (Factura $fe) => $fe->setDatosComplementariosSectorEnergia('MED-001', 1, 'R', '100.00', '250.00', '150.00'),
      'seguros' => fn (Factura $fe) => $fe->addDatosComplementariosSectorSegurosPoliza('SEG01', 'POL-2026-001', 'Meses', '12', '0001234567', new DateTime('2026-01-01'), new DateTime('2026-12-31'), 'PROD001'),
      'supermercados' => fn (Factura $fe) => $fe->setDatosComplementariosSectorSupermercados('Cajero 1', '100000', '0', null, null),
      'datos adicionales' => fn (Factura $fe) => $fe->setDatosAdicionalesDeUsoComercial('202601', new DateTime('2026-01-01'), new DateTime('2026-01-31'), new DateTime('2026-02-15'), 'CONTR-0001', '0'),
    ];
  }

  /** FE con un grupo sectorial (clave de sectores()) y un ítem con gRasMerc (lote, vencimiento, serie y pedido). */
  public static function facturaSectorial(string $sector, int $numDoc = 60): Factura
  {
    $fe = new Factura(CamCondOpe::Contado);
    self::configurarBase($fe, $numDoc);
    self::receptorContribuyente($fe);
    $fe->setTipoDeTransaccion(OpeComTipTrans::VentaMercaderia);
    $fe->setIndicadorPresencia(CamFEIndPres::Presencial);
    $fe->addItem('MED001', 'Medicamento', 77, '1', 0, '5000', null, CamIVAAfecIVA::Gravado, '100', CamIVATasaIVA::IVA10,
      null, null, null, null, null, null, 'LOTE-2026-A', new DateTime('2027-06-30'), 'SERIE-001', 'PED-77');
    $fe->calcTotSub(0);
    $fe->addPago(PaConEIniTiPago::Efectivo, '5000', 'PYG');
    (self::sectores()[$sector])($fe);
    return $fe;
  }

  /** FE con los cuatro grupos de tgCamEsp a la vez (Q-B8: se emiten todos, en el orden del XSD). */
  public static function facturaConTodosLosSectores(int $numDoc = 61): Factura
  {
    $fe = self::facturaSectorial('energía', $numDoc);
    foreach (['seguros', 'supermercados', 'datos adicionales'] as $sector) {
      (self::sectores()[$sector])($fe);
    }
    return $fe;
  }

  /** Autofactura cuyo lugar de la transacción no informa distrito (cDisProv es 0-1 en tgCamAE, DE_v150.xsd:1351). */
  public static function autofacturaSinDistrito(): Autofactura
  {
    $af = self::autofactura(32, 1);
    $af->setLugarTransaccion('Lugar de la transaccion', 1, null, 1);
    return $af;
  }

  /**
   * FE con los grupos opcionales que no cubren los demás documentos (B12): responsable del DE (gRespDE), obligación
   * afectada (gOblAfe), compras públicas (gCompPub), vehículo nuevo vendido al consumidor final en un ítem (gVehNuevo),
   * pagos con tarjeta y con cheque (gPagTarCD, gPagCheq) y campos generales con los datos de la carga (gCamGen,
   * gCamCarg). Sin dCilin: su patrón en el XSD es el texto literal "/d" (DE_v150.xsd, tgVehNuevo).
   */
  public static function facturaConTodosLosOpcionales(int $numDoc = 70): Factura
  {
    $fe = new Factura(CamCondOpe::Contado);
    self::configurarBase($fe, $numDoc);
    // D202 = 3 (B2G): las compras públicas (E020) solo se admiten en B2G (validación 1401) y B2G exige los códigos DNCP
    // del ítem (E704/E705, validaciones 1800/1801). Hasta la Fase C (C11) el fixture era B2B y nunca se homologó.
    self::receptorContribuyente($fe, 'Cliente Receptor SA', false, RecTiOpe::B2G);
    $fe->setTipoDeTransaccion(OpeComTipTrans::VentaMercaderia);
    $fe->setIndicadorPresencia(CamFEIndPres::Presencial);
    $fe->setEmisorResponsableDelDE(TipIDRespDE::CedulaParaguaya, '1234567', 'Responsable de Prueba', 'Gerente');
    $fe->addObligacionAfectada(COblAfe::ImpuestoAlValorAgregadoGravadasYExoneradasExportadores);
    $fe->setDatosComprasPublicas('01', '00001', 26, 1234567, new DateTime('2026-01-02')); // dAnoCont: 2 dígitos (tdAnoCont)
    $vehiculo = (new GVehNuevo())->setITipOpVN(2)->setDChasis('9BWZZZ377VT004251')->setDColor('Blanco')
      ->setDPotencia(150)->setDCapMot(1600)->setDPNet('1200.5')->setDPBruto('1500.25')->setITipCom(1)->setDNroMotor('MOT-0001')
      ->setDCapTracc('1500.75')->setDAnoFab(2026)->setCTipVeh('SEDAN')->setDCapac(5); // medidas con decimales (Q-B12)
    $fe->addItem('VEH001', 'Automóvil nuevo', 77, '1', 0, '150000000', null, CamIVAAfecIVA::Gravado, '100', CamIVATasaIVA::IVA10,
      dncpCodigoGeneral: '12345678', dncpCodigoEspecifico: '1234', detalleVehiculoNuevo: $vehiculo);
    $fe->calcTotSub(0);
    $fe->addPagoPYGPorTarjeta(true, '100000000', PagTarCDDenTarj::Visa, PagTarCDForProPa::POS, 123456, 'Titular de Prueba', '1234');
    $fe->addPagoPYGPorCheque('50000000', '00012345', 'Banco de Prueba');
    $fe->setNroDeOrdenDeCompra('OC-0001');
    $fe->setNroDeOrdenDeVenta('OV-0001');
    $fe->setNroDeAsientoContable('AS-0001');
    $fe->gCamGen->setGCamCarg((new GCamCarg())->setCUniMedTotVol(110)->setDTotVolMerc(10)->setCUniMedTotPes(83)
      ->setDTotPesMerc(1500)->setICarCarga(1));
    return $fe;
  }

  /**
   * RDE sin firmar y determinista, para comparar serializaciones: código de seguridad y fecha de firma
   * fijos. El código por defecto no empieza con cero; el cero inicial (PK-26) se prueba pasándolo.
   */
  public static function rde(DocumentoElectronico $doc, string $codSeg = '123456789'): RDE
  {
    $doc->gOpeDE->setDCodSeg($codSeg);
    $rde = match (true) {
      $doc instanceof Autofactura => $doc->autofacturaToRDE(),
      $doc instanceof Factura => $doc->facturaToRDE(),
      $doc instanceof NotaDeCredito => $doc->notaDeCreditoToRDE(),
      $doc instanceof NotaDeDebito => $doc->notaDeDebitoToRDE(),
      $doc instanceof NotaDeRemision => $doc->notaDeRemisionToRDE(),
      default => $doc->documentoElectronicoToRDE(),
    };
    $rde->getDE()->setDFecFirma(new DateTime('2026-01-15T10:05:00', new DateTimeZone('America/Asuncion')));
    return $rde;
  }

  /** Firma un RDE con el entorno de prueba ya inicializado (SifenTestEnvironment::init()). */
  public static function firmar(RDE $rde): string
  {
    return Sifen::FirmarDE($rde, new DateTime('2026-01-15T10:05:00', new DateTimeZone('America/Asuncion')));
  }
}
