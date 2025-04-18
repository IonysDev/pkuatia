<?php

namespace IonysDev\Pkuatia\Core\Constants;

enum RespEmiNR: int
{
    case EmisorFactura = 1;
    case PoseedorFacturaYBienes = 2;
    case EmpresaTransportista = 3;
    case DespachanteAduanas = 4;
    case AgenteTransporte = 5;

    public function getDescripcion(): string
    {
        return match($this) {
            self::EmisorFactura => 'Emisor de la factura',
            self::PoseedorFacturaYBienes => 'Poseedor de la factura y bienes',
            self::EmpresaTransportista => 'Empresa transportista',
            self::DespachanteAduanas => 'Despachante de Aduanas',
            self::AgenteTransporte => 'Agente de transporte o intermediario'
        };
    }

    public static function getDescripcionFromInt(int $valor): ?string
    {
        return self::from($valor)->getDescripcion();
    }

    public static function getList(): array
    {
        return [
            self::EmisorFactura->value => self::EmisorFactura->getDescripcion(),
            self::PoseedorFacturaYBienes->value => self::PoseedorFacturaYBienes->getDescripcion(),
            self::EmpresaTransportista->value => self::EmpresaTransportista->getDescripcion(),
            self::DespachanteAduanas->value => self::DespachanteAduanas->getDescripcion(),
            self::AgenteTransporte->value => self::AgenteTransporte->getDescripcion()
        ];
    }
}