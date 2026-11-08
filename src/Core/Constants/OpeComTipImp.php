<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene los tipos de impuestos de una operación comercial para los campos
 * iTipTra (D013) y dDesTipTra (D014) del grupo gOpeCom (D010).
 */
enum OpeComTipImp: int
{
    use EnumDescripcion;

    case IVA = 1;
    case ISC = 2;
    case Renta = 3;
    case Ninguno = 4;
    case IVARenta = 5;

    public function getDescription(): string
    {
        return match ($this) {
            self::IVA => 'IVA',
            self::ISC => 'ISC',
            self::Renta => 'Renta',
            self::Ninguno => 'Ninguno',
            // El XSD de producción exige el guion ASCII simple: "IVA - Renta" (no el guion largo Unicode).
            self::IVARenta => 'IVA - Renta'
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
