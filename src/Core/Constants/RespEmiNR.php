<?php

namespace IonysDev\Pkuatia\Core\Constants;

enum RespEmiNR: int {
    case EmisorFactura = 1;
    case PoseedorFacturaYBienes = 2;
    case EmpresaTransportista = 3;
    case DespachanteAduanas = 4;
    case AgenteTransporte = 5;

    public function getDescription(): string
    {
        return match($this) {
            self::EmisorFactura => 'Emisor de la factura',
            self::PoseedorFacturaYBienes => 'Poseedor de la factura y bienes',
            self::EmpresaTransportista => 'Empresa transportista',
            self::DespachanteAduanas => 'Despachante de Aduanas',
            self::AgenteTransporte => 'Agente de transporte o intermediario'
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
