<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene los tipos de transporte que se pueden informar en los campos que describen el transporte de las mercaderías.
 * Estos valores corresponden al campo iTipTrans (E901), asi como a su descripción correspondiente del campo dDesTipTrans (E902)
 * del grupo gTransp (E900).
 */
enum GTranspTipTrans: int
{
    use EnumDescripcion;

    case Propio = 1;
    case Tercero = 2;

    public function getDescription(): string
    {
        return match ($this) {
            self::Propio => 'Propio',
            self::Tercero => 'Tercero'
        };
    }

    /**
     * @deprecated Use getDescription() instead.
     */
    public function getDescripcion(): string
    {
        return $this->getDescription();
    }

    /**
     * @deprecated Use getDescriptionFromValue() instead.
     */
    public static function getDescripcionFromInt(int $valor): ?string
    {
        return self::getDescriptionFromValue($valor);
    }

    /**
     * @deprecated Use getValueDescriptionMap() instead.
     */
    public static function getList(): array
    {
        return self::getValueDescriptionMap();
    }
}
