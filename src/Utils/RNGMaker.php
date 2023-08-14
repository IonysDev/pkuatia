<?php

namespace Abiliomp\Pkuatia\Utils;

class RNGMaker
{
  public function __construct()
  {
  }

  public static function MakeSegurityCode($dNumDoc): int
  {
    $numDoc = intval($dNumDoc);
    $code = random_int(1, 999999999);
    while ($code == $numDoc) {
      $code = random_int(1, 999999999);
    }
    return $code;
  }
}
