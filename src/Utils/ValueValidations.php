<?php

namespace IonysDev\Pkuatia\Utils;

class ValueValidations
{
    /**
     * Comprueba que una cadena represente un número decimal no negativo con punto como separador,
     * con a lo sumo $intPartLenght dígitos en la parte entera y entre $decPartMinPrecision y
     * $decPartMaxPrecision decimales (con mínimo 0 la parte decimal es opcional).
     *
     * Refleja las facetas de los tipos numéricos del XSD de producción (DE_Types_v150.xsd):
     * tMontoBase 15 enteros / 8 decimales, tMontoBase4 15/4, tdCRed 4/4, tPorcDesc8 3/8,
     * tTipoCambioBase 5/4, tdCantProSer 10/8, tLectura 11/2. Hasta la v0.1.5 la expresión regular
     * contaba puntos en lugar de decimales (aceptaba '1000' con parte entera de 3 y rechazaba
     * '100.50' con mínimo 2) y devolvía el entero de preg_match, por lo que las comparaciones con
     * `=== false` nunca se cumplían (PK-16 de la evaluación del 02/10/2026).
     *
     * @param String $value Cadena a comprobar.
     * @param int $intPartLenght Cantidad máxima de dígitos de la parte entera.
     * @param int $decPartMinPrecision Cantidad mínima de decimales.
     * @param int $decPartMaxPrecision Cantidad máxima de decimales.
     *
     * @return bool
     *
     * @throws \Exception Si los límites son incoherentes (mínimo mayor al máximo o negativos).
     */
    public static function isValidStringDecimal(String $value, int $intPartLenght, int $decPartMinPrecision, int $decPartMaxPrecision = 99): bool
    {
        if($decPartMinPrecision > $decPartMaxPrecision)
            throw new \Exception("The minimum precision cannot be greater than the maximum precision.");
        if($decPartMinPrecision < 0 || $decPartMaxPrecision < 0)
            throw new \Exception("The precision cannot be negative.");
        if($intPartLenght < 0)
            throw new \Exception("The integer part lenght cannot be negative.");

        // is_numeric descarta espacios, comas y texto; la expresión regular excluye además signos,
        // notación científica y puntos sin dígitos.
        if($value === '' || !is_numeric($value))
            return false;

        $parteEntera = '[0-9]{1,' . $intPartLenght . '}';
        if($decPartMaxPrecision === 0) {
            $parteDecimal = '';
        } else {
            $minimo = max(1, $decPartMinPrecision);
            $parteDecimal = '(\.[0-9]{' . $minimo . ',' . $decPartMaxPrecision . '})' . ($decPartMinPrecision === 0 ? '?' : '');
        }
        return preg_match('/^' . $parteEntera . $parteDecimal . '$/', $value) === 1;
    }
}
