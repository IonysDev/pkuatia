<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene los tipos de impuestos de una operación comercial para los campos
 * iTipTra (D013) y dDesTipTra (D014) del grupo gOpeCom (D010).
 */
enum OpeComTipImp: int {

    case IVA = 1;
    case ISC = 2;
    case Renta = 3;
    case Ninguno = 4;
    case IVARenta = 5;

    public function getDescription(): string
    {
        return match($this) {
            self::IVA => 'IVA',
            self::ISC => 'ISC',
            self::Renta => 'Renta',
            self::Ninguno => 'Ninguno',
            self::IVARenta => 'IVA – Renta'
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

?>
