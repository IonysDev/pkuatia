<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración del tipo de pago al contado / entrega inicial: campos iTiPago (E606) y dDesTiPag (E607)
 * del grupo gPaConEIni (E605), según Manual Técnico SIFEN v150.
 */
enum PaConEIniTiPago: int {

    case Efectivo = 1;
    case Cheque = 2;
    case TarjetaCredito = 3;
    case TarjetaDebito = 4;
    case Transferencia = 5;
    case Giro = 6;
    case BilleteraElec = 7;
    case TarjetaEmpresarial = 8;
    case Vale = 9;
    case Retencion = 10;
    case PagoPorAnticipo = 11;
    case ValorFiscal = 12;
    case ValorComercial = 13;
    case Compensacion = 14;
    case Permuta = 15;
    case PagoBancario = 16;
    case PagoMovil = 17;
    case Donacion = 18;
    case Promocion = 19;
    case ConsumoInterno = 20;
    case PagoElectronico = 21;
    case Otros = 99;

    public function getDescription(): string
    {
        return match($this) {
            self::Efectivo => 'Efectivo',
            self::Cheque => 'Cheque',
            self::TarjetaCredito => 'Tarjeta de crédito',
            self::TarjetaDebito => 'Tarjeta de débito',
            self::Transferencia => 'Transferencia',
            self::Giro => 'Giro',
            self::BilleteraElec => 'Billetera electrónica',
            self::TarjetaEmpresarial => 'Tarjeta empresarial',
            self::Vale => 'Vale',
            self::Retencion => 'Retención',
            self::PagoPorAnticipo => 'Pago por anticipo',
            self::ValorFiscal => 'Valor fiscal',
            self::ValorComercial => 'Valor comercial',
            self::Compensacion => 'Compensación',
            self::Permuta => 'Permuta',
            self::PagoBancario => 'Pago bancario',
            self::PagoMovil => 'Pago Móvil',
            self::Donacion => 'Donación',
            self::Promocion => 'Promoción',
            self::ConsumoInterno => 'Consumo Interno',
            self::PagoElectronico => 'Pago Electrónico',
            self::Otros => 'Otro'
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
    public static function getDescripcion(int $value): ?string
    {
        return self::getDescriptionFromValue($value);
    }
}

?>
