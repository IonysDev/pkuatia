<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración del parámetro E905 iRespFlete relacionada a la tabla 10 del MT (v150) que lista los responsables del flete.
 */
enum GTranspRespFlete: int {
    case EmisorFactura = 1;
    case ReceptorFactura = 2;
    case Tercero = 3;
    case AgenteIntermediario = 4;
    case TransportePropio = 5;

    public function getDescription(): string
    {
        return match($this) {
            self::EmisorFactura => 'Emisor de la Factura Electrónica',
            self::ReceptorFactura => 'Receptor de la Factura Electrónica',
            self::Tercero => 'Tercero',
            self::AgenteIntermediario => 'Agente intermediario del transporte',
            self::TransportePropio => 'Transporte propio'
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
