<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración del parámetro `iMotEmi` (E401) del grupo `gCamNCDE` (E400),
 * utilizado en notas de crédito y notas de débito electrónicas. *
 * Cada valor corresponde a la descripción `dDesMotEmi` (E402).
 */
enum MotEmiNR: int {
    case TrasladoPorVentas = 1;
    case TrasladoPorConsignacion = 2;
    case Exportacion = 3;
    case TrasladoPorCompra = 4;
    case Importacion = 5;
    case TrasladoPorDevolucion = 6;
    case TrasladoEntreLocales = 7;
    case TrasladoPorTransformacion = 8;
    case TrasladoPorReparacion = 9;
    case TrasladoPorEmisorMovil = 10;
    case ExhibicionODemostracion = 11;
    case ParticipacionEnFerias = 12;
    case TrasladoDeEncomienda = 13;
    case Decomiso = 14;
    case Otro = 99;

    public function getDescription(): string
    {
        return match($this) {
            self::TrasladoPorVentas => 'Traslado por ventas',
            self::TrasladoPorConsignacion => 'Traslado por consignación',
            self::Exportacion => 'Exportación',
            self::TrasladoPorCompra => 'Traslado por compra',
            self::Importacion => 'Importación',
            self::TrasladoPorDevolucion => 'Traslado por devolución',
            self::TrasladoEntreLocales => 'Traslado entre locales de la empresa',
            self::TrasladoPorTransformacion => 'Traslado de bienes por transformación',
            self::TrasladoPorReparacion => 'Traslado de bienes por reparación',
            self::TrasladoPorEmisorMovil => 'Traslado por emisor móvil',
            self::ExhibicionODemostracion => 'Exhibición o demostración',
            self::ParticipacionEnFerias => 'Participación en ferias',
            self::TrasladoDeEncomienda => 'Traslado de encomienda',
            self::Decomiso => 'Decomiso',
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
