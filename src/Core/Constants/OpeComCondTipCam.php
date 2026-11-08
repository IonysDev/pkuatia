<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeraración que contiene las condiciones del tipo de cambio aplicables en una operación comercial.
 * Corresponde a los valores posibles del campo `dCondTiCam` (D017) del grupo `gOpeCom` (D010).
 */
enum OpeComCondTipCam: int
{
    case Global = 1;
    case PorItem = 2;

    public function getDescription(): string
    {
        return match ($this) {
            self::Global => 'Global',
            self::PorItem => 'Por Ítem'
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
