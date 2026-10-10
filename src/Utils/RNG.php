<?php

namespace IonysDev\Pkuatia\Utils;

class RNG {

    /**
     * Genera un número aleatorio entre $min y $max con $digits dígitos, y lo devuelve como String.
     * 
     * @param int $min
     * @param int $max
     * @param int $digits
     * 
     * @return String
     */
    public static function GenerateAsString(int $min, int $max, int $digits) : String
    {
        // random_int() usa el generador criptográfico del sistema: el código de seguridad (B004) ya no se puede predecir
        // ni reproducir con mt_srand(), como pasaba con rand() hasta 0.2.0 (PK-38). Igual que rand(), acepta $max < $min.
        $value = random_int(min($min, $max), max($min, $max));
        $value = str_pad((string) $value, $digits, "0", STR_PAD_LEFT);
        return $value;
    }

}

?>