<?php

namespace IonysDev\Pkuatia\Core\Constants;

use Exception;

/**
 * Enumeración que contiene los tipos de transacción de una operación comercial para los campos
 * cOblAfe (D031) y dDesOblAfe (D032) del grupo GOblAfe (D030).
 */
enum COblAfe: int {
    case ImpuestoALaRentaIracisRegimenEspeciales =  113;
    case TributoUnicoMaquila =  143;
    case ImpuestoAlValorAgregadoGravadasYExoneradasExportadores = 211;
    case ImpuestoSelectivoAlConsumoGeneral = 311;
    case ImpuestoSelectivoAlConsumoCombustibles = 321;
    case ImpuestoALaRentaEmpresarialRegimenGeneral = 700;
    case ImpuestoALaRentaEmpresarialSimple = 701;
    case ImpuestoDeZonaFranca = 703;
    case ImpuestoALaRentaEmpresarialResimple = 702;
    case ImpuestoALaRentaPersonalServiciosPersonales = 715;
    case ImpuestoALaRentaPersonalRentaYGananciasDeCapital = 716;


    public static function getDescripcion(int $cOblAfe): string
    {
        switch ($cOblAfe)
        {
            case 113:
                return 'IMPUESTO A LA RENTA IRACIS - REGÍMENES ESPECIALES';
            case 143:
                return 'TRIBUTO UNICO MAQUILA';
            case 211:
                return 'IMPUESTO AL VALOR AGREGADO - GRAVADAS Y EXONERADAS - EXPORTADORES';
            case 311:
                return 'IMPUESTO SELECTIVO AL CONSUMO - GENERAL';
            case 321:
                return 'IMPUESTO SELECTIVO AL CONSUMO COMBUSTIBLES';
            case 700:
                return 'IMPUESTO A LA RENTA EMPRESARIAL - RÉGIMEN GENERAL';
            case 701:
                return 'IMPUESTO A LA RENTA EMPRESARIAL - SIMPLE';
            case 703:
                return 'IMPUESTO DE ZONA FRANCA';
            case 702:
                return 'IMPUESTO A LA RENTA EMPRESARIAL - RESIMPLE';
            case 715:
                return 'IMPUESTO A LA RENTA PERSONAL - SERVICIOS PERSONALES';
            case 716:
                return 'IMPUESTO A LA RENTA PERSONAL - RENTAS Y GANANCIAS DE CAPITAL';
            default:
                throw new Exception('[COblAfe] Código de obligación afectada no soportada: ' . $cOblAfe);
        }

    }
}
?>