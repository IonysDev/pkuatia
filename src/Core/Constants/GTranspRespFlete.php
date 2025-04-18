<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración del parámetro E905 iRespFlete relacionada a la tabla 10 del MT (v150) que lista los responsables del flete.
 */
enum GTranspRespFlete: int
{
    case EmisorFactura = 1;
    case ReceptorFactura = 2;
    case Tercero = 3;
    case AgenteIntermediario = 4;
    case TransportePropio = 5;

    public function getDescripcion(): string
    {
        return match($this) {
            self::EmisorFactura => 'Emisor de la Factura Electrónica',
            self::ReceptorFactura => 'Receptor de la Factura Electrónica',
            self::Tercero => 'Tercero',
            self::AgenteIntermediario => 'Agente intermediario del transporte',
            self::TransportePropio => 'Transporte propio'
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
            self::ReceptorFactura->value => self::ReceptorFactura->getDescripcion(),
            self::Tercero->value => self::Tercero->getDescripcion(),
            self::AgenteIntermediario->value => self::AgenteIntermediario->getDescripcion(),
            self::TransportePropio->value => self::TransportePropio->getDescripcion()
        ];
    }
}
