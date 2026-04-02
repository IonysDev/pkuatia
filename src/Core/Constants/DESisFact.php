<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene los valores del campo dSisFact (A005) del grupo DE (A001).
 * Este campo representa el sistema de facturación del documento electrónico (DE).
 */

enum DESisFact: int {
    case Contribuyente = 1;

    public function getDescription(): string
    {
        return match($this) {
            self::Contribuyente => 'Contribuyente'
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

    /**
     * @deprecated Use getDescriptionFromValue() instead.
     */
    public static function getDescripcion(int $value): ?string
    {
        return self::getDescriptionFromValue($value);
    }
}
