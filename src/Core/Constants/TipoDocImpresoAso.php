<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración del tipo de documento impreso asociado: campos iTipoDocAso (H009) y dDTipoDocAso (H010)
 * del grupo gCamDEAsoc, según Manual Técnico SIFEN v150.
 */
enum TipoDocImpresoAso: int {

    case Factura = 1;
    case NotaDeCredito = 2;
    case NotaDeDebito = 3;
    case NotaDeRemision = 4;
    case ComprobanteRetencion = 5;

    public function getDescription(): string
    {
        return match($this) {
            self::Factura => 'Factura',
            self::NotaDeCredito => 'Nota de crédito',
            self::NotaDeDebito => 'Nota de débito',
            self::NotaDeRemision => 'Nota de remisión',
            self::ComprobanteRetencion => 'Comprobante de retención'
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
    public static function getDescripcion(int $tipDocImpresoAso): ?string
    {
        return self::getDescriptionFromValue($tipDocImpresoAso);
    }
}
