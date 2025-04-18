<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene los tipos de transporte que se pueden informar en los campos que describen el transporte de las mercaderías.
 * Estos valores corresponden al campo iTipTrans (E901), asi como a su descripción correspondiente del campo dDesTipTrans (E902) 
 * del grupo gTransp (E900).
 */
enum GTranspTipTrans: int
{
    case Propio = 1;
    case Tercero = 2;

    public function getDescripcion(): string
    {
        return match($this) {
            self::Propio => 'Propio',
            self::Tercero => 'Tercero'
        };
    }

    public static function getDescripcionFromInt(int $valor): ?string
    {
        return self::from($valor)->getDescripcion();
    }

    public static function getList(): array
    {
        return [
            self::Propio->value => self::Propio->getDescripcion(),
            self::Tercero->value => self::Tercero->getDescripcion()
        ];
    }
}


