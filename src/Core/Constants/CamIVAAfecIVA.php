<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene los tipos de afectación tributaria de los ítems valorizados.
 * No debe informarse para aquellos items que formen parte de notas de remsión (utilizar ítems no valorizados NoValueItem).
 * Tampoco debe informarse cuando el tipo de impuesto afectado sea el ISC (D013=2).
 * Estos valores corresponden al campo iAfecIVA (E731), asi como a su descripción correspondiente del campo dDesAfecIVA (E732) 
 * del grupo gCamIVA (E730).
 */
enum CamIVAAfecIVA: int {

    case Gravado = 1;
    case Exonerado = 2;
    case Exento = 3;
    case GravadoParcial = 4;

    public function getDescription(): string
    {
        return match($this) {
            self::Gravado => 'Gravado IVA',
            self::Exonerado => 'Exonerado (Art. 83- Ley 125/91)',
            self::Exento => 'Exento',
            self::GravadoParcial => 'Gravado parcial (Grav-Exento)'
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
