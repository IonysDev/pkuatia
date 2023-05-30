<?php

namespace Abiliomp\Pkuatia\Core\Responses;

use Abiliomp\Pkuatia\Core\Fields\Response\Ruc\TxContRuc;

/**
 * RespuestaConsultaRUC
 */
class RespuestaConsultaRUC
{
  public string $dCodRes; //codigo de respuesta
  public string $dMsgRes; //descripcion del codigo de respuesta
  public TxContRuc $txContRuc; //objeto de la respuesta


  //====================================================//
  ///SETTERS
  //====================================================//

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
   * Set the value of txContRuc
   *
   * @param TxContRuc $txContRuc
   *
   * @return self
   */
  public function setTxContRuc(TxContRuc $txContRuc): self
  {
    $this->txContRuc = $txContRuc;

    return $this;
  }

  //====================================================//
  ///GETTERS
  //====================================================//


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
   * Get the value of txContRuc
   *
   * @return TxContRuc
   */
  public function getTxContRuc(): TxContRuc
  {
    return $this->txContRuc;
  }

  //====================================================//
  //From Response
  //====================================================//

  public static function fromResponse($response): self
  {
    echo "RespuestaConsultaRUC::fromResponse\n";


    if (is_null($response)) {
      throw new \Exception("Error Processing Request: null", 1);
      return null;
    }

    if ($response->dCodRes != "0502") ///no object
    {
      $res = new RespuestaConsultaRUC();
      $res->setDCodRes($response->dCodRes);
      $res->setDMsgRes($response->dMsgRes);
    } else {
      $res = new RespuestaConsultaRUC();
      $res->setDCodRes($response->dCodRes);
      $res->setDMsgRes($response->dMsgRes);
      ///generate txContRuc object
      $txContRuc = new TxContRuc();
      $txContRuc = TxContRuc::fromResponse($response->xContRUC);
      $res->setTxContRuc($txContRuc);
    }

    return $res;
  }

  public function printData()
  {
    return "RespuestaConsultaRUC: " . PHP_EOL .
      "Código de Respuesta: " . $this->dCodRes . PHP_EOL .
      "Mensaje de Respuesta: " . $this->dMsgRes . PHP_EOL;
  }
}
