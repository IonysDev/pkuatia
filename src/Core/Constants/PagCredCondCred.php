<?php

namespace IonysDev\Pkuatia\Core\Constants;

use Exception;

/**
 * Enumeración que contiene las condiciones de operación a crédito con facturas y autofacturas electrónicas.
 * Estos valores corresponden al campo iCondCred (E641), asi como a su descripción correspondiente del campo dDCondCred (E642) 
 * del grupo gPagCred (E640).
 */
enum PagCredCondCred: int {

    case Plazo = 1;
    case Cuota = 2;

    public static function getDescripcion(int $value): string {
        switch($value) {
            case 1:
                return 'Plazo';
            case 2:
                return 'Cuota';
            default:
                throw new Exception("[CamCondOpe] Condición de operación a crédito inválida: $value");
        }
    }
}

?>