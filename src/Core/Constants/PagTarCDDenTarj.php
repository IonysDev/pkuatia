<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene las denominaciones de tarjetas de crédito y débito soportados por el Sifen.
 * Estos valores corresponden al campo iDenTarj (CE621002), asi como a su descripción correspondiente del campo dDesDenTarj (E622)
 * del grupo gPagTarCD (E620).
 */
enum PagTarCDDenTarj: int
{
    use EnumDescripcion;

    case Visa = 1;
    case Mastercard = 2;
    case AmericanExpress = 3;
    case Maestro = 4;
    case Panal = 5;
    case Cabal = 6;
    case Otro = 99;

    public function getDescription(): string
    {
        return match ($this) {
            self::Visa => 'Visa',
            self::Mastercard => 'Mastercard',
            self::AmericanExpress => 'American Express',
            self::Maestro => 'Maestro',
            self::Panal => 'Panal',
            self::Cabal => 'Cabal',
            self::Otro => 'Otro'
        };
    }

    /**
     * @deprecated Use getDescriptionFromValue() instead.
     */
    public static function getDescripcion(int $tipoDE): ?string
    {
        return self::getDescriptionFromValue($tipoDE);
    }
}
