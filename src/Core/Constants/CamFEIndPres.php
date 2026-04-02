<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene los indicadores de presencia para la emisión de una factura electrónica.
 * Estos valores corresponden al campo iIndPres (E011), asi como a su descripción correspondiente del campo dDesIndPres (E012) 
 * del grupo gCamFE (E010).
 */
enum CamFEIndPres: int {

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
     * @param int $value Valor del indicador de presencia.
     * @return string
     * @throws Exception
     */

    public function getDescription(): string
    {
        return match($this) {
            self::Presencial => 'Operación presencial',
            self::Electronica => 'Operación electrónica',
            self::Telemarketing => 'Operación telemarketing',
            self::ADomicilio => 'Venta a domicilio',
            self::Bancaria => 'Operación bancaria',
            self::CiclicaOSuscripcion => 'Operación cíclica',
            self::Otro => 'Otro'
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

    /**
     * @deprecated Use toIdNameList() instead.
     */
    public static function toKeyValueArray(): array
    {
        return self::toIdNameList();
    }
}
