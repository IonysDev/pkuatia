<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeraración que lista las formas de procesamiento de los pagos por tarjetas de crédito y débito.
 * Corresponde a los valores posibles del campo gPagTarCD (E626).
 */
enum PagTarCDForProPa: int {

    case POS = 1;
    case PagoElectronico = 2;
    case Otro = 9;

    public function getDescription(): string
    {
        return match($this) {
            self::POS => 'POS',
            self::PagoElectronico => 'Pago Electrónico',
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
}

?>
