<?php

namespace Abiliomp\Pkuatia\Core\Responses;

use Abiliomp\Pkuatia\Core\Fields\Response\DE\RContDe;
use DateTime;
use stdClass;

/**
 * Nodo Id:     DRSch01
 * Nombre:      rResEnviConsDe
 * Descripción: Clase que representa la respuesta a la consulta de un DE mediante su CDC.
 * Nodo Padre:  Es nodo raiz.
 */

class RResEnviConsDe 
{
                             // Id - Longitud - Ocurrencia - Descripción
  public DateTime $dFecProc; // DRSch02  - 19    - 1-1 - fecha de proceso formato AAAA-MM-DD-hh:mm:ss
  public String   $dCodRes;  // DRSch03  - 4     - 1-1 - Código del resultado de procesamiento 
  public String   $dMsgRes;  // DRSch04  - 1-255 - 1-1 - Mensaje del resultado de procesamiento
  public RContDe  $rContDe;  // ContDE01 - XML   - 0-1 - Objeto del DE consultado

  ///////////////////////////////////////////////////////////////////////
  ///SETTERS
  ///////////////////////////////////////////////////////////////////////

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
   * Set the value of dCodRes
   *
   * @param String $dCodRes
   *
   * @return self
   */
  public function setDCodRes(String $dCodRes): self
  {
    $this->dCodRes = $dCodRes;

    return $this;
  }


  /**
   * Set the value of dMsgRes
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
   * Set the value of rContDe
   *
   * @param RContDe $rContDe
   *
   * @return self
   */
  public function setRContDe(RContDe $rContDe): self 
  {
    $this->rContDe = $rContDe;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  ///GETTERS
  ///////////////////////////////////////////////////////////////////////


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
   * Get the value of dCodRes
   *
   * @return String
   */
  public function getDCodRes(): String
  {
    return $this->dCodRes;
  }

  /**
   * Get the value of dMsgRes
   *
   * @return String
   */
  public function getDMsgRes(): String
  {
    return $this->dMsgRes;
  }

  /**
   * Get the value of rContDe
   *
   * @return RContDe
   */
  public function getRContDe(): RContDe | null
  {
    return isset($this->rContDe) ? $this->rContDe : null;
  }

  ///////////////////////////////////////////////////////////////////////
  ///METHODS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Crea una nueva instancia de RResEnviConsDe a partir de un objeto stdClass.
   * Pensado para castear la respuesta de una llamada SOAP.
   * 
   * @param stdClass $object
   * 
   * @return self
   */
  public static function FromSifenResponseObject($object)
  {
    if (is_null($object)) {
      throw new \Exception("Error Processing Request: null", 1);
      return null;
    }
    $res = new RResEnviConsDe();
    $res->setDFecProc(DateTime::createFromFormat(DateTime::ATOM, $object->dFecProc));
    $res->setDCodRes($object->dCodRes);
    $res->setDMsgRes($object->dMsgRes);
    if (isset($object->xContenDE)) {
      // Al 12/08/2023 el SIFEN responde con un valor que el WS no puede interpretar lo cual deriva en una cadena XML inválida con múltiples elementos raiz.
      // Por este motivo se agrega artificialmente ese elemento raiz.
      if(is_string($object->xContenDE)) {
        $xml = str_replace('<rDE ', '<rContDe><rDE ', $object->xContenDE);
        $xml = $xml . '</rContDe>';
        //remove the xml declaration, si no se rompe ahora!
        $xml = preg_replace('/<\?xml.*\?>/', '', $xml);
        $res->setRContDe(RContDe::FromSimpleXMLElement(simplexml_load_string($xml)));
      }
      else{
        // DRSch05 - rContDe se denomina xContenDE en la respuesta de consulta SOAP.
        $res->setRContDe(RContDe::FromSifenResponseObject($object->xContenDE));
      }
    }
    else if (isset($object->rContDe)) {
      $res->setRContDe(RContDe::FromSifenResponseObject($object->rContDe));
    }    
    return $res;
  }
}
