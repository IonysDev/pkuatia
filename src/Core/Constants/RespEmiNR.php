<?php

namespace IonysDev\Pkuatia\Core\Constants;

enum RespEmiNR: int
{
    use EnumDescripcion;

    case EmisorFactura = 1;
    case PoseedorFacturaYBienes = 2;
    case EmpresaTransportista = 3;
    case DespachanteAduanas = 4;
    case AgenteTransporte = 5;

    public function getDescription(): string
    {
        return match ($this) {
            self::EmisorFactura => 'Emisor de la factura',
            self::PoseedorFacturaYBienes => 'Poseedor de la factura y bienes',
            self::EmpresaTransportista => 'Empresa transportista',
            self::DespachanteAduanas => 'Despachante de Aduanas',
            self::AgenteTransporte => 'Agente de transporte o intermediario'
        };
    }

    /**
     * @deprecated Use getDescription() instead.
     */
    public function getDescripcion(): string
    {
        return $this->getDescription();
    }

    /**
     * @deprecated Use getDescriptionFromValue() instead.
     */
    public static function getDescripcionFromInt(int $valor): ?string
    {
        return self::getDescriptionFromValue($valor);
    }

    /**
     * @deprecated Use getValueDescriptionMap() instead.
     */
    public static function getList(): array
    {
        return self::getValueDescriptionMap();
    }
}
