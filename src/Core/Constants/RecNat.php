<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeraración que lista la naturaleza de los receptores de documentos electrónicos.
 * Corresponde a los valores posibles del campo iNatRec (D201).
 */
enum RecNat: int
{
    use EnumDescripcion;

    case Contribuyente = 1;
    case NoContribuyente = 2;

    public function getDescription(): string
    {
        return match ($this) {
            self::Contribuyente => 'Contribuyente',
            self::NoContribuyente => 'No contribuyente'
        };
    }
}
