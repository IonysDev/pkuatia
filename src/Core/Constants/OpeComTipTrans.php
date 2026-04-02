<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración del tipo de transacción de la operación comercial: campos iTipTra (D011) y dDesTipTra (D012)
 * del grupo gOpeCom (D010), según Manual Técnico SIFEN v150.
 */
enum OpeComTipTrans: int {

    case VentaMercaderia = 1;
    case PrestacionServicios = 2;
    case MixtoMercaderiaServicios = 3;
    case VentaActivoFijo = 4;
    case VentaDivisas = 5;
    case CompraDivisas = 6;
    case PromocionOMuestra = 7;
    case Donacion = 8;
    case Anticipo = 9;
    case CompraProductos = 10;
    case CompraServicios = 11;
    case VentaCreditoFiscal = 12;
    case MuestrasMedicas = 13;

    public function getDescription(): string
    {
        return match($this) {
            self::VentaMercaderia => 'Venta de mercadería',
            self::PrestacionServicios => 'Prestación de servicios',
            self::MixtoMercaderiaServicios => 'Mixto (Venta de mercadería y servicios)',
            self::VentaActivoFijo => 'Venta de activo fijo',
            self::VentaDivisas => 'Venta de divisas',
            self::CompraDivisas => 'Compra de divisas',
            self::PromocionOMuestra => 'Promoción o entrega de muestras',
            self::Donacion => 'Donación',
            self::Anticipo => 'Anticipo',
            self::CompraProductos => 'Compra de productos',
            self::CompraServicios => 'Compra de servicios',
            self::VentaCreditoFiscal => 'Venta de crédito fiscal',
            self::MuestrasMedicas => 'Muestras médicas (Art. 3 RG 24/2014)'
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
    public static function getDescripcion(int $tipTrans): ?string
    {
        return self::getDescriptionFromValue($tipTrans);
    }
}

?>
