<?php

namespace IonysDev\Pkuatia\Core\Fields\Response\DE;


//ID: CRSch05, Grupo resultado del procesamiento del lote

class GResProcLote
{
                            ///ID - DESC - LONG - OCURRENCIA
  public string $id;        ///CRSch050 - CDC del DE procesado - 44 - 1-1
  public string $dEstRes;   ///CRSch051 - Estado del resultado del resultado - 8-30 - 1-1
  public string $dProtAut;  ///CRSch052 - Número de transacción - 10 - 0-1
  public array $gResProc;   ///CRSch053 - Grupo Mensaje de resultado - no tiene - 0-100


  /**
   * Establece el valor de id
   *
   * @param string $id
   *
   * @return self
   */
  public function setId(string $id): self
  {
    $this->id = $id;

    return $this;
  }


  /**
   * Establece el valor de dEstRes
   *
   * @param string $dEstRes
   *
   * @return self
   */
  public function setDEstRes(string $dEstRes): self
  {
    $this->dEstRes = $dEstRes;

    return $this;
  }


  /**
   * Establece el valor de dProtAut
   *
   * @param string $dProtAut
   *
   * @return self
   */
  public function setDProtAut(string $dProtAut): self
  {
    $this->dProtAut = $dProtAut;

    return $this;
  }




  /**
   * Obtiene el valor de id
   *
   * @return string
   */
  public function getId(): string
  {
    return $this->id;
  }

  /**
   * Obtiene el valor de dEstRes
   *
   * @return string
   */
  public function getDEstRes(): string
  {
    return $this->dEstRes;
  }

  /**
   * Obtiene el valor de dProtAut
   *
   * @return string
   */
  public function getDProtAut(): string
  {
    return $this->dProtAut;
  }

  /**
   * Obtiene el valor de gResProc
   *
   * @return array
   */
  public function getGResProc(): array
  {
    return $this->gResProc;
  }


  /**
   * Establece el valor de gResProc
   *
   * @param array $gResProc
   *
   * @return self
   */
  public function setGResProc(array $gResProc): self
  {
    $this->gResProc = $gResProc;

    return $this;
  }
}
