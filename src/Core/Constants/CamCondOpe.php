<?php

namespace IonysDev\Pkuatia\Core\Constants;

use Exception;

/**
 * Enumeración que contiene las condiciones posibles de operación de una factura o autofactura electrónica.
 * Estos valores corresponden al campo iCondOpe (E601), asi como a su descripción correspondiente del campo dDCondOpe (E602) 
 * del grupo gCamCond (E600).
 */
enum CamCondOpe: int {

    case Contado = 1;
    case Credito = 2;

    public static function getDescripcion(int $value): string {
        switch($value) {
            case 1:
                return 'Contado';
            case 2:
                return 'Crédito';
            default:
                throw new Exception("[CamCondOpe] Condición de operación inválida: $value");
        }
    }
}

?>