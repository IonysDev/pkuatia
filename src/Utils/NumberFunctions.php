<?php

namespace Abiliomp\Pkuatia\Utils;

class NumberFunctions
{

    /**
     * Redondea (Half Up) un número decimal representado en cadena de caracteres (BCMath) a la cantidad de decimales especificados en la precisión.
     * 
     * @param String $number    Número decimal a redondear.
     * @param int    $precision Cantidad de decimales a redondear (por defecto 0).
     * 
     * @return String Número decimal redondeado.
     */
    static function bcround(String $number, int $precision = 0) : String
    {
        if (strpos($number, '.') !== false) {
            if ($number[0] != '-')
                return bcadd($number, '0.' . str_repeat('0', $precision) . '5', $precision);
            return bcsub($number, '0.' . str_repeat('0', $precision) . '5', $precision);
        }
        return $number;
    }
}
