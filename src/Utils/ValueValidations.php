<?php

namespace Abiliomp\Pkuatia\Utils;

class ValueValidations
{
    /**
     * Check if a String represents a valid decimal number with the specified precision and integer part lenght.
     * 
     * @param String $value The String to check.
     * @param int $intPartLenght The integer part lenght.
     * @param int $decPartMinPrecision The minimum decimal part precision.
     * @param int $decPartMaxPrecision The maximum decimal part precision.
     * 
     * @return bool True if the String is a valid decimal number, false otherwise.
     */
    public static function isValidStringDecimal(String $value, int $intPartLenght, int $decPartMinPrecision, int $decPartMaxPrecision = 99)
    {
        if($decPartMinPrecision > $decPartMaxPrecision)
            throw new \Exception("The minimum precision cannot be greater than the maximum precision.");
        if($decPartMinPrecision < 0 || $decPartMaxPrecision < 0)
            throw new \Exception("The precision cannot be negative.");
        if($intPartLenght < 0)
            throw new \Exception("The integer part lenght cannot be negative.");
        
        // Check if the value is numeric
        if(!is_numeric($value))
            return false;
        
        // Check if the value is a decimal with the specified precision and integer part lenght
        $pattern = '/^([0-9]{1,' . $intPartLenght . '})(\.{' . $decPartMinPrecision . ',' . $decPartMaxPrecision . '})([0-9]{' . $decPartMinPrecision . ',' . $decPartMaxPrecision . '})?$/';
        return preg_match($pattern, $value);
    }
}

?>