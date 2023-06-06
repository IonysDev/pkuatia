<?php

namespace Abiliomp\Pkuatia\Core\Utils;

class RNGMaker
{
  public function __construct()
  {
  }

  public static function MakeSegurityCode($dNumDoc): int
  {
    $code = strval(random_int(1, 999999999));
    while ($code == $dNumDoc) {
      $code = strval(random_int(1, 999999999));
    }
    ///padding
    $code = str_pad($code, 9, "0", STR_PAD_LEFT);

    return intval($code);
  }
}
