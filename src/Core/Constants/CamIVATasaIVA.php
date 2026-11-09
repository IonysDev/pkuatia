<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene las tasas de IVA soportadas por el SIFEN.
 * Estos valores corresponden al campo dTasaIVA (E734) del grupo gCamIVA (E730).
 */

enum CamIVATasaIVA: int
{
    use EnumDescripcion;

    case ExentoExonerado = 0;
    case IVA5 = 5;
    case IVA10 = 10;

    public function getDescription(): string
    {
        return match ($this) {
            self::ExentoExonerado => 'Exento o Exonerado',
            self::IVA5 => 'IVA5',
            self::IVA10 => 'IVA10'
        };
    }
}
