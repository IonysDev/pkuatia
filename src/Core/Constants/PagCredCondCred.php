<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene las condiciones de operación a crédito con facturas y autofacturas electrónicas.
 * Estos valores corresponden al campo iCondCred (E641), asi como a su descripción correspondiente del campo dDCondCred (E642)
 * del grupo gPagCred (E640).
 */
enum PagCredCondCred: int
{
    use EnumDescripcion;

    case Plazo = 1;
    case Cuota = 2;

    public function getDescription(): string
    {
        return match ($this) {
            self::Plazo => 'Plazo',
            self::Cuota => 'Cuota'
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
