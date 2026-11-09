<?php

namespace IonysDev\Pkuatia\Utils;

class NumberStringFormatter
{
    /**
     * Formatea un número decimal expresado como String (BCMath) a una cadena con separador de miles y decimales.
     *
     * @param string $number Número decimal (BCMath) a formatear.
     * @param string $decsep Separador decimal.
     * @param string $thsep Separador de miles.
     *
     * @return string
     */
    public static function FormatBCMathNumber(string $number, string $decsep, string $thsep): string
    {
        $parts = explode(".", $number);
        $parts[0] = strrev(implode($thsep, str_split(strrev($parts[0]), 3)));
        return implode($decsep, $parts);
    }
}
