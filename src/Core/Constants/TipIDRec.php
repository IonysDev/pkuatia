<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración del tipo de documento de identidad del receptor: campos iTipIDRec (D208) y dDTipIDRec (D209)
 * del grupo gDatRec (D200), según Manual Técnico SIFEN v150.
 */
enum TipIDRec: int {

    case CedulaParaguaya = 1;
    case Pasaporte = 2;
    case CedulaExtranjera = 3;
    case CarnetDeResidencia = 4;
    case Innominado = 5;
    case TajetaDiplomatica = 6;
    case Otro = 9;

    public function getDescription(): string
    {
        return match($this) {
            self::CedulaParaguaya => 'Cédula paraguaya',
            self::Pasaporte => 'Pasaporte',
            self::CedulaExtranjera => 'Cédula extranjera',
            self::CarnetDeResidencia => 'Carnet de residencia',
            self::Innominado => 'Innominado',
            self::TajetaDiplomatica => 'Tarjeta Diplomática de exoneración fiscal',
            self::Otro => 'Otro'
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
    public static function getDescripcion(int $tipImp): ?string
    {
        return self::getDescriptionFromValue($tipImp);
    }
}
