<?php

namespace IonysDev\Pkuatia\Core;


/**
 * Clase que contiene los valores constantes utilizados en el paquete.
 */
class Constants
{  
    // Versiones
    const PKUATIA_VERSION = "0.1.0";
    const SIFEN_VERSION = "150";

    // Namespaces
    const RSA_SHA256 = "http://www.w3.org/2001/04/xmldsig-more#rsa-sha256";
    const SIFEN_NS_XSI = "http://www.w3.org/2001/XMLSchema-instance";
    const SIFEN_NS_URI = "http://ekuatia.set.gov.py/sifen/xsd";
    const SIFEN_NS_URI_RECEP_DE = self::SIFEN_NS_URI . " siRecepDE_v150.xsd";
    const SIFEN_NS_URI_RECEP_EVENTO = self::SIFEN_NS_URI . " siRecepEvento_v150.xsd";

    // URLs Base
    const SIFEN_URL_BASE_DEV = "https://sifen-test.set.gov.py";
    const SIFEN_URL_BASE_PROD = "https://sifen.set.gov.py";
    const SIFEN_URL_CONSULTA_QR_DEV = "https://ekuatia.set.gov.py/consultas-test/qr?";
    const SIFEN_URL_CONSULTA_QR_PROD = "https://ekuatia.set.gov.py/consultas/qr?";

    // Paths de los WSDL. OJO: algunos manuales/documentos publican rutas distintas (recepcion.wsdl,
    // recepcion-lote.wsdl, etc.); las rutas vigentes fueron verificadas empíricamente contra
    // sifen-test.set.gov.py en junio/2026 y son las siguientes.
    const SIFEN_PATH_RECIBE = "/de/ws/sync/recibe.wsdl";                             // siRecepDE
    const SIFEN_PATH_RECIBE_LOTE = "/de/ws/async/recibe-lote.wsdl";                  // siRecepLoteDE
    const SIFEN_PATH_EVENTO = "/de/ws/eventos/evento.wsdl";                          // siRecepEvento
    const SIFEN_PATH_CONSULTA_LOTE = "/de/ws/consultas/consulta-lote.wsdl";          // siResultLoteDE
    const SIFEN_PATH_CONSULTA_RUC = "/de/ws/consultas/consulta-ruc.wsdl";            // siConsRUC
    const SIFEN_PATH_CONSULTA = "/de/ws/consultas/consulta.wsdl";                    // siConsDE
    const SIFEN_PATH_CONSULTA_ARCHIVO_RUC = "/de/ws/consultas/consulta-archivo-ruc.wsdl"; // siConsArchivoRUC (NT-011, ruta pendiente de confirmación)

    //Tipos de transacciones
    public const TIPO_TRANSACCION_VENTA_MERCADERIA = 1;
    public const TIPO_TRANSACCION_PRESTACION_SERVICIOS = 2;
    public const TIPO_TRANSACCION_MIXTO = 3;
    public const TIPO_TRANSACCION_VENTA_ACTIVO_FIJO = 4;
    public const TIPO_TRANSACCION_VENTA_DIVISAS = 5;
    public const TIPO_TRANSACCION_COMPRA_DIVISAS = 6;
    public const TIPO_TRANSACCION_OTROS = 7;
    public const TIPO_TRANSACCION_DONACION = 8;
    public const TIPO_TRANSACCION_ANTICIPO = 9;
    public const TIPO_TRANSACCION_COMPRA_PRODUCTOS = 10;
    public const TIPO_TRANSACCION_COMPRA_SERVICIOS = 11;
    public const TIPO_TRANSACCION_CREDITO_FISCAL = 12;
    public const TIPO_TRANSACCION_MUESTRA_MEDICA = 13;

    //Tipos de IMPUESTOS
    public const TIPO_IMPUESTO_IVA = 1;
    public const TIPO_IMPUESTO_ISC = 2;
    public const TIPO_IMPUESTO_RENTA = 3;
    public const TIPO_IMPUESTO_NINGUNO = 4;
    public const TIPO_IMPUESTO_IVA_RENTA = 5;

    //Tipos de monedas
    public const MONEDA_BASE = "PYG";

    //TIPO OPERACION
    public const TIPO_OPERACION_B2G = 3;

    ///Condiciones operacion
    public const CONDICION_OPERACION_CONTADO = 1;
    public const CONDICION_OPERACION_CREDITO = 2;

    //tipo de pagos
    public const PAGO_EFECTIVO = 1;
    public const PAGO_CHEQUE = 2;
    public const PAGO_TARJETA_CREDITO = 3;
    public const PAGO_TARJETA_DEBITO = 4;

    //MODALIDAD TRASNPORTE
    public const TRANSPORTE_TERRESTRE = 1;

    // Valor Máximo del DID
    public const MAX_DID = 999999999999999;
    public const MAX_DOCUMENTOS_ELECTRONICOS_POR_LOTE = 50;

    // Cantidad máxima de eventos (rGesEve) por transmisión a siRecepEvento (Evento_v150.xsd)
    public const MAX_EVENTOS_POR_TRANSMISION = 15;

    // Umbral NT-024 (vigente desde 01/01/2025): el receptor innominado (D208 = 5) no está
    // permitido cuando el total general de la operación en guaraníes es >= a este monto.
    public const UMBRAL_INNOMINADO_PYG = '7000000';

    
}