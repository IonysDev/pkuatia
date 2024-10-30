<?php

namespace Abiliomp\Pkuatia\Core\Constants;

use Exception;

/**
 * Enumeración que contiene las tasas de IVA soportadas por el SIFEN.
 * Estos valores corresponden al campo dTasaIVA (E734) del grupo gCamIVA (E730).
 */

 enum CamIVATasaIVA : int {
    case ExentoExonerado = 0;
    case IVA5 = 5;
    case IVA10 = 10;
 }