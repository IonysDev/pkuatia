<?php

namespace Abiliomp\Pkuatia\Core\Constants;

use Exception;

/**
 * Enumeraración que contiene las condiciones del tipo de cambio aplicables en una operación comercial.
 * Corresponde a los valores posibles del campo dCondTiCam (D017).
 */
enum OpeComCondTipCam: int {

    case Global = 1;
    case PorItem = 2;

}

?>