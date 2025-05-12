<?php

namespace IonysDev\Pkuatia\Core\Constants;

use Exception;

/**
 * Enumeración que contiene los códigos de respuesta del WS de envío de lotes de comprobantes electrónicos.
 * Estos valores corresponden al campo dCodRes (BRSch03), asi como a su descripción correspondiente del campo dMsgRes (BRSch04) del grupo rResEnviLoteDe (BRSch01).
 */
enum ResEnviLoteDeCodRes: int {

    case EntradaSuperiorA100000KB = 270;
    case LoteRecibidoConExito = 300;
    case LoteNoEncolado = 301;

    public static function getDescripcion(int $value): string {
        switch($value) {
            case 270:
                return 'Mensaje de datos de entrada del WS de envío de lotes de comprobantes electrónicos superior a 10.000 KB.';
            case 300:
                return 'Lote recibido con éxito';
            case 301:
                return 'Lote no encolado para procesamiento';
            default:
                throw new Exception("[ResEnviLoteDeCodRes] Código de respuesta inválido: $value");
        }
    }
}

?>