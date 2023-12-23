<?php

namespace Abiliomp\Pkuatia\Core\Constants;

use Exception;

/**
 * Enumeración que contiene los indicadores de presencia para la emisión de una factura electrónica.
 * Estos valores corresponden al campo iIndPres (E011), asi como a su descripción correspondiente del campo dDesIndPres (E012) 
 * del grupo gCamFE (E010).
 */
enum CamFEIndPres: int {

    case Presencial = 1;
    case Electronica = 2;
    case Telemarketing = 3;
    case ADomicilio = 4;
    case Bancaria = 5;
    case CiclicaOSuscripcion = 6;
    case Otro = 9;

    public function __toString(): string {
        return self::getDescripcion($this->value);
    }

    public static function getDescripcion(int $value): string {
        switch($value) {
            case 1:
                return 'Operación presencial';
            case 2:
                return 'Operación electrónica';
            case 3:
                return 'Operación telemarketing';
            case 4:
                return 'Venta a domicilio';
            case 5:
                return 'Operación bancaria';
            case 6:
                return 'Operación cíclica';
            case 9:
                return 'Otro';
            default:
                throw new Exception("[CamFEIndPres] Indicador de presencia inválido: $value");
        }
    }
}