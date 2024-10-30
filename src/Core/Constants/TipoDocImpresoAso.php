<?php

namespace Abiliomp\Pkuatia\Core\Constants;

use Exception;

/**
 * Enumeración que contiene los tipos de documentos impresos asociados del campo H009.
 */
enum TipoDocImpresoAso: int {

    case Factura = 1;
    case NotaDeCredito = 2;
    case NotaDeDebito = 3;
    case NotaDeRemision = 4;
    case ComprobanteRetencion = 5;

    public static function getDescripcion(int $tipDocImpresoAso): string {
        switch($tipDocImpresoAso) {
            case 1:
                return 'Factura';
            case 2:
                return 'Nota de crédito';
            case 3:
                return 'Nota de débito';
            case 4:
                return 'Nota de remisión';
            case 5:
                return 'Comprobante de retención';
            default:
                throw new Exception("[TipoDocImpresoAso] Tipo de documento impreso erróneo: $tipDocImpresoAso");
        }
    }
}