<?php

namespace Abiliomp\Pkuatia\Core\Requests;

//ID: CSch01: Clase que compone la solicitud de consulta de un lote de DEs por su numero de lote obtenido por el WS

class REnviConsLoteDe
{                             //ID - DESC - LONG - OCURRENCIA
  public int $dId;           //CSch02 - Identificador de control de envío - 1-15 - 1-1
  public int $dProtConsLote; //CSch03 - Número de lote - 1-15 - 1-1


  public function __construct($dId, $dProtConsLote)
  {
    $this->dId = $dId;
    $this->dProtConsLote = $dProtConsLote;
  }
  
  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of dId
   *
   * @param int $dId
   *
   * @return self
   */
  public function setDId(int $dId): self
  {
    $this->dId = $dId;

    return $this;
  }


  /**
   * Set the value of dProtConsLote
   *
   * @param int $dProtConsLote
   *
   * @return self
   */
  public function setDProtConsLote(int $dProtConsLote): self
  {
    $this->dProtConsLote = $dProtConsLote;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////
  

  /**
   * Get the value of dId
   *
   * @return int
   */
  public function getDId(): int
  {
    return $this->dId;
  }

  /**
   * Get the value of dProtConsLote
   *
   * @return int
   */
  public function getDProtConsLote(): int
  {
    return $this->dProtConsLote;
  }
}
