<?php

namespace IonysDev\Pkuatia\Core\Constants;

use Exception;

/**
 * Enumeración que contiene los tipos de identificación del receptor del documento electrónico.
 * Estos valores corresponden al campo iTipIDRec (D208), asi como a su descripción correspondiente del campo dDTipIDRec (D209) 
 * del grupo gDatRec (D200).
 */
enum TipIDRec: int {

    case CedulaParaguaya = 1;
    case Pasaporte = 2;
    case CedulaExtranjera = 3;
    case CarnetDeResidencia = 4;
    case Innominado = 5;
    case TajetaDiplomatica = 6;
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
            case 5:
                return 'Innominado';
            case 6:
                return 'Tarjeta Diplomática de exoneración fiscal';
            case 9:
                return 'Otro';
            default:
                throw new Exception("[TipIDRespDE] Tipo de identificación inválida: $tipImp");
        }
    }
}