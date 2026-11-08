<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene los tipos de documentos asociacios del campo H002.
 */
enum TipDocAso: int
{
    use EnumDescripcion;

    case Electronico = 1;
    case Impreso = 2;
    case ConstanciaElectronica = 3;

    public function getDescription(): string
    {
        return match ($this) {
            self::Electronico => 'Electrónico',
            self::Impreso => 'Impreso',
            self::ConstanciaElectronica => 'Constancia Electrónica'
        };
    }

    /**
     * @deprecated Use getDescriptionFromValue() instead.
     */
    public static function getDescripcion(int $tipDocAso): ?string
    {
        return self::getDescriptionFromValue($tipDocAso);
    }
}
