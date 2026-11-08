<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración del parámetro E903 iModTrans relacionada a la tabla 10 del MT (v150) que lista los modos de transporte.
 */
enum GTranspModTrans: int
{
    use EnumDescripcion;

    case Terrestre = 1;
    case Fluvial = 2;
    case Aereo = 3;
    case Multimodal = 4;

    public function getDescription(): string
    {
        return match ($this) {
            self::Terrestre => 'Terrestre',
            self::Fluvial => 'Fluvial',
            self::Aereo => 'Aéreo',
            self::Multimodal => 'Multimodal'
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
