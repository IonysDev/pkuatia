<?php

namespace IonysDev\Pkuatia\Utils;

class NumberStringFormatter {

    /**
     * Formatea un número decimal expresado como String (BCMath) a una cadena con separador de miles y decimales.
     * 
     * @param int $min
     * @param int $max
     * @param int $digits
     * 
     * @return int
     */
    public static function FormatBCMAthNumber(String $number, String $decsep, String $thsep) : String
    {
        $parts = explode(".", $number);
        $parts[0] = strrev(implode($thsep, str_split(strrev($parts[0]), 3)));
        return implode($decsep, $parts);
    }
}