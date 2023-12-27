<?php

namespace Abiliomp\Pkuatia\Core\Constants;

use Exception;

/**
 * Enumeración que contiene los códigos de datos de relevancia de las mercaderías de un ítem.
 * Estos valores corresponden al campo cRelMerc (E715), asi como a su descripción correspondiente del campo dDesRelMerc (E716) 
 * del grupo gCamItem (E700).
 */
enum CamItemRelMerc: int {

    case ToleranciaQuiebra = 1;
    case ToleranciaMerma = 2;

    public function __toString(): string {
        return self::getDescripcion($this->value);
    }

    public static function getDescripcion(int $value): string {
        switch($value) {
            case 1:
                return 'Tolerancia de quiebra';
            case 2:
                return 'Tolerancia de merma';
            default:
                throw new Exception("[CamItemRelMerc] Condición de anticipo inválida: $value");
        }
    }
}

?>