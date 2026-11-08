<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene los valores del campo dSisFact (A005) del grupo DE (A001).
 * Este campo representa el sistema de facturación del documento electrónico (DE).
 */

enum DESisFact: int
{
    use EnumDescripcion;

    case Contribuyente = 1;

    public function getDescription(): string
    {
        return match ($this) {
            self::Contribuyente => 'Contribuyente'
        };
    }

    /**
     * @deprecated Use getDescriptionFromValue() instead.
     */
    public static function getDescripcion(int $value): ?string
    {
        return self::getDescriptionFromValue($value);
    }
}
