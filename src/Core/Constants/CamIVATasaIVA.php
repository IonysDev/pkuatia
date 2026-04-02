<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene las tasas de IVA soportadas por el SIFEN.
 * Estos valores corresponden al campo dTasaIVA (E734) del grupo gCamIVA (E730).
 */

enum CamIVATasaIVA: int {
    case ExentoExonerado = 0;
    case IVA5 = 5;
    case IVA10 = 10;

    public function getDescription(): string
    {
        return match($this) {
            self::ExentoExonerado => 'Exento o Exonerado',
            self::IVA5 => 'IVA5',
            self::IVA10 => 'IVA10'
        };
    }

    public static function getDescriptionFromValue(int|string $value): ?string
    {
        return self::tryFrom($value)?->getDescription();
    }

    public static function getValueDescriptionMap(): array
    {
        $list = [];
        foreach (self::cases() as $case) {
            $list[$case->value] = $case->getDescription();
        }

        return $list;
    }

    public static function toIdNameList(): array
    {
        $list = [];
        foreach (self::cases() as $case) {
            $list[] = ['id' => $case->value, 'name' => $case->getDescription()];
        }

        return $list;
    }
}
