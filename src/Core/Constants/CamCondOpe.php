<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene las condiciones posibles de operación de una factura o autofactura electrónica.
 * Estos valores corresponden al campo iCondOpe (E601), asi como a su descripción correspondiente del campo dDCondOpe (E602) 
 * del grupo gCamCond (E600).
 */
enum CamCondOpe: int {

    case Contado = 1;
    case Credito = 2;

    public function getDescription(): string
    {
        return match($this) {
            self::Contado => 'Contado',
            self::Credito => 'Crédito'
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

    /**
     * @deprecated Use toIdNameList() instead.
     */
    public static function toKeyValueArray(): array
    {
        return self::toIdNameList();
    }
}

?>
