<?php

namespace IonysDev\Pkuatia\Core\Constants;

enum MotEmiNR: int
{
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

    public function getDescripcion(): string
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

    public static function getDescripcionFromInt(int $valor): ?string
    {
        return self::from($valor)->getDescripcion();
    }

    public static function getList(): array
    {
        return [
            self::TrasladoPorVentas->value => self::TrasladoPorVentas->getDescripcion(),
            self::TrasladoPorConsignacion->value => self::TrasladoPorConsignacion->getDescripcion(),
            self::Exportacion->value => self::Exportacion->getDescripcion(),
            self::TrasladoPorCompra->value => self::TrasladoPorCompra->getDescripcion(),
            self::Importacion->value => self::Importacion->getDescripcion(),
            self::TrasladoPorDevolucion->value => self::TrasladoPorDevolucion->getDescripcion(),
            self::TrasladoEntreLocales->value => self::TrasladoEntreLocales->getDescripcion(),
            self::TrasladoPorTransformacion->value => self::TrasladoPorTransformacion->getDescripcion(),
            self::TrasladoPorReparacion->value => self::TrasladoPorReparacion->getDescripcion(),
            self::TrasladoPorEmisorMovil->value => self::TrasladoPorEmisorMovil->getDescripcion(),
            self::ExhibicionODemostracion->value => self::ExhibicionODemostracion->getDescripcion(),
            self::ParticipacionEnFerias->value => self::ParticipacionEnFerias->getDescripcion(),
            self::TrasladoDeEncomienda->value => self::TrasladoDeEncomienda->getDescripcion(),
            self::Decomiso->value => self::Decomiso->getDescripcion(),
            self::Otro->value => self::Otro->getDescripcion()
        ];
    }
}




