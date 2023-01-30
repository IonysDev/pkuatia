<?php

namespace Abiliomp\Pkuatia\Fields\Request\Events\GDE;

use DOMElement;
use DateTime;

/**
 * Nodo: GDE002 - rEve - Grupos de Campos Generales del Evento 
 * Padre: GDE001 - rGesEve - Raíz de Gestión de Eventos
 */
class TrEve
{
    public int          $Id;          // GDE003 - Identificador del evento - ATRIBUTO DEL CAMPO
    public DateTime     $dFecFirma;   // GDE004 - Fecha y Hora del firmado
    public int          $dVerFor;     // GDE005 - Versión del formato
    public TgGroupTiEvt $gGroupTiEvt; // GEI004 - Punto de expedición


}