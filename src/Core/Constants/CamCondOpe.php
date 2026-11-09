<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene las condiciones posibles de operación de una factura o autofactura electrónica.
 * Estos valores corresponden al campo iCondOpe (E601), asi como a su descripción correspondiente del campo dDCondOpe (E602)
 * del grupo gCamCond (E600).
 */
enum CamCondOpe: int
{
    use EnumDescripcion;

    case Contado = 1;
    case Credito = 2;

    public function getDescription(): string
    {
        return match ($this) {
            self::Contado => 'Contado',
            self::Credito => 'Crédito'
        };
    }

    /**
     * @deprecated Use getDescriptionFromValue() instead.
     */
    public static function getDescripcion(int $value): ?string
    {
        return self::getDescriptionFromValue($value);
    }

    /**
     * @deprecated Use toIdNameList() instead.
     */
    public static function toKeyValueArray(): array
    {
        return self::toIdNameList();
    }
}
