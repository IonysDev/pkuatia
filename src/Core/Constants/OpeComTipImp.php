<?php

namespace IonysDev\Pkuatia\Core\Constants;

use Exception;

/**
 * Enumeración que contiene los tipos de impuestos de una operación comercial para los campos
 * iTipTra (D013) y dDesTipTra (D014) del grupo gOpeCom (D010).
 */
enum OpeComTipImp: int {

    case IVA = 1;
    case ISC = 2;
    case Renta = 3;
    case Ninguno = 4;
    case IVARenta = 5;

    public static function getDescripcion(int $tipImp): string {
        switch($tipImp) {
            case 1:
                return 'IVA';
            case 2:
                return 'ISC';
            case 3:
                return 'Renta';
            case 4:
                return 'Ninguno';
            case 5:
                return 'IVA - Renta';
            default:
                throw new Exception("Tipo de impuesto equivocado: $tipImp");
        }
    }
}

?>