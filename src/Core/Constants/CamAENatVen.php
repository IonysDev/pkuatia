<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Naturaleza del vendedor en documentos de autofactura electrónica (grupo gCamAE, E300).
 * Valores del campo iNatVen (E301) y descripciones del campo dDesNatVen (E302).
 */
enum CamAENatVen: int
{
    use EnumDescripcion;

    case NoContribuyente = 1;
    case Extranjero = 2;

    public function getDescription(): string
    {
        return match ($this) {
            self::NoContribuyente => 'No contribuyente',
            self::Extranjero => 'Extranjero',
        };
    }
}
