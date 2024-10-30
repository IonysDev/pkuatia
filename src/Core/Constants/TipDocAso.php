<?php

namespace Abiliomp\Pkuatia\Core\Constants;

use Exception;

/**
 * Enumeración que contiene los tipos de documentos asociacios del campo H002.
 */
enum TipDocAso: int {

    case Electronico = 1;
    case Impreso = 2;
    case ConstanciaElectronica = 3;

    public static function getDescripcion(int $tipDocAso): string {
        switch($tipDocAso) {
            case 1:
                return 'Electrónico';
            case 2:
                return 'Impreso';
            case 3:
                return 'Constancia Electrónica';
            default:
                throw new Exception("[TipDocAso] Tipo de documento asociado equivocado: $tipDocAso");
        }
    }
}