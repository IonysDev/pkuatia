<?php

namespace IonysDev\Pkuatia\Core\Requests;

//ID: CSch01: Clase que compone la solicitud de consulta de un lote de DEs por su numero de lote obtenido por el WS

class REnviConsLoteDe
{                               // ID - DESC - LONG - OCURRENCIA
  public int    $dId;           // CSch02 - Identificador de control de envío - 1-15 - 1-1
  public string $dProtConsLote; // CSch03 - Número de lote - 1-20 - 1-1


  public function __construct($dId, $dProtConsLote)
  {
    $this->dId = $dId;
    $this->dProtConsLote = $dProtConsLote;
  }
  
  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de dId
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
   * Establece el valor de dProtConsLote
   *
   * @param string $dProtConsLote
   *
   * @return self
   */
  public function setDProtConsLote(string $dProtConsLote): self
  {
    $this->dProtConsLote = $dProtConsLote;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////
  

  /**
   * Obtiene el valor de dId
   *
   * @return int
   */
  public function getDId(): int
  {
    return $this->dId;
  }

  /**
   * Obtiene el valor de dProtConsLote
   *
   * @return int
   */
  public function getDProtConsLote(): int
  {
    return $this->dProtConsLote;
  }
}
