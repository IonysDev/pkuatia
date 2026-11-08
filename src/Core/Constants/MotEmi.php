<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración del parámetro `iMotEmi` (E401) del grupo `gCamNCDE` (E400),
 * utilizado en notas de crédito y notas de débito electrónicas. *
 * Cada valor corresponde a la descripción `dDesMotEmi` (E402)
 */
enum MotEmi: int
{
    use EnumDescripcion;

    case DevolucionYAjustePrecio = 1;
    case Devolucion = 2;
    case Descuento = 3;
    case Bonificacion = 4;
    case CreditoIncobrable = 5;
    case RecuperoDeCosto = 6;
    case RecuperoDeGasto = 7;
    case AjusteDePrecio = 8;

    public function getDescription(): string
    {
        return match ($this) {
            self::DevolucionYAjustePrecio => 'Devolución y Ajuste de precios',
            self::Devolucion => 'Devolución',
            self::Descuento => 'Descuento',
            self::Bonificacion => 'Bonificación',
            self::CreditoIncobrable => 'Crédito incobrable',
            self::RecuperoDeCosto => 'Recupero de costo',
            self::RecuperoDeGasto => 'Recupero de gasto',
            self::AjusteDePrecio => 'Ajuste de precio'
        };
    }

    /**
     * @deprecated Use getDescriptionFromValue() instead.
     */
    public static function getDescripcion(int $value): ?string
    {
        return self::getDescriptionFromValue($value);
    }

    /**
     * @deprecated Use getValueDescriptionMap() instead.
     */
    public static function getList(): array
    {
        return self::getValueDescriptionMap();
    }
}
