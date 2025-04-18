<?php

namespace IonysDev\Pkuatia\Core\Constants;

use Exception;

/**
 * Enumeración que contiene los motivos de emisión de las notas de crédito y débito.
 * 
 */
enum MotEmi: int {
    case DevolucionYAjustePrecio = 1;
    case Devolucion = 2;
    case Descuento = 3;
    case Bonificacion = 4;
    case CreditoIncobrable = 5;
    case RecuperoDeCosto = 6;
    case RecuperoDeGasto = 7;
    case AjusteDePrecio = 8;

    public static function getDescripcion(int $value): string {
        switch($value) {
            case 1:
                return 'Devolución y Ajuste de precios';
            case 2:
                return 'Devolución';
            case 3:
                return 'Descuento';
            case 4:
                return 'Bonificación';
            case 5:
                return 'Crédito incobrable';
            case 6:
                return 'Recupero de costo';
            case 7:
                return 'Recupero de gasto';
            case 8:
                return 'Ajuste de precio';
            default:
                throw new Exception("[MotEmi] Motivo de emisión inválido: $value");
        }
    }

    public static function getList(): array {
        return [
            self::DevolucionYAjustePrecio->value => self::getDescripcion(self::DevolucionYAjustePrecio->value),
            self::Devolucion->value => self::getDescripcion(self::Devolucion->value),
            self::Descuento->value => self::getDescripcion(self::Descuento->value),
            self::Bonificacion->value => self::getDescripcion(self::Bonificacion->value),
            self::CreditoIncobrable->value => self::getDescripcion(self::CreditoIncobrable->value),
            self::RecuperoDeCosto->value => self::getDescripcion(self::RecuperoDeCosto->value),
            self::RecuperoDeGasto->value => self::getDescripcion(self::RecuperoDeGasto->value),
            self::AjusteDePrecio->value => self::getDescripcion(self::AjusteDePrecio->value)
        ];
    }
}