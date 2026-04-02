<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeraración que lista los tipos de operación del receptor del documento electrónico.
 * Corresponde a los valores posibles del campo iTiOpe (D202).
 */
enum RecTiOpe: int {

    case B2B = 1;
    case B2C = 2;
    case B2G = 3;
    case B2F = 4;

    public function getDescription(): string
    {
        return match($this) {
            self::B2B => 'B2B',
            self::B2C => 'B2C',
            self::B2G => 'B2G',
            self::B2F => 'B2F'
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

?>
