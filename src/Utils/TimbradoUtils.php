<?php

namespace Abiliomp\Pkuatia\Utils;

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
        if(strcmp($this->dSerieNum, 'ZZ') == 0)
            throw new Exception('[GTimb] La serie actual es ZZ, no existe una serie siguiente.');
        $res = '';
        $c1 = substr($this->dSerieNum, 0, 1);
        $c2 = substr($this->dSerieNum, 1, 1);
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

}

?>