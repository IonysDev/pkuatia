<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Tipo de documento de identidad del vendedor en autofactura electrónica (grupo gCamAE, E300).
 * Valores del campo iTipIDVen (E304) y descripciones del campo dDTipIDVen (E305).
 * En gCamAE solo aplican los códigos 1–4 (el receptor en gDatRec admite valores adicionales).
 */
enum CamAETipIDVen: int
{
    use EnumDescripcion;

    case CedulaParaguaya = 1;
    case Pasaporte = 2;
    case CedulaExtranjera = 3;
    case CarnetDeResidencia = 4;

    public function getDescription(): string
    {
        return match ($this) {
            self::CedulaParaguaya => 'Cédula paraguaya',
            self::Pasaporte => 'Pasaporte',
            self::CedulaExtranjera => 'Cédula extranjera',
            self::CarnetDeResidencia => 'Carnet de residencia',
        };
    }
}
