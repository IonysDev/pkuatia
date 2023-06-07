<?php

namespace Abiliomp\Pkuatia\Core;
use Abiliomp\Pkuatia\Constants;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\A\DE;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\AA\RDE;

class DocumentoElectronico {

  public $rDE;

  public function __construct()
  {
    $this->rDE = new RDE();
  }

}
