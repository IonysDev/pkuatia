<?php

namespace Abiliomp\Pkuatia\Core\Constants;

use Exception;

/**
 * Enumeración que contiene los tipos de pagos soportados en una operación comercial para los campos
 * iTiPago (E606) y dDesTiPag (E607) del grupo gPaConEIni (E605).
 */
enum PaConEIniTiPago: int {

    case Efectivo = 1;
    case Cheque = 2;
    case TarjetaCredito = 3;
    case TarjetaDebito = 4;
    case Transferencia = 5;
    case Giro = 6;
    case BilleteraElec = 7;
    case TarjetaEmpresarial = 8;
    case Vale = 9;
    case Retencion = 10;
    case PagoPorAnticipo = 11;
    case ValorFiscal = 12;
    case ValorComercial = 13;
    case Compensacion = 14;
    case Permuta = 15;
    case PagoBancario = 16;
    case PagoMovil = 17;
    case Donacion = 18;
    case Promocion = 19;
    case ConsumoInterno = 20;
    case PagoElectronico = 21;
    case Otros = 99;

    public static function getDescripcion(int $value): string {
        switch($value) {
            case 1:
                return 'Efectivo';
            case 2:
                return 'Cheque';
            case 3:
                return 'Tarjeta de crédito';
            case 4:
                return 'Tarjeta de débito';
            case 5:
                return 'Transferencia';
            case 6:
                return 'Giro';
            case 7:
                return 'Billetera electrónica';
            case 8:
                return 'Tarjeta empresarial';
            case 9:
                return 'Vale';
            case 10:
                return 'Retención';
            case 11:
                return 'Pago por anticipo';
            case 12:
                return 'Valor fiscal';
            case 13:
                return 'Valor comercial';
            case 14:
                return 'Compensación';
            case 15:
                return 'Permuta';
            case 16:
                return 'Pago bancario';
            case 17:
                return 'Pago Móvil';
            case 18:
                return 'Donación';
            case 19:
                return 'Promoción';
            case 20:
                return 'Consumo Interno';
            case 21:
                return 'Pago Electrónico';
            case 99:
                return 'Otro';
            default:
                throw new Exception("[PaConEIniTiPago] Tipo de pago equivocado: $value");
        }
    }
}

?>