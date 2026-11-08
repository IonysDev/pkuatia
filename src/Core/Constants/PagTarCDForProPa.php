<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeraración que lista las formas de procesamiento de los pagos por tarjetas de crédito y débito.
 * Corresponde a los valores posibles del campo gPagTarCD (E626).
 */
enum PagTarCDForProPa: int
{
    use EnumDescripcion;

    case POS = 1;
    case PagoElectronico = 2;
    case Otro = 9;

    public function getDescription(): string
    {
        return match ($this) {
            self::POS => 'POS',
            self::PagoElectronico => 'Pago Electrónico',
            self::Otro => 'Otro'
        };
    }
}
