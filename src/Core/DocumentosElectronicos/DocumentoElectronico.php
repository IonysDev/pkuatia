<?php

namespace Abiliomp\Pkuatia\Core\DocumentosElectronicos;

use Abiliomp\Pkuatia\Core\Fields\DE\B\GOpeDE;
use Abiliomp\Pkuatia\Core\Fields\DE\C\GTimb;

/**
 * Clase que contiene la estructura básica de un DE, en todos los casos posibles de éste
 */
class DocumentoElectronico {

  public GOpeDE $gOpeDE; // Campos que describen la operación del documento electrónico
  public GTimb  $gTimb; // Campos que describen el timbrado del documento electrónico

  /**
   * Constructor
   * 
   * @param GTimb $timbrado datos de timbrado del documento electrónico
   */
  public function __construct(GTimb $timbrado = null)
  {
    $this->gOpeDE = new GOpeDE();
    if($timbrado)
      $this->gTimb = $timbrado;
    else
      $this->gTimb = new GTimb();
  }


  /**
   * Establece información y/o comentarios de interés del emisor.
   * 
   * @param String $dInfEmi comentarios del emisor
   * 
   * @return self
   */
  public function setInfoEmi(String $infoEmi): self
  {
    $this->gOpeDE->setDInfoEmi($infoEmi);
    return $this;
  }

  /**
   * Establece información y/o comentarios de interés para el fisco.
   * 
   * @param String $dInfFisc comentarios del fisco
   * 
   * @return self
   */
  public function setInfoFisc(String $infoFisc): self
  {
    $this->gOpeDE->setDInfoFisc($infoFisc);
    return $this;
  }
  
}
