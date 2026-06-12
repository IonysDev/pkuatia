<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración del tipo de obligación afectada para los campos cOblAfe (D031) y dDesOblAfe (D032)
 * del grupo gOblAfe (D030), según Tabla 12 - Tipo de Obligaciones de la NT-018.
 */
enum COblAfe: int {
    case ImpuestoALaRentaIracisRegimenEspeciales =  113;
    case TributoUnicoMaquila =  143;
    case ImpuestoAlValorAgregadoGravadasYExoneradasExportadores = 211;
    case ImpuestoSelectivoAlConsumoGeneral = 311;
    case ImpuestoSelectivoAlConsumoCombustibles = 321;
    case ImpuestoALaRentaEmpresarialRegimenGeneral = 700;
    case ImpuestoALaRentaEmpresarialSimple = 701;
    case ImpuestoDeZonaFranca = 703;
    case ImpuestoALaRentaEmpresarialResimple = 702;
    case ImpuestoALaRentaPersonalServiciosPersonales = 715;
    case ImpuestoALaRentaPersonalRentaYGananciasDeCapital = 716;

    /**
     * Devuelve la descripción oficial de la obligación afectada (D032) según la Tabla 12 de la NT-018.
     * La validación SIFEN 1221 exige que la descripción coincida exactamente con el código informado en D031.
     */
    public function getDescription(): string
    {
        return match($this) {
            self::ImpuestoALaRentaIracisRegimenEspeciales => 'IMPUESTO A LA RENTA IRACIS - REGÍMENES ESPECIALES',
            self::TributoUnicoMaquila => 'TRIBUTO UNICO MAQUILA',
            self::ImpuestoAlValorAgregadoGravadasYExoneradasExportadores => 'IMPUESTO AL VALOR AGREGADO - GRAVADAS Y EXONERADAS - EXPORTADORES',
            self::ImpuestoSelectivoAlConsumoGeneral => 'IMPUESTO SELECTIVO AL CONSUMO - GENERAL',
            self::ImpuestoSelectivoAlConsumoCombustibles => 'IMPUESTO SELECTIVO AL CONSUMO COMBUSTIBLES',
            self::ImpuestoALaRentaEmpresarialRegimenGeneral => 'IMPUESTO A LA RENTA EMPRESARIAL - RÉGIMEN GENERAL',
            self::ImpuestoALaRentaEmpresarialSimple => 'IMPUESTO A LA RENTA EMPRESARIAL - SIMPLE',
            self::ImpuestoDeZonaFranca => 'IMPUESTO DE ZONA FRANCA',
            self::ImpuestoALaRentaEmpresarialResimple => 'IMPUESTO A LA RENTA EMPRESARIAL - RESIMPLE',
            self::ImpuestoALaRentaPersonalServiciosPersonales => 'IMPUESTO A LA RENTA PERSONAL - SERVICIOS PERSONALES',
            self::ImpuestoALaRentaPersonalRentaYGananciasDeCapital => 'IMPUESTO A LA RENTA PERSONAL - RENTAS Y GANANCIAS DE CAPITAL'
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
    public static function getDescripcion(int $cOblAfe): ?string
    {
        return self::getDescriptionFromValue($cOblAfe);
    }
}

?>
