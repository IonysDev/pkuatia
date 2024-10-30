<?php

namespace Abiliomp\Pkuatia\Core\Constants;

/**
 * Enumeración que contiene los códigos para el responsable por el costo de flete que pueden informar en los campos que describen el transporte de las mercaderías.
 * Estos valores corresponden al campo iRespFlete (E905) del grupo gTransp (E900).
 */
enum GTranspRespFlete: int {

    case EmisorDeLaFacturaElectronica = 1;
    case ReceptorDeLaFacturaElectronica = 2;
    case Tercero = 3;
    case AgenteIntermediario = 4;
    case TransportePropio = 5;
}

?>