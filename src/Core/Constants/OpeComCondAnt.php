<?php

namespace Abiliomp\Pkuatia\Core\Constants;

use Exception;

/**
 * Enumeración que contiene las condiciones posibles de anticipo de una operación comercial.
 * Estos valores corresponden al campo iCondAnt (D019), asi como a su descripción correspondiente del campo dDesCondAnt (D20) 
 * del grupo gOpeCom (D010).
 */
enum OpeComCondAnt: int {

    case AnticipoGlobal = 1;
    case AnticipoPorItem = 2;

    public function __toString(): string {
        return self::getDescripcion($this->value);
    }

    public static function getDescripcion(int $value): string {
        switch($value) {
            case 1:
                return 'Anticipo Global';
            case 2:
                return 'Anticipo por Ítem';
            default:
                throw new Exception("[OpeComCondAnt] Condición de anticipo inválida: $value");
        }
    }
}

?>