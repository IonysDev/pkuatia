<?php

namespace Abiliomp\Pkuatia\Core\Responses;

use Abiliomp\Pkuatia\Core\Fields\Response\DE\gResProcEVe;
use Abiliomp\Pkuatia\Core\Fields\Response\GResProc;
use DateTime;
use SimpleXMLElement;

//id: GRSch01,respuesta del registro de eventos
class RRetEnviEventoDe
{                            //ID - DESC - LONG - OCURRENCIA
  public DateTime $dFecProc; //GRSch02 -Fecha y hora del procesamiento del último evento enviado - 19 - 1-1
  public array $gResProcEVe; //GRSch03 -Grupo Resultado del procesamiento del evento - Sin longitud - 0-50


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
  public function setgResProcEVe(array $gResProcEVe): self
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
  public function getgResProcEVe(): array
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
      ///como la ocurrencia es 1-15 se revisa si es un array
      if (is_array($object->gResProcEVe)) {
        foreach ($object->gResProcLote as $item) {
          $aux = new gResProcEVe();
          $aux->setDEstRes($item->dEstRes);
          if (isset($item->dProtAut)) {
            $aux->setDProtAut($item->dProtAut);
          }
          $aux->setId($item->id);
          ///array for gResProc
          $gResProc = array();
          ///check if is an array or an object
          if (is_array($item->gResProc)) {
            echo "TODO CUANTICO";
            echo "is array";
          } else {
            $aux2 = new GResProc();
            $aux2->setDCodRes($item->gResProc->dCodRes);
            $aux2->setDMsgRes($item->gResProc->dMsgRes);
          }
          ///push aux2 into gResProc array
          array_push($gResProc, $aux2);
          ///set gResProc to aux
          $aux->setGResProc($gResProc);
          //push aux into gResProcLote array
          array_push($gResProcLote, $aux);
        }
      } else {
        $aux = new gResProcEVe();
        $aux->setDEstRes($object->gResProcEVe->dEstRes);
        if (isset($object->gResProcEVe->dProtAut)) {
          $aux->setDProtAut($object->gResProcEVe->dProtAut);
        }
        $aux->setId($object->gResProcEVe->id);
        ///array for gResProc
        $gResProc = array();
      }
      ///set gResProcLote to res
      $res->setgResProcEVe($gResProcEVe);
      $aux2 = new GResProc();
      $aux2->setDCodRes($object->gResProcEVe->gResProc->dCodRes);
      $aux2->setDMsgRes($object->gResProcEVe->gResProc->dMsgRes);
      array_push($gResProc, $aux2);
      $aux->setGResProc($gResProc);
      array_push($gResProcEVe, $aux);
      $res->setgResProcEVe($gResProcEVe);
    }
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
      $res->setgResProcEVe($gResProcEVe);
    }

    return $res;
  }
}
