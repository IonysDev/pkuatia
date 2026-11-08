<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración del tipo de documento de identidad del responsable de la generación del DE: campos iTipIDRespDE (D141)
 * y dDTipIDRespDE (D142) del grupo gRespDE (D140), según Manual Técnico SIFEN v150.
 */
enum TipIDRespDE: int
{
    use EnumDescripcion;

    case CedulaParaguaya = 1;
    case Pasaporte = 2;
    case CedulaExtranjera = 3;
    case CarnetDeResidencia = 4;
    case Otro = 9;

    public function getDescription(): string
    {
        return match ($this) {
            self::CedulaParaguaya => 'Cédula paraguaya',
            self::Pasaporte => 'Pasaporte',
            self::CedulaExtranjera => 'Cédula extranjera',
            self::CarnetDeResidencia => 'Carnet de residencia',
            self::Otro => 'Otro'
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
