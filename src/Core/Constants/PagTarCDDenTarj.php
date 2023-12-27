<?php

namespace Abiliomp\Pkuatia\Core\Constants;

use Exception;

/**
 * Enumeración que contiene las denominaciones de tarjetas de crédito y débito soportados por el Sifen.
 * Estos valores corresponden al campo iDenTarj (CE621002), asi como a su descripción correspondiente del campo dDesDenTarj (E622) 
 * del grupo gPagTarCD (E620).
 */
enum PagTarCDDenTarj: int {

    case Visa = 1;
    case Mastercard = 2;
    case AmericanExpress = 3;
    case Maestro = 4;
    case Panal = 5;
    case Cabal = 6;
    case Otro = 99;

    public function __toString(): string {
        return self::getDescripcion($this->value);
    }

    public static function getDescripcion(int $tipoDE): string {
        switch ($tipoDE) {
            case 1:
                return 'Visa';
            case 2:
                return 'Mastercard';
            case 3:
                return 'American Express';
            case 4:
                return 'Maestro';
            case 5:
                return 'Panal';
            case 6:
                return 'Cabal';
            case 99:
                return 'Otro';
            default:
                throw new Exception('[PagTarCDDenTarj] Denominación de tarjeta inválida: ' . $tipoDE);
        }
    }
}

?>