<?php

namespace IonysDev\Pkuatia\Core\Constants;

use Exception;

/**
 * Enumeración que contiene los tipos de documentos electrónicos soportados por Sifen.
 * Estos valores corresponden al campo iTiDE (C002), asi como a su descripción correspondiente del campo dDesTiDE (C003) 
 * del grupo gTimb (C001).
 */
enum TimbTiDE: int {

    case Factura = 1;
    case FacturaExportacion = 2;
    case FacturaImportacion = 3;
    case Autofactura = 4;
    case NotaCredito = 5;
    case NotaDebito = 6;
    case NotaRemision = 7;
    case ComprobanteRetencion = 8;

    public static function getDescripcion(int $tipoDE): string {
        switch ($tipoDE) {
            case 1:
                return 'Factura electrónica';
            case 2:
                return 'Factura electrónica de exportación';
            case 3:
                return 'Factura electrónica de importación';
            case 4:
                return 'Autofactura electrónica';
            case 5:
                return 'Nota de crédito electrónica';
            case 6:
                return 'Nota de débito electrónica';
            case 7:
                return 'Nota de remisión electrónica';
            case 8:
                return 'Comprobante de retención electrónico';
            default:
                throw new Exception('[TimbTiDE] Tipo de documento electrónico inválido: ' . $tipoDE);
        }
    }
}

?>