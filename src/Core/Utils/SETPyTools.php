<?php

namespace Abiliomp\Pkuatia\Core\Utils;

/**
 * SETPyTools
 */
class SETPyTools {
	
	private static $ruc_basemax = 11;
	
	public static function calcDV($value){
		$ruc_al = "";
		for($i = 0; $i < strlen($value); $i++){
			$c = $value[$i];
			if(is_numeric($c)){
				$ruc_al = $ruc_al . $c;
			}
			else{
				//se debe allar el valor ascii de la letra
				$ascii = ord($c);
				$ruc_al = $ruc_al . $ascii;
			}
		}
		$k = 2;
		$v = 0;
		for($i = (strlen($ruc_al) - 1); $i >= 0; $i--){
			if($k > SETPyTools::$ruc_basemax){
				$k = 2;
			}
			$aux = intval($ruc_al[$i]);
			$v = $v + ($aux * $k);
			$k = $k + 1;
		}
		$r = $v % 11;
		$dv = 0;
		if($r > 1){
			$dv = 11 - $r;
		}
		return $dv;
	}
}