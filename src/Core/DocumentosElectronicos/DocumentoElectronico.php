<?php

namespace Abiliomp\Pkuatia\Core\DocumentosElectronicos;
use Abiliomp\Pkuatia\Core\Fields\DE\AA\RDE;

/**
 * Clase que contiene la estructura básica de un DE, en todos los casos posibles de éste
 */
class DocumentoElectronico {

  public RDE $rDE; //Raiz del documento electronico AA01

  public function __construct()
  {
    $this->rDE = new RDE();
  }

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de rDE (Raiz del documento electronico)
   *
   * @param RDE $rDE
   *
   * @return self
   */
  public function setRDE(RDE $rDE): self
  {
    $this->rDE = $rDE;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Devuelve el valor de rDE (Raiz del documento electronico)
   *
   * @return RDE
   */
  public function getRDE(): RDE
  {
    return $this->rDE;
  }

  ///////////////////////////////////////////////////////////////////////
  // Conversores
  ///////////////////////////////////////////////////////////////////////

  /**
   * Convierte el objeto a un String XML
   *
   * @return String
   */
  public function toXMLString(): String
  {
    return $this->rDE->toXMLString();
  }

}
