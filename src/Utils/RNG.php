<?php

namespace Abiliomp\Pkuatia\Utils;

class RNG {

    /**
     * Genera un número aleatorio entre $min y $max con $digits dígitos, y lo devuelve como String.
     * 
     * @param int $min
     * @param int $max
     * @param int $digits
     * 
     * @return int
     */
    public static function GenerateAsString(int $min, int $max, int $digits) : String
    {
        $value = rand($min, $max);
        $value = str_pad($value, $digits, "0", STR_PAD_LEFT);
        return $value;
    }

}

?>