<?php

namespace Abiliomp\Pkuatia\Core\Responses;
use Abiliomp\Pkuatia\Core\Fields\Response\DE\TxContenDE;

/**
 * RespuestaConsultaDE
 */
class RespuestaConsultaDE
{
  public string $dFecProc;//fecha de proceso
  public string $dCodRes;//codigo de respuesta
  public string $dMsgRes;//descripcion del codigo de respuesta
  public TxContenDE $xContEv;//objeto de la respuesta

  //====================================================//
  ///SETTERS
  //====================================================//
  
  /**
   * Set the value of dFecProc
   *
   * @param string $dFecProc
   *
   * @return self
   */
  public function setDFecProc(string $dFecProc): self
  {
    $this->dFecProc = $dFecProc;

    return $this;
  }


  /**
   * Set the value of dCodRes
   *
   * @param string $dCodRes
   *
   * @return self
   */
  public function setDCodRes(string $dCodRes): self
  {
    $this->dCodRes = $dCodRes;

    return $this;
  }


  /**
   * Set the value of dMsgRes
   *
   * @param string $dMsgRes
   *
   * @return self
   */
  public function setDMsgRes(string $dMsgRes): self
  {
    $this->dMsgRes = $dMsgRes;

    return $this;
  }


  /**
   * Set the value of xContEv
   *
   * @param TxContenDE $xContEv
   *
   * @return self
   */
  public function setXContEv(TxContenDE $xContEv): self
  {
    $this->xContEv = $xContEv;

    return $this;
  }

  //====================================================//
  ///GETTERS
  //====================================================//
  

  /**
   * Get the value of dFecProc
   *
   * @return string
   */
  public function getDFecProc(): string
  {
    return $this->dFecProc;
  }

  /**
   * Get the value of dCodRes
   *
   * @return string
   */
  public function getDCodRes(): string
  {
    return $this->dCodRes;
  }

  /**
   * Get the value of dMsgRes
   *
   * @return string
   */
  public function getDMsgRes(): string
  {
    return $this->dMsgRes;
  }

  /**
   * Get the value of xContEv
   *
   * @return TxContenDE
   */
  public function getXContEv(): TxContenDE
  {
    return $this->xContEv;
  }

  //====================================================//
  ///METHODS
  //====================================================//
  
  /**
   * fromResponse
   *
   * @param  mixed $response
   * @return self
   */
  public static function fromResponse($response): self
  {
    echo "RespuestaConsultaDE::fromResponse\n";

    if(is_null($response))
    {
      throw new \Exception("RespuestaConsultaDE::fromResponse: response is null");
      return null;
    }

    if($response->dCodRes != '0422')
    {
      $res = new RespuestaConsultaDE();
      $res->setDFecProc($response->dFecProc);
      $res->setDCodRes($response->dCodRes);
      $res->setDMsgRes($response->dMsgRes);
    }else
    {
      $res = new RespuestaConsultaDE();
      $res->setDFecProc($response->dFecProc);
      $res->setDCodRes($response->dCodRes);
      $res->setDMsgRes($response->dMsgRes);

      TxContenDE::fromResponse($response->xContenDE);
    }

    return $res;
  }

  public function printData()
  {
    return "RespuestaConsultaDE: " . PHP_EOL .
      "Fecha de Consulta: " . $this->dFecProc . PHP_EOL .
      "Código de Respuesta: " . $this->dCodRes . PHP_EOL .
      "Mensaje de Respuesta: " . $this->dMsgRes . PHP_EOL;
  }
}
