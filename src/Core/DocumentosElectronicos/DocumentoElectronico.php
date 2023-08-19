<?php

namespace Abiliomp\Pkuatia\Core\DocumentosElectronicos;
use Abiliomp\Pkuatia\Core\Fields\DE\AA\RDE;

/**
 * Clase que contiene la estructura básica de un DE, en todos los casos posibles de éste
 */
class DocumentoElectronico {

  public $rDE; //Raiz del documento electronico AA01

  public function __construct()
  {
    $this->rDE = new RDE();
  }

}
