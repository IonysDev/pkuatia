<?php

namespace IonysDev\Pkuatia\Core\Constants;

use Exception;

/**
 * Enumeración que contiene los tipos de transporte que se pueden informar en los campos que describen el transporte de las mercaderías.
 * Estos valores corresponden al campo iTipTrans (E901), asi como a su descripción correspondiente del campo dDesTipTrans (E902) 
 * del grupo gTransp (E900).
 */
enum GTranspTipTrans: int {

    case Propio = 1;
    case Tercero = 2;
    
    public static function getDescripcion(int $value): string {
        switch($value) {
            case 1:
                return 'Propio';
            case 2:
                return 'Tercero';
            default:
                throw new Exception("[GTranspTipTrans] Tipo de transporte inválida: $value");
        }
    }
}

?>