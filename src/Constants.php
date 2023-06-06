<?php

namespace Abiliomp\Pkuatia;


/**
 * Clase que contiene los valores constantes utilizados en el paquete.
 */
class Constants
{  
    // Versiones
    const PKUATIA_VERSION = "0.2.0";
    const SIFEN_VERSION = "150";

    // Namespaces
    const RSA_SHA256 = "http://www.w3.org/2001/04/xmldsig-more#rsa-sha256";
    const SIFEN_NS_URI = "http://ekuatia.set.gov.py/sifen/xsd";
    const SIFEN_NS_URI_RECEP_DE = self::SIFEN_NS_URI + " siRecepDE_v150.xsd";
    const SIFEN_NS_URI_RECEP_EVENTO = self::SIFEN_NS_URI + " siRecepEvento_v150.xsd";

    // URLs Base
    const SIFEN_URL_BASE_DEV = "https://sifen-test.set.gov.py";
    const SIFEN_URL_BASE_PROD = "https://sifen.set.gov.py";
    const SIFEN_URL_CONSULTA_QR_DEV = "https://ekuatia.set.gov.py/consultas-test/qr?";
    const SIFEN_URL_CONSULTA_QR_PROD = "https://ekuatia.set.gov.py/consultas/qr?";

    // Paths
    const SIFEN_PATH_RECIBE = "/de/ws/sync/recibe.wsdl";
    const SIFEN_PATH_RECIBE_LOTE = "/de/ws/async/recibe-lote.wsdl";
    const SIFEN_PATH_EVENTO = "/de/ws/eventos/evento.wsdl";
    const SIFEN_PATH_CONSULTA_LOTE = "/de/ws/consultas/consulta-lote.wsdl";
    const SIFEN_PATH_CONSULTA_RUC = "/de/ws/consultas/consulta-ruc.wsdl";
    const SIFEN_PATH_CONSULTA = "/de/ws/consultas/consulta.wsdl";

    // Tipos de Documentos
    const TIPO_DOCUMENTO_FACTURA = 1;
    const TIPO_DOCUMENTO_FACTURA_EXPORTACION = 2;
    const TIPO_DOCUMENTO_FACTURA_IMPORTACION = 3;
    const TIPO_DOCUMENTO_AUTOFACTURA = 4;
    const TIPO_DOCUMENTO_NOTA_CREDITO = 5;
    const TIPO_DOCUMENTO_NOTA_DEBITO = 6;
    const TIPO_DOCUMENTO_COMPROBANTE_RETENCION = 7;

    //Tipos de contribuyentes
    const TIPO_CONTRIBUYENTE_PERSONA_FISICA = 1;
    const TIPO_CONTRIBUYENTE_PERSONA_JURIDICA = 2;

    //Tipos de emisión
    CONST TIPO_EMISION_NORMAL = 1;
    CONST TIPO_EMISION_CONTINGENCIA = 2;

    
}