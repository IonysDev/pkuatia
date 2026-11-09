<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene los indicadores de presencia para la emisión de una factura electrónica.
 * Estos valores corresponden al campo iIndPres (E011), asi como a su descripción correspondiente del campo dDesIndPres (E012)
 * del grupo gCamFE (E010).
 */
enum CamFEIndPres: int
{
    use EnumDescripcion;

    case Presencial = 1;
    case Electronica = 2;
    case Telemarketing = 3;
    case ADomicilio = 4;
    case Bancaria = 5;
    case CiclicaOSuscripcion = 6;
    case Otro = 9;

    /**
     * Devuelve la descripción del indicador de presencia.
     *
     * @return string
     */

    public function getDescription(): string
    {
        return match ($this) {
            self::Presencial => 'Operación presencial',
            self::Electronica => 'Operación electrónica',
            self::Telemarketing => 'Operación telemarketing',
            self::ADomicilio => 'Venta a domicilio',
            self::Bancaria => 'Operación bancaria',
            self::CiclicaOSuscripcion => 'Operación cíclica',
            self::Otro => 'Otro'
        };
    }

    /**
     * @deprecated Use getDescriptionFromValue() instead.
     */
    public static function getDescripcion(int $value): ?string
    {
        return self::getDescriptionFromValue($value);
    }

    /**
     * @deprecated Use toIdNameList() instead.
     */
    public static function toKeyValueArray(): array
    {
        return self::toIdNameList();
    }
}
