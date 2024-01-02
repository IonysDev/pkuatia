<?php

namespace Abiliomp\Pkuatia\Core\Constants;

use Exception;

/**
 * Enumeración que contiene los tipos de afectación tributaria de los ítems valorizados.
 * No debe informarse para aquellos items que formen parte de notas de remsión (utilizar ítems no valorizados NoValueItem).
 * Tampoco debe informarse cuando el tipo de impuesto afectado sea el ISC (D013=2).
 * Estos valores corresponden al campo iAfecIVA (E731), asi como a su descripción correspondiente del campo dDesAfecIVA (E732) 
 * del grupo gCamIVA (E730).
 */
enum CamIVAAfecIVA: int {

    case Gravado = 1;
    case Exonerado = 2;
    case Exento = 3;
    case GravadoParcial = 4;
    
    public static function getDescripcion(int $value): string {
        switch($value) {
            case 1:
                return 'Gravado IVA';
            case 2:
                return 'Exonerado (Art. 83- Ley 125/91)';
            case 3:
                return 'Exento';
            case 4:
                return 'Gravado parcial (Grav-Exento)';
            default:
                throw new Exception("[CamIVAAfecIVA] Tipo de afectación tributaria inválida: $value");
        }
    }
}

?>