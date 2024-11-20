<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Enumeraración que lista los tipos de operación del receptor del documento electrónico.
 * Corresponde a los valores posibles del campo iTiOpe (D202).
 */
enum RecTiOpe: int {

    case B2B = 1;
    case B2C = 2;
    case B2G = 3;
    case B2F = 4;

}

?>