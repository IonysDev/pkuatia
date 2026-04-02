<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene las condiciones de operación a crédito con facturas y autofacturas electrónicas.
 * Estos valores corresponden al campo iCondCred (E641), asi como a su descripción correspondiente del campo dDCondCred (E642) 
 * del grupo gPagCred (E640).
 */
enum PagCredCondCred: int {

    case Plazo = 1;
    case Cuota = 2;

    public function getDescription(): string
    {
        return match($this) {
            self::Plazo => 'Plazo',
            self::Cuota => 'Cuota'
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
