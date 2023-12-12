<?php

namespace Abiliomp\Pkuatia\Utils;

use Exception;

/**
 * Clase con métodos de utilidad para el timbrado de documentos.
 */
class TimbradoUtils {

    /**
     * Calcula la serie siguiente a partir de la serie actual.
     * Si la serie actual es null o vacía, se retorna la serie AA.
     * A partir de AA se pasa a AB, luego a AC y asi sucesivamente hasta ZZ.
     * Si la serie es ZZ, se lanza una excepción.
     * 
     * @return String Serie siguiente.
     */
    public static function CalcSerieSgte($serieActual = null): String
    {
        if(!isset($serieActual) || strlen($serieActual) == 0)
            return 'AA';
        if(strcmp($serieActual, 'ZZ') == 0)
            throw new Exception('[GTimb] La serie actual es ZZ, no existe una serie siguiente.');
        $res = '';
        $c1 = substr($serieActual, 0, 1);
        $c2 = substr($serieActual, 1, 1);
        if(strcmp($c2, 'Z') == 0)
        {
            $c1 = chr(ord($c1) + 1);
            $c2 = 'A';
        }
        else
        {
            $c2 = chr(ord($c2) + 1);
        }
        return $res;
    }

    /**
     * Valida un número de serie
     * 
     * @param String $serie serie a validar
     * 
     * @return bool true si la serie es válida, false en caso contrario
     */
    public static function ValidarSerie($serie): bool
    {
        if(strlen($serie) != 2)
            return false;
        $c1 = substr($serie, 0, 1);
        $c2 = substr($serie, 1, 1);
        if(ord($c1) < ord('A') || ord($c1) > ord('Z'))
            return false;
        if(ord($c2) < ord('A') || ord($c2) > ord('Z'))
            return false;
        return true;
    }

}

?>