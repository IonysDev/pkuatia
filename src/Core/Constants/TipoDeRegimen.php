<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración del tipo de régimen tributario del emisor (Tabla 1, MT SIFEN v150), campo cTipReg (D104) en gEmis (D100).
 */
enum TipoDeRegimen: int
{
    use EnumDescripcion;

    case Turismo = 1;
    case Importador = 2;
    case Exportador = 3;
    case Maquila = 4;
    case Ley6090 = 5;
    case PequenoProductor = 6;
    case MedianoProductor = 7;
    case Contable = 8;

    public function getDescription(): string
    {
        return match ($this) {
            self::Turismo => 'Régimen de Turismo',
            self::Importador => 'Importador',
            self::Exportador => 'Exportador',
            self::Maquila => 'Maquila',
            self::Ley6090 => 'Ley N° 60/90',
            self::PequenoProductor => 'Régimen del Pequeño Productor',
            self::MedianoProductor => 'Régimen del Mediano Productor',
            self::Contable => 'Régimen Contable'
        };
    }

    /**
     * @deprecated Use getDescriptionFromValue() instead.
     */
    public static function getDescripcion(int $tipImp): ?string
    {
        return self::getDescriptionFromValue($tipImp);
    }
}
