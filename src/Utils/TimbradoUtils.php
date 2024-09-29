<?php

namespace Abiliomp\Pkuatia\Utils;

use Abiliomp\Pkuatia\Core\Fields\DE\C\GTimb;
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
    public static function CalcSerieSgte(?String $serieActual = null): String
    {
        if(is_null($serieActual) || strlen($serieActual) == 0)
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
     * Calcula el siguiente número a partir del serie/número indicado
     * 
     * @param String $serieActual Serie actual
     * @param int $numeroActual Número actual
     * 
     * @return array con las claves 'serie' y 'numero' que contienen la serie y número siguientes
     */
    public static function CalcNumSgte(?String $serieActual, int $numeroActual): array
    {
        if(!self::ValidarSerie($serieActual))
            throw new Exception('[TimbradoUtils] La serie actual no es válida.');
        if($numeroActual < 1 || $numeroActual > GTimb::MAX_NUMDOC)
            throw new Exception('[TimbradoUtils] El número actual no es válido.');

        if($numeroActual < GTimb::MAX_NUMDOC) {
            return ['serie' => $serieActual, 'numero' => $numeroActual + 1];
        }
        else {
            if(!is_null($serieActual) && strcmp($serieActual, 'ZZ') == 0)
                throw new Exception('[TimbradoUtils] Series y números agotados.');
            return ['serie' => self::CalcSerieSgte($serieActual), 'numero' => 1];
        }
    }

    /**
     * Valida un número de serie
     * 
     * @param String $serie serie a validar
     * 
     * @return bool true si la serie es válida, false en caso contrario
     */
    public static function ValidarSerie(?String $serie): bool
    {
        if(is_null($serie))
            return true;
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