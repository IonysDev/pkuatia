<?php

namespace IonysDev\Pkuatia\Core\Constants;

use Exception;

/**
 * Enumeración que contiene las modalidades de transporte que se pueden informar en los campos que describen el transporte de las mercaderías.
 * Estos valores corresponden al campo iModTrans (E903), asi como a su descripción correspondiente del campo dDesModTrans (E904) 
 * del grupo gTransp (E900).
 */
enum GTranspModTrans: int {

    case Terrestre = 1;
    case Fluvial = 2;
    case Aereo = 3;
    case Multimodal = 4;
    
    public static function getDescripcion(int $value): string {
        switch($value) {
            case 1:
                return 'Terrestre';
            case 2:
                return 'Fluvial';
            case 3:
                return 'Aéreo';
            case 4:
                return 'Multimodal';
            default:
                throw new Exception("[GTranspModTrans] Tipo de modalidad de transporte inválida: $value");
        }
    }
}

?>