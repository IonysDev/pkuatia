<?php

namespace IonysDev\Pkuatia\Core\Constants;

use Exception;

/**
 * Enumeración que contiene los tipos de identificación del responsable por la generación del documento electrónico.
 * Estos valores corresponden al campo iTipIDRespDE (D141), asi como a su descripción correspondiente del campo dDTipIDRespDE (D142) 
 * del grupo gRespDE (D140).
 */
enum TipIDRespDE: int {

    case CedulaParaguaya = 1;
    case Pasaporte = 2;
    case CedulaExtranjera = 3;
    case CarnetDeResidencia = 4;
    case Otro = 9;

    public static function getDescripcion(int $tipImp): string {
        switch($tipImp) {
            case 1:
                return 'Cédula paraguaya';
            case 2:
                return 'Pasaporte';
            case 3:
                return 'Cédula extranjera';
            case 4:
                return 'Carnet de residencia';
            case 9:
                return 'Otro';
            default:
                throw new Exception("[TipIDRespDE] Tipo de identificación inválida: $tipImp");
        }
    }
}