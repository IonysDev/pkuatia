<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración relacionada a la tabla 10 del MT (v150) que lista los INCOTERMS soportados por el Sifen.
 */
enum Incoterm: string
{
    use EnumDescripcion;

    /**
     * Costo y flete
     */
    case CFR = "CFR";
    /**
     * Costo, seguro y flete
     */
    case CIF = "CIF";
    /**
     * Transporte y seguro pagados hasta
     */
    case CIP = "CIP";
    /**
     * Transporte pagado hasta
     */
    case CPT = "CPT";
    /**
     * Entregada en lugar convenido
     */
    case DAP = "DAP";
    /**
     * Entregada en terminaL
     */
    case DAT = "DAT";
    /**
     * Entregada derechos pagados
     */
    case DDP = "DDP";
    /**
     * En fabrica
     */
    case EXW = "EXW";
    /**
     * Franco al costado del buque
     */
    case FAS = "FAS";
    /**
     * Franco transportista
     */
    case FCA = "FCA";
    /**
     * Franco a bordo
     */
    case FOB = "FOB";

    public function getDescription(): string
    {
        return match ($this) {
            self::CFR => 'CFR',
            self::CIF => 'CIF',
            self::CIP => 'CIP',
            self::CPT => 'CPT',
            self::DAP => 'DAP',
            self::DAT => 'DAT',
            self::DDP => 'DDP',
            self::EXW => 'EXW',
            self::FAS => 'FAS',
            self::FCA => 'FCA',
            self::FOB => 'FOB'
        };
    }

    /**
     * @deprecated Use getDescriptionFromValue() instead.
     */
    public static function getDescripcion(string $value): ?string
    {
        return self::getDescriptionFromValue($value);
    }
}
