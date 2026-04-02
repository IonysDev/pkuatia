<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene los tipos de emisión para
 * iTipEmi (B002) y dDesTipEmi (B003) del grupo gOpeDE (B001).
 */
enum OpeDETipEmi: int {
    case Normal = 1;
    case Contingencia = 2;

    public function getDescription(): string
    {
        return match($this) {
            self::Normal => 'Normal',
            self::Contingencia => 'Contingencia'
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
