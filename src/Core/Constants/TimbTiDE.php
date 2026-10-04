<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración del tipo de documento electrónico: campos iTiDE (C002) y dDesTiDE (C003) del grupo gTimb (C001),
 * según Manual Técnico SIFEN v150.
 */
enum TimbTiDE: int {

    case Factura = 1;
    case FacturaExportacion = 2;
    case FacturaImportacion = 3;
    case Autofactura = 4;
    case NotaDeCredito = 5;
    case NotaDeDebito = 6;
    case NotaDeRemision = 7;
    case ComprobanteDeRetencion = 8;
    /** C002 = 9, régimen RESIMPLE / e-kuatia'i (existe en el XSD de producción, sin NT ni sección del MT). */
    case BoletaDeVenta = 9;
    /** C002 = 10, régimen RESIMPLE / e-kuatia'i (existe en el XSD de producción, sin NT ni sección del MT). */
    case BoletaResimple = 10;

    public function getDescription(): string
    {
        return match($this) {
            self::Factura => 'Factura electrónica',
            self::FacturaExportacion => 'Factura electrónica de exportación',
            self::FacturaImportacion => 'Factura electrónica de importación',
            self::Autofactura => 'Autofactura electrónica',
            self::NotaDeCredito => 'Nota de crédito electrónica',
            self::NotaDeDebito => 'Nota de débito electrónica',
            self::NotaDeRemision => 'Nota de remisión electrónica',
            self::ComprobanteDeRetencion => 'Comprobante de retención electrónico',
            self::BoletaDeVenta => 'Boleta de venta electrónica',
            self::BoletaResimple => 'Boleta resimple electrónica'
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
    public static function getDescripcion(int $tipoDE): ?string
    {
        return self::getDescriptionFromValue($tipoDE);
    }
}

?>
