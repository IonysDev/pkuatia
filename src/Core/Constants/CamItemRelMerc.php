<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene los códigos de datos de relevancia de las mercaderías de un ítem.
 * Estos valores corresponden al campo cRelMerc (E715), asi como a su descripción correspondiente del campo dDesRelMerc (E716) 
 * del grupo gCamItem (E700).
 */
enum CamItemRelMerc: int {

    case ToleranciaQuiebra = 1;
    case ToleranciaMerma = 2;

    public function getDescription(): string
    {
        return match($this) {
            self::ToleranciaQuiebra => 'Tolerancia de quiebra',
            self::ToleranciaMerma => 'Tolerancia de merma'
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

?>
