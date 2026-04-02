<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene los tipos de personas contribuyentes para emisores y receptores de documentos electrónicos.
 * Estos valores corresponden al campo iTipCont (D103) del grupo gEmis(D100), y al campo iTiContRec (D205) del grupo gDatRec (D200).
 */

enum EmisRecTipCont: int {
    case PersonaFisica = 1;
    case PersonaJuridica = 2;

    public function getDescription(): string
    {
        return match($this) {
            self::PersonaFisica => 'PersonaFisica',
            self::PersonaJuridica => 'PersonaJuridica'
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
