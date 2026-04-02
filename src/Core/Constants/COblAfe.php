<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene los tipos de transacción de una operación comercial para los campos
 * cOblAfe (D031) y dDesOblAfe (D032) del grupo GOblAfe (D030).
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

    public function getDescription(): string
    {
        return match($this) {
            self::ImpuestoALaRentaIracisRegimenEspeciales => 'ImpuestoALaRentaIracisRegimenEspeciales',
            self::TributoUnicoMaquila => 'TributoUnicoMaquila',
            self::ImpuestoAlValorAgregadoGravadasYExoneradasExportadores => 'ImpuestoAlValorAgregadoGravadasYExoneradasExportadores',
            self::ImpuestoSelectivoAlConsumoGeneral => 'ImpuestoSelectivoAlConsumoGeneral',
            self::ImpuestoSelectivoAlConsumoCombustibles => 'ImpuestoSelectivoAlConsumoCombustibles',
            self::ImpuestoALaRentaEmpresarialRegimenGeneral => 'ImpuestoALaRentaEmpresarialRegimenGeneral',
            self::ImpuestoALaRentaEmpresarialSimple => 'ImpuestoALaRentaEmpresarialSimple',
            self::ImpuestoDeZonaFranca => 'ImpuestoDeZonaFranca',
            self::ImpuestoALaRentaEmpresarialResimple => 'ImpuestoALaRentaEmpresarialResimple',
            self::ImpuestoALaRentaPersonalServiciosPersonales => 'ImpuestoALaRentaPersonalServiciosPersonales',
            self::ImpuestoALaRentaPersonalRentaYGananciasDeCapital => 'ImpuestoALaRentaPersonalRentaYGananciasDeCapital'
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
