<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene las condiciones posibles de anticipo de una operación comercial.
 * Estos valores corresponden al campo iCondAnt (D019), asi como a su descripción correspondiente del campo dDesCondAnt (D20) 
 * del grupo gOpeCom (D010).
 */
enum OpeComCondAnt: int {

    case AnticipoGlobal = 1;
    case AnticipoPorItem = 2;

    public function getDescription(): string
    {
        return match($this) {
            self::AnticipoGlobal => 'Anticipo Global',
            self::AnticipoPorItem => 'Anticipo por Ítem'
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
