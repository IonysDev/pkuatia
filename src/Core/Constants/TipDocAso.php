<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene los tipos de documentos asociacios del campo H002.
 */
enum TipDocAso: int {

    case Electronico = 1;
    case Impreso = 2;
    case ConstanciaElectronica = 3;

    public function getDescription(): string
    {
        return match($this) {
            self::Electronico => 'Electrónico',
            self::Impreso => 'Impreso',
            self::ConstanciaElectronica => 'Constancia electrónica'
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
    public static function getDescripcion(int $tipDocAso): ?string
    {
        return self::getDescriptionFromValue($tipDocAso);
    }
}
