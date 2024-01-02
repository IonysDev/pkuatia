<?php

namespace Abiliomp\Pkuatia\Core\Constants;

use Exception;

/**
 * Enumeración que contiene los tipos de transacción de una operación comercial para los campos
 * iTipTra (D011) y dDesTipTra (D012) del grupo gOpeCom (D010).
 */
enum OpeComTipTrans: int {

    case VentaMercaderia = 1;
    case PrestacionServicios = 2;
    case MixtoMercaderiaServicios = 3;
    case VentaActivoFijo = 4;
    case VentaDivisas = 5;
    case CompraDivisas = 6;
    case PromocionOMuestra = 7;
    case Donacion = 8;
    case Anticipo = 9;
    case CompraProductos = 10;
    case CompraServicios = 11;
    case VentaCreditoFiscal = 12;
    case MuestrasMedicas = 13;

    public static function getDescripcion(int $tipTrans): string {
        switch($tipTrans) {
            case 1:
                return 'Venta de mercadería';
            case 2:
                return 'Prestación de servicios';
            case 3:
                return 'Mixto';
            case 4:
                return 'Venta de activo fijo';
            case 5:
                return 'Venta de divisas';
            case 6:
                return 'Compra de divisas';
            case 7:
                return 'Promoción o entrega de muestras';
            case 8:
                return 'Donación';
            case 9:
                return 'Anticipo';
            case 10:
                return 'Compra de productos';
            case 11:
                return 'Compra de servicios';
            case 12:
                return 'Venta de crédito fiscal';
            case 13:
                return 'Muestras médicas (Art. 3 RG 24/2014)';
            default:
                throw new Exception('[OpeComTipTrans] Tipo de transacción no soportada: ' . $tipTrans);
        }
    }
}

?>