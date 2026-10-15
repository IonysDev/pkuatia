<?php

// Qué método público de PKuatia informa cada campo del Manual Técnico (ID del MT → método). Mantenido a mano
// (Fase C, paso C5); lo usan CatalogoValidaciones::metodoPkuatia() y los errores del validador como sugerencia.
// Cuando un campo lo cargan varios métodos se listan separados por " / ". Las variantes con letra (D208c) se
// resuelven por el ID base (D208).

$m = [
  // B. Operación del DE
  'B002' => 'setTipoEmisionDocumento()',
  'B005' => 'setInformacionDeInteresEmisor()',
  'B006' => 'setInfoDeInteresFiscal()',
  // C. Timbrado
  'C002' => 'el tipo de documento lo fija la clase (Factura, Autofactura, NotaDeCredito, NotaDeDebito, NotaDeRemision)',
  'C004' => 'setTimbrado() / setNumeroDeTimbrado()',
  'C005' => 'setTimbrado() / setNumeroEstablecimiento()',
  'C006' => 'setTimbrado() / setNumeroPuntoExpedicion()',
  'C007' => 'setTimbrado() / setNumeroDocumento()',
  'C008' => 'setTimbrado() / setFechaInicioTimbrado()',
  'C010' => 'setTimbrado() / setSerieNumeroTimbrado()',
  // D. Datos generales, operación comercial, emisor
  'D002' => 'setFechaEmision()',
  'D011' => 'setTipoDeTransaccion()',
  'D013' => 'setTipoDeImpuestoAfectado()',
  'D015' => 'setMoneda()',
  'D017' => 'setCondicionTipoDeCambio()',
  'D018' => 'setTipoDeCambio()',
  'D019' => 'setCondicionDeAnticipo()',
  'D030' => 'addObligacionAfectada()',
  'D031' => 'addObligacionAfectada()',
  'D032' => 'addObligacionAfectada()',
  'D101' => 'setEmisor() / setEmisorRUC()',
  'D102' => 'setEmisor() / setEmisorRUC()',
  'D103' => 'setEmisor() / setEmisorTipoContribuyente()',
  'D104' => 'setEmisorTipoRegimen()',
  'D105' => 'setEmisor() / setEmisorNombre()',
  'D106' => 'setEmisorNombreFantasia()',
  'D107' => 'setEmisor() / setEmisorDireccionLocal()',
  'D108' => 'setEmisor() / setEmisorNumCasa()',
  'D109' => 'setEmisorCalleSecundaria()',
  'D110' => 'setEmisorComplementoDireccion()',
  'D111' => 'setEmisor() / setEmisorCodigoDepartamento()',
  'D113' => 'setEmisorCodigoDistrito()',
  'D115' => 'setEmisor() / setEmisorCodigoCiudad()',
  'D117' => 'setEmisor() / setEmisorTelefono()',
  'D118' => 'setEmisor() / setEmisorEmail()',
  'D119' => 'setEmisorDenominacionSucursal()',
  'D130' => 'addEmisorActividadEconomica()',
  'D131' => 'addEmisorActividadEconomica()',
  'D132' => 'addEmisorActividadEconomica()',
  'D140' => 'setEmisorResponsableDelDE()',
  // E. Campos por tipo de documento
  'E011' => 'Factura::setIndicadorPresencia()',
  'E013' => 'Factura::setFechaDeRemision()',
  'E020' => 'Factura::setDatosComprasPublicas()',
  'E301' => 'Autofactura::setDatosVendedor() / setNaturalezaVendedor()',
  'E304' => 'Autofactura::setDatosVendedor() / setTipoDocumentoIdentidadVendedor()',
  'E306' => 'Autofactura::setDatosVendedor() / setNumeroDocumentoVendedor()',
  'E307' => 'Autofactura::setDatosVendedor() / setNombreCompletoVendedor()',
  'E308' => 'Autofactura::setDatosVendedor() / setDireccionVendedor()',
  'E309' => 'Autofactura::setDatosVendedor() / setDireccionVendedor()',
  'E310' => 'Autofactura::setDatosVendedor() / setDepartamentoVendedor()',
  'E312' => 'Autofactura::setDistritoVendedor()',
  'E314' => 'Autofactura::setDatosVendedor() / setCiudadVendedor()',
  'E316' => 'Autofactura::setLugarTransaccion() / setDireccionLugarTransaccion()',
  'E317' => 'Autofactura::setLugarTransaccion() / setDepartamentoLugarTransaccion()',
  'E319' => 'Autofactura::setDistritoLugarTransaccion()',
  'E321' => 'Autofactura::setLugarTransaccion() / setCiudadLugarTransaccion()',
  'E401' => 'NotaDeCredito::setMotivoEmision() / NotaDeDebito::setMotivoEmision()',
  'E501' => 'NotaDeRemision::setMotivoEmision()',
  'E502' => 'NotaDeRemision::setDescripcionMotivoEmision()',
  'E503' => 'NotaDeRemision::setResponsableEmision()',
  'E505' => 'NotaDeRemision::setKilometrosRecorrido()',
  'E506' => 'NotaDeRemision::setFechaFuturaEmisionFactura()',
  'E601' => 'addPago() (contado) / setOperacionCreditoAPlazo() / setOperacionCreditoEnCuotas() (crédito)',
  'E605' => 'addPago() / addPagoPYGPorTarjeta() / addPagoPorCheque()',
  'E606' => 'addPago() / addPagoPYGPorTarjeta() / addPagoPorCheque()',
  'E608' => 'addPago()',
  'E609' => 'addPago()',
  'E611' => 'addPago()',
  'E620' => 'addPagoPYGPorTarjeta()',
  'E630' => 'addPagoPorCheque() / addPagoPYGPorCheque() / addPagoUSDPorCheque()',
  'E640' => 'setOperacionCreditoAPlazo() / setOperacionCreditoEnCuotas()',
  'E641' => 'setOperacionCreditoAPlazo() / setOperacionCreditoEnCuotas()',
  'E643' => 'setOperacionCreditoAPlazo()',
  'E644' => 'setOperacionCreditoEnCuotas()',
  'E645' => 'setOperacionCreditoEnCuotas()',
  'E650' => 'setOperacionCreditoEnCuotas()',
  'E791' => 'setDatosComplementariosSectorEnergia() / addDatosComplementariosSectorEnergia()',
  'E800' => 'addDatosComplementariosSectorSegurosPoliza()',
  'E810' => 'setDatosComplementariosSectorSupermercados()',
  'E820' => 'setDatosAdicionalesDeUsoComercial() / addVencimientoDePagoDeUsoComercial()',
  'E900' => 'setTransporte()',
  'E905' => 'setTransporteIncoterm()',
  'E907' => 'setTransporteNumeroManifiesto()',
  'E908' => 'setTransporteNumeroDespachoImportacion()',
  'E909' => 'setTransporteFechasTraslado()',
  'E910' => 'setTransporteFechasTraslado()',
  'E911' => 'setTransportePaisDestino()',
  'E920' => 'setTransporteLocalSalida()',
  'E940' => 'addTransporteLocalEntrega()',
  'E960' => 'addTransporteVehiculo()',
  'E980' => 'setTransporteTransportista() / setTransporteAgente()',
  // G. Uso general
  'G002' => 'setNroDeOrdenDeCompra()',
  'G003' => 'setNroDeOrdenDeVenta()',
  'G004' => 'setNroDeAsientoContable()',
  // H. Documento asociado
  'H001' => 'addDocumentoElectronicoAsociado() / addDocumentoImpresoAsociado() / addConstanciaDeNoSerContribuyente()',
  'H002' => 'addDocumentoElectronicoAsociado() / addDocumentoImpresoAsociado() / addConstanciaDeNoSerContribuyente()',
  'H004' => 'addDocumentoElectronicoAsociado()',
  'H014' => 'addConstanciaDeNoSerContribuyente()',
  'H016' => 'addConstanciaDeNoSerContribuyente()',
  'H017' => 'addConstanciaDeNoSerContribuyente()',
  // J. Fuera de la firma
  'J003' => 'Sifen::FirmarDE($rde, $fecha, $infoAdicionalEmisor)',
];

// Receptor (D200-D224): todo por setReceptor().
foreach (range(200, 224) as $n)
  $m["D$n"] = 'setReceptor()';
// Responsable de la generación (D141-D145).
foreach (range(141, 145) as $n)
  $m["D$n"] = 'setEmisorResponsableDelDE()';
// Ítems (E700-E737, EA001-EA009) y vehículo nuevo (E770-E786): addItem().
foreach (range(700, 737) as $n)
  $m["E$n"] = 'addItem()';
foreach (range(1, 9) as $n)
  $m['EA00' . $n] = 'addItem()';
foreach (range(770, 786) as $n)
  $m["E$n"] = 'addItem() (parámetro $detalleVehiculoNuevo) / setDetalleVehiculoNuevo()';
// Documento impreso asociado (H005-H011).
foreach (range(5, 11) as $n)
  $m['H0' . str_pad((string) $n, 2, '0', STR_PAD_LEFT)] = 'addDocumentoImpresoAsociado()';
// Totales (F001-F037): calcTotSub().
foreach (range(1, 37) as $n)
  $m['F0' . str_pad((string) $n, 2, '0', STR_PAD_LEFT)] = 'calcTotSub()';
// Transporte: vehículo (E961-E967), salida (E921-E930), entrega (E941-E950), transportista (E981-E993).
foreach (range(961, 967) as $n)
  $m["E$n"] = 'addTransporteVehiculo()';
foreach (range(921, 930) as $n)
  $m["E$n"] = 'setTransporteLocalSalida()';
foreach (range(941, 950) as $n)
  $m["E$n"] = 'addTransporteLocalEntrega()';
foreach (range(981, 993) as $n)
  $m["E$n"] = 'setTransporteTransportista() / setTransporteAgente()';

return $m;
