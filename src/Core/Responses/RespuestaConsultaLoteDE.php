<?php

namespace Abiliomp\Pkuatia\Core\Responses;

/**
 * RespuestaConsultaLoteDE
 */
class RespuestaConsultaLoteDE
{
  public string $dFecProd; //fecha de la consulta
  public string $dCodResLot; //codigo de respuesta del lote
  public string $dMsgResLot; //descripcion del codigo de respuesta del lote

  //====================================================//
  ///SETTERS
  //====================================================//
  /**
   * Set the value of dFecProd
   *
   * @param string $dFecProd
   *
   * @return self
   */
  public function setDFecProd(string $dFecProd): self
  {
    $this->dFecProd = $dFecProd;

    return $this;
  }


  /**
   * Set the value of dCodResLot
   *
   * @param string $dCodResLot
   *
   * @return self
   */
  public function setDCodResLot(string $dCodResLot): self
  {
    $this->dCodResLot = $dCodResLot;

    return $this;
  }


  /**
   * Set the value of dMsgResLot
   *
   * @param string $dMsgResLot
   *
   * @return self
   */
  public function setDMsgResLot(string $dMsgResLot): self
  {
    $this->dMsgResLot = $dMsgResLot;

    return $this;
  }

  //====================================================//
  ///GETTERS
  //====================================================//



  /**
   * Get the value of dFecProd
   *
   * @return string
   */
  public function getDFecProd(): string
  {
    return $this->dFecProd;
  }

  /**
   * Get the value of dCodResLot
   *
   * @return string
   */
  public function getDCodResLot(): string
  {
    return $this->dCodResLot;
  }

  /**
   * Get the value of dMsgResLot
   *
   * @return string
   */
  public function getDMsgResLot(): string
  {
    return $this->dMsgResLot;
  }

  //====================================================//
  //From Response
  //====================================================//

  public static function fromResponse($response): self
  {
    echo "RespuestaConsultaLoteDE::fromResponse" . PHP_EOL;

    ///is is null
    if (is_null($response)) {
      throw new \Exception("Error Processing Request: null", 1);
      return null;
    }

    ///check response codes
    if ($response->dCodResLot != "0362") {
      ///retorna el objeto
      $res = new RespuestaConsultaLoteDE();
      $res->setDFecProd($response->dFecProc);
      $res->setDCodResLot($response->dCodResLot);
      $res->setDMsgResLot($response->dMsgResLot);
    } else {
      ///retorna el objeto
      $res = new RespuestaConsultaLoteDE();
      $res->setDFecProd($response->dFecProc);
      $res->setDCodResLot($response->dCodResLot);
      $res->setDMsgResLot($response->dMsgResLot);
      ///Acá la logica al obtener el lote
    }

    return $res;
  }
}
