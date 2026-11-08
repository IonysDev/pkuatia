<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración del tipo de documento impreso asociado: campos iTipoDocAso (H009) y dDTipoDocAso (H010)
 * del grupo gCamDEAsoc, según Manual Técnico SIFEN v150.
 */
enum TipoDocImpresoAso: int
{
    use EnumDescripcion;

    case Factura = 1;
    case NotaDeCredito = 2;
    case NotaDeDebito = 3;
    case NotaDeRemision = 4;
    /** @deprecated No existe en el XSD de producción (tiTIpoDoc admite 1-4, DE_Types_v150.xsd): el SIFEN lo rechaza. Se conserva solo por compatibilidad; GCamDEAsoc::toDOMElement lo bloquea. */
    case ComprobanteRetencion = 5;

    public function getDescription(): string
    {
        return match ($this) {
            self::Factura => 'Factura',
            self::NotaDeCredito => 'Nota de crédito',
            self::NotaDeDebito => 'Nota de débito',
            self::NotaDeRemision => 'Nota de remisión',
            self::ComprobanteRetencion => 'Comprobante de retención'
        };
    }

    /**
     * @deprecated Use getDescriptionFromValue() instead.
     */
    public static function getDescripcion(int $tipDocImpresoAso): ?string
    {
        return self::getDescriptionFromValue($tipDocImpresoAso);
    }
}
