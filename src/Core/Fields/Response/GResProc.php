<?php

namespace IonysDev\Pkuatia\Core\Fields\Response;

use DOMElement;
use SimpleXMLElement;

/**
 * ID:PP05 Grupo Resultado de Procesamiento PADRE:PP01 
 */
class GResProc
{
  public const COD_RES_ACEPTADO = 260;

                          // ID - DESC - LONG - OCURRENCIA
  public String $dCodRes; // PP052 - Código del resultado de procesamiento - 4 - 1-1
  public String $dMsgRes; // PP053 - Mensaje del resultado de procesamiento - 1-255 - 1-1

  ///////////////////////////////////////////////////////////////////////
  ///SETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de dCodRes
   *
   * @param int $dCodRes
   *
   * @return self
   */
  public function setDCodRes(String $dCodRes): self
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

  ///////////////////////////////////////////////////////////////////////
  //GETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de dCodRes
   *
   * @return int
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

  ///////////////////////////////////////////////////////////////////////
  // Instanciadores
  ///////////////////////////////////////////////////////////////////////  
  
  /**
   * Instancia un GResProc a partir de un objeto stdClass recibido como respuesta a una llamada SOAP al SIFEN.
   * 
   * @param stdClass $object
   * 
   * @return GResProc
   */
  public static function FromSifenResponseObject($object): GResProc
  {
    $res = new GResProc();
    $res->setDCodRes($object->dCodRes);
    $res->setDMsgRes($object->dMsgRes);
    return $res;
  }

}
