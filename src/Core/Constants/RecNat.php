<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeraración que lista la naturaleza de los receptores de documentos electrónicos.
 * Corresponde a los valores posibles del campo iNatRec (D201).
 */
enum RecNat: int {

    case Contribuyente = 1;
    case NoContribuyente = 2;

    public function getDescription(): string
    {
        return match($this) {
            self::Contribuyente => 'Contribuyente',
            self::NoContribuyente => 'No contribuyente'
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

?>
