<?php

namespace Abiliomp\Pkuatia\Core;

use Abiliomp\Pkuatia\Constants;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\A\DE;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\AA\RDE;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\J\GCamFuFD;

class Factura {

    public RDE $raiz;

    public function __construct() {
        $this->raiz = new RDE();
        $this->raiz->dVerFor = Constants::SIFEN_VERSION;
        $this->raiz->dE = new DE();
        $this->raiz->gCamFuFD = new GCamFuFD();
    }

    

    public function sign() {
        // TO DO
    }


}

?>