<?php

namespace Abiliomp\Pkuatia\Core\Constants;

/**
 * Enumeraración que lista la naturaleza de los receptores de documentos electrónicos.
 * Corresponde a los valores posibles del campo iNatRec (D201).
 */
enum RecNat: int {

    case Contribuyente = 1;
    case NoContribuyente = 2;

}

?>