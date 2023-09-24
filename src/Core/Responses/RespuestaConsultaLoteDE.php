<?php

namespace Abiliomp\Pkuatia\Core\Responses;

/**
 * RespuestaConsultaLoteDE
 */
class RespuestaConsultaLoteDE
{
  public String $dFecProd; //fecha de la consulta
  public String $dCodResLot; //codigo de respuesta del lote
  public String $dMsgResLot; //descripcion del codigo de respuesta del lote

  ///////////////////////////////////////////////////////////////////////
  ///SETTERS
  ///////////////////////////////////////////////////////////////////////
  /**
   * Set the value of dFecProd
   *
   * @param String $dFecProd
   *
   * @return self
   */
  public function setDFecProd(String $dFecProd): self
  {
    $this->dFecProd = $dFecProd;

    return $this;
  }


  /**
   * Set the value of dCodResLot
   *
   * @param String $dCodResLot
   *
   * @return self
   */
  public function setDCodResLot(String $dCodResLot): self
  {
    $this->dCodResLot = $dCodResLot;

    return $this;
  }


  /**
   * Set the value of dMsgResLot
   *
   * @param String $dMsgResLot
   *
   * @return self
   */
  public function setDMsgResLot(String $dMsgResLot): self
  {
    $this->dMsgResLot = $dMsgResLot;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  ///GETTERS
  ///////////////////////////////////////////////////////////////////////



  /**
   * Get the value of dFecProd
   *
   * @return String
   */
  public function getDFecProd(): String
  {
    return $this->dFecProd;
  }

  /**
   * Get the value of dCodResLot
   *
   * @return String
   */
  public function getDCodResLot(): String
  {
    return $this->dCodResLot;
  }

  /**
   * Get the value of dMsgResLot
   *
   * @return String
   */
  public function getDMsgResLot(): String
  {
    return $this->dMsgResLot;
  }

  ///////////////////////////////////////////////////////////////////////
  //From Response
  ///////////////////////////////////////////////////////////////////////

  public static function FromSifenResponseObject($object): self
  {
    echo "RespuestaConsultaLoteDE::FromSifenResponseObject" . PHP_EOL;

    ///is is null
    if (is_null($object)) {
      throw new \Exception("Error Processing Request: null", 1);
      return null;
    }

    ///check response codes
    if ($object->dCodResLot != "0362") {
      ///retorna el objeto
      $res = new RespuestaConsultaLoteDE();
      $res->setDFecProd($object->dFecProc);
      $res->setDCodResLot($object->dCodResLot);
      $res->setDMsgResLot($object->dMsgResLot);
    } else {
      ///retorna el objeto
      $res = new RespuestaConsultaLoteDE();
      $res->setDFecProd($object->dFecProc);
      $res->setDCodResLot($object->dCodResLot);
      $res->setDMsgResLot($object->dMsgResLot);
      ///Acá la logica al obtener el lote
    }

    return $res;
  }

  public function printData()
  {
    return "RespuestaConsultaDE: " . PHP_EOL .
      "Fecha de Consulta: " . $this->dFecProd . PHP_EOL .
      "Código de Respuesta: " . $this->dCodResLot . PHP_EOL .
      "Mensaje de Respuesta: " . $this->dMsgResLot . PHP_EOL;
  }
}
