<?php

namespace Abiliomp\Pkuatia\Fields;

use DateTime;
use DOMElement;

/**
 * Campos generales del DE (D001)
 * Nodo padre DE (A001): Campos firmados del DE
 */

class GDatGralOpe {

    public DateTime $dFeEmiDE; // Fecha y hora de emisión del DE (D002) AAAA-MM-DDThh:mm:ss
    public GOpeCom $gOpeCom; // Campos inherentes a la operación comercial (D010)
    public GEmis $gEmis; // Grupo de campos que identifican al emisor (D100)
    public GDatRec $gDatRec; // Grupo de campos que identifican al receptor (D200)
}

?> 