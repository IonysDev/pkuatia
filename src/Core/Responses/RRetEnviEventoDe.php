<?php

namespace IonysDev\Pkuatia\Core\Responses;

use IonysDev\Pkuatia\Core\Fields\Response\DE\gResProcEVe;
use IonysDev\Pkuatia\Core\Fields\Response\GResProc;
use DateTime;
use IonysDev\Pkuatia\Core\Fields\Response\DE\GResProcEVe as DEGResProcEVe;
use SimpleXMLElement;

//id: GRSch01,respuesta del registro de eventos
class RRetEnviEventoDe
{                            // Id - Longitud - Ocurrencia - Descripción
  public DateTime $dFecProc; //GRSch02 - 19 - 1-1  - Fecha y hora del procesamiento del último evento enviado - 19 - 1-1
  public array $gResProcEVe; //GRSch03 - G  - 1-15 - Grupo Resultado del procesamiento del evento - Sin longitud - 0-50


  /**
   * Establece el valor de dFecProc
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
   * Establece el valor de gResProcEVe
   *
   * @param array $gResProcEVe
   *
   * @return self
   */
  public function seGResProcEVe(array $gResProcEVe): self
  {
    $this->gResProcEVe = $gResProcEVe;

    return $this;
  }

  /**
   * Obtiene el valor de dFecProc
   *
   * @return DateTime
   */
  public function getDFecProc(): DateTime
  {
    return $this->dFecProc;
  }

  /**
   * Obtiene el valor de gResProcEVe
   *
   * @return array
   */
  public function geGResProcEVe(): array
  {
    return $this->gResProcEVe;
  }

  public static function FromSifenResponseObject($object)
  {
    if (is_null($object)) {
      throw new \Exception("Error Processing Request: null", 1);
      return null;
    }
    $res = new RRetEnviEventoDe();
    $res->setDFecProc(DateTime::createFromFormat(DateTime::ATOM, $object->dFecProc));
    $gResProcEVe = array();
    if (isset($object->gResProcEVe)) {
      if(is_array($object->gResProcEVe)) {
        foreach($object->gResProcEVe as $item) {
          $aux = GResProcEVe::FromSifenResponseObject($item);
          array_push($gResProcEVe, $aux);
        }
      } else {
        $aux = GResProcEVe::FromSifenResponseObject($object->gResProcEVe);
        array_push($gResProcEVe, $aux);
      }
    }
    $res->seGResProcEVe($gResProcEVe);
    return $res;
  }

  public static function FromSimpleXMLElement(SimpleXMLElement $node):self
  {
    if(strcmp($node->getName(),'rRetEnviEventoDe') != 0) {
      throw new \Exception("Invalid XML Element:" . $node->getName());
      return null;
    }

    $res = new RRetEnviEventoDe();
    $res->setDFecProc(DateTime::createFromFormat("Y-m-d\TH:i:s", $node->dFecProc));
    ///create the array
    $gResProcEVe = array();
    if(isset($node->gResProcEVe))
    {
      $aux = gResProcEVe::FromSimpleXMLElement($node->gResProcEVe);
      array_push($gResProcEVe,$aux);
      $res->seGResProcEVe($gResProcEVe);
    }

    return $res;
  }
}
