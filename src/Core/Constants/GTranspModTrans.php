<?php

namespace IonysDev\Pkuatia\Core\Constants;


/**
 * Enumeración del parámetro E903 iModTrans relacionada a la tabla 10 del MT (v150) que lista los modos de transporte.
 */
enum GTranspModTrans: int
{
    case Terrestre = 1;
    case Fluvial = 2;
    case Aereo = 3;
    case Multimodal = 4;

    public function getDescripcion(): string
    {
        return match($this) {
            self::Terrestre => 'Terrestre',
            self::Fluvial => 'Fluvial',
            self::Aereo => 'Aéreo',
            self::Multimodal => 'Multimodal'
        };
    }

    public static function getDescripcionFromInt(int $valor): ?string
    {
        return self::from($valor)->getDescripcion();
    }

    public static function getList(): array
    {
        return [
            self::Terrestre->value => self::Terrestre->getDescripcion(),
            self::Fluvial->value => self::Fluvial->getDescripcion(),
            self::Aereo->value => self::Aereo->getDescripcion(),
            self::Multimodal->value => self::Multimodal->getDescripcion()
        ];
    }
}
