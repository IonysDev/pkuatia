<?php

namespace Abiliomp\Pkuatia\Core\Responses;

use DateTime;

//id: GRSch01,respuesta del registro de eventos
class RRetEnviEventoDe
{                            //ID - DESC - LONG - OCURRENCIA
  public DateTime $dFecProc; //GRSch02 -Fecha y hora del procesamiento del último evento enviado - 19 - 1-1
  public array $gResprocEve; //GRSch03 -Grupo Resultado del procesamiento del evento - Sin longitud - 0-50


  /**
   * Set the value of dFecProc
   *
   * @param DateTime $dFecProc
   *
   * @return self
   */
  public function setDFecProc(DateTime $dFecProc): self
  {
    $this->dFecProc = $dFecProc;

    return $this;
  }


  /**
   * Set the value of gResprocEve
   *
   * @param array $gResprocEve
   *
   * @return self
   */
  public function setGResprocEve(array $gResprocEve): self
  {
    $this->gResprocEve = $gResprocEve;

    return $this;
  }

  /**
   * Get the value of dFecProc
   *
   * @return DateTime
   */
  public function getDFecProc(): DateTime
  {
    return $this->dFecProc;
  }

  /**
   * Get the value of gResprocEve
   *
   * @return array
   */
  public function getGResprocEve(): array
  {
    return $this->gResprocEve;
  }
}

