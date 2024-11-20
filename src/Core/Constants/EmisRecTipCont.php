<?php

namespace IonysDev\Pkuatia\Core\Constants;

use Exception;

/**
 * Enumeración que contiene los tipos de personas contribuyentes para emisores y receptores de documentos electrónicos.
 * Estos valores corresponden al campo iTipCont (D103) del grupo gEmis(D100), y al campo iTiContRec (D205) del grupo gDatRec (D200).
 */

 enum EmisRecTipCont : int {
    case PersonaFisica = 1;
    case PersonaJuridica = 2;
 }