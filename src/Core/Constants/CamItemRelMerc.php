<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene los códigos de datos de relevancia de las mercaderías de un ítem.
 * Estos valores corresponden al campo cRelMerc (E715), asi como a su descripción correspondiente del campo dDesRelMerc (E716)
 * del grupo gCamItem (E700).
 */
enum CamItemRelMerc: int
{
    use EnumDescripcion;

    case ToleranciaQuiebra = 1;
    case ToleranciaMerma = 2;

    public function getDescription(): string
    {
        return match ($this) {
            self::ToleranciaQuiebra => 'Tolerancia de quiebra',
            self::ToleranciaMerma => 'Tolerancia de merma'
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
