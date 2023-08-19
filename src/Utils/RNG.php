<?php

// Random Number Generator

class RNG {

    private function __construct(){  }

    public static function GenerateAsString(int $min, int $max, int $digits) : String
    {
        $value = rand($min, $max);
        $value = str_pad($value, $digits, "0", STR_PAD_LEFT);
        return $value;
    }

}

?>