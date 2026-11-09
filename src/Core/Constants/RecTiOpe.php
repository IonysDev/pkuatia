<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeraración que lista los tipos de operación del receptor del documento electrónico.
 * Corresponde a los valores posibles del campo iTiOpe (D202).
 */
enum RecTiOpe: int
{
    use EnumDescripcion;

    case B2B = 1;
    case B2C = 2;
    case B2G = 3;
    case B2F = 4;

    public function getDescription(): string
    {
        return match ($this) {
            self::B2B => 'B2B',
            self::B2C => 'B2C',
            self::B2G => 'B2G',
            self::B2F => 'B2F'
        };
    }

    /**
     * @deprecated Use getDescription() instead.
     */
    public function getDescripcion(): string
    {
        return $this->getDescription();
    }

    /**
     * @deprecated Use getDescriptionFromValue() instead.
     */
    public static function getDescripcionFromInt(int $valor): ?string
    {
        return self::getDescriptionFromValue($valor);
    }

    /**
     * @deprecated Use getValueDescriptionMap() instead.
     */
    public static function getList(): array
    {
        return self::getValueDescriptionMap();
    }
}
