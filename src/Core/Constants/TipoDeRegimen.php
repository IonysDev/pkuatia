<?php

namespace Abiliomp\Pkuatia\Core\Constants;

use Exception;

/**
 * Enumeración que contiene los tipos de regímenes tributarios según la Tabla 1 del manual técnico del SIFEN.
 */
enum TipoDeRegimen: int {

    case Turismo = 1;
    case Importador = 2;
    case Exportador = 3;
    case Maquila = 4;
    case Ley6090 = 5;
    case PequenoProductor = 6;
    case MedianoProductor = 7;
    case Contable = 8;

    public function __toString(): string {
        return self::getDescripcion($this->value);
    }

    public static function getDescripcion(int $tipImp): string {
        switch($tipImp) {
            case 1:
                return 'Régimen de Turismo';
            case 2:
                return 'Importador';
            case 3:
                return 'Exportador';
            case 4:
                return 'Maquila';
            case 5:
                return 'Ley N° 60/90';
            case 5:
                return 'Régimen del Pequeño Productor';
            case 7:
                return 'Régimen del Mediano Productor';
            case 8:
                return 'Régimen Contable';
            default:
                throw new Exception("[TipoDeRegimen] Tipo de régimen equivocado: $tipImp");
        }
    }
}