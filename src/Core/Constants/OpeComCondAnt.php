<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene las condiciones posibles de anticipo de una operación comercial.
 * Estos valores corresponden al campo iCondAnt (D019), asi como a su descripción correspondiente del campo dDesCondAnt (D20)
 * del grupo gOpeCom (D010).
 */
enum OpeComCondAnt: int
{
    use EnumDescripcion;

    case AnticipoGlobal = 1;
    case AnticipoPorItem = 2;

    public function getDescription(): string
    {
        return match ($this) {
            self::AnticipoGlobal => 'Anticipo Global',
            self::AnticipoPorItem => 'Anticipo por Ítem'
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
