<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Naturaleza del vendedor en documentos de autofactura electrónica (grupo gCamAE, E300).
 * Valores del campo iNatVen (E301) y descripciones del campo dDesNatVen (E302).
 */
enum CamAENatVen: int {

    case NoContribuyente = 1;
    case Extranjero = 2;

    public function getDescription(): string
    {
        return match ($this) {
            self::NoContribuyente => 'No contribuyente',
            self::Extranjero => 'Extranjero',
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
