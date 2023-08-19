<?php

namespace Abiliomp\Pkuatia\Core\Responses;

use Abiliomp\Pkuatia\Core\Fields\Response\Ruc\RContRuc;

/**
 * RespuestaConsultaRUC
 */
class RResEnviConsRUC 
{
  public int    $dCodRes;    // RRSch02 - Código del resultado de la consulta RUC 
  public String $dMsgRes;    // RRSch03 - Mensaje del resultado  de  la consulta RUC
  public RContRuc $rContRuc; // RRSch04 - Contenedor del RUC consultado

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de dCodRes
   *
   * @param int $dCodRes
   *
   * @return self
   */
  public function setDCodRes(int $dCodRes): self
  {
    $this->dCodRes = $dCodRes;

    return $this;
  }


  /**
   * Establece el valor de dMsgRes
   *
   * @param String $dMsgRes
   *
   * @return self
   */
  public function setDMsgRes(String $dMsgRes): self
  {
    $this->dMsgRes = $dMsgRes;

    return $this;
  }


  /**
   * Establece el valor de RContRuc
   *
   * @param RContRuc $rContRuc
   *
   * @return self
   */
  public function setRContRuc(RContRuc $rContRuc): self
  {
    $this->rContRuc = $rContRuc;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////


  /**
   * Obtiene el valor de dCodRes
   *
   * @return String
   */
  public function getDCodRes(): String
  {
    return $this->dCodRes;
  }

  /**
   * Obtiene el valor de dMsgRes
   *
   * @return String
   */
  public function getDMsgRes(): String
  {
    return $this->dMsgRes;
  }

  /**
   * Obtiene el valor de rContRuc
   *
   * @return RContRuc
   */
  public function getRContRuc(): RContRuc
  {
    return $this->rContRuc;
  }

  ///////////////////////////////////////////////////////////////////////
  // Métodos especiales de instanciación
  ///////////////////////////////////////////////////////////////////////

  /**
   * Crea una nueva instancia de RResEnviConsRUC a partir de un objeto stdClass.
   * Pensado para castear la respuesta de una llamada SOAP.
   * 
   * @param stdClass $object
   * 
   * @return RResEnviConsRUC
   */

  public static function fromStdClassObject($object)
  {
    if (is_null($object)) {
      throw new \Exception("Error Processing Request: null", 1);
      return null;
    }
    $res = new RResEnviConsRUC();
    $res->setDCodRes($object->dCodRes);
    $res->setDMsgRes($object->dMsgRes);
    if ($object->dCodRes == "0502")
    {
      if(isset($object->xContRUC))
        //  RRSch04 - rContRUC se denomina xContRUC en las respuestas del SIFEN
        $res->setRContRuc(RContRuc::fromStdClassObject($object->xContRUC));
      else if(isset($object->rContRUC))
        $res->setRContRuc(RContRuc::fromStdClassObject($object->rContRUC));
    }
    return $res;
  }
}
