<?php

namespace IonysDev\Pkuatia\Core\Constants;

use Exception;

/**
 * Enumeración que contiene los códigos de respuesta del WS de consulta de comprobantes electrónicos.
 * Estos valores corresponden al campo dCodRes (DRSch03), asi como a su descripción correspondiente del campo dMsgRes (DRSch04) del grupo rResEnviConsDe  (DRSch01).
 */
enum ResEnviConsDeCodRes: int {

    case CDCInexistente = 420;
    case RUCSinPermiso = 421;
    case CDCEncontrado = 422;

    public static function getDescripcion(int $value): string {
        switch($value) {
            case 420:
                return 'Comprobante electrónico inexistente';
            case 421:
                return 'RUC sin permiso para consulta';
            case 422:
                return 'Comprobante electrónico encontrado';
            default:
                throw new Exception("[ResEnviConsDeCodRes] Código de respuesta inválido: $value");
        }
    }
}

?>