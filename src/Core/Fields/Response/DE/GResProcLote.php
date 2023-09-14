<?php

namespace Abiliomp\Pkuatia\Core\Fields\Response\DE;


//ID: CRSch05, Grupo resultado del procesamiento del lote

class GResProcLote
{
                            ///ID - DESC - LONG - OCURRENCIA
  public string $id;        ///CRSch050 - CDC del DE procesado - 44 - 1-1
  public string $dEstRes;   ///CRSch051 - Estado del resultado del resultado - 8-30 - 1-1
  public string $dProtAut;  ///CRSch052 - Número de transacción - 10 - 0-1
  public array $gResProc;   ///CRSch053 - Grupo Mensaje de resultado - no tiene - 0-100


  /**
   * Set the value of id
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
   * Set the value of dEstRes
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
   * Set the value of dProtAut
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
   * Get the value of id
   *
   * @return string
   */
  public function getId(): string
  {
    return $this->id;
  }

  /**
   * Get the value of dEstRes
   *
   * @return string
   */
  public function getDEstRes(): string
  {
    return $this->dEstRes;
  }

  /**
   * Get the value of dProtAut
   *
   * @return string
   */
  public function getDProtAut(): string
  {
    return $this->dProtAut;
  }

  /**
   * Get the value of gResProc
   *
   * @return array
   */
  public function getGResProc(): array
  {
    return $this->gResProc;
  }


  /**
   * Set the value of gResProc
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
