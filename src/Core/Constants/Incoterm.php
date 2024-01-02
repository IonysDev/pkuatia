<?php


namespace Abiliomp\Pkuatia\Core\Constants;

use Exception;

/**
 * Enumeración relacionada a la tabla 10 del MT (v150) que lista los INCOTERMS soportados por el Sifen.
 */
enum Incoterm: String {
    /**
     * Costo y flete
     */
    case CFR = "CFR";
    /**
     * Costo, seguro y flete
     */
    case CIF = "CIF";
    /**
     * Transporte y seguro pagados hasta
     */
    case CIP = "CIP";
    /**
     * Transporte pagado hasta
     */
    case CPT = "CPT";
    /**
     * Entregada en lugar convenido
     */
    case DAP = "DAP";
    /**
     * Entregada en terminaL
     */
    case DAT = "DAT";
    /**
     * Entregada derechos pagados
     */
    case DDP = "DDP";
    /**
     * En fabrica
     */
    case EXW = "EXW";
    /**
     * Franco al costado del buque
     */
    case FAS = "FAS";
    /**
     * Franco transportista
     */
    case FCA = "FCA";
    /**
     * Franco a bordo
     */
    case FOB = "FOB";
    
    public static function getDescripcion(String $value): string {
        switch($value) {
            case "CFR":
                return "Costo y flete";
            case "CIF":
                return "Costo, seguro y flete";
            case "CIP":
                return "Transporte y seguro pagados hasta";
            case "CPT":
                return "Transporte pagado hasta";
            case "DAP":
                return "Entregada en lugar convenido";
            case "DAT":
                return "Entregada en terminaL";
            case "DDP":
                return "Entregada derechos pagados";
            case "EXW":
                return "En fabrica";
            case "FAS":
                return "Franco al costado del buque";
            case "FCA":
                return "Franco transportista";
            case "FOB":
                return "Franco a bordo";
            default:
                throw new Exception("[Incoterms] Tipo de incoterm inválido: $value");
        }
    }
}




 ?>