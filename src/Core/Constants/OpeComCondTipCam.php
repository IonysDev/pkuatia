<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeraración que contiene las condiciones del tipo de cambio aplicables en una operación comercial.
 * Corresponde a los valores posibles del campo `dCondTiCam` (D017) del grupo `gOpeCom` (D010).
 */
enum OpeComCondTipCam: int
{
    use EnumDescripcion;

    case Global = 1;
    case PorItem = 2;

    public function getDescription(): string
    {
        return match ($this) {
            self::Global => 'Global',
            self::PorItem => 'Por Ítem'
        };
    }
}
