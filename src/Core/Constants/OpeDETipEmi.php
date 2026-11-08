<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene los tipos de emisión para
 * iTipEmi (B002) y dDesTipEmi (B003) del grupo gOpeDE (B001).
 */
enum OpeDETipEmi: int
{
    use EnumDescripcion;

    case Normal = 1;
    case Contingencia = 2;

    public function getDescription(): string
    {
        return match ($this) {
            self::Normal => 'Normal',
            self::Contingencia => 'Contingencia'
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
